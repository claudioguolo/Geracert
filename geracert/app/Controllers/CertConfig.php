<?php

namespace App\Controllers;

use App\Models\CertConfigModel;
use App\Services\CertificateIssuanceService;
use App\Services\ContestImageUploadService;

class CertConfig extends BaseController
{
    private const DEFAULT_TEMPLATE = [
        'concurso' => '',
        'ano' => '',
        'organizador' => 'GERACERT',
        'imagem' => 'cqws2024.png',
        'html' => "<h4>This certificate is awarded to</h4>\n<h2>\$indicativo</h2>\n<h4>\$nome</h4>\n<h5>\$class_geral</h5>\n<h5>\$categoria - \$modalidade</h5>\n<h5>\$pontuacao points</h5>\n<div class=\"operator\">\$operador</div>",
        'texto_text' => 'position: fixed; top: 260px; left: 12%; width: 76%; text-align: center;',
        'serial_text' => 'position: fixed; top: 12px; left: 16px; color: grey;',
        'datetime_text' => 'position: fixed; top: 18px; right: 20px; color: grey;',
        'size_h1' => 'color: black; text-align: center; font-size: 45px; line-height: 1;',
        'size_h2' => 'color: black; text-align: center; font-size: 36px; line-height: 1.1;',
        'size_h3' => 'color: black; text-align: center; font-size: 30px; line-height: 1.05;',
        'size_h4' => 'color: black; text-align: center; font-size: 24px; line-height: 1.1;',
        'size_h5' => 'color: black; text-align: center; font-size: 20px; line-height: 1.1;',
        'size_h6' => 'color: grey; text-align: center; font-size: 15px; line-height: 1;',
    ];

    private const LEGACY_FORM_MAP = [
        'cert_id'            => 'id',
        'cert_concurso'      => 'concurso',
        'cert_ano'           => 'ano',
        'cert_organizador'   => 'organizador',
        'cert_imagem'        => 'imagem',
        'cert_html_corpo'    => 'html',
        'cert_texto_text'    => 'texto_text',
        'cert_serial_text'   => 'serial_text',
        'cert_datetime_text' => 'datetime_text',
        'cert_size_h1'       => 'size_h1',
        'cert_size_h2'       => 'size_h2',
        'cert_size_h3'       => 'size_h3',
        'cert_size_h4'       => 'size_h4',
        'cert_size_h5'       => 'size_h5',
        'cert_size_h6'       => 'size_h6',
    ];


    ########################################################################

    private $certconfigModel;
    private CertificateIssuanceService $certificateIssuanceService;
    private ContestImageUploadService $contestImageUploadService;
    private array $contestImageFiles;

    private const FORM_FIELDS = [
        'id',
        'concurso',
        'ano',
        'organizador',
        'imagem',
        'html',
        'texto_text',
        'serial_text',
        'datetime_text',
        'size_h1',
        'size_h2',
        'size_h3',
        'size_h4',
        'size_h5',
        'size_h6',
    ];

    public function __construct()
    {

        $this->certconfigModel = new CertConfigModel();
        $this->certificateIssuanceService = new CertificateIssuanceService();
        $this->contestImageUploadService = new ContestImageUploadService();
        $this->contestImageFiles = $this->listContestImageFiles();
    }


    ########################################################################

    public function index()
    {
        return view('certconfig', [
            'certconfigs' => $this->certconfigModel->orderBy('id', 'DESC')->paginate(15),
            'pager' => $this->certconfigModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->certconfigModel->delete($id)) {
            return redirect()->to(base_url('certconfig'))
                ->with('success', lang('UI.contestDeleted'));
        }

        return redirect()->to(base_url('certconfig'))
            ->with('error', lang('UI.operationError'));
    }


    ########################################################################

    public function create()
    {
        $template = $this->defaultTemplate();

        return view('certconfigform', [
            'certconfig' => (object) $template,
            'mode' => 'create',
            'contestImageFiles' => $this->contestImageFiles,
        ]);
    }

    ########################################################################

    public function store()
    {
        $payload = $this->request->getPost(self::FORM_FIELDS);

        foreach ($payload as $field => $value) {
            if (is_string($value)) {
                $payload[$field] = trim($value);
            }
        }

        if (empty($payload['id'])) {
            unset($payload['id']);
        }

        if ($this->certconfigModel->save($payload)) {
            return redirect()->to(base_url('certconfig'))
                ->with('success', lang('UI.contestSaved'));
        }

        return view('certconfigform', [
            'certconfig' => (object) $payload,
            'errors'     => $this->certconfigModel->errors(),
            'mode'       => empty($payload['id']) ? 'create' : 'edit',
            'contestImageFiles' => $this->contestImageFiles,
        ]);
    }

    ########################################################################

    public function edit($id) {

        //dd($this->certconfigModel->find($id));

        return view('certconfigform', [
            'certconfig' => $this->certconfigModel->find($id),
            'mode' => 'edit',
            'contestImageFiles' => $this->contestImageFiles,
        ]);
    }

    public function copy($id) {

        return view('certconfigform', [
            'certconfig' => $this->certconfigModel->find($id),
            'mode' => 'copy',
            'contestImageFiles' => $this->contestImageFiles,
        ]);
    }

    public function preview()
    {
        $payload = $this->request->getPost(self::FORM_FIELDS);
        $viewData = $this->certificateIssuanceService->buildTemplatePreviewViewData($payload);

        return view('cert_model', $viewData);
    }

    public function uploadImage()
    {
        $file = $this->request->getFile('background_image');

        if ($file === null) {
            session()->setFlashdata('upload_error', lang('UI.imageUploadMissing'));
            return redirect()->back()->withInput();
        }

        try {
            $filename = $this->contestImageUploadService->upload($file);
        } catch (\RuntimeException $exception) {
            session()->setFlashdata('upload_error', $exception->getMessage());
            return redirect()->back()->withInput();
        }

        session()->setFlashdata('upload_success', lang('UI.imageUploadSuccess'));
        session()->setFlashdata('uploaded_image', $filename);

        return redirect()->back()->withInput();
    }

    public function storeLegacy()
    {
        $payload = [];

        foreach (self::LEGACY_FORM_MAP as $legacyField => $field) {
            $payload[$field] = $this->request->getPost($legacyField);
        }

        if (! empty($payload['html'])) {
            $payload['html'] = ltrim((string) $payload['html']);
        }

        if (empty($payload['id'])) {
            unset($payload['id']);
        }

        if ($this->certconfigModel->save($payload)) {
            return redirect()->to(base_url('certconfig'));
        }

        return view('certconfigform', [
            'certconfig' => (object) $payload,
            'errors'     => $this->certconfigModel->errors(),
            'mode'       => empty($payload['id']) ? 'create' : 'edit',
            'contestImageFiles' => $this->contestImageFiles,
        ]);
    }

    private function listContestImageFiles(): array
    {
        $imageDir = rtrim(FCPATH, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'contest';
        $files = glob($imageDir . DIRECTORY_SEPARATOR . '*') ?: [];
        $files = array_filter($files, static fn (string $file): bool => is_file($file));

        $filenames = array_map('basename', $files);
        sort($filenames);

        return $filenames;
    }

    private function defaultTemplate(): array
    {
        $preferredTemplate = $this->certconfigModel
            ->where('concurso', 'CQWS')
            ->orderBy('ano', 'DESC')
            ->first();

        if ($preferredTemplate !== null) {
            $template = (array) $preferredTemplate;
            unset($template['id'], $template['created_at'], $template['updated_at'], $template['deleted_at']);
            $template['concurso'] = '';
            $template['ano'] = '';

            return array_merge(self::DEFAULT_TEMPLATE, $template);
        }

        return self::DEFAULT_TEMPLATE;
    }

}
