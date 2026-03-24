<!DOCTYPE html>
<html lang="pt-br">
<?php $previewMode = isset($preview_mode) && $preview_mode === true; ?>

<head>
    <title>Geracert</title>
    <meta charset="UTF-8">
    <style type="text/css">
        html, body {height: 95%;}

        body {background-size: cover; background-repeat: no-repeat; padding: 0;}
        <?php if ($previewMode) : ?>
        html, body {
            width: 1123px;
            height: 794px;
        }
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #fff;
        }
        <?php endif; ?>

        h1 {<?= $format_vars['size_h1'] ?>}
        h2 {<?= $format_vars['size_h2'] ?>}
        h3 {<?= $format_vars['size_h3'] ?>}
        h4 {<?= $format_vars['size_h4'] ?>}
        h5 {<?= $format_vars['size_h5'] ?>}
        h6 {<?= $format_vars['size_h6'] ?>}

        .corpo {
            position: fixed;
            left: 0px;
            top: 0px;
            right: 0px;
            text-align: center;
            border: 0px;
            width: 100%;
            height: 100%;
        }

        .texto {<?= $format_vars['texto_text'] ?>}

        .serial {<?= $format_vars['serial_text'] ?>}

        .operator{
            width: 400px;
            text-align: center;
            margin: auto;
        }

        .localdata { 
            position: fixed; 
            top: 510px; 
            left: 500px; 
            text-align: left; 
            border: solid 0px; 
            width: 50%; 
            height: 100%;
        }

        .datetime {<?= $format_vars['datetime_text'] ?>}

    </style>
</head>


<body>
    <div class="corpo">

        <div class="serial"><h6>#<?= $cert_vars['serial'] ?></h6></div>
        <img src="<?= esc($format_vars['imagem']) ?>" style="width: 100%; margin-top: -1%;">
        <div class="texto"><?= $format_vars['$div_texto'] ?></div>
        <div class="datetime"><h6><?= esc(lang('UI.generatedOn')) ?>: <?= $cert_vars['geracao_data'] ?> </h6></div>

    </div>

</body>

</html>
