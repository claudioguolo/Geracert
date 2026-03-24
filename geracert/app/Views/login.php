<!doctype html>
<html lang="<?= esc(service('request')->getLocale()) ?>" data-bs-theme="auto">

<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title><?= esc(lang('UI.siteTitle')) ?> - <?= esc(lang('UI.login')) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Favicons -->

    <meta name="theme-color" content="#712cf9">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <div class="d-flex justify-content-end mb-3">
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?= esc(lang('UI.language')) ?>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item<?= service('request')->getLocale() === 'pt-BR' ? ' active' : '' ?>" href="<?= base_url('locale/pt-BR') ?>">Português (Brasil)</a></li>
                    <li><a class="dropdown-item<?= service('request')->getLocale() === 'en' ? ' active' : '' ?>" href="<?= base_url('locale/en') ?>">English</a></li>
                </ul>
            </div>
        </div>
        <form action="<?= base_url('login/signIn') ?>" method="post">
            <?= csrf_field() ?>
            <!-- <img class="mb-4" src="" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal"><?= esc(lang('UI.adminArea')) ?></h1>

            <div class="form-floating">
                <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="name@example.com">
                <label for="inputEmail"><?= esc(lang('UI.emailAddress')) ?></label>
            </div>
            <div class="form-floating">
                <input type="password" name="inputPassword" class="form-control" id="inputPassword" placeholder="Password">
                <label for="inputPassword"><?= esc(lang('UI.password')) ?></label>
            </div>

            <div class="checkbox mb-3">
               <!-- <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label> -->
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit"><?= esc(lang('UI.login')) ?></button>
            <div class="mt-3">
            <a class="mx-3" href="/"><?= esc(lang('UI.home')) ?></a>
            </div>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
        </form>
        <?php $msg = session()->getFlashData('msg') ?>
        <?php if (!empty($msg)) : ?>
            <div class="alert alert-danger">
                <?= esc($msg) ?>
            </div>
        <?php endif; ?>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-cuYeNwDkM1s0M9N8YQ91u0J8kY0s8AjtKoa6HgMHqYjgJv1bVbWcv16O3Q8b6jzr" crossorigin="anonymous"></script>

</body>

</html>
