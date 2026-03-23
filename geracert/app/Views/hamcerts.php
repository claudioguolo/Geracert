<?= $this->extend('layouts/main_layout') ?>


<?= $this->section('content') ?>

<table id="ph" class="table table-striped table-hover caption-top">
  <!-- <caption>Certificados Disponíveis</caption> -->

  <thead>
    <th style="width: 10%"><b>INDICATIVO</b></th>
    <th style="width: 10%"><b>CONCURSO</b></th>
    <th style="width: 10%" style="width: 5%"><b>ANO</b></th>
    <th style="width: 10%"><b>SCORE</b></th>
    <th style="width: 10%"><b>TIPO</b></th>
    <th style="width: 23%"><b>CLUBE</b></th>
    <th style="width: 25%"><b>NOME</b></th>
    <th style="width: 5%"><b>CERT</b></th>
  </thead>

  <tbody class=".table-hover">

    <!--  ================================================================================================== -->

    <!-- inicio da formação do corpo da tabela com os dados -->

    <?php foreach($consulta as $certificado): ?>

    <?= '<tr>' ?>
    <?= '<td><b>'.$certificado->indicativo.'</b></td>'; ?>
    <?= '<td><b>'.$certificado->concurso.'</b></td>'; ?>
    <?= '<td>'.$certificado->ano.'</td>'; ?>
    <?= '<td>'.$certificado->pontuacao.'</td>'; ?>
    <?= '<td>'.strtoupper($certificado->tipo_evento).'</td>'; ?>
    <?= '<td>'.$certificado->clube.'</td>'; ?>
    <?= '<td><b>'.strtoupper($certificado->nome).'</b></td>'; ?>
    <?= helper("App_helper"); ?>
    <?= findIco($certificado->status, $certificado->serial, $certificado->identificador); ?>
    <?= '</tr>' ?>

    <?php endforeach; ?>

    <!-- Fim da formação do corpo da tabela com os dados -->

  </tbody>
</table>

<?= $this->endSection()?>