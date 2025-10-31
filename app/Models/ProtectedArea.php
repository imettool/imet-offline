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

namespace App\Models;

use Database\Factories\ProtectedAreaFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ImetCore\Models\ProtectedArea as BaseProtectedArea;

/**
 * Class ProtectedArea
 * Extends the base ProtectedArea model from ImetCore to provide database factory support.
 */
class ProtectedArea extends BaseProtectedArea
{
    use HasFactory;

    protected static function newFactory(): Factory
    {
        return ProtectedAreaFactory::new();
    }
}
