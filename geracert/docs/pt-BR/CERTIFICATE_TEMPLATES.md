# Guia de Modelos de Certificado

Este guia explica como o GERACERT monta certificados e como personalizar modelos para um novo concurso de radioamador.

## Como a Renderizacao Funciona

Quando um usuario abre uma URL publica de certificado, o GERACERT:

1. localiza o registro do certificado em `certificados`
2. carrega o modelo correspondente em `certformat`
3. substitui placeholders dentro do HTML do modelo
4. aplica blocos de CSS sanitizados
5. carrega a imagem de fundo selecionada em `py9mt/images/contest/`
6. renderiza o PDF final

O fluxo principal de renderizacao esta em:

- `app/Services/CertificateIssuanceService.php`
- `app/Views/cert_model.php`

## Onde os Modelos Sao Armazenados

Os modelos de concurso sao armazenados na tabela `certformat` e gerenciados pela area administrativa.

Campos editaveis principais:

- `concurso`: nome do concurso
- `ano`: ano do concurso
- `organizador`: rotulo do organizador usado nos dados do certificado
- `imagem`: nome do arquivo de fundo
- `html`: HTML do corpo do certificado
- `texto_text`: declaracoes CSS do bloco principal de texto
- `serial_text`: declaracoes CSS do bloco de serial
- `datetime_text`: declaracoes CSS do bloco de data de geracao
- `size_h1` ate `size_h6`: declaracoes CSS aplicadas aos headings

## Imagens de Fundo

As imagens de fundo devem ficar em:

- `py9mt/images/contest/`

O campo `imagem` deve conter apenas o nome do arquivo, por exemplo:

- `cqws2024.png`
- `cva-2023.png`

## Placeholders Suportados

Placeholders disponiveis:

- `$id`
- `$indicativo`
- `$indicativo-`
- `$nome+indicativo`
- `$concurso`
- `$pontuacao`
- `$ano`
- `$cod_clube`
- `$tipo_evento`
- `$organizador`
- `$modalidade`
- `$categoria`
- `$class_geral`
- `$status`
- `$operador`
- `$km`
- `$class_pais`
- `$class_cont`
- `$clube`
- `$nome`

Esses valores sao preparados em `app/Services/CertificateIssuanceService.php`.

## Exemplo de HTML do Modelo

```html
<h4>This certificate is awarded to</h4>
<h2>$indicativo</h2>
<h4>$nome</h4>
<h5>$class_geral - $categoria - $modalidade</h5>
<h5>$pontuacao points</h5>
<div class="operator">$operador</div>
```

## HTML Permitido

Tags permitidas:

- `div`
- `p`
- `span`
- `strong`
- `em`
- `b`
- `i`
- `u`
- `small`
- `br`
- `h1` ate `h6`

Apenas a classe CSS `operator` e preservada.

## CSS Permitido

Exemplos de propriedades permitidas:

- `font-size`
- `font-family`
- `font-style`
- `font-weight`
- `line-height`
- `letter-spacing`
- `text-align`
- `text-transform`
- `color`
- `background-color`
- `margin`
- `padding`
- `width`
- `height`
- `display`
- `position`
- `top`
- `right`
- `bottom`
- `left`
- `z-index`

Exemplos bloqueados:

- `url(...)`
- `@import`
- `javascript:`
- `expression(...)`

## Como Criar um Novo Modelo de Concurso

Fluxo recomendado:

1. Prepare a imagem de fundo do certificado.
2. Copie a imagem para `py9mt/images/contest/`.
3. Abra a area administrativa e crie um novo modelo de concurso.
4. Preencha nome do concurso, ano, organizador, nome da imagem, HTML e campos de estilo.
5. Salve o modelo.
6. Crie ou importe registros de certificado com o mesmo `concurso` e `ano`.
7. Teste uma URL real de certificado e refine o layout conforme necessario.

## Como o Matching Funciona

O GERACERT seleciona o modelo por:

- `concurso`
- `ano`

O registro do certificado e o modelo precisam coincidir exatamente nesses dois valores.

## Dicas Praticas

- comece copiando um modelo existente;
- mantenha a estrutura HTML simples;
- prefira `h2`, `h3`, `h4`, `h5` e poucos blocos `div`;
- ajuste espacamento principalmente em `texto_text` e nos campos de tamanho dos headings;
- use nomes curtos de arquivo com ASCII;
- teste nomes longos de operador e indicativos longos antes de publicar.

## Problemas Comuns

### O PDF abre sem a imagem de fundo

Verifique:

- se o arquivo existe em `py9mt/images/contest/`;
- se o campo `imagem` contem apenas o nome do arquivo;
- se o nome do arquivo esta exatamente correto.

### O texto do certificado nao aparece

Verifique:

- se o campo `html` nao esta vazio;
- se os placeholders estao escritos exatamente, como `$indicativo`;
- se o certificado selecionado realmente possui dados nesses campos.

### O layout parece quebrado

Verifique:

- se alguma propriedade CSS foi filtrada;
- se o tamanho de fonte esta grande demais;
- se o posicionamento em `texto_text` combina com a imagem.

### A URL do certificado retorna 404

Verifique:

- se o certificado possui `identificador` valido;
- se existe um registro `certformat` correspondente para o mesmo `concurso` e `ano`.

## Limitacao Atual

A personalizacao de modelos ainda e baseada em texto. Nao existe editor drag-and-drop. O fluxo recomendado e editar, salvar, gerar um certificado de exemplo e refinar de forma incremental.

## Exemplo de Importacao CSV

O GERACERT suporta importacao CSV na area administrativa, na tela de importacao de certificados.

Exemplo minimo:

```csv
callsign,contest,year,name,score
PY9MT,CQWS,2024,Claudio,15420
PP5ABC,CQWS,2024,Ana Souza,13200
```

Exemplo estendido:

```csv
callsign,contest,year,name,score,club,event_type,organizer,mode,category,overall_class,status,operator,km,continent_class,country_class,club_code,station_club
PY9MT,CQWS,2024,Claudio,15420,LABRE,C,GERACERT,CW,SINGLE-OP,1,d,Claudio PY9MT,0,1,1,001,LABRE
PP5ABC,CQWS,2024,Ana Souza,13200,ARAUCARIA DX GROUP,C,GERACERT,SSB,MULTI-OP,2,d,Ana Souza PP5ABC,0,2,3,015,ARAUCARIA DX GROUP
```
