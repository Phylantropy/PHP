<!DOCTYPE hmlt>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <?php echo $content ?>
        <div id="pages">
            Pages: <?php echo $pages ?>
        </div>
    </body>
</html>