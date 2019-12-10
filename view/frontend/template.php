<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?= $title ?></title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
            <?php echo $header ?>
            
            <?php
            if ( !isset( $_COOKIE[ 'pseudo' ] )) { ?>
                <div id="subscribe">
                    <a href="index.php?action=subscribe">S'inscrire</a>
                </div>
            <?php
            }
            ?>

            <?php

            if ( isset( $_SESSION[ 'isAdmin' ] ) && $_SESSION[ 'isAdmin' ] === true && !empty($_COOKIE[ 'pseudo' ]) ) { ?>
                <div id="administration">
                    <a href="index.php?action=administration">Administration</a>
                </div>
            <?php
            }
            ?>

            <div id="connexion">
                <a href="index.php?action=<?php echo $connectionCSS ?>"><?php echo $connectionText ?></a>
            </div>
        </header>

        <?php echo $content ?>

        <div id="pages">
            Pages: <?php echo $pages ?>
        </div>
    </body>
</html>