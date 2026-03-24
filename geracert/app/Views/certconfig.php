<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('certconfig/create'), lang('UI.newContest'), ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>

                <th><?= esc(lang('UI.tableId')) ?></th>
                <th><?= esc(lang('UI.tableContest')) ?></th>
                <th><?= esc(lang('UI.organizer')) ?></th>
                <th><?= esc(lang('UI.year')) ?></th>
                <th><?= esc(lang('UI.actions')) ?></th>

            </tr>
            <?php foreach ($certconfigs as $certconfig) : ?>

                <tr>
                    <td><?= esc($certconfig->id) ?></td>
                    <td><?= esc($certconfig->concurso) ?></td>
                    <td><?= esc($certconfig->organizador) ?></td>
                    <td><?= esc($certconfig->ano) ?></td>
                    <td>
                        <?php echo anchor('certconfig/edit/' . $certconfig->id, lang('UI.edit')) ?>
                        -
                        <?php echo anchor('certconfig/copy/' . $certconfig->id, lang('UI.copy')) ?>
                        <form action="<?= base_url('certconfig/delete/' . $certconfig->id) ?>" method="post" class="d-inline" onsubmit="return confirma()">
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
