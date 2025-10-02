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

namespace Tests\Feature;

use ImetCore\Models\Imet\v1\Imet;
use ImetCore\Models\Imet\v1\Imet_Eval;
use Tests\TestCase;


class ImetV1RoutesTest extends TestCase
{
    const MAX_IMETS = 9999;
    private static $IMET_IDS = null;

    protected function setUp(): void
    {
        parent::setUp();

        if(static::$IMET_IDS === null) {
            static::$IMET_IDS =
                Imet::select((new Imet())->getKeyName())
                    ->where('version', 'v1')
                    ->inRandomOrder()
                    ->limit(static::MAX_IMETS)
                    ->get()
                    ->pluck((new Imet())->getKeyName())
                    ->toArray();
        }
    }

    public function testV1ContextEditRoutes()
    {
        $modules = Imet::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('imet/v1/context/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('imet/v1/context/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV1EvaluationEditRoutes()
    {
        $modules = Imet_Eval::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('imet/v1/evaluation/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('imet/v1/evaluation/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV1AnalysisReportEditRoutes()
    {
        foreach (static::$IMET_IDS as $imet){
            $this->get('imet/v1/report/' . $imet . '/edit')->assertStatus(200);
        }
    }

    public function testV1AnalysisReportShowRoutes()
    {
        foreach (static::$IMET_IDS as $imet){
            $this->get('imet/v1/report/' . $imet . '/show')->assertStatus(200);
        }
    }

    public function testV1ExportEditRoutes()
    {
        foreach (static::$IMET_IDS as $imet){
            $this->get('imet/' . $imet . '/export')->assertStatus(200);
        }
    }

}
