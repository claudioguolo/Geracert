# Documentacao de Escopo

## 1. Objetivo do Projeto

O GERACERT e uma aplicacao web para cadastro, publicacao e emissao sob demanda de certificados de concursos de radioamador. O sistema elimina a geracao manual de certificados em ferramentas graficas e centraliza o processo em um fluxo orientado por banco de dados com modelos reutilizaveis por concurso e ano.

## 2. Problema que o Sistema Resolve

O projeto atende clubes, organizadores de concursos e administradores de certificados que precisam:

- manter um catalogo de participantes e resultados;
- disponibilizar certificados para busca publica por indicativo ou clube;
- gerar PDFs sob demanda a partir de um layout padronizado;
- reutilizar modelos visuais por concurso;
- operar um painel administrativo simples com controle de acesso.

## 3. Escopo Funcional Atual

### 3.1 Area publica

- pagina inicial com selecao de idioma;
- busca publica de certificados por indicativo, operador ou clube;
- listagem dos resultados encontrados;
- acesso a emissao do certificado por meio de um identificador publico;
- geracao do PDF no momento da consulta.

### 3.2 Area administrativa

- autenticacao por email e senha;
- migracao transparente de hash legado MD5 para `password_hash`;
- dashboard administrativo;
- CRUD de certificados;
- marcacao de certificado como disponivel publicamente;
- importacao em lote de certificados por CSV;
- CRUD de concursos e modelos;
- copia de modelos existentes para acelerar novos concursos;
- preview HTML antes da publicacao;
- upload de imagem de fundo para certificados;
- CRUD de clubes.

### 3.3 Controle de acesso

Perfis atualmente implementados:

- `admin`: acesso total ao painel, certificados, modelos e clubes;
- `editor`: acesso ao painel, certificados e modelos, sem gestao de clubes.

O controle e baseado no campo `permissoes` da tabela `usuarios`, interpretado por `AuthorizationService`.

## 4. Principais Fluxos de Negocio

### 4.1 Publicacao de certificado

1. O administrador cadastra ou importa um certificado.
2. O registro recebe ou gera um `identificador` unico.
3. O administrador marca o certificado como disponivel.
4. O usuario consulta por indicativo ou clube.
5. O sistema localiza o certificado e o modelo correspondente de concurso e ano.
6. O HTML do modelo e preenchido com os dados do certificado.
7. O PDF e gerado sob demanda.

### 4.2 Criacao de modelo de concurso

1. O usuario acessa a area de gestao de concursos.
2. Define concurso, ano, organizador, imagem e blocos de estilo.
3. Ajusta placeholders HTML como `$indicativo`, `$nome`, `$categoria` e `$pontuacao`.
4. Usa a rota de preview para validar o layout.
5. Salva o modelo para emissao real.

### 4.3 Importacao em lote

1. O usuario envia um arquivo CSV.
2. O sistema detecta o delimitador e normaliza cabecalhos em portugues e ingles.
3. Linhas validas sao inseridas ou atualizadas.
4. Campos criticos ausentes recebem padroes, como `status = d` e geracao automatica de `identificador`.
5. O sistema retorna um resumo com inseridos, atualizados, ignorados e erros.

## 5. Modulos do Sistema

### 5.1 Busca publica e emissao

Responsabilidades:

- busca por indicativo, operador ou clube;
- preparacao dos dados do certificado;
- carregamento do modelo visual por concurso e ano;
- renderizacao HTML e emissao em PDF.

Arquivos centrais:

- `app/Controllers/Main.php`
- `app/Services/CertificateIssuanceService.php`

### 5.2 Autenticacao e autorizacao

Responsabilidades:

- login e logout;
- persistencia de sessao;
- verificacao de permissao por rota;
- traducao de perfis em capacidades.

Arquivos centrais:

- `app/Controllers/Login.php`
- `app/Filters/Auth.php`
- `app/Services/AuthorizationService.php`

### 5.3 Gestao de certificados

Responsabilidades:

- cadastro manual;
- edicao e exclusao;
- liberacao para emissao publica;
- importacao em lote.

Arquivos centrais:

- `app/Controllers/Certificado.php`
- `app/Models/CertificadosModel.php`
- `app/Services/CertificateCsvImportService.php`

### 5.4 Gestao de modelos de certificado

Responsabilidades:

- manutencao de layouts por concurso e ano;
- configuracao de HTML e CSS permitidos;
- preview da saida do certificado;
- upload de arquivos de fundo.

Arquivos centrais:

- `app/Controllers/CertConfig.php`
- `app/Models/CertConfigModel.php`
- `app/Services/ContestImageUploadService.php`

### 5.5 Gestao de clubes

Responsabilidades:

- manter o cadastro de clubes;
- suportar a busca publica por clube.

Arquivos centrais:

- `app/Controllers/Clube.php`
- `app/Models/ClubeModel.php`

## 6. Estrutura de Dados no Escopo Atual

Tabelas principais:

- `usuarios`: credenciais, nome, email e perfis;
- `clubes`: cadastro de clubes e codigos;
- `certformat`: modelos visuais e parametros de estilo;
- `certificados`: resultados, dados do participante, metadados de emissao e identificador publico;
- `ci_sessions`: persistencia de sessao.

Relacionamentos relevantes:

- `certificados.concurso` + `certificados.ano` devem corresponder a `certformat.concurso` + `certformat.ano` para emissao correta;
- `certificados.cod_clube` e usado na busca publica por clube;
- `usuarios.permissoes` governa o acesso administrativo.

## 7. Regras e Restricoes Importantes

- a emissao publica depende de um `identificador` valido;
- a emissao tambem depende da existencia de um modelo para o mesmo concurso e ano;
- o HTML do modelo e sanitizado antes da renderizacao;
- apenas um subconjunto de tags HTML, classes CSS e propriedades CSS e permitido;
- uploads de imagem aceitam apenas PNG e JPEG com validacao de tamanho, resolucao e proporcao;
- a estrutura do projeto foi desenhada para manter a aplicacao real fora do document root publico.

## 8. Dependencias Tecnicas

- PHP 8.1;
- CodeIgniter 4;
- MySQL 8;
- Bootstrap 5;
- Dompdf;
- Docker Compose para desenvolvimento local.

Topologia relevante:

- `py9mt/` atua como web root publico;
- `geracert/` contem aplicacao, framework, testes e dependencias.

## 9. Fora de Escopo no Estado Atual

Nao ha implementacao visivel no projeto para:

- fluxo de aprovacao em multiplas etapas;
- trilha detalhada de auditoria por usuario;
- API publica ou API REST administrativa;
- notificacoes por email;
- isolamento multi-tenant entre organizacoes;
- versionamento formal de modelos de certificado;
- fila assincrona para geracao de PDF;
- modelo de permissao granular alem dos perfis atuais.

## 10. Cobertura de Testes Existente

O projeto ja possui testes automatizados para:

- autenticacao e restricoes por perfil;
- busca publica;
- CRUD administrativo basico;
- preview e persistencia de modelos;
- geracao de identificador ao publicar certificado;
- sanitizacao da emissao;
- importacao CSV;
- upload de imagem de concurso.

Isso reduz risco de regressao nos fluxos principais, mas nao substitui validacao visual dos modelos e testes operacionais em producao.

## 11. Publico-Alvo

- clubes de radioamador;
- organizadores de concursos;
- administradores que publicam certificados;
- participantes que buscam e baixam seus certificados.

## 12. Resumo Executivo

O escopo atual do GERACERT cobre o ciclo principal de negocio para certificados de concursos: cadastro ou importacao de resultados, configuracao do layout do certificado, busca publica e emissao PDF sob demanda, com painel administrativo simples e controle de acesso por perfil. O sistema ja esta estruturado para uso pratico, especialmente em hospedagem compartilhada e operacao enxuta de clubes.
