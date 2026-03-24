<?php

namespace App\Services;

use App\Models\CertificadosModel;
use RuntimeException;

class CertificateCsvImportService
{
    private const HEADER_MAP = [
        'id' => 'id',
        'indicativo' => 'indicativo',
        'callsign' => 'indicativo',
        'call_sign' => 'indicativo',
        'nome' => 'nome',
        'name' => 'nome',
        'concurso' => 'concurso',
        'contest' => 'concurso',
        'ano' => 'ano',
        'year' => 'ano',
        'pontuacao' => 'pontuacao',
        'pontuação' => 'pontuacao',
        'score' => 'pontuacao',
        'clube' => 'clube',
        'club' => 'clube',
        'tipo_evento' => 'tipo_evento',
        'event_type' => 'tipo_evento',
        'type' => 'tipo_evento',
        'organizador' => 'organizador',
        'organizer' => 'organizador',
        'modalidade' => 'modalidade',
        'mode' => 'modalidade',
        'categoria' => 'categoria',
        'category' => 'categoria',
        'class_geral' => 'class_geral',
        'overall_class' => 'class_geral',
        'status' => 'status',
        'operator' => 'operator',
        'km' => 'km',
        'class_cont' => 'class_cont',
        'continent_class' => 'class_cont',
        'class_pais' => 'class_pais',
        'country_class' => 'class_pais',
        'cod_clube' => 'cod_clube',
        'club_code' => 'cod_clube',
        'clube_estacao' => 'clube_estacao',
        'station_club' => 'clube_estacao',
        'identificador' => 'identificador',
        'identifier' => 'identificador',
    ];

    private const IMPORTABLE_FIELDS = [
        'id',
        'indicativo',
        'concurso',
        'pontuacao',
        'nome',
        'ano',
        'clube',
        'tipo_evento',
        'organizador',
        'modalidade',
        'categoria',
        'class_geral',
        'status',
        'operator',
        'km',
        'class_cont',
        'class_pais',
        'cod_clube',
        'clube_estacao',
        'identificador',
    ];

    private CertificadosModel $certificadosModel;

    public function __construct(?CertificadosModel $certificadosModel = null)
    {
        $this->certificadosModel = $certificadosModel ?? new CertificadosModel();
    }

    public function importFromFile(string $path): array
    {
        if (! is_file($path) || ! is_readable($path)) {
            throw new RuntimeException('CSV file is not readable.');
        }

        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new RuntimeException('Unable to open CSV file.');
        }

        try {
            $headers = null;
            $lineNumber = 0;
            $inserted = 0;
            $updated = 0;
            $skipped = 0;
            $errors = [];
            $delimiter = $this->detectDelimiter($path);

            while (($row = fgetcsv($handle, 0, $delimiter)) !== false) {
                $lineNumber++;

                if ($this->rowIsEmpty($row)) {
                    $skipped++;
                    continue;
                }

                if ($headers === null) {
                    $headers = $this->normalizeHeaders($row);
                    continue;
                }

                $payload = $this->mapRowToPayload($headers, $row);
                if ($payload === []) {
                    $skipped++;
                    continue;
                }

                $payload = $this->preparePayload($payload);

                if (! $this->certificadosModel->save($payload)) {
                    $errors[] = [
                        'line' => $lineNumber,
                        'errors' => $this->certificadosModel->errors(),
                        'payload' => $payload,
                    ];
                    continue;
                }

                if (! empty($payload['id'])) {
                    $updated++;
                } else {
                    $inserted++;
                }
            }
        } finally {
            fclose($handle);
        }

        return [
            'inserted' => $inserted,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }

    public static function acceptedHeaders(): array
    {
        return self::IMPORTABLE_FIELDS;
    }

    private function detectDelimiter(string $path): string
    {
        $firstLine = (string) fgets(fopen($path, 'rb'));
        $commaCount = substr_count($firstLine, ',');
        $semicolonCount = substr_count($firstLine, ';');
        $tabCount = substr_count($firstLine, "\t");

        $delimiter = ',';
        $maxCount = $commaCount;

        if ($semicolonCount > $maxCount) {
            $delimiter = ';';
            $maxCount = $semicolonCount;
        }

        if ($tabCount > $maxCount) {
            $delimiter = "\t";
        }

        return $delimiter;
    }

    private function normalizeHeaders(array $headers): array
    {
        $normalized = [];

        foreach ($headers as $header) {
            $key = $this->normalizeHeaderName((string) $header);
            $normalized[] = self::HEADER_MAP[$key] ?? null;
        }

        return $normalized;
    }

    private function normalizeHeaderName(string $header): string
    {
        $header = trim($header);
        $header = preg_replace('/^\xEF\xBB\xBF/', '', $header) ?? $header;
        $header = strtolower($header);
        $header = strtr($header, [
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'é' => 'e',
            'ê' => 'e',
            'í' => 'i',
            'ó' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ú' => 'u',
            'ç' => 'c',
        ]);
        $header = preg_replace('/[^a-z0-9]+/', '_', $header) ?? $header;

        return trim($header, '_');
    }

    private function mapRowToPayload(array $headers, array $row): array
    {
        $payload = [];

        foreach ($headers as $index => $field) {
            if ($field === null || ! array_key_exists($index, $row)) {
                continue;
            }

            $value = trim((string) $row[$index]);
            if ($value === '') {
                continue;
            }

            $payload[$field] = $value;
        }

        return $payload;
    }

    private function preparePayload(array $payload): array
    {
        if (empty($payload['status'])) {
            $payload['status'] = 'd';
        }

        if (empty($payload['identificador'])) {
            $payload['identificador'] = $this->generateIdentifier($payload);
        }

        return $payload;
    }

    private function generateIdentifier(array $payload): string
    {
        return hash('sha256', implode('|', [
            microtime(true),
            $payload['indicativo'] ?? '',
            $payload['concurso'] ?? '',
            $payload['ano'] ?? '',
            $payload['nome'] ?? '',
            bin2hex(random_bytes(8)),
        ]));
    }

    private function rowIsEmpty(array $row): bool
    {
        foreach ($row as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }
}
