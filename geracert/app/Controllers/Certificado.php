<?php

namespace App\Controllers;

use App\Models\CertificadosModel;
use App\Services\CertificateCsvImportService;

class Certificado extends BaseController
{

    ########################################################################

    private $certificadoModel;
    private CertificateCsvImportService $certificateCsvImportService;

    private const FORM_FIELDS = [
        'id',
        'indicativo',
        'nome',
        'concurso',
        'ano',
        'pontuacao',
    ];

    public function __construct()
    {

        $this->certificadoModel = new CertificadosModel();
        $this->certificateCsvImportService = new CertificateCsvImportService($this->certificadoModel);
    }

    ########################################################################

    public function index()
    {
        return view('certificados', [
            'certificados' => $this->certificadoModel->orderBy('id', 'DESC')->paginate(15),
            'pager' => $this->certificadoModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->certificadoModel->delete($id)) {
            return redirect()->to(base_url('certificado'))
                ->with('success', lang('UI.certificateDeleted'));
        }

        return redirect()->to(base_url('certificado'))
            ->with('error', lang('UI.operationError'));
    }

    public function markAvailable($id)
    {
        $certificado = $this->certificadoModel->find($id);

        if ($certificado === null) {
            return redirect()->to(base_url('certificado'))
                ->with('error', lang('UI.operationError'));
        }

        $payload = ['status' => 'd'];

        if (empty($certificado->identificador)) {
            $payload['identificador'] = $this->generateIdentifier((array) $certificado);
        }

        if ($this->certificadoModel->update($id, $payload)) {
            return redirect()->to(base_url('certificado'))
                ->with('success', lang('UI.certificateMarkedAvailable'));
        }

        return redirect()->to(base_url('certificado'))
            ->with('error', lang('UI.operationError'));
    }


    ########################################################################

    public function create()
    {
        return view('certificadoform');
    }

    ########################################################################

    public function store()
    {
        $payload = $this->request->getPost(self::FORM_FIELDS);

        if ($this->certificadoModel->save($payload)) {
            return redirect()->to(base_url('certificado'))
                ->with('success', lang('UI.certificateSaved'));
        }

        return view('certificadoform', [
            'certificado' => (object) $payload,
            'errors'      => $this->certificadoModel->errors(),
        ]);
    }

    ########################################################################

    public function edit($id) {

        return view('certificadoform', [
            'certificado' => $this->certificadoModel->find($id)
        ]);
    }

    public function import()
    {
        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('csv_file');

            if ($file === null || ! $file->isValid()) {
                return view('certificado_import', [
                    'errors' => [lang('UI.csvFileRequired')],
                    'acceptedHeaders' => CertificateCsvImportService::acceptedHeaders(),
                ]);
            }

            $summary = $this->certificateCsvImportService->importFromFile($file->getTempName());

            return view('certificado_import', [
                'summary' => $summary,
                'acceptedHeaders' => CertificateCsvImportService::acceptedHeaders(),
            ]);
        }

        return view('certificado_import', [
            'acceptedHeaders' => CertificateCsvImportService::acceptedHeaders(),
        ]);
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
}
