<?= $this->extend('layouts/main_layout') ?>


<?= $this->section('content') ?>

<table id="ph" class="table table-striped table-hover caption-top">
  <!-- <caption>Certificados Disponíveis</caption> -->

  <thead>
    <th style="width: 10%"><b>CÓDIGO</b></th>
    <th style="width: 10%"><b>CLUBE</b></th>
    <th style="width: 10%"><b>CONCURSO</b></th>
    <th style="width: 10%" style="width: 5%"><b>ANO</b></th>
    <th style="width: 10%"><b>SCORE</b></th>
    <th style="width: 10%"><b>TIPO</b></th>
    <th style="width: 5%"><b>CERT</b></th>
  </thead>

  <tbody class=".table-hover">

    <!--  ================================================================================================== -->

    <!-- inicio da formação do corpo da tabela com os dados -->

    <?php foreach($consulta as $certificado): ?>

    <?= '<tr>' ?>
    <?= '<td><b>'.$certificado->id.'</b></td>'; ?>
    <?= '<td><b>'.$certificado->clube.'</b></td>'; ?>
    <?= '<td>'.$certificado->concurso.'</td>'; ?>
    <?= '<td>'.$certificado->ano.'</td>'; ?>
    <?= '<td>'.$certificado->pontuacao.'</td>'; ?>
    <?= '<td>'.strtoupper($certificado->tipo_evento).'</td>'; ?>
    <?= helper("App_helper"); ?>
    <?= findIco($certificado->status, $certificado->serial, $certificado->identificador,"func=clube"); ?>
    <?= '</tr>' ?>

    <?php endforeach; ?>

    <!-- Fim da formação do corpo da tabela com os dados -->

  </tbody>
</table>

<?= $this->endSection()?>