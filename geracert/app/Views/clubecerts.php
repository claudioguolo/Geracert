<?= $this->extend('layouts/main_layout') ?>


<?= $this->section('content') ?>

<table id="ph" class="table table-striped table-hover caption-top">
  <!-- <caption>Certificados Disponíveis</caption> -->

  <thead>
    <th style="width: 10%"><b><?= esc(lang('UI.publicCode')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicClub')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicContest')) ?></b></th>
    <th style="width: 10%" style="width: 5%"><b><?= esc(lang('UI.publicYear')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicScore')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicType')) ?></b></th>
    <th style="width: 5%"><b><?= esc(lang('UI.publicCertificate')) ?></b></th>
  </thead>

  <tbody class=".table-hover">

    <!--  ================================================================================================== -->

    <!-- inicio da formação do corpo da tabela com os dados -->

    <?php foreach($consulta as $certificado): ?>

    <tr>
    <td><b><?= esc($certificado->id) ?></b></td>
    <td><b><?= esc($certificado->clube) ?></b></td>
    <td><?= esc($certificado->concurso) ?></td>
    <td><?= esc($certificado->ano) ?></td>
    <td><?= esc($certificado->pontuacao) ?></td>
    <td><?= esc(strtoupper((string) $certificado->tipo_evento)) ?></td>
    <?= helper("App_helper"); ?>
    <?= findIco($certificado->status, $certificado->serial, $certificado->identificador,"func=clube"); ?>
    </tr>

    <?php endforeach; ?>

    <!-- Fim da formação do corpo da tabela com os dados -->

  </tbody>
</table>

<?= $this->endSection()?>
