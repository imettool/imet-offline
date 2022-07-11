<?php

namespace Tests\Feature;

use AndreaMarelli\ImetCore\Helpers\API\DOPA\DOPA;

use Tests\TestCase;

class ApiTest extends TestCase
{
    const ISO = 'CMR';
    const WDPA = '555547993';

    private function basicApiAssertions($response)
    {
        $this->assertIsArray($response);
        $this->assertJson(json_encode($response));
//        $this->assertArrayNotHasKey('error', $response);
    }

    public function testDopaCountryApi()
    {
        $response = DOPA::get_country_pa_stats(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_redlist_th_list(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3_country', (array) $response[0]);

        $response = DOPA::get_country_species_total(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_threatened_animals(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_endemics_threatened_vertebrates(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_all_inds(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('country_iso3', (array) $response[0]);

        $response = DOPA::get_country_pa_normalized_indicator(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_pa_normalized_indicator_marine(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_ecoregions_stats(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

        $response = DOPA::get_country_lc_copernicus(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('lc_class', (array) $response[0]);

        $response = DOPA::get_country_lcc_esa(static::ISO);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iso3', (array) $response[0]);

    }

    public function testDopaProtectedAreaApi()
    {
        $response = DOPA::get_wdpa_all_inds(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('wdpaid', (array) $response[0]);

        $response = DOPA::get_pa_ecoregions(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('wdpa_id', (array) $response[0]);

        $response = DOPA::get_wdpa_lcc_esa(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('lc2_2015', (array) $response[0]);

        $response = DOPA::get_worldclim_pa(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('type', (array) $response[0]);

        $response = DOPA::get_pa_redlist_status(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('class', (array) $response[0]);

        $response = DOPA::get_pa_redlist_list(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('iucn_species_id', (array) $response[0]);

        $response = DOPA::get_wdpa_radarplot(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('indicator', (array) $response[0]);

        $response = DOPA::get_wdpa_lc_copernicus(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('lc_class', (array) $response[0]);

        $response = DOPA::get_wdpa_ecoregions(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('wdpaid', (array) $response[0]);

        $response = DOPA::get_wdpa_copernicus(static::WDPA);
        $this->basicApiAssertions($response);
        $this->assertArrayHasKey('lc_class', (array) $response[0]);

    }

}
