<?php
require '../model/model.php';

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $post = getPost($_GET['id']);
    $comments = getComments($_GET['id']);
    
    //var_dump($comments);

    require '../view/postView.php';
}
else {
    echo 'Erreur : aucun identifiant de billet envoyé';
}