<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicSearchFeatureTest extends TestCase
{
    public function testSearchByStationShowsSeededCertificate(): void
    {
        $result = $this->get('/tablecerts', ['callsign' => 'PY9TEST']);

        $result->assertStatus(200);
        $result->assertSee('PY9TEST');
        $result->assertSee('OPERADOR TESTE');
    }

    public function testSearchByClubShowsSeededClubCertificate(): void
    {
        $result = $this->get('/tablecerts', ['clube' => '001']);

        $result->assertStatus(200);
        $result->assertSee('16 GRUPO ESCOTEIRO ANHANGA');
        $result->assertSee('CQWS');
        $result->assertSee('99');
    }
}
