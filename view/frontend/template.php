<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?= $title ?></title>
    <link href="public/css/style.css" rel="stylesheet" />
</head>

<body>
    <header>
        <h1>Bienvenu sur le blog de Jean Forteroche</h1>        
    </header>


    <nav>
    <?php
    if ( !isset( $_COOKIE[ 'pseudo' ] )) { ?>
        <a href="index.php?action=subscribe" id="subscribe">S'inscrire</a>
    <?php
    } ?>
    <a href="index.php?action=<?= $connectionCSS ?>" id="connexion"><?= $connectionText ?></a>

    <?php
    if ( isset( $home )) {
        echo ( $home );
    } ?>
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