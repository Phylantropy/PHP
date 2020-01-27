<?php

$title = htmlspecialchars( $post['title'] );

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? 'disconnection' : 'connectionView';
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? 'Se déconnecter' : 'Se connecter';

$notice = 'Commentaires du billet:';


ob_start(); ?>

    <a href="index.php">Accueil</a>
    
<?php $home = ob_get_clean();


ob_start(); ?>
    <article class="news">
        <h3>
            <?= htmlspecialchars( $post[ 'title' ] ) ?>
        </h3>

        <div id="creationDate">
            le <?= $post[ 'creation_date_fr' ] ?>
        </div>

        <p>
            <?= nl2br(htmlspecialchars( $post[ 'content' ] )) ?>
        </p>
    </article>

    <h2>Commentaires:</h2>

    <?php
    while ($comment = $comments->fetch() ) { ?>
        <div class="comments">
            <div class="commentTitle">
                <div class="commentAuthor"><?= htmlspecialchars( $comment['author']) ?></div><div class="commentDate"> le <?= $comment['comment_date_fr'] ?></div>
            </div>
            <p><?= nl2br(htmlspecialchars( $comment['content'])) ?></p>

            <?php
            if ( isset( $_COOKIE['pseudo'] ) && !empty( $_COOKIE['pseudo'] )) { ?>
                <a href="index.php?action=reportComment&amp;commentId=<?= $comment['id'] ?>&amp;user=<?= $_COOKIE['pseudo'] ?>">Signaler</a>
            <?php
            }
            ?>
        </div>
    <?php
    } 
    
    if ( isset( $_SESSION['pseudo']) && !empty( $_SESSION['pseudo']) && isset($_COOKIE['pseudo']) ) { ?>
        <section id="newComment">
            <h3>Ajouter un commentaire</h3>

            <form action="index.php?action=addComment&amp;id=<?= $post['id'] ?>" method="post">
                
                <label for="comment">Nouveau commentaire:</label>
                <textarea id="comment" name="comment"></textarea>
                <input type="submit" />

            </form>
        </section>
    <?php
    }

$content = ob_get_clean();


ob_start();

foreach ($pagesNumber as $value) { ?>
    <a href="index.php?action=postView&amp;id=<?= $post['id']; ?>&amp;page=<?= $value ?>"><?= $value ?></a>
<?php
}

unset( $value );
$pages = ob_get_clean();


require_once 'view/frontend/template.php';