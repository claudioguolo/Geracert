<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <?php echo form_open('clube/store') ?>

    <div class="form-group mx-3">
        <label for="codigo">Código</label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="<?php echo isset($clube->codigo) ? $clube->codigo : '' ?>">
        <label for="indicativo">Indicativo</label>
        <input type="text" name="indicativo" id="indicativo" class="form-control" value="<?php echo isset($clube->indicativo) ? $clube->indicativo : '' ?>">
        <label for="clube">Clube</label>
        <input type="text" name="clube" id="clube" class="form-control" value="<?php echo isset($clube->clube) ? $clube->clube : '' ?>">
        <label for="categoria">Categoria</label>
        <input type="text" name="categoria" id="categoria" class="form-control" value="<?php echo isset($clube->categoria) ? $clube->categoria : '' ?>">
        <label for="status">Status</label>
        <input type="text" name="status" id="status" class="form-control" value="<?php echo isset($clube->status) ? $clube->status : '' ?>">
    </div>
    <div class="mt-3">
        <input type="submit" value="Salvar" class="btn btn-primary mx-5 ">
        <input type="hidden" name="id" value="<?php echo isset($clube->id) ? $clube->id : '' ?>">
    </div>
    <?php echo form_close() ?>

</div>
<?= $this->endSection() ?>