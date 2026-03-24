<?php

namespace Tests\Feature;

use App\Services\CertificateIssuanceService;
use Tests\TestCase;

class CertificateIssuanceServiceTest extends TestCase
{
    public function testBuildCertificateViewDataSanitizesTemplateAndKeepsExpectedValues(): void
    {
        $identifier = str_repeat('a', 64);

        $this->seeInDatabase('certificados', [
            'identificador' => $identifier,
            'indicativo' => 'PY9TEST',
        ]);

        $service = new CertificateIssuanceService();

        $data = $service->buildCertificateViewData($identifier);

        $this->assertSame('PY9TEST', $data['cert_vars']['$indicativo']);
        $this->assertStringContainsString('PY9TEST', $data['format_vars']['$div_texto']);
        $this->assertStringNotContainsString('<script', $data['format_vars']['$div_texto']);
        $this->assertStringNotContainsString('url(', $data['format_vars']['texto_text']);
        $this->assertStringEndsWith('.png', $data['format_vars']['imagem']);
    }
}
