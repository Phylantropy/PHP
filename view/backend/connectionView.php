<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain - Connexion</title>
        <link href="public/css/style.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <header>
            <h1>Page de connexion</h1>
        </header>

        <nav>
            <a href="index.php">Accueil</a>
        </nav>

        <div>
            <form action="index.php?action=connection" method="post">
                <div>
                    <label for="login">Pseudo</label><br />
                    <input type="text" id="login" name="login" />
                </div>
                <div>
                    <label for="password">Mot de passe</label><br />
                    <input type="password" id="password" name="password" />
                </div>
                <div>
                    <input type="submit" />
                </div>
            </form>
            <br />
            <div>
                <?php
                if ( isset($errorMessage) ) {
                    echo $errorMessage;
                }
                ?>
            </div>
        </div>
    </body>
</html>