<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
    public function testLoginPageLoads(): void
    {
        $result = $this->get('/login');

        $result->assertStatus(200);
        $result->assertSee('Área Administrativa');
    }

    public function testLoginPageCanRenderInEnglish(): void
    {
        $result = $this->withSession([
            'locale' => 'en',
        ])->get('/login');

        $result->assertStatus(200);
        $result->assertSee('Administrative Area');
        $result->assertSee('Language');
        $result->assertSee('Log in');
    }

    public function testProtectedRouteRedirectsWhenUnauthenticated(): void
    {
        $result = $this->get('/admin');

        $result->assertRedirectTo('/login');
    }

    public function testAdminLoginRedirectsToDashboard(): void
    {
        $result = $this->post('/login/signIn', [
            'inputEmail' => 'admin@geracert.local',
            'inputPassword' => 'admin123456',
        ]);

        $result->assertRedirectTo(base_url('admin'));
    }

    public function testEditorCanAccessDashboardButNotClubs(): void
    {
        $login = $this->post('/login/signIn', [
            'inputEmail' => 'editor@geracert.local',
            'inputPassword' => 'editor123456',
        ]);

        $login->assertRedirectTo(base_url('admin'));

        $dashboard = $this->withSession([
            'isLoggedIn' => true,
            'nome' => 'Editor',
            'permissoes' => 'editor',
        ])->get('/admin');
        $dashboard->assertStatus(200);

        $clubs = $this->withSession([
            'isLoggedIn' => true,
            'nome' => 'Editor',
            'permissoes' => 'editor',
        ])->get('/clube');
        $clubs->assertRedirectTo(base_url('/'));
    }
}
