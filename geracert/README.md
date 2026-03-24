# GERACERT

GERACERT is an open-source ham radio contest certificate generator built with PHP, CodeIgniter 4 and MySQL.

It was created to avoid manual certificate editing in desktop publishing tools and to keep contest certificates available online with a database-driven workflow. Organizers can store participant records, manage certificate templates, and generate PDF certificates on demand.

This repository is being published so radio clubs, contest managers and individual radio amateurs can reuse the project instead of building a certificate platform from scratch.

## Features

- Public search by callsign or club
- On-demand PDF certificate generation
- Administrative dashboard with role-based access
- Contest template management
- Certificate record management
- Club registry
- Database migrations and seeders
- Automated feature tests
- Basic multilingual UI support (`pt-BR` and `en`)

## Stack

- PHP 8.1
- CodeIgniter 4
- MySQL 8
- Bootstrap 5
- Dompdf
- Docker Compose

## Project Layout

```text
.
├── docker-compose.yaml
├── docker/
├── py9mt/                     # Public web root served by the PHP container / shared hosting
└── geracert/
    ├── app/                   # Application code
    ├── ci4/                   # CodeIgniter framework source used by this project
    ├── tests/                 # Automated tests
    ├── vendor/                # Composer dependencies
    └── README.md
```

## Why `py9mt/` and `geracert/` Are Separate

This repository intentionally uses two top-level directories because of the deployment model used in shared hosting environments such as Hostinger.

- `py9mt/` is the public web root
- `geracert/` contains the real CodeIgniter application, framework files, configuration, business logic and dependencies

In shared hosting, the public directory is usually `public_html`. The entire CodeIgniter application should not be exposed there. Only the front controller and public assets should be reachable from the web server.

For that reason:

- `py9mt/` plays the role that would normally be handled by a standard CI4 `public/` directory
- `geracert/` stays outside the public document root
- sensitive files such as app configuration, framework internals and dependencies remain protected from direct web access

So even though the layout is different from a default fresh CodeIgniter 4 project, it reflects a practical and safer structure for low-cost shared hosting.

## Requirements

- Docker and Docker Compose

If you want to run it without Docker, you will also need:

- PHP 8.1+
- Composer
- MySQL 8+
- Required PHP extensions for CodeIgniter and PDF generation

## Quick Start

From the repository root:

```bash
cp .env.example .env
docker compose up -d --build
```

Application URL:

- `http://localhost:8085`

## Database Setup

The default Docker stack reads values from the repository root `.env`.

Default example values:

- database: `geracert_dev`
- user: `geracert_dev`
- password: `change_me_dev_password`
- root password: `change_me_root_password`

Run migrations:

```bash
docker compose exec -T php sh -lc "cd /var/www/html/geracert && php spark migrate -n App"
```

Run seeders:

```bash
docker compose exec -T php sh -lc "cd /var/www/html/geracert && php spark db:seed DatabaseSeeder"
```

## Default Admin Account

The default seeder creates an administrator:

- email: `admin@geracert.local`
- password: `admin123456`
- role: `admin`

Override the seeded values if needed:

- `SEED_ADMIN_EMAIL`
- `SEED_ADMIN_NOME`
- `SEED_ADMIN_PASSWORD`

Example:

```bash
SEED_ADMIN_EMAIL=club@example.org \
SEED_ADMIN_NOME="Contest Admin" \
SEED_ADMIN_PASSWORD="change-this-password" \
docker compose exec -T php sh -lc "cd /var/www/html/geracert && php spark db:seed DatabaseSeeder"
```

## Environment

Use `geracert/.env.example` as a starting point and create your own `geracert/.env`.

Important settings:

- `CI_ENVIRONMENT`
- `app.baseURL`
- database credentials if you are not using the provided Docker stack

Recommended:

- use `development` locally
- use `production` on public servers
- enable HTTPS in production
- change default credentials immediately

## Shared Hosting Deployment Notes

If you deploy this project to Hostinger or another shared hosting provider:

- place `py9mt/` inside `public_html` or configure `public_html` to point to it
- keep `geracert/` outside the public directory whenever possible
- update the paths used by [index.php](/home/claudio/docker/geracert/py9mt/index.php) and [Paths.php](/home/claudio/docker/geracert/geracert/app/Config/Paths.php) if your hosting structure is different
- configure `app.baseURL` for your final domain

This split is not accidental. It is part of the deployment strategy.

## Running Tests

The project includes automated feature tests.

Run them with:

```bash
docker compose exec -T php sh -lc "cd /var/www/html/geracert && php vendor/bin/phpunit --testsuite App"
```

## Roles and Access

Current built-in roles:

- `admin`: full administrative access
- `editor`: dashboard, contests and certificates

## Multilingual UI

The application includes a basic language switcher using CodeIgniter language files.

Supported locales:

- `pt-BR`
- `en`

The selected language is stored in the session and can be changed from:

- public home page
- login page
- admin navigation bar

Language files:

- `app/Language/pt-BR/UI.php`
- `app/Language/en/UI.php`

## Certificate Template Customization

GERACERT generates certificates by combining:

- one certificate record from `certificados`
- one matching template from `certformat`
- one background image stored in `py9mt/images/contest/`

If you want to create a new contest certificate layout, read:

- [Certificate Template Guide](/home/claudio/docker/geracert/geracert/docs/CERTIFICATE_TEMPLATES.md)

That guide explains:

- where template files and images live
- which placeholders are available
- which HTML and CSS are allowed
- how `concurso` and `ano` matching works
- how to build a new template safely

It also includes CSV import examples for batch certificate loading.

## Typical Workflow

1. Start the containers.
2. Run migrations.
3. Run seeders.
4. Log in to the admin area.
5. Configure clubs.
6. Create or adjust contest templates.
7. Import or manually register certificate records.
8. Publish the public search page.

## Production Checklist

- set `CI_ENVIRONMENT=production`
- configure `app.baseURL`
- enable HTTPS
- replace default credentials
- test PDF generation with your real templates and assets
- configure backups for MySQL and uploaded assets

## Current Limitations

- the repository still uses a shared-hosting-oriented structure instead of a fresh standard CI4 layout
- some secondary UI texts are still being translated gradually
- background certificate images are intentionally not shipped in the public repository

## License

This project is distributed under a BSD-style attribution license. In practical terms:

- you may use it privately
- you may adapt it for your own radio club or event
- you may reuse it in other projects, including modified versions
- you must keep the original copyright and license notice
- you must preserve attribution to the original creator and GERACERT project

The full license text is available in [LICENSE](/home/claudio/docker/geracert/LICENSE).

Required attribution:

`This product includes software originally developed by Claudio 'PY9MT' for the GERACERT project.`

## Purpose

Many ham radio events need certificates, but building a complete workflow from zero is unnecessary repeated effort. GERACERT is intended as a reusable starting point for clubs and organizers that need searchable records, printable PDF output and a web-based administration panel.

## Credits

Created by Claudio `PY9MT`.

## Contributing and Security

- [Contributing Guide](/home/claudio/docker/geracert/CONTRIBUTING.md)
- [Security Policy](/home/claudio/docker/geracert/SECURITY.md)
- [Changelog](/home/claudio/docker/geracert/CHANGELOG.md)
