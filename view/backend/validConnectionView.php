<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain - Connexion</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <p>Vous êtes connecté!</p>
        <br />
        <p>
        <?php
            if ( $_SESSION[ 'isAdmin' ] === false ) {
                echo( '<a href="index.php">Retour à la liste des billets</a>' );
            } elseif ( $_SESSION[ 'isAdmin' ] === true ) {
                echo( '<a href="index.php?action=administration">Accueil administration</a>' );
            }
        ?>
        </p>
    </body>
</html>