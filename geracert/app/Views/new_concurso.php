<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>


<div class="container p-3">


    <div class="card" id="edita_concurso">
        <div class="card-body">

            <?= form_open('/insert_concurso') ?>

            <label name="titulo" class="h4">

                <p>Novo Concurso</p>
            </label>

            <div class="form-group p-3">



                

                <label>Concurso</label><input name="cert_concurso" type="text" class="form-control" value="">

                <label>Ano</label><input name="cert_ano" type="text" class="form-control" value="">

                <label>Organizador</label><input name="cert_organizador" type="text" class="form-control" value="">

                <label>HTML do Corpo</label><textarea name="cert_html_corpo" id="" cols="30" rows="10" class="form-control"></textarea>

                <label>Conf do Corpo</label><textarea name="cert_texto_text" id="" cols="30" rows="10" class="form-control"></textarea>

                <label>Conf do Serial</label><textarea name="cert_serial_text" id="" cols="30" rows="10" class="form-control"></textarea>

                <label>datetime_text</label><input type="text" name="cert_datetime_text" class="form-control" value="">

                <label>H1</label><input name="cert_size_h1" type="text" class="form-control" value="">

                <label>H2</label><input name="cert_size_h2" type="text" class="form-control" value="">

                <label>H3</label><input name="cert_size_h3" type="text" class="form-control" value="">

                <label>H4</label><input name="cert_size_h4" type="text" class="form-control" value="">

                <label>H5</label><input name="cert_size_h5" type="text" class="form-control" value="">

                <label>H6</label><input name="cert_size_h6" type="text" class="form-control" value="">

                <label>Imagem do certificado</label>
                <div class="input-group">
                    <input type="text" name="cert_imagem" class="form-control" placeholder="Selecione uma imagem" value="">
                    <button class="btn btn-outline-secondary mx-2" type="button">Selecionar</button>
                </div>
            </div>


            <div class="form-group text-center p-3">

                <button class="btn btn-primary" type="submit">Salvar</button>
                <button type="" class="btn btn-secondary"><a href="/lista_concursos" class="text-decoration-none text-reset">Cancel</a></button>

            </div>
            <?= form_close() ?>
        </div>


        <?= $this->endSection() ?>