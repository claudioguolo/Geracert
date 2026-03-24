<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-2"><?= esc(lang('UI.statsContests')) ?></p>
                    <p class="display-6 fw-bold mb-3"><?= esc((string) ($stats['concursos'] ?? 0)) ?></p>
                    <a href="<?= base_url('certconfig') ?>" class="btn btn-primary"><?= esc(lang('UI.manage')) ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-2"><?= esc(lang('UI.statsCertificates')) ?></p>
                    <p class="display-6 fw-bold mb-3"><?= esc((string) ($stats['certificados'] ?? 0)) ?></p>
                    <a href="<?= base_url('certificado') ?>" class="btn btn-primary"><?= esc(lang('UI.manage')) ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-2"><?= esc(lang('UI.statsClubs')) ?></p>
                    <p class="display-6 fw-bold mb-3"><?= esc((string) ($stats['clubes'] ?? 0)) ?></p>
                    <a href="<?= base_url('clube') ?>" class="btn btn-primary"><?= esc(lang('UI.manage')) ?></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-uppercase text-muted small mb-2"><?= esc(lang('UI.statsUsers')) ?></p>
                    <p class="display-6 fw-bold mb-3"><?= esc((string) ($stats['usuarios'] ?? 0)) ?></p>
                    <button class="btn btn-outline-secondary" type="button" disabled><?= esc(lang('UI.comingSoon')) ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
