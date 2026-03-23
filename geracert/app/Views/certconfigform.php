<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <?php echo form_open('certconfig/store') ?>

    <div class="form-group mx-3">

        <label for="Concurso">Concurso</label>
        <input type="text" name="concurso" id="concurso" class="form-control" value="<?php echo isset($certconfig->concurso) ? $certconfig->concurso : '' ?>">

        <label for="ano">Ano</label>
        <input type="text" name="ano" id="ano" class="form-control" value="<?php echo isset($certconfig->ano) ? $certconfig->ano : '' ?>">

        <label for="organizador">Organizador</label>
        <input type="text" name="organizador" id="organizador" class="form-control" value="<?php echo isset($certconfig->organizador) ? $certconfig->organizador : '' ?>">

        <label for="imagem">Imagem</label>
        <input type="text" name="imagem" id="imagem" class="form-control" value="<?php echo isset($certconfig->imagem) ? $certconfig->imagem : '' ?>">

        <label for="html">HTML do corpo</label>
        <textarea type="text" name="html" id="html" class="form-control" value=""><?php echo isset($certconfig->html) ? $certconfig->html : '' ?></textarea>

        <label for="texto_text">Conf do corpo</label>
        <input type="text" name="texto_text" id="texto_text" class="form-control" value="<?php echo isset($certconfig->texto_text) ? $certconfig->texto_text : '' ?>">

        <label for="serial_text">Conf do serial</label>
        <input type="text" name="serial_text" id="serial_text" class="form-control" value="<?php echo isset($certconfig->serial_text) ? $certconfig->serial_text : '' ?>">

        <label for="datetime_text">Conf do DataTime</label>
        <input type="text" name="datetime_text" id="datetime_text" class="form-control" value="<?php echo isset($certconfig->datetime_text) ? $certconfig->datetime_text : '' ?>">

        <label for="size_h1">Size H1</label>
        <input type="text" name="size_h1" id="size_h1" class="form-control" value="<?php echo isset($certconfig->size_h1) ? $certconfig->size_h1 : '' ?>">

        <label for="size_h2">Size H2</label>
        <input type="text" name="size_h2" id="size_h2" class="form-control" value="<?php echo isset($certconfig->size_h2) ? $certconfig->size_h2 : '' ?>">

        <label for="size_h3">Size H3</label>
        <input type="text" name="size_h3" id="size_h3" class="form-control" value="<?php echo isset($certconfig->size_h3) ? $certconfig->size_h3 : '' ?>">

        <label for="size_h4">Size H4</label>
        <input type="text" name="size_h4" id="size_h4" class="form-control" value="<?php echo isset($certconfig->size_h4) ? $certconfig->size_h4 : '' ?>">

        <label for="size_h5">Size H5</label>
        <input type="text" name="size_h5" id="size_h5" class="form-control" value="<?php echo isset($certconfig->size_h5) ? $certconfig->size_h5 : '' ?>">

        <label for="size_h6">Size H6</label>
        <input type="text" name="size_h6" id="size_h6" class="form-control" value="<?php echo isset($certconfig->size_h6) ? $certconfig->size_h6 : '' ?>">

    </div>
    <div class="mt-3">
        <input type="submit" value="Salvar" class="btn btn-primary mx-5 ">
        <input type="hidden" name="id" value="<?php echo isset($certconfig->id) ? (isset($function) ? '' : $certconfig->id) : '' ?>">
    </div>
    <?php echo form_close() ?>

</div>
<?= $this->endSection() ?>