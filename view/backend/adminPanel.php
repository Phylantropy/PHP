<?php

$title = 'Blog de Jean Forteroche';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? 'disconnection' : 'connectionView';
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? 'Se déconnecter' : 'Se connecter';

$notice = 'Voici les derniers billets du blog :';

ob_start(); ?>

    <a href="index.php?action=newPostPanel">Nouveau billet</a>
    <a href="index.php?action=commentsModeration">Modération des commentaires</a>

<?php
$adminShortcuts = ob_get_clean();


ob_start();

    while ( $data = $posts->fetch() ) { ?>
        <article class="news">
            <h3>
                <?= htmlspecialchars( $data['title'] ); ?>
            </h3>
            
            <div id="creationDate">
                <span>le <?= $data['date_creation_fr']; ?></span>
            </div>
            
            <p>
                <?= nl2br( htmlspecialchars ($data['content'] )); ?>
            </p>

            <a class="commentsLink" href="index.php?action=postView&amp;id=<?= $data['id']; ?>&amp;page=1">Commentaires</a>
            <a class="editLink"href="index.php?action=editPost&amp;postId=<?= $data['id'] ?>">Editer</a>
        </article>
    <?php
    }
    $posts->closeCursor();
$content = ob_get_clean();


ob_start();
    foreach ( $pagesNumber as $value ) { ?>
        <a href="index.php?action=administration&amp;page=<?= $value ?>"><?= $value ?></a>
    <?php
    }
    unset( $value );
$pages = ob_get_clean();


require_once 'view/backend/template.php';