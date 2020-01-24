<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain - Connexion</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <nav>
            <a href="index.php">Aller à l'accueil</a>
        <?php
            if ( $_SESSION[ 'isAdmin' ] === true ) { ?>
                ou bien, <br>
                <a href="index.php?action=administration">Aller sur la page d'administration</a>
            <?php
            }
        ?>
        </nav>

        <div class="message">
            <p>Bienvenu <?= $_SESSION['pseudo']?>!</p>
        </div>
    </body>
</html>