<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <?php echo form_open('certificado/store') ?>

    <div class="form-group mx-3">
        <label for="indicativo">Indicativo</label>
        <input type="text" name="indicativo" id="indicativo" class="form-control" value="<?php echo isset($certificado->indicativo) ? $certificado->indicativo : '' ?>">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?php echo isset($certificado->nome) ? $certificado->nome : '' ?>">
        <label for="concurso">Concurso</label>
        <input type="text" name="concurso" id="concurso" class="form-control" value="<?php echo isset($certificado->concurso) ? $certificado->concurso : '' ?>">
        <label for="ano">Ano</label>
        <input type="text" name="ano" id="ano" class="form-control" value="<?php echo isset($certificado->ano) ? $certificado->ano : '' ?>">
        <label for="pontuacao">Pontuação</label>
        <input type="text" name="pontuacao" id="pontuacao" class="form-control" value="<?php echo isset($certificado->pontuacao) ? $certificado->pontuacao : '' ?>">
    </div>
    <div class="mt-3">
        <input type="submit" value="Salvar" class="btn btn-primary mx-5 ">
        <input type="hidden" name="id" value="<?php echo isset($certificado->id) ? $certificado->id : '' ?>">
    </div>
    <?php echo form_close() ?>

</div>
<?= $this->endSection() ?>