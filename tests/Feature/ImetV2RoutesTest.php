<?php

namespace Tests\Feature;

use AndreaMarelli\ImetCore\Models\Imet\v2\Imet;
use AndreaMarelli\ImetCore\Models\Imet\v2\Imet_Eval;
use Tests\TestCase;


class ImetV2RoutesTest extends TestCase
{
    const MAX_IMETS = 9999;
    private static $IMET_IDS = null;

    protected function setUp(): void
    {
        parent::setUp();

        if(static::$IMET_IDS === null) {
            static::$IMET_IDS =
                Imet::select((new Imet())->getKeyName())
                    ->where('version', 'v2')
                    ->inRandomOrder()
                    ->limit(static::MAX_IMETS)
                    ->get()
                    ->pluck((new Imet())->getKeyName())
                    ->toArray();
        }
    }

    public function testV2ContextEditRoutes()
    {
        $modules = Imet::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/context/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/context/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2ContextShowRoutes()
    {
        $modules = Imet::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/context/' . $imet . '/show')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/context/' . $imet . '/show/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2EvaluationEditRoutes()
    {
        $modules = Imet_Eval::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/evaluation/' . $imet . '/edit')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/evaluation/' . $imet . '/edit/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2EvaluationShowRoutes()
    {
        $modules = Imet_Eval::modules();
        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/evaluation/' . $imet . '/show')->assertStatus(200);
            foreach (array_keys($modules) as $module){
                $this->get('admin/imet/v2/evaluation/' . $imet . '/show/' . $module)->assertStatus(200);
            }
        }
    }

    public function testV2AnalysisReportEditRoutes()
    {        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/report/' . $imet . '/edit')->assertStatus(200);
        }
    }

    public function testV2AnalysisReportShowRoutes()
    {        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/v2/report/' . $imet . '/show')->assertStatus(200);
        }
    }

    public function testV2ExportEditRoutes()
    {
        foreach (static::$IMET_IDS as $imet){
            $this->get('admin/imet/' . $imet . '/export')->assertStatus(200);
        }
    }

}
