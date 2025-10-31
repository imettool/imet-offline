<?php

/*
 * Copyright (C) 2025 European Union
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

namespace App\Helpers;

use Generator;

/**
 * CSVReader: read CSV files in chunks
 *
 * Usage:
 * $csvReader = new CSVReader('path/to/file.csv');
 * foreach ($csvReader->rows() as $chunk) {
 *    ... Process each chunk ...
 * }
 */
class CSVReader
{
    /** @var resource $file */
    private $file;

    /** @var array<int, string> $header */
    private array $header;

    public int $row_index = 0;

    private int $chunk_index = 0;

    public int $num_rows = 0;

    private const int CHUNK_SIZE = 1000;

    /**
     * constructor
     */
    public function __construct(string $filePath,
        private readonly string $delimiter = ',',
        private readonly int $header_row_index = 0)
    {
        $this->file = fopen($filePath, 'r');
    }

    /**
     * Retrieve CSV header
     * @return array<int, string>
     */
    public function header(): array
    {
        return $this->header;
    }

    /**
     * Retrieve the CSV size [in rows]
     */
    private function getSize(): void
    {
        $num_rows = 0;
        while (fgetcsv($this->file, 0, $this->delimiter, $enclosure = '"', $escape = '\\') !== false) {
            $num_rows++;
        }

        rewind($this->file);
        $this->num_rows = $num_rows;
    }

    /**
     * Iterate over CSV rows (in chunks)
     */
    public function rows(int $chunk_size = self::CHUNK_SIZE): Generator
    {
        $this->getSize();
        $num_chunks = (int) ceil($this->num_rows / $chunk_size);
        $rows_in_last_chunk = $this->num_rows - (((int) floor($this->num_rows / $chunk_size)) * $chunk_size);

        $chunk_data = [];
        $row_index_in_chunk = 0;
        while (($row_data = fgetcsv($this->file, 0, $this->delimiter, $enclosure = '"', $escape = '\\')) !== false) {

            // Set header
            if ($this->row_index === $this->header_row_index) {
                $this->header = $row_data;
                // set rows
            } elseif ($this->row_index > $this->header_row_index) {
                // add row to chunk
                $chunk_data[] = array_combine($this->header(), $row_data);
                $row_index_in_chunk++;
                // chunk size reached
                if ($row_index_in_chunk === $chunk_size) {

                    yield $chunk_data;

                    // reset chunk and index
                    $this->chunk_index++;
                    $row_index_in_chunk = 0;
                    $chunk_data = [];
                }

                if ($this->chunk_index === $num_chunks - 1 && $row_index_in_chunk === $rows_in_last_chunk - 1) {
                    yield $chunk_data;
                }
            }

            $this->row_index++;
        }
    }
}
