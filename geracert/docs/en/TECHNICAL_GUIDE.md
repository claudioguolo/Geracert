# Technical Guide

## 1. Technical Summary

GERACERT is a PHP 8.1 application built on CodeIgniter 4 with MySQL and Dompdf. The repository uses a split deployment structure:

- `py9mt/`: public web root, static assets and front controller;
- `geracert/`: application code, framework source, tests, migrations and dependencies.

This layout is intentional and supports shared hosting deployment with reduced exposure of internal application files.

## 2. Main Stack

- PHP 8.1
- CodeIgniter 4
- MySQL 8
- Bootstrap 5
- Dompdf
- Docker Compose

## 3. Application Structure

Relevant paths:

- `geracert/app/Controllers`: HTTP entrypoints and route handlers;
- `geracert/app/Services`: business logic and processing services;
- `geracert/app/Models`: database access and validation rules;
- `geracert/app/Filters`: authentication and authorization guards;
- `geracert/app/Database/Migrations`: schema definition;
- `geracert/app/Database/Seeds`: initial and test data;
- `geracert/app/Views`: public and admin presentation layer;
- `geracert/tests/Feature`: feature and service-level tests.

## 4. Routing and Access Control

Routes are defined in `app/Config/Routes.php` with `setAutoRoute(false)`.

Main public routes:

- `/`
- `/locale/{locale}`
- `/tablecerts`
- `/pregeracert/{identifier}`
- `/login`

Protected route groups:

- `/admin`
- `/certificado/*`
- `/certconfig/*`
- `/clube/*`

Authorization is enforced through `App\Filters\Auth`, which checks session state and abilities derived from `AuthorizationService`.

Current roles:

- `admin`
- `editor`

## 5. Main Modules

### 5.1 Public search and issuance

Files:

- `app/Controllers/Main.php`
- `app/Services/CertificateIssuanceService.php`
- `app/Views/tablecerts_index.php`
- `app/Views/hamcerts.php`
- `app/Views/clubecerts.php`
- `app/Views/cert_model.php`

Responsibilities:

- search certificates by callsign/operator or club;
- load certificate and contest template data;
- sanitize rendered content;
- produce final HTML for PDF generation.

### 5.2 Authentication

Files:

- `app/Controllers/Login.php`
- `app/Models/UsuarioModel.php`
- `app/Filters/Auth.php`
- `app/Services/AuthorizationService.php`

Responsibilities:

- authenticate admin users;
- migrate legacy MD5 passwords after successful login;
- persist session attributes;
- protect routes by ability.

### 5.3 Certificate management

Files:

- `app/Controllers/Certificado.php`
- `app/Models/CertificadosModel.php`
- `app/Services/CertificateCsvImportService.php`

Responsibilities:

- list, create, edit and delete certificates;
- import CSV rows into `certificados`;
- generate `identificador` when missing;
- mark records as publicly available.

### 5.4 Contest/template management

Files:

- `app/Controllers/CertConfig.php`
- `app/Models/CertConfigModel.php`
- `app/Services/ContestImageUploadService.php`

Responsibilities:

- maintain template records in `certformat`;
- preview certificate rendering using sample data;
- upload and validate contest background images;
- support copy workflow for existing templates;
- preserve compatibility with legacy form payloads.

### 5.5 Club management

Files:

- `app/Controllers/Clube.php`
- `app/Models/ClubeModel.php`

Responsibilities:

- maintain club registry used by public search and admin workflows.

## 6. Database Model

Main tables:

- `usuarios`
- `clubes`
- `certformat`
- `certificados`
- `ci_sessions`

Key functional dependencies:

- `certificados.concurso` + `certificados.ano` must match a `certformat` record for issuance;
- `certificados.identificador` is the public issuance key;
- `certificados.cod_clube` supports club-oriented search;
- `usuarios.permissoes` stores roles or explicit abilities.

## 7. Issuance Pipeline

Issuance flow implemented mainly in `CertificateIssuanceService`:

1. validate identifier format;
2. load certificate from `certificados`;
3. ensure serial and generation date exist;
4. load matching template from `certformat`;
5. map certificate data to placeholders;
6. sanitize HTML and CSS fragments;
7. resolve sanitized background image path;
8. render `app/Views/cert_model.php`;
9. hand resulting HTML to the PDF helper.

## 8. Template Safety Model

The template engine is intentionally constrained.

Current controls:

- limited HTML tag allowlist;
- limited CSS property allowlist;
- restricted CSS class preservation;
- background image path sanitization;
- HTML escaping for certificate variable values.

This keeps admin-managed templates flexible enough for certificate composition while reducing injection risk.

## 9. CSV Import Rules

`CertificateCsvImportService` supports:

- delimiter auto-detection;
- Portuguese and English header aliases;
- blank row skipping;
- insert or update behavior through CodeIgniter model `save()`;
- defaulting `status` to `d`;
- automatic identifier generation when not provided.

Accepted header canonical fields are exposed by `acceptedHeaders()`.

## 10. Image Upload Rules

`ContestImageUploadService` currently validates:

- upload success status;
- maximum file size;
- MIME type limited to PNG and JPEG;
- minimum dimensions;
- aspect ratio tolerance;
- duplicate filename prevention.

Files are stored under `py9mt/images/contest/`.

## 11. Test Strategy

The project uses:

- `CIUnitTestCase`
- `FeatureTestTrait`
- `DatabaseTestTrait`

Base test behavior is defined in `tests/TestCase.php` with database refresh enabled and seeders loaded automatically.

Current automated coverage includes:

- public search;
- authentication;
- admin CRUD scenarios;
- issuance sanitization;
- CSV import;
- contest image upload.

## 12. Local Development Notes

Top-level operational commands are already described in `README.md`.

Important practical points:

- the Docker entrypoint serves the application from the repository root setup;
- migrations live under `app/Database/Migrations`;
- seeders can recreate baseline admin data;
- tests rely on the dedicated test database configuration.

## 13. Known Technical Limits

- no REST API layer;
- no asynchronous job queue for PDF generation;
- no formal template version history;
- simple role model rather than fine-grained policy objects;
- some legacy naming and compatibility routes remain in place.

## 14. Recommended Next Technical Improvements

- add explicit unique constraint strategy for contest/year templates if business rules require it;
- introduce audit logging for admin actions;
- formalize service boundaries around PDF helper usage;
- improve domain-level validation for publication readiness;
- document deployment variants beyond Docker and shared hosting.
