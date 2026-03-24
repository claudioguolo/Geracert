<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'     => CSRF::class,
        'toolbar'  => DebugToolbar::class,
        'honeypot' => Honeypot::class,
        'auth'     => \App\Filters\Auth::class

    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'csrf' => [
                'except' => [
                    'certconfig/preview',
                ],
            ],
            // 'honeypot',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [];

    public function __construct()
    {
        parent::__construct();

        $environment = defined('ENVIRONMENT') ? ENVIRONMENT : (getenv('CI_ENVIRONMENT') ?: 'production');

        if ($environment === 'testing') {
            foreach ($this->globals['before'] as $key => $filter) {
                if ($key === 'csrf' || $filter === 'csrf') {
                    unset($this->globals['before'][$key]);
                }
            }
        }

        if ($environment !== 'development') {
            $this->globals['after'] = array_values(array_filter(
                $this->globals['after'],
                static fn (string $filter): bool => $filter !== 'toolbar'
            ));
        }
    }
}
