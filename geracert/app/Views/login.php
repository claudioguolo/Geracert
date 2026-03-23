<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>Geracert - Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Favicons -->

    <meta name="theme-color" content="#712cf9">

    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/5.3/examples/sign-in/sign-in.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin w-100 m-auto">
        <form action="<?php echo base_url('login/signIn') ?>" method="post">
            <!-- <img class="mb-4" src="" alt="" width="72" height="57"> -->
            <h1 class="h3 mb-3 fw-normal">Área Administrativa</h1>

            <div class="form-floating">
                <input type="email" name="inputEmail" class="form-control" id="inputEmail" placeholder="name@example.com">
                <label for="inputEmail">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" name="inputPassword" class="form-control" id="inputPassword" placeholder="Password">
                <label for="inputPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
               <!-- <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label> -->
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
            <div class="mt-3">
            <a class="mx-3" href="/">HOME</a>
            </div>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
        </form>
        <?php $msg = session()->getFlashData('msg') ?>
        <?php if (!empty($msg)) : ?>
            <div class="alert alert-danger">
                <?php echo $msg ?>
            </div>
        <?php endif; ?>

    </main>

</body>

</html>