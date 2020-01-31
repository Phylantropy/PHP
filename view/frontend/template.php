<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="public/css/style.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <header>
        <h1>Bienvenue sur le blog de Jean Forteroche</h1>        
    </header>


    <nav>
    <?php
    if ( !isset( $_COOKIE[ 'pseudo' ] )) { ?>
        <a href="index.php?action=subscribe" id="subscribe">S'inscrire</a>
    <?php
    } ?>
    <a href="index.php?action=<?= $connectionCSS ?>" id="connexion"><?= $connectionText ?></a>

    <?= $home ?>
    </nav>


    <section>
        <h2><?= $notice ?></h2>

        <?= $content ?>
    </section>

    <div id="pages"> 
        Pages: <?= $pages ?> 
    </div>
</body>
</html>