<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('clube/create'), 'Novo Clube', ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>

                <th>id</th>
                <th>codigo</th>
                <th>indicativo</th>
                <th>clube</th>
                <th>categoria</th>
                <th>status</th>
                <th>Ações</th>

            </tr>
            <?php foreach ($clubes as $clube) : ?>

                <tr>
                    <td><?php echo $clube->id ?></td>
                    <td><?php echo $clube->codigo ?></td>
                    <td><?php echo $clube->indicativo ?></td>
                    <td><?php echo $clube->clube ?></td>
                    <td><?php echo $clube->categoria ?></td>
                    <td><?php echo $clube->status ?></td>
                    <td>
                        <?php echo anchor('clube/edit/' . $clube->id, 'Editar') ?>
                        -
                        <?php echo anchor('clube/delete/' . $clube->id, 'Excluir', ['onclick' => 'return confirma()']) ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

        <?php echo $pager->links(); ?>

    </div>

    <?= $this->endSection() ?>