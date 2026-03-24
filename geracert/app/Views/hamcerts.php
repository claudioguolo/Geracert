<?= $this->extend('layouts/main_layout') ?>


<?= $this->section('content') ?>

<table id="ph" class="table table-striped table-hover caption-top">
  <!-- <caption>Certificados Disponíveis</caption> -->

  <thead>
    <th style="width: 10%"><b><?= esc(lang('UI.callsign')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicContest')) ?></b></th>
    <th style="width: 10%" style="width: 5%"><b><?= esc(lang('UI.publicYear')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicScore')) ?></b></th>
    <th style="width: 10%"><b><?= esc(lang('UI.publicType')) ?></b></th>
    <th style="width: 23%"><b><?= esc(lang('UI.publicClub')) ?></b></th>
    <th style="width: 25%"><b><?= esc(lang('UI.publicName')) ?></b></th>
    <th style="width: 5%"><b><?= esc(lang('UI.publicCertificate')) ?></b></th>
  </thead>

  <tbody class=".table-hover">

    <!--  ================================================================================================== -->

    <!-- inicio da formação do corpo da tabela com os dados -->

    <?php foreach($consulta as $certificado): ?>

    <tr>
    <td><b><?= esc($certificado->indicativo) ?></b></td>
    <td><b><?= esc($certificado->concurso) ?></b></td>
    <td><?= esc($certificado->ano) ?></td>
    <td><?= esc($certificado->pontuacao) ?></td>
    <td><?= esc(strtoupper((string) $certificado->tipo_evento)) ?></td>
    <td><?= esc($certificado->clube) ?></td>
    <td><b><?= esc(strtoupper((string) $certificado->nome)) ?></b></td>
    <?= helper("App_helper"); ?>
    <?= findIco($certificado->status, $certificado->serial, $certificado->identificador); ?>
    </tr>

    <?php endforeach; ?>

    <!-- Fim da formação do corpo da tabela com os dados -->

  </tbody>
</table>

<?= $this->endSection()?>
