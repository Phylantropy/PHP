<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain - Inscription</title>
        <link href="public/css/style.css" rel="stylesheet" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body>
        <section>
            <h2>Page d'inscription</h2>
        </section>

        <nav>
            <a href="index.php">Accueil</a>
        </nav>

        <div>
            <form action="index.php?action=subscription" method="post">
                <div>
                    <label for="pseudo">Pseudo</label><br />
                    <input type="text" id="pseudo" name="pseudo" />
                </div>
                <div>
                    <label for="password">Mot de passe</label><br />
                    <input type="password" id="password" name="password" />
                </div>
                <div>
                    <label for="passwordCheck">Retapez votre mot de passe</label><br />
                    <input type="password" id="passwordCheck" name="passwordCheck" />
                </div>
                <div>
                    <input type="submit" />
                </div>
            </form>
            <br />
            <div>
                <?php
                if ( isset($errorMessage) ) { echo $errorMessage; }
                ?>
            </div>
        </div>
    </body>
</html>