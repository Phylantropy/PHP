<?php $title = 'Blog écrivain';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'disconnection' ) : htmlspecialchars( 'connectionView' );
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'Se déconnecter' ) : htmlspecialchars( 'Se connecter' );

?>

<?php ob_start(); ?>

    <div id="h1">
        <h1>Administration</h1>
    </div>

<?php $header = ob_get_clean(); ?>


<?php ob_start(); ?>
    
    <section id="editor">
        <h2>Edition de billet</h2>

        <form action="index.php?action=addPost" method="post">
            <textarea id="mytextarea" name="mytextarea"><?= $post ?></textarea>
            <br />
            <input type="submit" value="Modifier"/>
        </form>
    </section>

    <div id="postAnnonce">Dernier billet publié:</div>
    
    <?php
    while ( $data = $posts->fetch() ) {
    ?>

    <div class="news">

        <h3>
            <?= htmlspecialchars( $data['title'] ); ?>
            <br />
            <em>le <?= $data['date_creation_fr']; ?></em>
        </h3>
        
        <p>
            <?= nl2br( htmlspecialchars( $data['content'] )); ?>
            <br />
            <em><a href="index.php?action=post&amp;id=<?= $data[ 'id' ]; ?>&amp;page=1">Commentaires</a></em>
            <br />
            id: <?= $data['id']; ?>
            <br />
            <a href="index.php?action=editPost&amp;postId=<?= $data[ 'id' ] ?>">Editer</a>
        </p>
    </div>

    <?php
    }
    $posts->closeCursor();
    ?>

<?php $content = ob_get_clean(); ?>

<?php
ob_start();
    foreach ( $pagesNumber as $value ) {
    ?>
        <a href="index.php?action=administration&amp;page=<?= $value ?>"><?= $value ?></a>
    <?php
    }
    unset( $value );
    ?>
<?php $pages = ob_get_clean(); ?>


<?php require_once 'view/backend/template.php'; ?>