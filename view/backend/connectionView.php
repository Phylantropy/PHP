<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain - Connexion</title>
        <link href="public/css/style.css" rel="stylesheet" />
    </head>

    <body>
        <header>
            <h1>Page de connexion</h1>
        </header>

        <p><a href="index.php">Retour à la liste des billets</a></p>

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