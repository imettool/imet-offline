<?php

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
        $this->get('admin/imet')->assertStatus(200);
        $this->get('admin/imet/v1')->assertStatus(200);
        $this->get('admin/imet/v2')->assertStatus(200);
    }

    public function testCreationRoutes()
    {
        $this->get('admin/imet/v2/context/create')->assertStatus(200);
        $this->get('admin/imet/v2/context/create_non_wdpa')->assertStatus(200);
    }

    public function testImportExportRoutes()
    {
        $this->get('admin/imet/import')->assertStatus(200);
        $this->get('admin/imet/export_view')->assertStatus(200);
    }

}
