# Scope Documentation

## 1. Project Objective

GERACERT is a web application for registering, publishing and issuing ham radio contest certificates on demand. The system removes manual certificate production in desktop publishing tools and centralizes the process in a database-driven workflow with reusable templates by contest and year.

## 2. Problem the System Solves

The project serves clubs, contest organizers and certificate administrators who need to:

- maintain a participant and results catalog;
- make certificates publicly searchable by callsign or club;
- generate PDFs on demand from a standardized layout;
- reuse visual templates by contest;
- operate a simple administrative panel with access control.

## 3. Current Functional Scope

### 3.1 Public area

- home page with language selection;
- public certificate search by callsign, operator or club;
- listing of matching results;
- certificate issuance access through a public identifier;
- PDF generation at request time.

### 3.2 Administrative area

- email and password authentication;
- transparent migration from legacy MD5 hashes to `password_hash`;
- administrative dashboard;
- certificate CRUD;
- ability to mark a certificate as publicly available;
- batch certificate import via CSV;
- contest/template CRUD;
- copy of existing templates to speed up new contest setup;
- HTML preview before publication;
- background image upload for certificates;
- club CRUD.

### 3.3 Access control

Currently implemented roles:

- `admin`: full access to dashboard, certificates, templates and clubs;
- `editor`: access to dashboard, certificates and templates, without club management.

Access control is based on the `permissoes` field in the `usuarios` table and interpreted by `AuthorizationService`.

## 4. Main Business Flows

### 4.1 Certificate publication

1. The administrator creates or imports a certificate.
2. The record receives or generates a unique `identificador`.
3. The administrator marks the certificate as available.
4. The user searches by callsign or club.
5. The system finds the certificate and the matching contest/year template.
6. The template HTML is filled with certificate data.
7. The PDF is generated on demand.

### 4.2 Contest template creation

1. The user opens the contest management area.
2. The user defines contest, year, organizer, image and style blocks.
3. The user adjusts HTML placeholders such as `$indicativo`, `$nome`, `$categoria` and `$pontuacao`.
4. The user uses the preview route to validate the layout.
5. The template is saved for real issuance.

### 4.3 Batch import

1. The user uploads a CSV file.
2. The system detects the delimiter and normalizes Portuguese and English headers.
3. Valid rows are inserted or updated.
4. Critical missing fields receive defaults, such as `status = d` and automatic `identificador` generation.
5. The system returns a summary with inserted, updated, skipped and error counts.

## 5. System Modules

### 5.1 Public search and issuance

Responsibilities:

- search by callsign, operator or club;
- prepare certificate data;
- load the visual template by contest and year;
- render HTML and issue PDF.

Core files:

- `app/Controllers/Main.php`
- `app/Services/CertificateIssuanceService.php`

### 5.2 Authentication and authorization

Responsibilities:

- login and logout;
- session storage;
- route-level permission checks;
- translation of roles into abilities.

Core files:

- `app/Controllers/Login.php`
- `app/Filters/Auth.php`
- `app/Services/AuthorizationService.php`

### 5.3 Certificate management

Responsibilities:

- manual registration;
- editing and deletion;
- public availability release;
- batch import.

Core files:

- `app/Controllers/Certificado.php`
- `app/Models/CertificadosModel.php`
- `app/Services/CertificateCsvImportService.php`

### 5.4 Certificate template management

Responsibilities:

- maintain layouts by contest/year;
- configure allowed HTML and CSS fragments;
- preview certificate output;
- upload background files.

Core files:

- `app/Controllers/CertConfig.php`
- `app/Models/CertConfigModel.php`
- `app/Services/ContestImageUploadService.php`

### 5.5 Club management

Responsibilities:

- maintain the club registry;
- support club-based public search.

Core files:

- `app/Controllers/Clube.php`
- `app/Models/ClubeModel.php`

## 6. Data Structure in Current Scope

Main tables:

- `usuarios`: credentials, name, email and roles;
- `clubes`: club registry and codes;
- `certformat`: visual templates and style parameters;
- `certificados`: results, participant data, issuance metadata and public identifier;
- `ci_sessions`: session persistence.

Relevant relationships:

- `certificados.concurso` + `certificados.ano` must match `certformat.concurso` + `certformat.ano` for successful issuance;
- `certificados.cod_clube` is used in public search by club;
- `usuarios.permissoes` governs admin access.

## 7. Important Rules and Restrictions

- public issuance depends on a valid `identificador`;
- issuance also depends on an existing template for the same contest and year;
- template HTML is sanitized before rendering;
- only a subset of HTML tags, CSS classes and CSS properties is allowed;
- image uploads accept only PNG and JPEG with validation for size, resolution and ratio;
- the project layout is designed to keep the real application outside the public document root.

## 8. Technical Dependencies

- PHP 8.1;
- CodeIgniter 4;
- MySQL 8;
- Bootstrap 5;
- Dompdf;
- Docker Compose for local development.

Relevant topology:

- `py9mt/` acts as the public web root;
- `geracert/` contains application code, framework, tests and dependencies.

## 9. Out of Scope in the Current State

There is no visible implementation in the project for:

- multi-step approval workflow;
- detailed audit trail by user action;
- public API or administrative REST API;
- email notifications;
- multi-tenant organization isolation;
- formal versioning of certificate templates;
- asynchronous PDF generation queue;
- fine-grained permission model beyond the current roles.

## 10. Existing Test Coverage

The project already includes automated tests for:

- authentication and role restrictions;
- public search;
- basic administrative CRUD;
- template preview and persistence;
- identifier generation when publishing a certificate;
- issuance sanitization;
- CSV import;
- contest image upload.

This reduces regression risk in the main flows of the current scope, but it does not replace visual validation of templates and production operational testing.

## 11. Target Users

- amateur radio clubs;
- contest organizers;
- administrators who publish certificates;
- participants who search and download their certificates.

## 12. Executive Summary

The current GERACERT scope covers the main business cycle for contest certificates: registration or import of results, certificate layout configuration, public search and on-demand PDF issuance, with a simple administrative panel and role-based access control. The system is already structured for practical use, especially in shared hosting and lean club operations.
