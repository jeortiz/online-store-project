<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="content/style.css" />
    <?php
        include("includes/favicon.inc.php");
        if(isset($extraHeader))
            echo $extraHeader;
    ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body id="<?= $bodyId ?>">
    <?php
        include("includes/header.inc.php");
        include("{$template}.tpl.php");
    ?>
</body>
</html>