<!DOCTYPE html>
<html lang="pt-br">

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
  
      <div class="containerw3-bar w3-padding w3-section">
        <div class="container">

          <!-- Titulo -->
          <div class="text-center m-5 ">
            <p class="h1 text-primary">GERACERT</p>
            <p class="h3 text-secondary">Gerador de Certificados</p>
          </div>
          <!-- Titulo -->

          <!-- Formulario -->
          <form action="tablecerts" method="get" name="filter">

            <div class="row m-4 p-4 mx-5 shadow border rounded-4 align-self-center">

              <div class="col-5">
                <input class="form-control col" placeholder="Buscar por Estação" type="text" size="16" maxlength="20" onfocus="document.getElementById('clube').value = ''" id="callsign" value="" name="callsign">
              </div>


              <div class="col-5">
                <select class="form-select col" placeholder="Selecione" onchange="document.getElementById('callsign').value = ''" id="clube" name="clube">
                  <option value="">Buscar por Clube</option>
                  <?php foreach ($clubes as $clube) : ?>
                    <option value=<?php echo $clube->codigo ?>><?php echo $clube->clube ?></option>
                  <?php endforeach; ?>

                </select>
              </div>

              <div class="col-2 d-grid gap-2 col-2 mx-auto">
                <input class="btn btn-primary" type="submit" value="Buscar" id="buscar" name="buscar">
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
              <i class="fa fa-times-circle" style="font-size:20px;color:red"></i> Cancelado
            </div>
            <div class="col-2">
              <i class="fa fa-file-pdf-o" style="font-size:20px;color:red"></i> Já Emitido
            </div>
            <div class="col-2">
              <i class="fa fa-file-pdf-o" style="font-size:20px;color:blue"></i> Disponível
            </div>
            <div class="col-3">
              <i class="fa fa-spinner" style="font-size:20px;color:red"></i> Processamento
            </div>
          </div>


          <div class="row justify-content-md-center p-3">
            <div class="mx-3 text-center mb-3" style="width: 18rem;">
              <div class="card-body">
                <p class="card-text">Para dúvidas, sugestões ou colaborar com este projeto: py9mt@yahoo.com.br</p>
              </div>
              <div>
                <p class=""><b>PIX:</b></p>
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