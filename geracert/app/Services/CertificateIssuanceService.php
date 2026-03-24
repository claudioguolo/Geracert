<?php

namespace App\Services;

use App\Models\CertConfigModel;
use App\Models\CertificadosModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CertificateIssuanceService
{
    private const ALLOWED_TEMPLATE_TAGS = '<div><p><span><strong><em><b><i><u><small><br><h1><h2><h3><h4><h5><h6>';
    private const ALLOWED_TEMPLATE_CLASSES = [
        'operator',
    ];
    private const ALLOWED_CSS_PROPERTIES = [
        'font-size',
        'font-family',
        'font-style',
        'font-weight',
        'font-variant',
        'line-height',
        'letter-spacing',
        'word-spacing',
        'text-align',
        'text-transform',
        'text-decoration',
        'text-indent',
        'color',
        'background-color',
        'margin',
        'margin-top',
        'margin-right',
        'margin-bottom',
        'margin-left',
        'padding',
        'padding-top',
        'padding-right',
        'padding-bottom',
        'padding-left',
        'width',
        'height',
        'max-width',
        'min-width',
        'display',
        'position',
        'top',
        'right',
        'bottom',
        'left',
        'z-index',
    ];

    private CertificadosModel $certificadosModel;
    private CertConfigModel $certConfigModel;

    public function __construct()
    {
        $this->certificadosModel = new CertificadosModel();
        $this->certConfigModel = new CertConfigModel();
    }

    public function buildCertificateViewData(string $identifier): array
    {
        $this->assertValidIdentifier($identifier);
        $certificate = $this->findCertificateByIdentifier($identifier);
        $certificate = $this->ensureSerialData($certificate, $identifier);
        $template = $this->findTemplate($certificate->concurso, $certificate->ano);

        $certVars = $this->buildCertVars($certificate);
        $formatVars = $this->buildFormatVars($template, $certVars, false);

        return [
            'cert_vars' => $certVars,
            'format_vars' => $formatVars,
            'preview_mode' => false,
        ];
    }

    public function buildTemplatePreviewViewData(array $templatePayload): array
    {
        $template = (object) $templatePayload;
        $certificate = (object) [
            'id' => 1001,
            'indicativo' => 'PY9MT',
            'nome' => 'Claudio',
            'concurso' => $templatePayload['concurso'] ?? 'CQWS',
            'pontuacao' => '15420',
            'ano' => $templatePayload['ano'] ?? '2026',
            'clube' => 'LABRE',
            'tipo_evento' => 'HF',
            'geracao_data' => '24-03-2026 11:45',
            'serial' => 'GERACERT-2026',
            'organizador' => $templatePayload['organizador'] ?? 'GERACERT',
            'modalidade' => 'CW',
            'categoria' => 'SINGLE-OP',
            'class_geral' => '1st Place',
            'status' => 'd',
            'operator' => 'Claudio PY9MT',
            'km' => '0',
            'class_cont' => '1',
            'class_pais' => '1',
        ];

        $certVars = $this->buildCertVars($certificate);
        $formatVars = $this->buildFormatVars($template, $certVars, true);

        return [
            'cert_vars' => $certVars,
            'format_vars' => $formatVars,
            'preview_mode' => true,
        ];
    }

    private function assertValidIdentifier(string $identifier): void
    {
        if (!preg_match('/^[a-f0-9]{64}([a-f0-9]{64})?$/i', $identifier)) {
            throw PageNotFoundException::forPageNotFound();
        }
    }

    private function findCertificateByIdentifier(string $identifier): object
    {
        $certificate = $this->certificadosModel
            ->where('identificador', $identifier)
            ->first();

        if ($certificate === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $certificate;
    }

    private function ensureSerialData(object $certificate, string $identifier): object
    {
        if (!empty($certificate->geracao_data)) {
            return $certificate;
        }

        date_default_timezone_set('UCT');
        $date = date('d-m-Y H:i');
        $serial = $certificate->organizador . str_pad($identifier, 5, '0', STR_PAD_LEFT) . date('y');

        $this->certificadosModel->query(
            'UPDATE certificados SET serial = ?, geracao_data = ?, nome = ? WHERE identificador = ?',
            [$serial, $date, $certificate->nome, $identifier]
        );

        $certificate->serial = $serial;
        $certificate->geracao_data = $date;

        return $certificate;
    }

    private function findTemplate(string $contest, string $year): object
    {
        $template = $this->certConfigModel
            ->where('concurso', $contest)
            ->where('ano', $year)
            ->first();

        if ($template === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $template;
    }

    private function buildCertVars(object $certificate): array
    {
        $name = $certificate->nome === '' ? $certificate->clube : $certificate->nome;

        return [
            '$id' => $certificate->id,
            '$indicativo' => $certificate->indicativo,
            '$indicativo-' => '- ' . $certificate->indicativo . ' -',
            '$nome+indicativo' => substr($name, 0, 40) . ' - ' . $certificate->indicativo . ' -',
            '$concurso' => $certificate->concurso,
            '$pontuacao' => $certificate->pontuacao,
            '$ano' => $certificate->ano,
            '$cod_clube' => $certificate->clube,
            '$tipo_evento' => $certificate->tipo_evento,
            'geracao_data' => $certificate->geracao_data,
            'serial' => $certificate->serial,
            '$organizador' => $certificate->organizador,
            '$modalidade' => $certificate->modalidade,
            '$categoria' => $certificate->categoria,
            '$class_geral' => $certificate->class_geral,
            '$status' => $certificate->status,
            '$operador' => $certificate->operator,
            '$km' => $certificate->km,
            '$class_pais' => $certificate->class_pais,
            '$class_cont' => $certificate->class_cont,
            '$clube' => $certificate->clube,
            '$nome' => substr($name, 0, 40),
        ];
    }

    private function buildFormatVars(object $template, array $certVars, bool $forBrowserPreview = false): array
    {
        $escapedCertVars = $this->escapeCertVars($certVars);

        return [
            'texto_text' => $this->sanitizeCssDeclarations((string) $template->texto_text),
            'serial_text' => $this->sanitizeCssDeclarations((string) $template->serial_text),
            'datetime_text' => $this->sanitizeCssDeclarations((string) $template->datetime_text),
            'imagem' => $this->sanitizeImagePath((string) $template->imagem, $forBrowserPreview),
            '$div_texto' => $this->sanitizeTemplateHtml(strtr((string) $template->html, $escapedCertVars)),
            'size_h1' => $this->sanitizeCssDeclarations((string) $template->size_h1),
            'size_h2' => $this->sanitizeCssDeclarations((string) $template->size_h2),
            'size_h3' => $this->sanitizeCssDeclarations((string) $template->size_h3),
            'size_h4' => $this->sanitizeCssDeclarations((string) $template->size_h4),
            'size_h5' => $this->sanitizeCssDeclarations((string) $template->size_h5),
            'size_h6' => $this->sanitizeCssDeclarations((string) $template->size_h6),
        ];
    }

    private function escapeCertVars(array $certVars): array
    {
        $escaped = [];

        foreach ($certVars as $key => $value) {
            $escaped[$key] = htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        }

        return $escaped;
    }

    private function sanitizeTemplateHtml(string $html): string
    {
        $cleanHtml = strip_tags($html, self::ALLOWED_TEMPLATE_TAGS);

        return (string) preg_replace_callback(
            '/<([a-z0-9]+)([^>]*)>/i',
            function (array $matches): string {
                $tag = strtolower($matches[1]);

                if (!preg_match('/^h[1-6]$|^div$|^p$|^span$|^strong$|^em$|^b$|^i$|^u$|^small$|^br$/', $tag)) {
                    return '';
                }

                if ($tag === 'br') {
                    return '<br>';
                }

                $attributes = '';

                if (preg_match('/class\s*=\s*"([^"]+)"/i', $matches[2], $classMatch)) {
                    $classes = preg_split('/\s+/', trim($classMatch[1])) ?: [];
                    $classes = array_values(array_intersect($classes, self::ALLOWED_TEMPLATE_CLASSES));

                    if ($classes !== []) {
                        $attributes = ' class="' . implode(' ', $classes) . '"';
                    }
                }

                return "<{$tag}{$attributes}>";
            },
            $cleanHtml
        );
    }

    private function sanitizeCssDeclarations(string $css): string
    {
        $safeDeclarations = [];

        foreach (explode(';', $css) as $declaration) {
            $declaration = trim($declaration);

            if ($declaration === '' || !str_contains($declaration, ':')) {
                continue;
            }

            [$property, $value] = array_map('trim', explode(':', $declaration, 2));
            $property = strtolower($property);

            if (!in_array($property, self::ALLOWED_CSS_PROPERTIES, true)) {
                continue;
            }

            if ($value === '' || preg_match('/expression|url\s*\(|@import|javascript:|behavior:|<\/style/i', $value)) {
                continue;
            }

            if (!preg_match('/^[#(),.%+\-\/\w\s"\']+$/u', $value)) {
                continue;
            }

            $safeDeclarations[] = $property . ': ' . $value;
        }

        return implode('; ', $safeDeclarations) . ($safeDeclarations !== [] ? ';' : '');
    }

    private function sanitizeImagePath(string $image, bool $forBrowserPreview = false): string
    {
        $filename = basename(str_replace('\\', '/', $image));

        if ($filename === '' || !preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            return '';
        }

        $path = FCPATH . 'images/contest/' . $filename;

        if (!is_file($path)) {
            return '';
        }

        if ($forBrowserPreview) {
            return base_url('images/contest/' . rawurlencode($filename));
        }

        return $path;
    }
}
