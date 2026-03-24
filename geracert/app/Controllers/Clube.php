<?php

namespace App\Controllers;

use App\Models\ClubeModel;

class Clube extends BaseController
{

    ########################################################################

    private $clubeModel;

    private const FORM_FIELDS = [
        'id',
        'codigo',
        'indicativo',
        'clube',
        'categoria',
        'status',
    ];

    public function __construct()
    {

        $this->clubeModel = new ClubeModel();
    }

    ########################################################################

    public function index()
    {

        return view('clubes', [
            'clubes' => $this->clubeModel->orderBy('id', 'DESC')->paginate(15),
            'pager' => $this->clubeModel->pager

        ]);
    }

    ########################################################################

    public function delete($id)
    {

        if ($this->clubeModel->delete($id)) {
            return redirect()->to(base_url('clube'))
                ->with('success', lang('UI.clubDeleted'));
        }

        return redirect()->to(base_url('clube'))
            ->with('error', lang('UI.operationError'));
    }

    ########################################################################

    public function create()
    {
        return view('clubeform');
    }

    ########################################################################

    public function store()
    {
        $payload = $this->request->getPost(self::FORM_FIELDS);

        if ($this->clubeModel->save($payload)) {
            return redirect()->to(base_url('clube'))
                ->with('success', lang('UI.clubSaved'));
        }

        return view('clubeform', [
            'clube'  => (object) $payload,
            'errors' => $this->clubeModel->errors(),
        ]);
    }

    ########################################################################

    public function edit($id) {

        return view('clubeform', [
            'clube' => $this->clubeModel->find($id)
        ]);
    }
}
