<?php

namespace Tests\Feature;

use AndreaMarelli\ImetCore\Models\Imet\v1\Imet;
use AndreaMarelli\ImetCore\Models\Imet\v1\Imet_Eval;
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
