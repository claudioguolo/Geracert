<!DOCTYPE html>
<html lang="<?= esc(service('request')->getLocale()) ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title><?= esc(lang('UI.siteTitle')) ?></title>
</head>
<body>
    

<div class="container">
    <div class="alert alert-info">
        <?= esc($message); ?>
        <p class="mt-3"><?php echo anchor(base_url($redirect ?? ''), lang('UI.backToHome'))?></p>
    </div>
</div>

</body>
</html>
