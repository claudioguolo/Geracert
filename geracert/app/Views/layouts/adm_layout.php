<!DOCTYPE html>
<html lang="<?= esc(service('request')->getLocale()) ?>">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>GERACERT</title>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <link href="./style/css/login.css" rel="stylesheet">
    <link href="./style/css/pagination.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script>
        function confirma() {

            if (!confirm('<?= esc(lang('UI.confirmDelete')) ?>')) {
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <?php $authorization = service('authorization'); ?>
    <?php $currentLocale = service('request')->getLocale(); ?>
    <?php $languageOptions = ['pt-BR' => 'Português (Brasil)', 'en' => 'English']; ?>
    <div class="container-fluid py-3">

        <header class="text-center">
            <!--  ================================================================================================= -->

            <div class="text-center mt-4">
                <p class="h1"><?= esc(lang('UI.siteTitle')) ?></p>
                <h6><?= esc(lang('UI.siteSubtitle')) ?></h6>
            </div>

        </header>
        <!--  ================================================================================================= -->

        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-expand-lg rounded-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/"><?= esc(lang('UI.home')) ?></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="/admin"><?= esc(lang('UI.dashboard')) ?></a>
                            <?php if ($authorization->can((string) session()->get('permissoes'), 'certconfig.manage')) : ?>
                                <a class="nav-link active" aria-current="page" href="/certconfig"><?= esc(lang('UI.contests')) ?></a>
                            <?php endif; ?>
                            <?php if ($authorization->can((string) session()->get('permissoes'), 'certificado.manage')) : ?>
                                <a class="nav-link active" aria-current="page" href="/certificado"><?= esc(lang('UI.certificates')) ?></a>
                            <?php endif; ?>
                            <?php if ($authorization->can((string) session()->get('permissoes'), 'clube.manage')) : ?>
                                <a class="nav-link active" aria-current="page" href="/clube"><?= esc(lang('UI.clubs')) ?></a>
                            <?php endif; ?>
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= esc(lang('UI.language')) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php foreach ($languageOptions as $localeCode => $localeLabel) : ?>
                                        <li><a class="dropdown-item<?= $currentLocale === $localeCode ? ' active' : '' ?>" href="<?= base_url('locale/' . rawurlencode($localeCode)) ?>"><?= esc($localeLabel) ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <form action="<?php echo base_url('login/signOut') ?>" method="post" class="d-inline-flex align-items-center ms-2">
                                <?= csrf_field() ?>
                                <button type="submit" class="nav-link active btn btn-link p-0 border-0 text-decoration-none"><?= esc(lang('UI.logout')) ?></button>
                            </form>

                        </div>
                    </div>
                </div>
            </nav>

        </div>

        <div class="mt-4">
            <!--  ================================================================================================= -->

            <?php if ($success = session()->getFlashdata('success')) : ?>
                <div class="container mb-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= esc($success) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($error = session()->getFlashdata('error')) : ?>
                <div class="container mb-3">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= esc($error) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>

            <!--  ================================================================================================== -->
        </div>

        <footer class="bd-footer py-4 mt-4">
            <div class="text-center p-4">
                Copyright © 2004-2026
                <a href="https://www.py9mt.qsl.br/" target="blank">PY9MT</a>. All Rights Reserved.
            </div>
        </footer>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-cuYeNwDkM1s0M9N8YQ91u0J8kY0s8AjtKoa6HgMHqYjgJv1bVbWcv16O3Q8b6jzr" crossorigin="anonymous"></script>



</body>

</html>
