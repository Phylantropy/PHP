<?php

$title = 'Blog écrivain';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? 'disconnection' : 'connectionView';
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? 'Se déconnecter' : 'Se connecter';

$notice = 'Liste des commentaires signalés non modérés:';

ob_start(); ?>

    <a href="index.php?action=administration">Panneau administration</a>
    <a href="index.php?action=newPostPanel">Nouveau billet</a>

<?php
$adminShortcuts = ob_get_clean();


ob_start();

for ( $i = $firstComment; $i < $commentsCount ; $i++ ) { ?>
    <article class="comment">
        <div class="infosComment">
            <em>Auteur du commentaire:</em><span> <?= htmlspecialchars( $commentsArr[ $i ][ 'author' ] ); ?></span>
            <br>
            <span>posté le:</span><em> <?= $commentsArr[ $i ][ 'comment_date' ]; ?></em>
            <br>
            <em>signalé le:</em><span> <?= $commentsArr[ $i ][ 'report_date' ]; ?></span>
            <br>
            <span>par:</span><em> <?= htmlspecialchars( $commentsArr[ $i ][ 'pseudo' ]); ?></em>
        </div>
        
        <p>
            <?= nl2br( htmlspecialchars( $commentsArr[ $i ][ 'content' ] )); ?>
            <br />
        </p>

        <form class="editComment" action="index.php?action=moderateComment&amp;commentId=<?= $commentsArr[ $i ][ 'comment_id' ] ?>" method="post">

            <textarea class="commentArea" name="comment"> <?= nl2br( htmlspecialchars( $commentsArr[ $i ][ 'content' ] )); ?></textarea>
            <br>
            <em>Attention: éditer un commentaire changera son statut comme ayant été modéré.</em>
            <br>
            <input type="submit" value="Modifier"/> ou bien annuler la modification:
            <input type="button" value="Annuler" class="cancelEdit">
        </form>

        <div class="delete-confirmation">
            <em>Vous êtes sur le point de supprimer ce commentaire.</em>
            <br />
            Confirmation: <a href="index.php?action=deleteReportedComment&amp;commentId=<?= $commentsArr[ $i ][ 'comment_id' ] ?>"><input type="button" value="Supprimer"></a>
            ou bien annuler la suppression:
            <input type="button" value="Annuler" class="cancelDelete">
        </div>
        
        <div class="inputsComment">
            <input type="button" value="Editer" class="editButton"/>
            <input type="button" value="Supprimer" class="delete-button">
        </div>
    </article>
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