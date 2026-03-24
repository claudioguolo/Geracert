<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminCrudFeatureTest extends TestCase
{
    public function testAdminDashboardLoadsWithAdminSession(): void
    {
        $result = $this->withSession($this->adminSession())->get('/admin');

        $result->assertStatus(200);
        $result->assertSee('Concursos');
        $result->assertSee('Certificados');
        $result->assertSee('Clubes');
    }

    public function testCertificateCreateValidationReturnsErrors(): void
    {
        $result = $this->withSession($this->adminSession())->post('/certificado/store', [
            'indicativo' => '',
            'nome' => 'Teste',
            'concurso' => '',
            'ano' => '20AB',
            'pontuacao' => '10',
        ]);

        $result->assertStatus(200);
        $result->assertSee('Indicativo e obrigatorio.');
        $result->assertSee('Concurso e obrigatorio.');
        $result->assertSee('Ano deve conter apenas numeros.');
    }

    public function testCertificateCreatePersistsValidRecord(): void
    {
        $result = $this->withSession($this->adminSession())->call('post', '/certificado/store', [
            'indicativo' => 'ZZ9UNIT',
            'nome' => 'Teste Automatizado',
            'concurso' => 'UNIT',
            'ano' => '2026',
            'pontuacao' => '123',
        ]);

        $result->assertStatus(302);
        $result->assertRedirectTo(base_url('certificado'));

        $this->seeInDatabase('certificados', [
            'indicativo' => 'ZZ9UNIT',
            'concurso' => 'UNIT',
            'ano' => '2026',
        ]);
    }

    public function testContestFormIncludesVisualEditor(): void
    {
        $result = $this->withSession($this->adminSession())->get('/certconfig/create');

        $result->assertStatus(200);
        $result->assertSee('Editor visual');
        $result->assertSee('gc-preview-frame');
        $result->assertSee('gc-image-gallery');
        $result->assertSee('$indicativo');
    }

    public function testContestPreviewRouteRendersCertificateMarkup(): void
    {
        $result = $this->withSession($this->adminSession())->post('/certconfig/preview', [
            'concurso' => 'CQWS',
            'ano' => '2026',
            'organizador' => 'GERACERT',
            'imagem' => 'cqws2024.png',
            'html' => '<h2>$indicativo</h2><h4>$nome</h4>',
            'texto_text' => 'position: fixed; top: 250px; left: 10%; width: 80%;',
            'serial_text' => 'position: fixed; top: 10px; left: 10px;',
            'datetime_text' => 'position: fixed; top: 500px; left: 500px;',
            'size_h1' => '',
            'size_h2' => 'font-size: 36px;',
            'size_h3' => '',
            'size_h4' => 'font-size: 24px;',
            'size_h5' => '',
            'size_h6' => '',
        ]);

        $result->assertStatus(200);
        $result->assertSee('PY9MT');
        $result->assertSee('Claudio');
        $result->assertSee('GERACERT');
    }

    public function testContestCreatePersistsValidRecord(): void
    {
        $result = $this->withSession($this->adminSession())->call('post', '/certconfig/store', [
            'concurso' => 'NEW-CONTEST',
            'ano' => '2026',
            'organizador' => 'GERACERT',
            'imagem' => 'cqws2024.png',
            'html' => '<h2>$indicativo</h2>',
            'texto_text' => 'position: fixed; top: 250px; left: 10%; width: 80%;',
            'serial_text' => 'position: fixed; top: 10px; left: 10px;',
            'datetime_text' => 'position: fixed; top: 500px; left: 500px;',
            'size_h1' => '',
            'size_h2' => 'font-size: 36px;',
            'size_h3' => '',
            'size_h4' => '',
            'size_h5' => '',
            'size_h6' => '',
        ]);

        $result->assertStatus(302);
        $result->assertRedirectTo(base_url('certconfig'));

        $this->seeInDatabase('certformat', [
            'concurso' => 'NEW-CONTEST',
            'ano' => '2026',
        ]);
    }

    public function testContestCopyCreatesNewRecordWhenIdIsEmpty(): void
    {
        $existing = $this->grabFromDatabase('certformat', 'id', [
            'concurso' => 'CQWS',
            'ano' => '2022',
        ]);

        $result = $this->withSession($this->adminSession())->call('post', '/certconfig/store', [
            'id' => '',
            'concurso' => 'CQWS-COPY',
            'ano' => '2026',
            'organizador' => 'GERACERT',
            'imagem' => 'cqws2024.png',
            'html' => '<h2>$indicativo</h2>',
            'texto_text' => 'position: fixed; top: 250px; left: 10%; width: 80%;',
            'serial_text' => 'position: fixed; top: 10px; left: 10px;',
            'datetime_text' => 'position: fixed; top: 500px; left: 500px;',
            'size_h1' => '',
            'size_h2' => 'font-size: 36px;',
            'size_h3' => '',
            'size_h4' => '',
            'size_h5' => '',
            'size_h6' => '',
        ]);

        $result->assertStatus(302);
        $result->assertRedirectTo(base_url('certconfig'));

        $newId = $this->grabFromDatabase('certformat', 'id', [
            'concurso' => 'CQWS-COPY',
            'ano' => '2026',
        ]);

        $this->assertNotSame((string) $existing, (string) $newId);
    }

    public function testMarkCertificateAvailableAlsoGeneratesIdentifierWhenMissing(): void
    {
        $this->hasInDatabase('certificados', [
            'indicativo' => 'ZZ9UNIT',
            'concurso' => 'UNIT',
            'ano' => '2026',
        ]);

        $id = $this->grabFromDatabase('certificados', 'id', [
            'indicativo' => 'ZZ9UNIT',
            'concurso' => 'UNIT',
            'ano' => '2026',
        ]);

        $result = $this->withSession($this->adminSession())->call('post', '/certificado/available/' . $id);

        $result->assertStatus(302);
        $result->assertRedirectTo(base_url('certificado'));

        $identifier = $this->grabFromDatabase('certificados', 'identificador', ['id' => $id]);
        $status = $this->grabFromDatabase('certificados', 'status', ['id' => $id]);

        $this->assertSame('d', $status);
        $this->assertNotEmpty($identifier);
    }
}
