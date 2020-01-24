<?php

$title = 'Blog écrivain';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? 'disconnection' : 'connectionView';
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? 'Se déconnecter' : 'Se connecter';

$notice = 'Nouveau billet:';


ob_start(); ?>

    <a href="index.php?action=administration">Panneau administration</a>
    <a href="index.php?action=commentsModeration">Modération des commentaires</a>

<?php
$adminShortcuts = ob_get_clean();


ob_start(); ?>
    
    <section id="editor">
        
        <form action="index.php?action=addPost" method="post">
            Titre: <input type="text" name="title"/>
            <textarea id="mytextarea" name="mytextarea"></textarea>
            <input type="submit" value="Publier"/>
        </form>

    </section>

    <h2>Liste des billets:</h2>

<?php
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
        <a class="editLink" href="index.php?action=editPost&amp;postId=<?= $data['id'] ?>">Editer</a>
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