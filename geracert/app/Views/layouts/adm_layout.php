<!DOCTYPE html>
<html lang="pt-br">

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

            if (!confirm('Deseja excluir o registro?')) {
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="container-fluid py-3">

        <header class="text-center">
            <!--  ================================================================================================= -->

            <div class="text-center mt-4">
                <p class="h1">GERACERT</p>
                <h6>Gerador de Certificados</6>
            </div>

        </header>
        <!--  ================================================================================================= -->

        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-primary navbar-expand-lg rounded-2">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Home</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-link active" aria-current="page" href="#">Concursos</a>
                            <a class="nav-link active" aria-current="page" href="/certificado">Certificados</a>
                            <a class="nav-link active" aria-current="page" href="/certconfig">Modelos</a>
                            <a class="nav-link active" aria-current="page" href="/clube">Clubes</a>
                            <a class="nav-link" aria-current="page" href="#">Usuários</a>
                            <a class="nav-link active" aria-current="page" href="/login/signOut">Sair</a>

                        </div>
                    </div>
                </div>
            </nav>

        </div>

        <div class="mt-4">
            <!--  ================================================================================================= -->

            <?= $this->renderSection('content') ?>

            <!--  ================================================================================================== -->
        </div>

        <footer class="bd-footer py-4 mt-4">
            <div class="text-center p-4">
                Copyright © 2004-2021
                <a href="https://www.py9mt.qsl.br/" target="blank">PY9MT</a>. All Rights Reserved.
            </div>
        </footer>
    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>



</body>

</html>