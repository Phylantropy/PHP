<?php
$title = 'Blog écrivain';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'disconnection' ) : htmlspecialchars( 'connectionView' );
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'Se déconnecter' ) : htmlspecialchars( 'Se connecter' );


ob_start(); ?>

    <div id="h1">
        <h1>Administration</h1>
    </div>

    <a href="index.php?action=administration">Accueil administration</a>

<?php
$header = ob_get_clean();


ob_start(); ?>
<br>
<div id="commentsList">Liste des commentaires signalés non modérés:</div>

<?php
for ( $i = $firstComment; $i < $commentsCount ; $i++ ) { ?>

    <div class="news">

        <h3>
            <em>Auteur du commentaire:</em> <?= htmlspecialchars( $commentsArr[ $i ][ 'author' ] ); ?>
            <br>
            <em>posté <?= $commentsArr[ $i ][ 'comment_date' ]; ?></em>
            <br>
            <em>signalé le <?= $commentsArr[ $i ][ 'report_date' ]; ?></em>
            <br>
            <em>par <?= htmlspecialchars( $commentsArr[ $i ][ 'pseudo' ]); ?></em>
        </h3>
        
        <p>
            <?= nl2br( htmlspecialchars( $commentsArr[ $i ][ 'content' ] )); ?>
            <br />
        </p>

        <input type="button" value="Editer" class="editButton"/>

        <form action="index.php?action=moderateComment&amp;commentId=<?= $commentsArr[ $i ][ 'comment_id' ] ?>" method="post" class="editComment">

            <textarea class="comment" name="comment"> <?= nl2br( htmlspecialchars( $commentsArr[ $i ][ 'content' ] )); ?></textarea>
            <input type="submit" value="Modifier"/>

        </form>

        <p class="delete-confirmation">
            Vous êtes sur le point de supprimer ce commentaire.
            <br />
            Confirmation: <a href="index.php?action=deleteReportedComment&amp;commentId=<?= $commentsArr[ $i ][ 'comment_id' ] ?>"><input type="button" value="Supprimer"></a>
        </p>
        
        <p class="delete-button-P">
            <input type="button" value="Supprimer" class="delete-button"> 
        </p>

    </div>

<?php
}
unset($data); ?>

<script src="public/js/edit-comment.js"></script>

<?php
$content = ob_get_clean();


ob_start();
    for ( $i = 1; $i <= $pageCount; $i++ ) { ?>
        <a href="index.php?action=commentsModeration&amp;page=<?= $i ?>"><?= $i ?></a>
    <?php
    }
$pages = ob_get_clean();


require_once 'view/backend/template.php';