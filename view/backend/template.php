<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Administration</title>
        <link href="public/css/style.css" rel="stylesheet" />
        <script src='public\tinymce\js\tinymce\tinymce.min.js' referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: '#mytextarea'
            });
        </script>
    </head>

    <body>
        <header>

            <?= $header ?>
            
            <div id="connexion">
                <a href="index.php?action=<?= $connectionCSS ?>"><?= $connectionText ?></a>
            </div>
        </header>

        <?= $content ?>

        <div id="pages"> 
            Pages: <?= $pages ?> 
        </div>
    </body>
</html>