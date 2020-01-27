<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <title>Administration</title>
    <link href="public/css/style.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='public\tinymce\js\tinymce\tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>
</head>


<body>
    <header>
        <h1>Administration</h1>
    </header>


    <nav>
        <a href="index.php?action=<?= $connectionCSS ?>" id="connexion"><?= $connectionText ?></a>
        <a href="index.php">Accueil</a>
    </nav>


    <div id="adminShortcuts">
        <?= $adminShortcuts ?>
    </div>


    <section>
        <h2><?= $notice ?></h2>

        <?= $content ?>
    </section>


    <div id="pages"> 
        Pages: <?= $pages ?> 
    </div>
</body>
</html>