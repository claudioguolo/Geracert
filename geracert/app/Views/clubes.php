<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('clube/create'), lang('UI.newClub'), ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>

                <th><?= esc(lang('UI.tableId')) ?></th>
                <th><?= esc(lang('UI.clubCode')) ?></th>
                <th><?= esc(lang('UI.callsign')) ?></th>
                <th><?= esc(lang('UI.clubName')) ?></th>
                <th><?= esc(lang('UI.category')) ?></th>
                <th><?= esc(lang('UI.status')) ?></th>
                <th><?= esc(lang('UI.actions')) ?></th>

            </tr>
            <?php foreach ($clubes as $clube) : ?>

                <tr>
                    <td><?= esc($clube->id) ?></td>
                    <td><?= esc($clube->codigo) ?></td>
                    <td><?= esc($clube->indicativo) ?></td>
                    <td><?= esc($clube->clube) ?></td>
                    <td><?= esc($clube->categoria) ?></td>
                    <td><?= esc($clube->status) ?></td>
                    <td>
                        <?php echo anchor('clube/edit/' . $clube->id, lang('UI.edit')) ?>
                        <form action="<?= base_url('clube/delete/' . $clube->id) ?>" method="post" class="d-inline" onsubmit="return confirma()">
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
