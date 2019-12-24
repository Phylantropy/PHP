<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
            <?= $header ?>
            
            <?php
            if ( !isset( $_COOKIE[ 'pseudo' ] )) { ?>
                <div id="subscribe">
                    <a href="index.php?action=subscribe">S'inscrire</a>
                </div>
            <?php
            }
            ?>

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