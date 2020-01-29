<?php

$title = 'Blog de Jean Forteroche';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? 'disconnection' : 'connectionView';
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? 'Se déconnecter' : 'Se connecter';

$notice = 'Voici les derniers billets du blog :';


ob_start();

    if ( $_SESSION[ 'isAdmin'] === true ) { ?>
        <a href="index.php?action=administration">Panneau administration</a>
    <?php
    }
    
$home = ob_get_clean();


ob_start(); 

    while ( $data = $posts->fetch() ) { ?>
        <article class="news">
            <h3>
                <?= htmlspecialchars( $data['title'] ); ?>
            </h3>
            
            <div class="creationDate">
                <span>le <?= $data['date_creation_fr']; ?></span>
            </div>
            
            <p>
                <?= nl2br( htmlspecialchars ($data['content'] )); ?>
            </p>

            <a class="commentsLink" href="index.php?action=postView&amp;id=<?= $data['id']; ?>&amp;page=1">Commentaires</a>
        </article>
    <?php
    }
    $posts->closeCursor();
$content = ob_get_clean();


ob_start();
    foreach ( $pagesNumber as $value ) { ?>
        <a href="index.php?action=listPosts&amp;page=<?= $value ?>"><?= $value ?></a>
    <?php
    }
    unset( $value );
$pages = ob_get_clean();


require_once 'view/frontend/template.php';