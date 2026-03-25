# Architecture Diagrams

## 1. Module Diagram

```text
                                +----------------------+
                                |      Public User     |
                                +----------+-----------+
                                           |
                                           v
                                +----------------------+
                                |   Main Controller    |
                                |  search / issuance   |
                                +----------+-----------+
                                           |
                    +----------------------+----------------------+
                    |                                             |
                    v                                             v
         +---------------------------+                +---------------------------+
         |     ClubeModel            |                | CertificateIssuanceService|
         | clubs for search UI       |                | issuance orchestration    |
         +---------------------------+                +------------+--------------+
                                                                   |
                                         +-------------------------+-------------------------+
                                         |                                                   |
                                         v                                                   v
                           +---------------------------+                     +---------------------------+
                           |    CertificadosModel      |                     |     CertConfigModel       |
                           | certificate records       |                     | contest templates         |
                           +---------------------------+                     +---------------------------+
                                         |                                                   |
                                         +-------------------------+-------------------------+
                                                                   |
                                                                   v
                                                   +-------------------------------+
                                                   | cert_model view + PDF helper  |
                                                   +-------------------------------+


                                +----------------------+
                                |     Admin User       |
                                +----------+-----------+
                                           |
                                           v
                                +----------------------+
                                |  Login + Auth Filter |
                                +----------+-----------+
                                           |
                +--------------------------+---------------------------+
                |                          |                           |
                v                          v                           v
    +----------------------+   +----------------------+   +----------------------+
    | Certificado Ctrl     |   | CertConfig Ctrl      |   | Clube Ctrl           |
    | certificate CRUD     |   | template CRUD        |   | club CRUD            |
    +----------+-----------+   +----------+-----------+   +----------+-----------+
               |                          |                          |
               v                          v                          v
    +----------------------+   +----------------------+   +----------------------+
    | CSV Import Service   |   | Image Upload Service |   | ClubeModel           |
    +----------------------+   +----------------------+   +----------------------+
               |                          |
               v                          v
    +----------------------+   +----------------------+
    | CertificadosModel    |   | CertConfigModel      |
    +----------------------+   +----------------------+
```

## 2. Public Search Flow

```text
User
  |
  v
GET /tablecerts?callsign=... or ?clube=...
  |
  v
Main::tablecerts
  |
  +--> query certificados by callsign/operator
  |        or
  +--> query certificados by club code
  |
  v
Render result list view
  |
  v
User selects certificate
  |
  v
GET /pregeracert/{identificador}
  |
  v
Main::pregeracert
  |
  v
CertificateIssuanceService
  |
  +--> validate identifier
  +--> load certificate
  +--> ensure serial/generation date
  +--> load matching template
  +--> sanitize and assemble view data
  |
  v
Render cert_model
  |
  v
PDF output
```

## 3. Admin Authentication and Authorization Flow

```text
Admin User
  |
  v
POST /login/signIn
  |
  v
Login::signIn
  |
  +--> UsuarioModel::getByEmail
  +--> validate password
  +--> migrate MD5 to password_hash when needed
  +--> resolve roles and abilities
  +--> write session
  |
  v
Redirect /admin
  |
  v
Auth Filter on protected route
  |
  +--> session isLoggedIn?
  +--> permissions allow requested ability?
  |
  +--> no  -> redirect
  +--> yes -> controller action executes
```

## 4. Certificate Publication Flow

```text
Admin User
  |
  v
Create or import certificate
  |
  v
certificados record saved
  |
  v
POST /certificado/available/{id}
  |
  v
Certificado::markAvailable
  |
  +--> load record
  +--> set status = d
  +--> generate identificador if missing
  |
  v
Certificate becomes publicly issuable
```

## 5. CSV Import Flow

```text
Admin User
  |
  v
POST /certificado/import with CSV
  |
  v
Certificado::import
  |
  v
CertificateCsvImportService::importFromFile
  |
  +--> detect delimiter
  +--> normalize headers
  +--> iterate rows
  +--> map row to payload
  +--> default status and identifier
  +--> save via CertificadosModel
  |
  v
Import summary returned to UI
```

## 6. Template Management Flow

```text
Admin User
  |
  v
GET /certconfig/create or /certconfig/edit/{id}
  |
  v
CertConfig controller
  |
  +--> load existing template or default template
  +--> load available background images
  |
  v
Admin edits template fields
  |
  +--> POST /certconfig/preview
  |       |
  |       v
  |   CertificateIssuanceService builds sample preview
  |
  +--> POST /certconfig/store
          |
          v
      CertConfigModel::save
```

## 7. Deployment Topology

```text
Browser
  |
  v
Web server / PHP container
  |
  +--> serves public files from py9mt/
  +--> executes py9mt/index.php
  |
  v
CodeIgniter application in geracert/
  |
  +--> Controllers
  +--> Services
  +--> Models
  +--> Views
  |
  +--> MySQL database
  |
  +--> background images in py9mt/images/contest/
```
