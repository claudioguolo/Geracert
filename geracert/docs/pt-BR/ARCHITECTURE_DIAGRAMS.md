# Diagramas de Arquitetura

## 1. Diagrama de Modulos

```text
                                +----------------------+
                                |    Usuario Publico   |
                                +----------+-----------+
                                           |
                                           v
                                +----------------------+
                                |   Main Controller    |
                                | busca / emissao      |
                                +----------+-----------+
                                           |
                    +----------------------+----------------------+
                    |                                             |
                    v                                             v
         +---------------------------+                +---------------------------+
         |     ClubeModel            |                | CertificateIssuanceService|
         | clubes para busca         |                | orquestracao de emissao   |
         +---------------------------+                +------------+--------------+
                                                                   |
                                         +-------------------------+-------------------------+
                                         |                                                   |
                                         v                                                   v
                           +---------------------------+                     +---------------------------+
                           |    CertificadosModel      |                     |     CertConfigModel       |
                           | registros de certificado  |                     | modelos de concurso       |
                           +---------------------------+                     +---------------------------+
                                         |                                                   |
                                         +-------------------------+-------------------------+
                                                                   |
                                                                   v
                                                   +-------------------------------+
                                                   | cert_model view + helper PDF  |
                                                   +-------------------------------+


                                +----------------------+
                                |   Usuario Admin      |
                                +----------+-----------+
                                           |
                                           v
                                +----------------------+
                                | Login + Auth Filter  |
                                +----------+-----------+
                                           |
                +--------------------------+---------------------------+
                |                          |                           |
                v                          v                           v
    +----------------------+   +----------------------+   +----------------------+
    | Certificado Ctrl     |   | CertConfig Ctrl      |   | Clube Ctrl           |
    | CRUD certificados    |   | CRUD modelos         |   | CRUD clubes          |
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

## 2. Fluxo de Busca Publica

```text
Usuario
  |
  v
GET /tablecerts?callsign=... ou ?clube=...
  |
  v
Main::tablecerts
  |
  +--> consulta certificados por indicativo/operador
  |        ou
  +--> consulta certificados por codigo do clube
  |
  v
Renderiza a lista de resultados
  |
  v
Usuario seleciona o certificado
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
  +--> valida identificador
  +--> carrega certificado
  +--> garante serial/data de geracao
  +--> carrega modelo correspondente
  +--> sanitiza e monta os dados da view
  |
  v
Renderiza cert_model
  |
  v
Saida PDF
```

## 3. Fluxo de Autenticacao e Autorizacao

```text
Usuario Admin
  |
  v
POST /login/signIn
  |
  v
Login::signIn
  |
  +--> UsuarioModel::getByEmail
  +--> valida senha
  +--> migra MD5 para password_hash quando necessario
  +--> resolve papeis e capacidades
  +--> grava sessao
  |
  v
Redirect /admin
  |
  v
Auth Filter na rota protegida
  |
  +--> sessao isLoggedIn?
  +--> permissoes autorizam a capacidade pedida?
  |
  +--> nao -> redirect
  +--> sim -> controller executa
```

## 4. Fluxo de Publicacao de Certificado

```text
Usuario Admin
  |
  v
Cria ou importa certificado
  |
  v
registro em certificados salvo
  |
  v
POST /certificado/available/{id}
  |
  v
Certificado::markAvailable
  |
  +--> carrega registro
  +--> define status = d
  +--> gera identificador se estiver ausente
  |
  v
Certificado torna-se publicamente emitivel
```

## 5. Fluxo de Importacao CSV

```text
Usuario Admin
  |
  v
POST /certificado/import com CSV
  |
  v
Certificado::import
  |
  v
CertificateCsvImportService::importFromFile
  |
  +--> detecta delimitador
  +--> normaliza cabecalhos
  +--> percorre linhas
  +--> mapeia linha para payload
  +--> define status e identificador padrao
  +--> salva via CertificadosModel
  |
  v
Resumo da importacao retorna para a interface
```

## 6. Fluxo de Gestao de Modelos

```text
Usuario Admin
  |
  v
GET /certconfig/create ou /certconfig/edit/{id}
  |
  v
Controller CertConfig
  |
  +--> carrega modelo existente ou modelo padrao
  +--> carrega imagens de fundo disponiveis
  |
  v
Admin edita campos do modelo
  |
  +--> POST /certconfig/preview
  |       |
  |       v
  |   CertificateIssuanceService monta preview de exemplo
  |
  +--> POST /certconfig/store
          |
          v
      CertConfigModel::save
```

## 7. Topologia de Implantacao

```text
Browser
  |
  v
Web server / container PHP
  |
  +--> serve arquivos publicos de py9mt/
  +--> executa py9mt/index.php
  |
  v
Aplicacao CodeIgniter em geracert/
  |
  +--> Controllers
  +--> Services
  +--> Models
  +--> Views
  |
  +--> banco MySQL
  |
  +--> imagens de fundo em py9mt/images/contest/
```
