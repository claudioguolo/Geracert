<?php

namespace Tests;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

abstract class TestCase extends CIUnitTestCase
{
    use FeatureTestTrait;
    use DatabaseTestTrait;

    protected $refresh = true;
    protected $namespace = 'App';
    protected $basePath = APPPATH . 'Database';
    protected $seed = [
        \App\Database\Seeds\DatabaseSeeder::class,
        \App\Database\Seeds\TestDataSeeder::class,
    ];
    protected $DBGroup = 'tests';

    protected function adminSession(): array
    {
        return [
            'isLoggedIn' => true,
            'nome' => 'Administrador',
            'permissoes' => 'admin',
        ];
    }
}
