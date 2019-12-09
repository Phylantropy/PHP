<?php $title = 'Blog écrivain';

$connectionCSS = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'disconnection' ) : htmlspecialchars( 'connectionView' );
$connectionText = ( isset( $_COOKIE['pseudo']) ) ? htmlspecialchars( 'Se déconnecter' ) : htmlspecialchars( 'Se connecter' );

?>

<?php ob_start(); ?>
    <header>
        <div id="h1">
            <h1>Mon blog</h1>
            <p>Voici les derniers billets du blog :</p>
        </div>

        
        <?php
        if ( !isset( $_COOKIE[ 'pseudo' ] )) { ?>
            <div id="subscribe">
                <a href="index.php?action=subscribe">S'inscrire</a>
            </div>
        <?php
        }
        ?>

        <?php

        if ( isset( $_SESSION[ 'isAdmin' ] ) && $_SESSION[ 'isAdmin' ] === true && !empty($_COOKIE[ 'pseudo' ]) ) { ?>
            <div id="administration">
                <a href="index.php?action=administration">Administration</a>
            </div>
        <?php
        }
        ?>

        <div id="connexion">
            <a href="index.php?action=<?php echo $connectionCSS ?>"><?php echo $connectionText ?></a>
        </div>
    </header>
<?php $header = ob_get_clean(); ?>


<?php ob_start(); ?>
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
                <?= nl2br( htmlspecialchars ($data['content'] )); ?>
                <br />
                <em><a href="index.php?action=post&amp;id=<?= $data['id']; ?>&amp;page=1">Commentaires</a></em>
                <br />
                id: <?= $data['id']; ?>
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
        <a href="index.php?action=listPosts&amp;page=<?php echo $value ?>"><?php echo $value ?></a>
    <?php
    }
    unset( $value );
    ?>
<?php $pages = ob_get_clean(); ?>


<?php require_once 'view/frontend/template.php'; ?>