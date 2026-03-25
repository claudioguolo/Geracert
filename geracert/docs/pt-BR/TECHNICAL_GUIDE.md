# Guia Tecnico

## 1. Resumo Tecnico

GERACERT e uma aplicacao PHP 8.1 construida em CodeIgniter 4, com MySQL e Dompdf. O repositorio usa uma estrutura de implantacao separada:

- `py9mt/`: web root publico, assets estaticos e front controller;
- `geracert/`: codigo da aplicacao, fonte do framework, testes, migrations e dependencias.

Essa estrutura e intencional e facilita implantacao em hospedagem compartilhada com menor exposicao dos arquivos internos.

## 2. Stack Principal

- PHP 8.1
- CodeIgniter 4
- MySQL 8
- Bootstrap 5
- Dompdf
- Docker Compose

## 3. Estrutura da Aplicacao

Caminhos relevantes:

- `geracert/app/Controllers`: entrypoints HTTP e handlers de rota;
- `geracert/app/Services`: logica de negocio e servicos de processamento;
- `geracert/app/Models`: acesso a banco e regras de validacao;
- `geracert/app/Filters`: guardas de autenticacao e autorizacao;
- `geracert/app/Database/Migrations`: definicao de schema;
- `geracert/app/Database/Seeds`: dados iniciais e de teste;
- `geracert/app/Views`: camada de apresentacao publica e administrativa;
- `geracert/tests/Feature`: testes de feature e servicos.

## 4. Rotas e Controle de Acesso

As rotas sao definidas em `app/Config/Routes.php` com `setAutoRoute(false)`.

Rotas publicas principais:

- `/`
- `/locale/{locale}`
- `/tablecerts`
- `/pregeracert/{identifier}`
- `/login`

Grupos de rotas protegidas:

- `/admin`
- `/certificado/*`
- `/certconfig/*`
- `/clube/*`

A autorizacao e aplicada por `App\Filters\Auth`, que valida sessao e capacidades derivadas de `AuthorizationService`.

Papeis atuais:

- `admin`
- `editor`

## 5. Modulos Principais

### 5.1 Busca publica e emissao

Arquivos:

- `app/Controllers/Main.php`
- `app/Services/CertificateIssuanceService.php`
- `app/Views/tablecerts_index.php`
- `app/Views/hamcerts.php`
- `app/Views/clubecerts.php`
- `app/Views/cert_model.php`

Responsabilidades:

- buscar certificados por indicativo, operador ou clube;
- carregar dados de certificado e modelo;
- sanitizar o conteudo renderizado;
- produzir o HTML final para geracao de PDF.

### 5.2 Autenticacao

Arquivos:

- `app/Controllers/Login.php`
- `app/Models/UsuarioModel.php`
- `app/Filters/Auth.php`
- `app/Services/AuthorizationService.php`

Responsabilidades:

- autenticar usuarios administrativos;
- migrar senhas MD5 legadas apos login bem-sucedido;
- persistir atributos de sessao;
- proteger rotas por capacidade.

### 5.3 Gestao de certificados

Arquivos:

- `app/Controllers/Certificado.php`
- `app/Models/CertificadosModel.php`
- `app/Services/CertificateCsvImportService.php`

Responsabilidades:

- listar, criar, editar e excluir certificados;
- importar linhas CSV para `certificados`;
- gerar `identificador` quando ausente;
- marcar registros como publicamente disponiveis.

### 5.4 Gestao de concursos e modelos

Arquivos:

- `app/Controllers/CertConfig.php`
- `app/Models/CertConfigModel.php`
- `app/Services/ContestImageUploadService.php`

Responsabilidades:

- manter modelos em `certformat`;
- gerar preview com dados de exemplo;
- fazer upload e validacao de imagens de fundo;
- suportar copia de modelos existentes;
- manter compatibilidade com payloads legados.

### 5.5 Gestao de clubes

Arquivos:

- `app/Controllers/Clube.php`
- `app/Models/ClubeModel.php`

Responsabilidades:

- manter o cadastro de clubes usado pela busca publica e pelo admin.

## 6. Modelo de Dados

Tabelas principais:

- `usuarios`
- `clubes`
- `certformat`
- `certificados`
- `ci_sessions`

Dependencias funcionais chave:

- `certificados.concurso` + `certificados.ano` devem corresponder a um registro em `certformat` para emissao;
- `certificados.identificador` e a chave publica de emissao;
- `certificados.cod_clube` suporta busca orientada por clube;
- `usuarios.permissoes` armazena papeis ou capacidades explicitas.

## 7. Pipeline de Emissao

Fluxo de emissao implementado principalmente em `CertificateIssuanceService`:

1. validar o formato do identificador;
2. carregar o certificado em `certificados`;
3. garantir serial e data de geracao;
4. carregar o modelo correspondente em `certformat`;
5. mapear dados do certificado para placeholders;
6. sanitizar trechos de HTML e CSS;
7. resolver o caminho sanitizado da imagem de fundo;
8. renderizar `app/Views/cert_model.php`;
9. entregar o HTML final ao helper de PDF.

## 8. Modelo de Seguranca dos Templates

O motor de templates e intencionalmente restrito.

Controles atuais:

- allowlist limitada de tags HTML;
- allowlist limitada de propriedades CSS;
- preservacao restrita de classes CSS;
- sanitizacao do caminho da imagem de fundo;
- escape HTML dos valores de variaveis do certificado.

Isso mantem flexibilidade suficiente para composicao do certificado, reduzindo risco de injecao.

## 9. Regras de Importacao CSV

`CertificateCsvImportService` suporta:

- deteccao automatica de delimitador;
- aliases de cabecalho em portugues e ingles;
- descarte de linhas em branco;
- comportamento de insert ou update via `save()` do model;
- definicao padrao de `status` como `d`;
- geracao automatica de identificador quando ausente.

Os campos canonicos aceitos sao expostos por `acceptedHeaders()`.

## 10. Regras de Upload de Imagem

`ContestImageUploadService` atualmente valida:

- status de upload;
- tamanho maximo do arquivo;
- MIME type limitado a PNG e JPEG;
- dimensoes minimas;
- tolerancia de proporcao;
- prevencao de nome duplicado.

Os arquivos sao armazenados em `py9mt/images/contest/`.

## 11. Estrategia de Testes

O projeto usa:

- `CIUnitTestCase`
- `FeatureTestTrait`
- `DatabaseTestTrait`

O comportamento base dos testes fica em `tests/TestCase.php`, com refresh de banco habilitado e seeders carregados automaticamente.

A cobertura automatizada atual inclui:

- busca publica;
- autenticacao;
- cenarios de CRUD administrativo;
- sanitizacao da emissao;
- importacao CSV;
- upload de imagem de concurso.

## 12. Notas para Desenvolvimento Local

Os principais comandos operacionais ja estao descritos em `README.md`.

Pontos praticos importantes:

- o ambiente Docker serve a aplicacao a partir do setup do repositorio;
- migrations ficam em `app/Database/Migrations`;
- seeders podem recriar os dados administrativos basicos;
- os testes dependem da configuracao dedicada de banco de teste.

## 13. Limites Tecnicos Conhecidos

- nao ha camada REST API;
- nao ha fila assincrona para geracao de PDF;
- nao ha historico formal de versao de modelos;
- o modelo de papeis e simples, sem policy objects granulares;
- ainda existem nomes e rotas de compatibilidade legada.

## 14. Melhorias Tecnicas Recomendadas

- adicionar estrategia explicita de unicidade para modelos por concurso e ano, se a regra de negocio exigir;
- introduzir auditoria de acoes administrativas;
- formalizar melhor os limites de servico ao redor do helper de PDF;
- melhorar validacao de dominio para prontidao de publicacao;
- documentar variantes de implantacao alem de Docker e hospedagem compartilhada.
