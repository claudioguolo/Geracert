<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">

    <?php if (! empty($errors)) : ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php echo form_open('certificado/store') ?>

    <div class="form-group mx-3">
        <label for="indicativo"><?= esc(lang('UI.callsign')) ?></label>
        <input type="text" name="indicativo" id="indicativo" class="form-control" value="<?= isset($certificado->indicativo) ? esc($certificado->indicativo) : '' ?>">
        <label for="nome"><?= esc(lang('UI.name')) ?></label>
        <input type="text" name="nome" id="nome" class="form-control" value="<?= isset($certificado->nome) ? esc($certificado->nome) : '' ?>">
        <label for="concurso"><?= esc(lang('UI.tableContest')) ?></label>
        <input type="text" name="concurso" id="concurso" class="form-control" value="<?= isset($certificado->concurso) ? esc($certificado->concurso) : '' ?>">
        <label for="ano"><?= esc(lang('UI.year')) ?></label>
        <input type="text" name="ano" id="ano" class="form-control" value="<?= isset($certificado->ano) ? esc($certificado->ano) : '' ?>">
        <label for="pontuacao"><?= esc(lang('UI.score')) ?></label>
        <input type="text" name="pontuacao" id="pontuacao" class="form-control" value="<?= isset($certificado->pontuacao) ? esc($certificado->pontuacao) : '' ?>">
    </div>
    <div class="mt-3">
        <input type="submit" value="<?= esc(lang('UI.save')) ?>" class="btn btn-primary mx-5 ">
        <input type="hidden" name="id" value="<?= isset($certificado->id) ? esc((string) $certificado->id) : '' ?>">
    </div>
    <?php echo form_close() ?>

</div>
<?= $this->endSection() ?>
