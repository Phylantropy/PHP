<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Blog écrivain</title>
        <link href="../public/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <header>
            <h1>Mon blog</h1>
            <p>Voici les derniers billets du blog :</p>
        </header>

        <?php
        while ($data = $article->fetch() ) {
        ?>

        <div class="news">
            <h3>
                <?= htmlspecialchars($data['title'] ); ?>
                <br />
                <em>le <?= $data['date_creation_fr']; ?></em>
            </h3>
            
            <p>
                <?= nl2br(htmlspecialchars($data['content'] )); ?>
                <br />
                <em><a href="post.php?id=<?= $data['id']; ?>">Commentaires</a></em>
                <br />
                id: <?= $data['id']; ?>
            </p>
        </div>
        <?php
        }
        $article->closeCursor();
        ?>
    </body>
</html>