<!DOCTYPE html>
<html lang="<?= esc(service('request')->getLocale()) ?>">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>GERACERT - CERTIFICADOS</title>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <link href="./style/css/nav.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="./style/css/geracert.css" rel="stylesheet">


</head>

<body onload="document.forms.filter.Form_Callsign.focus()">
      <?php $authorization = service('authorization'); ?>
      <?php $currentLocale = service('request')->getLocale(); ?>
      <?php $languageOptions = ['pt-BR' => 'Português (Brasil)', 'en' => 'English']; ?>
  
      <div class="containerw3-bar w3-padding w3-section">
        <div class="container">

          <!-- Titulo -->
          <div class="text-center m-5 ">
            <p class="h1 text-primary"><?= esc(lang('UI.siteTitle')) ?></p>
            <p class="h3 text-secondary"><?= esc(lang('UI.siteSubtitle')) ?></p>
          </div>
          <!-- Titulo -->

          <div class="d-flex justify-content-end mb-3">
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-translate"></i> <?= esc(lang('UI.language')) ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php foreach ($languageOptions as $localeCode => $localeLabel) : ?>
                  <li>
                    <a class="dropdown-item<?= $currentLocale === $localeCode ? ' active' : '' ?>" href="<?= base_url('locale/' . rawurlencode($localeCode)) ?>">
                      <?= esc($localeLabel) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>

          <?php if ((bool) session()->get('isLoggedIn') === true && $authorization->can((string) session()->get('permissoes'), 'admin.dashboard')) : ?>
            <div class="row justify-content-center mb-4">
              <div class="col-lg-10">
                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center p-3 border rounded-4 bg-light shadow-sm">
                  <span class="badge text-bg-dark px-3 py-2"><?= esc((string) session()->get('nome')) ?> · <?= esc($authorization->rolesLabel((string) session()->get('permissoes'))) ?></span>
                  <a class="btn btn-primary" href="<?= base_url('admin') ?>"><?= esc(lang('UI.adminPanel')) ?></a>
                  <?php if ($authorization->can((string) session()->get('permissoes'), 'certconfig.manage')) : ?>
                    <a class="btn btn-outline-primary" href="<?= base_url('certconfig') ?>"><?= esc(lang('UI.contests')) ?></a>
                  <?php endif; ?>
                  <?php if ($authorization->can((string) session()->get('permissoes'), 'certificado.manage')) : ?>
                    <a class="btn btn-outline-primary" href="<?= base_url('certificado') ?>"><?= esc(lang('UI.certificates')) ?></a>
                  <?php endif; ?>
                  <?php if ($authorization->can((string) session()->get('permissoes'), 'clube.manage')) : ?>
                    <a class="btn btn-outline-primary" href="<?= base_url('clube') ?>"><?= esc(lang('UI.clubs')) ?></a>
                  <?php endif; ?>
                  <form action="<?= base_url('login/signOut') ?>" method="post" class="d-inline-flex">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-outline-danger"><?= esc(lang('UI.logout')) ?></button>
                  </form>
                </div>
              </div>
            </div>
          <?php endif; ?>

          <!-- Formulario -->
          <form action="tablecerts" method="get" name="filter">

            <div class="row m-4 p-4 mx-5 shadow border rounded-4 align-self-center">

              <div class="col-5">
                <input class="form-control col" placeholder="<?= esc(lang('UI.searchByStation')) ?>" type="text" size="16" maxlength="20" onfocus="document.getElementById('clube').value = ''" id="callsign" value="" name="callsign">
              </div>


              <div class="col-5">
                <select class="form-select col" placeholder="Selecione" onchange="document.getElementById('callsign').value = ''" id="clube" name="clube">
                  <option value=""><?= esc(lang('UI.searchByClub')) ?></option>
                  <?php foreach ($clubes as $clube) : ?>
                    <option value="<?= esc($clube->codigo) ?>"><?= esc($clube->clube) ?></option>
                  <?php endforeach; ?>

                </select>
              </div>

              <div class="col-2 d-grid gap-2 col-2 mx-auto">
                <input class="btn btn-primary" type="submit" value="<?= esc(lang('UI.search')) ?>" id="buscar" name="buscar">
              </div>

            </div>
          </form>
          <!-- Formulario -->

          <!--  ================================================================================================== -->

          <?= $this->renderSection('content') ?>

          <!--  ================================================================================================== -->



          <div class="row p-3">
            <div class="col-2">
            </div>
            <div class="col-2">
              <i class="fa fa-times-circle" style="font-size:20px;color:red"></i> <?= esc(lang('UI.legendCancelled')) ?>
            </div>
            <div class="col-2">
              <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> <?= esc(lang('UI.legendIssued')) ?>
            </div>
            <div class="col-2">
              <i class="fa fa-file-pdf-o" style="font-size:20px;color:blue"></i> <?= esc(lang('UI.legendAvailable')) ?>
            </div>
            <div class="col-3">
              <i class="fa fa-spinner" style="font-size:20px;color:red"></i> <?= esc(lang('UI.legendProcessing')) ?>
            </div>
          </div>


          <div class="row justify-content-md-center p-3">
            <div class="mx-3 text-center mb-3" style="width: 18rem;">
              <div class="card-body">
                <p class="card-text"><?= esc(lang('UI.supportText')) ?> py9mt@yahoo.com.br</p>
              </div>
              <div>
                <p class=""><b><?= esc(lang('UI.pixLabel')) ?>:</b></p>
                <img src="./images/py9mt-pix.jpg" style="max-width: 80%" class="card-img-top img-thumbnail border rounded-4" alt="PIX">
              </div>
            </div>
          </div>
        </div>



        <!-- Footer -->
        <div class="text-center text-light p-2 bg-primary container border rounded-4">
          <p>Copyright © 2004-2023<a href="https://www.py9mt.qsl.br/" target="blank"> PY9MT</a> All Rights Reserved.</p>
        </div>
        <!-- Footer -->

      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
      </script>

</body>

</html>
</div>
