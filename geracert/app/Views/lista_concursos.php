<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="mx-auto w-75 mx-3">
<div class=" table-responsive container center">

    <table class="table table-sm  table-fixed table-hover">

        <thead class="thead-dark table-primary">
            <tr>
                <th>#</th>
                <th>Ano</th>
                <th>Concurso</th>
                <th>Concurso</th>
                <th>Ações</th>

            </tr>
        </thead>

        <tbody>
            <?php foreach ($concursos as $concurso) : ?>

                <?= '<tr>' ?>
                <?= '<th scope="row"><b>' . $concurso->id . '</b></th>'; ?>
                <?= '<td>' . $concurso->ano . '</td>'; ?>
                <?= '<td>' . $concurso->concurso . '</td>'; ?>
                <?= '<td>' . $concurso->organizador . '</td>'; ?>
                <?= '<td><div class="container">
                        <a class="btn btn-primary" href="/edita_concurso/'.$concurso->id.'">Editar</a>
                        <a class="btn btn-info" href="#">Info</a>
                    </div></td>'; ?>
                <?= '</tr>' ?>

            <?php endforeach; ?>

            <div class="containet mx-5 mb-5">
                <a href="/new_concurso" class="btn btn-primary">Novo</a>
            </div>


        </tbody>
    </table>
</div>
</div>


<?= $this->endSection() ?>