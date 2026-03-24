<?= $this->extend('layouts/main_layout') ?>


<?= $this->section('content') ?>


<!-- Só pra gerar o alerta no inicio quando ainda não tem consulta.  -->

<table id="ph" class="w3-table-all">
    <!-- <caption>Certificados Disponíveis</caption> -->


    <tbody class=".table-hover">
    <tr>
        <td style="width: 90%;">
            <b>
                <?= esc(lang('UI.introSearch')) ?>
            </b>
        </td>
    </tr>
    </tbody>
</table>


<?= $this->endSection()?>
