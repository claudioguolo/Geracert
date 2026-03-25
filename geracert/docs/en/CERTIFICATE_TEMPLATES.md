# Certificate Template Guide

This guide explains how GERACERT builds certificates and how to customize templates for a new ham radio contest.

## How Certificate Rendering Works

When a user opens a public certificate URL, GERACERT:

1. finds the certificate record in `certificados`
2. loads the matching contest template from `certformat`
3. replaces placeholders inside the template HTML
4. applies sanitized CSS style blocks
5. loads the selected background image from `py9mt/images/contest/`
6. renders the final PDF

The rendering flow is implemented in:

- `app/Services/CertificateIssuanceService.php`
- `app/Views/cert_model.php`

## Where Templates Are Stored

Contest templates are stored in the `certformat` table and managed from the admin area.

Main editable fields:

- `concurso`: contest name
- `ano`: contest year
- `organizador`: organizer label used in certificate data
- `imagem`: background file name
- `html`: certificate body HTML
- `texto_text`: CSS declarations for the main text block
- `serial_text`: CSS declarations for the serial block
- `datetime_text`: CSS declarations for the generation date block
- `size_h1` to `size_h6`: CSS declarations applied to heading tags

## Background Images

Background images must be stored in:

- `py9mt/images/contest/`

The `imagem` field should contain only the file name, for example:

- `cqws2024.png`
- `cva-2023.png`

## Supported Placeholders

Available placeholders:

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

These values are prepared in `app/Services/CertificateIssuanceService.php`.

## Example Template HTML

```html
<h4>This certificate is awarded to</h4>
<h2>$indicativo</h2>
<h4>$nome</h4>
<h5>$class_geral - $categoria - $modalidade</h5>
<h5>$pontuacao points</h5>
<div class="operator">$operador</div>
```

## Allowed HTML

Allowed tags:

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
- `h1` to `h6`

Only the `operator` CSS class is preserved.

## Allowed CSS

Examples of allowed properties:

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

Blocked examples:

- `url(...)`
- `@import`
- `javascript:`
- `expression(...)`

## How to Create a New Contest Template

Recommended workflow:

1. Prepare the certificate background image.
2. Copy the image to `py9mt/images/contest/`.
3. Open the admin area and create a new contest template.
4. Fill contest name, year, organizer, image name, HTML body and style fields.
5. Save the template.
6. Create or import certificate records with the same `concurso` and `ano`.
7. Test a real certificate URL and refine the layout as needed.

## How Matching Works

GERACERT selects the template by:

- `concurso`
- `ano`

The certificate record and template must match exactly on both values.

## Practical Tips

- start from an existing template and copy it;
- keep the HTML structure simple;
- prefer `h2`, `h3`, `h4`, `h5` and a few `div` blocks;
- adjust spacing mostly through `texto_text` and heading size fields;
- use short ASCII-only image file names;
- test long operator names and long callsigns before publishing.

## Common Problems

### PDF opens without background image

Check:

- the file exists in `py9mt/images/contest/`;
- the `imagem` field contains only the file name;
- the file name matches exactly.

### Certificate text does not appear

Check:

- the `html` field is not empty;
- placeholders are written exactly, such as `$indicativo`;
- the selected certificate actually contains data for those fields.

### Layout looks broken

Check:

- whether a CSS property was filtered out;
- whether the font size is too large;
- whether the `texto_text` positioning matches the image.

### Certificate URL returns 404

Check:

- whether the certificate has a valid `identificador`;
- whether a matching `certformat` record exists for the same `concurso` and `ano`.

## Current Limitation

Template customization is still text-based. There is no drag-and-drop editor. The recommended workflow is to edit, save, generate a sample certificate and refine incrementally.

## CSV Import Example

GERACERT supports CSV import in the admin area under the certificate import screen.

Minimal example:

```csv
callsign,contest,year,name,score
PY9MT,CQWS,2024,Claudio,15420
PP5ABC,CQWS,2024,Ana Souza,13200
```

Extended example:

```csv
callsign,contest,year,name,score,club,event_type,organizer,mode,category,overall_class,status,operator,km,continent_class,country_class,club_code,station_club
PY9MT,CQWS,2024,Claudio,15420,LABRE,C,GERACERT,CW,SINGLE-OP,1,d,Claudio PY9MT,0,1,1,001,LABRE
PP5ABC,CQWS,2024,Ana Souza,13200,ARAUCARIA DX GROUP,C,GERACERT,SSB,MULTI-OP,2,d,Ana Souza PP5ABC,0,2,3,015,ARAUCARIA DX GROUP
```
