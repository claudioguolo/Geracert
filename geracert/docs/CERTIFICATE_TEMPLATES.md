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

- [CertificateIssuanceService.php](/home/claudio/docker/geracert/geracert/app/Services/CertificateIssuanceService.php)
- [cert_model.php](/home/claudio/docker/geracert/geracert/app/Views/cert_model.php)

## Where Templates Are Stored

Contest templates are stored in the `certformat` table and managed from the admin area:

- `Admin > Contests`

The main editable fields are:

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

Background image files must be stored in:

- [py9mt/images/contest](/home/claudio/docker/geracert/py9mt/images/contest)

The `imagem` field should contain only the file name, for example:

- `cqws2024.png`
- `cva-2023.png`

The application sanitizes this value and only accepts safe file names that actually exist in that folder.

## Supported Placeholders

The template HTML supports variable replacement using the certificate data loaded from the database.

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

These values are prepared in:

- [CertificateIssuanceService.php](/home/claudio/docker/geracert/geracert/app/Services/CertificateIssuanceService.php)

## Example Template HTML

Example:

```html
<h4>This certificate is awarded to</h4>
<h2>$indicativo</h2>
<h4>$nome</h4>
<h5>$class_geral - $categoria - $modalidade</h5>
<h5>$pontuacao points</h5>
<div class="operator">$operador</div>
```

The class `operator` is explicitly allowed by the HTML sanitizer and can be used for centered operator blocks.

## Allowed HTML

The template sanitizer currently allows a limited set of tags:

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

Arbitrary classes are not allowed. Only the `operator` class is preserved.

## Allowed CSS

Style fields such as `texto_text`, `serial_text`, `datetime_text` and `size_h1`...`size_h6` accept CSS declarations, but only a safe subset is kept.

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

1. Prepare the background certificate image in PNG format.
2. Copy the image to [py9mt/images/contest](/home/claudio/docker/geracert/py9mt/images/contest).
3. Open the admin area and go to `Contests`.
4. Create a new contest template.
5. Fill in:
   - contest name
   - year
   - organizer
   - background image file name
   - HTML body
   - positioning/style fields
6. Save the template.
7. Create or import certificate records for that same `concurso` and `ano`.
8. Test a real certificate URL and adjust spacing/font sizes until the PDF matches the intended layout.

## How Matching Works

GERACERT selects the template using:

- `concurso`
- `ano`

That means the certificate record and the template must match exactly on those two values.

If the template exists but the values differ, the PDF will not be found.

## Seeded Examples

The project ships with example templates in:

- [CertformatSeeder.php](/home/claudio/docker/geracert/geracert/app/Database/Seeds/CertformatSeeder.php)

These examples are useful as a starting point when creating a new contest layout.

## Practical Tips

- Start from an existing template and copy it.
- Keep the HTML structure simple.
- Prefer `h2`, `h3`, `h4` and `h5` plus a few `div` blocks.
- Adjust spacing mainly through `texto_text` and heading sizes.
- Use short image file names with ASCII characters only.
- Test with long operator names and long callsigns before publishing.

## Common Problems

### The PDF opens without the background image

Check:

- the file exists in `py9mt/images/contest/`
- the `imagem` field contains only the file name
- the file name matches exactly, including extension

### The certificate text does not appear

Check:

- the `html` field is not empty
- placeholders are written exactly, for example `$indicativo`
- the selected certificate record really has data for those fields

### The layout looks broken

Check:

- whether a CSS property was filtered out by the sanitizer
- whether the font size is too large
- whether the `texto_text` positioning is appropriate for that image

### The certificate URL returns 404

Check:

- whether the certificate record has a valid `identificador`
- whether a matching `certformat` record exists for the same `concurso` and `ano`

## Current Limitation

At the moment, template customization is still text-based. There is no visual drag-and-drop editor. The recommended workflow is to edit, save, generate a sample certificate and refine the template incrementally.

## CSV Import Example

GERACERT now supports CSV import in the admin area under:

- `Certificates > Import CSV`

The importer expects a header row and accepts common header names in both Portuguese and English.

### Minimal Example

```csv
callsign,contest,year,name,score
PY9MT,CQWS,2024,Claudio,15420
PP5ABC,CQWS,2024,Ana Souza,13200
```

### Extended Example

```csv
callsign,contest,year,name,score,club,event_type,organizer,mode,category,overall_class,status,operator,km,continent_class,country_class,club_code,station_club
PY9MT,CQWS,2024,Claudio,15420,LABRE,C,GERACERT,CW,SINGLE-OP,1,d,Claudio PY9MT,0,1,1,001,LABRE
PP5ABC,CQWS,2024,Ana Souza,13200,ARAUCARIA DX GROUP,C,GERACERT,SSB,MULTI-OP,2,d,Ana Souza PP5ABC,0,2,3,015,ARAUCARIA DX GROUP
```

Ready-to-copy sample file:

- [certificates-import-example.csv](/home/claudio/docker/geracert/geracert/docs/examples/certificates-import-example.csv)

### Accepted Header Variants

Examples of equivalent headers:

- `callsign` or `indicativo`
- `contest` or `concurso`
- `year` or `ano`
- `name` or `nome`
- `score` or `pontuacao`
- `club` or `clube`
- `organizer` or `organizador`
- `mode` or `modalidade`
- `category` or `categoria`
- `identifier` or `identificador`

### Notes

- If `status` is omitted, GERACERT defaults it to `d`.
- If `identificador` is omitted, GERACERT generates one automatically.
- The imported certificate record must still match an existing template by `concurso` and `ano` for PDF generation to work.
- Use UTF-8 CSV files with a header row.
