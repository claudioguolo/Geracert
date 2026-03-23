<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

    <div class="container mt-5">

    <?php echo anchor(base_url('certificado/create'), 'Novo certificado', ['class' => 'btn btn-success mb-3'] ) ?>
    <?php echo anchor(base_url('certificado/import'), 'Importar CSV', ['class' => 'btn btn-success mb-3'] ) ?>
        <table class="table">

            <tr>
                <th>id</th>
                <th>Indicativo</th>
                <th>Nome</th>
                <th>Concurso</th>
                <th>Ano</th>
                <th>Pontuação</th>
                <th>Modalidade</th>

            </tr>
            <?php foreach ($certificados as $certificado) : ?>

                <tr>
                    <td><?php echo $certificado->id ?></td>
                    <td><?php echo $certificado->indicativo ?></td>
                    <td><?php echo strtoupper($certificado->nome) ?></td>
                    <td><?php echo $certificado->concurso ?></td>
                    <td><?php echo $certificado->ano ?></td>
                    <td><?php echo $certificado->pontuacao ?></td>
                    <td><?php echo $certificado->modalidade ?></td>
                    <td>
                        <?php echo anchor('certificado/edit/' . $certificado->id, 'Editar') ?>
                        -
                        <?php echo anchor('certificado/delete/' . $certificado->id, 'Excluir', ['onclick' => 'return confirma()']) ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

        <?php echo $pager->links(); ?>

    </div>

    <?= $this->endSection() ?>