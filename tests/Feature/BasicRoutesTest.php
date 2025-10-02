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

use Tests\TestCase;

class BasicRoutesTest extends TestCase
{

    public function testHomeRoutes()
    {
        $this->get('/')->assertStatus(302); // Redirect

        // Offline user
        $this->get('confirm_user')->assertStatus(200);
        $this->patch('confirm_user', [
            'first_name' => 'TestUser Firstname',
            'last_name' => 'TestUser Lastname',
            'organisation'  => 'testorg',
            'function'      => 'tesfunct',
            'country'       => 'CMR'
        ])->assertStatus(302);                  // Redirect

        // List
        $this->get('imet')->assertStatus(200);
        $this->get('imet/v1')->assertStatus(200);
        $this->get('imet/v2')->assertStatus(200);
    }

    public function testCreationRoutes()
    {
        $this->get('imet/v2/context/create')->assertStatus(200);
        $this->get('imet/v2/context/create_non_wdpa')->assertStatus(200);
    }

    public function testImportExportRoutes()
    {
        $this->get('imet/import')->assertStatus(200);
        $this->get('imet/export_view')->assertStatus(200);
    }

}
