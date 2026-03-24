<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('certificado/create'), lang('UI.newCertificate'), ['class' => 'btn btn-success mb-3'] ) ?>
    <?php echo anchor(base_url('certificado/import'), lang('UI.importCsv'), ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>
                <th><?= esc(lang('UI.tableId')) ?></th>
                <th><?= esc(lang('UI.callsign')) ?></th>
                <th><?= esc(lang('UI.name')) ?></th>
                <th><?= esc(lang('UI.tableContest')) ?></th>
                <th><?= esc(lang('UI.year')) ?></th>
                <th><?= esc(lang('UI.score')) ?></th>
                <th><?= esc(lang('UI.mode')) ?></th>
                <th><?= esc(lang('UI.status')) ?></th>
                <th><?= esc(lang('UI.actions')) ?></th>

            </tr>
            <?php foreach ($certificados as $certificado) : ?>

                <tr>
                    <td><?= esc($certificado->id) ?></td>
                    <td><?= esc($certificado->indicativo) ?></td>
                    <td><?= esc(strtoupper((string) $certificado->nome)) ?></td>
                    <td><?= esc($certificado->concurso) ?></td>
                    <td><?= esc($certificado->ano) ?></td>
                    <td><?= esc($certificado->pontuacao) ?></td>
                    <td><?= esc($certificado->modalidade) ?></td>
                    <td><?= esc($certificado->status) ?></td>
                    <td>
                        <?php echo anchor('certificado/edit/' . $certificado->id, lang('UI.edit')) ?>
                        <?php if (($certificado->status ?? '') !== 'd' || empty($certificado->identificador)) : ?>
                            -
                            <form action="<?= base_url('certificado/available/' . $certificado->id) ?>" method="post" class="d-inline">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-link p-0 align-baseline"><?= esc(lang('UI.markAvailable')) ?></button>
                            </form>
                        <?php endif; ?>
                        -
                        <form action="<?= base_url('certificado/delete/' . $certificado->id) ?>" method="post" class="d-inline" onsubmit="return confirma()">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-link p-0 align-baseline"><?= esc(lang('UI.delete')) ?></button>
                        </form>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

        <?php echo $pager->links(); ?>

    </div>

    <?= $this->endSection() ?>
