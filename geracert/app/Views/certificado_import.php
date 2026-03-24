<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h2 class="h4 mb-3"><?= esc(lang('UI.importCertificates')) ?></h2>
                    <p class="text-muted"><?= esc(lang('UI.importInstructions')) ?></p>

                    <?php if (! empty($errors)) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if (! empty($summary)) : ?>
                        <div class="alert alert-info">
                            <p class="mb-2"><strong><?= esc(lang('UI.importCompleted')) ?></strong></p>
                            <ul class="mb-0">
                                <li><?= esc(lang('UI.rowsInserted')) ?>: <?= esc((string) ($summary['inserted'] ?? 0)) ?></li>
                                <li><?= esc(lang('UI.rowsUpdated')) ?>: <?= esc((string) ($summary['updated'] ?? 0)) ?></li>
                                <li><?= esc(lang('UI.rowsSkipped')) ?>: <?= esc((string) ($summary['skipped'] ?? 0)) ?></li>
                                <li><?= esc(lang('UI.rowsWithErrors')) ?>: <?= esc((string) count($summary['errors'] ?? [])) ?></li>
                            </ul>
                        </div>

                        <?php if (! empty($summary['errors'])) : ?>
                            <div class="alert alert-warning">
                                <p class="mb-2"><strong><?= esc(lang('UI.rowsWithErrors')) ?></strong></p>
                                <ul class="mb-0">
                                    <?php foreach ($summary['errors'] as $error) : ?>
                                        <li>
                                            <?= esc(lang('UI.csvLine')) ?> <?= esc((string) $error['line']) ?>:
                                            <?= esc(implode(' | ', array_values($error['errors'] ?? []))) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?= form_open_multipart('certificado/import') ?>
                        <div class="mb-3">
                            <label for="csv_file" class="form-label"><?= esc(lang('UI.csvFile')) ?></label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv,text/csv">
                        </div>
                        <button type="submit" class="btn btn-primary"><?= esc(lang('UI.importCsv')) ?></button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h3 class="h5"><?= esc(lang('UI.importAcceptedHeaders')) ?></h3>
                    <p class="text-muted small"><?= esc(lang('UI.importAcceptedHeadersHelp')) ?></p>
                    <code class="small d-block"><?= esc(implode(', ', $acceptedHeaders ?? [])) ?></code>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
