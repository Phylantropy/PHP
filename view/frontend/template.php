<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <a href="index.php?action=subscribe">S'inscrire</a>
        
        <?php echo $content ?>

        <div id="pages">
            Pages: <?php echo $pages ?>
        </div>
    </body>
</html>