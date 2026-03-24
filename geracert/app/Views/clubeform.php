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

    <?php echo form_open('clube/store') ?>

    <div class="form-group mx-3">
        <label for="codigo"><?= esc(lang('UI.clubCode')) ?></label>
        <input type="text" name="codigo" id="codigo" class="form-control" value="<?= isset($clube->codigo) ? esc($clube->codigo) : '' ?>">
        <label for="indicativo"><?= esc(lang('UI.callsign')) ?></label>
        <input type="text" name="indicativo" id="indicativo" class="form-control" value="<?= isset($clube->indicativo) ? esc($clube->indicativo) : '' ?>">
        <label for="clube"><?= esc(lang('UI.clubName')) ?></label>
        <input type="text" name="clube" id="clube" class="form-control" value="<?= isset($clube->clube) ? esc($clube->clube) : '' ?>">
        <label for="categoria"><?= esc(lang('UI.category')) ?></label>
        <input type="text" name="categoria" id="categoria" class="form-control" value="<?= isset($clube->categoria) ? esc($clube->categoria) : '' ?>">
        <label for="status"><?= esc(lang('UI.status')) ?></label>
        <input type="text" name="status" id="status" class="form-control" value="<?= isset($clube->status) ? esc($clube->status) : '' ?>">
    </div>
    <div class="mt-3">
        <input type="submit" value="<?= esc(lang('UI.save')) ?>" class="btn btn-primary mx-5 ">
        <input type="hidden" name="id" value="<?= isset($clube->id) ? esc((string) $clube->id) : '' ?>">
    </div>
    <?php echo form_close() ?>

</div>
<?= $this->endSection() ?>
