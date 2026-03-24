<?php

namespace Tests\Feature;

use App\Services\CertificateCsvImportService;
use Tests\TestCase;

class CertificateCsvImportServiceTest extends TestCase
{
    public function testImportFromCsvPersistsRowsAndDefaultsIdentifierAndStatus(): void
    {
        $csv = implode("\n", [
            'callsign,contest,year,name,score,category,mode',
            'ZZ9CSV,CSVTEST,2026,Import Test,321,SINGLE-OP,CW',
        ]);

        $path = tempnam(sys_get_temp_dir(), 'geracert_csv_');
        file_put_contents($path, $csv);

        $service = new CertificateCsvImportService();
        $summary = $service->importFromFile($path);

        @unlink($path);

        $this->assertSame(1, $summary['inserted']);
        $this->assertSame(0, $summary['updated']);
        $this->assertSame(0, count($summary['errors']));

        $this->seeInDatabase('certificados', [
            'indicativo' => 'ZZ9CSV',
            'concurso' => 'CSVTEST',
            'ano' => '2026',
            'status' => 'd',
        ]);
    }
}
