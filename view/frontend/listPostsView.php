<?php $title = 'Blog écrivain'; ?>

<?php ob_start(); ?>
<header>
    <h1>Mon blog</h1>
    <p>Voici les derniers billets du blog :</p>
</header>

<?php
while ($data = $posts->fetch()) {
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
            <em><a href="index.php?action=post&amp;id=<?= $data['id']; ?>">Commentaires</a></em>
            <br />
            id: <?= $data['id']; ?>
        </p>
    </div>
<?php
}
$posts->closeCursor();
?>
<?php $content = ob_get_clean(); ?>

<?php require 'view/frontend/template.php'; ?>