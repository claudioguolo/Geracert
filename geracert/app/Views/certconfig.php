<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('certconfig/create'), 'Novo Modelo', ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>

                <th>id</th>
                <th>concurso</th>
                <th>organizador</th>
                <th>ano</th>
                <th>Ações</th>

            </tr>
            <?php foreach ($certconfigs as $certconfig) : ?>

                <tr>
                    <td><?php echo $certconfig->id ?></td>
                    <td><?php echo $certconfig->concurso ?></td>
                    <td><?php echo $certconfig->organizador ?></td>
                    <td><?php echo $certconfig->ano ?></td>
                    <td>
                        <?php echo anchor('certconfig/edit/' . $certconfig->id, 'Editar') ?>
                        -
                        <?php echo anchor('certconfig/copy/' . $certconfig->id, 'Copiar') ?>
                        -
                        <?php echo anchor('certconfig/delete/' . $certconfig->id, 'Excluir', ['onclick' => 'return confirma()']) ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

        <?php echo $pager->links(); ?>

    </div>

    <?= $this->endSection() ?>