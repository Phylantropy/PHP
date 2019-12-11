<?php $title = htmlspecialchars($post['title']);

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'disconnection' ) : htmlspecialchars( 'connectionView' );
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'Se déconnecter' ) : htmlspecialchars( 'Se connecter' );

?>

<?php ob_start(); ?>

    <div id="h1">
        <h1>Mon blog</h1>
    </div>

    <p><a href="index.php">Retour à la liste des billets</a></p>
    
<?php $header = ob_get_clean(); ?>


<?php ob_start(); ?>
    <div class="news">
        <h3>
            <?= htmlspecialchars($post['title']) ?>
            <em>le <?= $post['creation_date_fr'] ?></em>
        </h3>

        <p>
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </p>
    </div>

    <h2>Commentaires</h2>

    <?php
    while ($comment = $comments->fetch() ) {
    ?>
        <div class="commentaires">
        <p class="firstP"><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_date_fr'] ?></p>
        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
        </div>
    <?php
    }

    if ( isset( $_SESSION['pseudo']) && !empty( $_SESSION['pseudo']) && isset($_COOKIE['pseudo']) ) {
    ?>
        <h3>Ajouter un commentaire</h3>

        <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
            <div>
                <label for="comment">Commentaire</label><br />
                <textarea id="comment" name="comment"></textarea>
            </div>
            <div>
                <input type="submit" />
            </div>
        </form>
        <?php
    }

    $content = ob_get_clean(); ?>


<?php
ob_start();

foreach ($pagesNumber as $value) {
?>
    <a href="index.php?action=post&amp;id=<?= $post['id']; ?>&amp;page=<?= $value ?>"><?= $value ?></a>
<?php
}
unset($value);
?>
<?php $pages = ob_get_clean(); ?>


<?php require_once 'view/frontend/template.php'; ?>