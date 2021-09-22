<?php

namespace Tests\Feature;

use AndreaMarelli\ImetCore\Models\Imet\v1;
use AndreaMarelli\ImetCore\Models\Imet\v2;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    const NUM_IMETS = 1;

    private static function imetsV1()
    {
        return v1\Imet::where('version', 'v1')
            ->inRandomOrder()
            ->limit(static::NUM_IMETS)
            ->get()
            ->pluck((new v1\Imet())->getKeyName())
            ->toArray();
    }

    private static function imetsV2()
    {
        return v2\Imet::where('version', 'v2')
            ->inRandomOrder()
            ->limit(static::NUM_IMETS)
            ->get()
            ->pluck((new v2\Imet())->getKeyName())
            ->toArray();
    }

    public function testHomeRoutes()
    {
        $this->get('/')->assertStatus(302); // Redirect

        // Offline user
        $this->get('admin/confirm_user')->assertStatus(200);
        $this->patch('admin/staff/0', [
            'first_name' => 'TestUser Firstname',
            'last_name' => 'TestUser Lastname',
        ])->assertStatus(302);                  // Redirect

        // List
        $this->get('admin/imet')->assertStatus(200);
        $this->get('admin/imet/v1')->assertStatus(200);
        $this->get('admin/imet/v2')->assertStatus(200);

    }

    public function testV1ContextEditRoutes()
    {
        $imets = static::imetsV1();
        $modules = v1\Imet::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v1/context/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v1/context/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2ContextEditRoutes()
    {
        $imets = static::imetsV2();
        $modules = v2\Imet::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v2/context/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/context/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2ContextShowRoutes()
    {
        $imets = static::imetsV2();
        $modules = v2\Imet::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v2/context/' . $imet . '/show')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/context/' . $imet . '/show/' . $module)->assertStatus(200);
            }
        }

    }

    public function testV1EvaluationEditRoutes()
    {
        $imets = static::imetsV1();
        $modules = v1\Imet_Eval::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v1/evaluation/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v1/evaluation/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2EvaluationEditRoutes()
    {
        $imets = static::imetsV2();
        $modules = v2\Imet_Eval::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v2/evaluation/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/evaluation/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2EvaluationShowRoutes()
    {
        $imets = static::imetsV2();
        $modules = v2\Imet_Eval::modules();

        foreach ($imets as $imet){
            $this->get('admin/imet/v2/evaluation/' . $imet . '/show')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/evaluation/' . $imet . '/show/' . $module)->assertStatus(200);
            }
        }
    }

}
