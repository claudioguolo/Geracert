<?= $this->extend('layouts/adm_layout') ?>

<?= $this->section('content') ?>

<div class="card" id="telaLogin">
    <div class="card-body">

        <?= form_open('/login_submit') ?>

        <div class="form-group">

            <div class="mb-3">
                <label class="form-label">Login</label>
                <input type="text" class="form-control" name="text_usuario" aria-describedby="emailHelp" placeholder="Nome de usuário">
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" class="form-control" name="text_senha" id="" placeholder="Insira sua senha">
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-success btn-block" type="submit">Login</button>
            </div>
        </div>

    </div>


    <?= form_close() ?>
</div>

<?= $this->endSection() ?>