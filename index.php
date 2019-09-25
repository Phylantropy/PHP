<?php

require_once 'controller/frontend.php';

$id = ( isset($_GET['id']) ) ? intval( $_GET['id'] ) : 0;
$page = ( isset($_GET['page']) ) ? intval( $_GET['page'] ) : 0;
$author = ( isset($_POST['author']) ) ? htmlentities($_POST['author'], ENT_QUOTES ) : '';
$comment = ( isset($_POST['comment']) ) ? htmlentities($_POST['comment'], ENT_QUOTES ) : '';
$action = ( isset($_GET['action']) ) ? htmlentities($_GET['action'], ENT_QUOTES ) : '';

try {
    switch ( $action ) {
        case 'listPosts':
            listPosts($page);
            break;
            
        case 'post':
            post($id, $page);
            break;

        case 'addComment':
            if ($author !== '') {
                if ($comment !== '') {
                    addComment($id, $author, $comment);
                }
                else {
                    throw new Exception('Aucun texte dans le commentaire');
                }
            }
            else {
                throw new Exception('Aucun auteur d\'indiqué');
            }
            break;

        default:
            listPosts($page);
    }
}
catch(Exception $e) {
    $errorMessage = $e->getMessage();
    require 'view/errorView.php';
}




// try {
//     if (isset($_GET['action'])) {
//         if ($_GET['action'] == 'listPosts' && isset($_GET['page'])) {
//             if ($_GET['page'] > 0) {
//                 listPosts();
//             }
//             else {
//                 throw new Exception('Erreur dans la page indiquée');
//             }
//         }
//         elseif ($_GET['action'] == 'post') {
//             if (isset($_GET['id']) && $_GET['id'] > 0 ) {
//                 if (isset($_GET['page']) && $_GET['page'] > 0) {
//                     post();
//                 }
//                 else {
//                     throw new Exception('Aucune page de commentaire envoyé');
//                 }
//             }
//             else {
//                 throw new Exception('Aucun identifiant de billet envoyé');
//             }
//         }
//         elseif ($_GET['action'] == 'addComment') {
//             if (isset($_GET['id']) && $_GET['id'] > 0) {
//                 if (!empty($_POST['author']) && !empty($_POST['comment'])) {
//                     addComment($_GET['id'], $_POST['author'], $_POST['comment']);
//                 }
//                 else {
//                     throw new Exception('Tous les champs ne sont pas remplis!');
//                 }
//             }
//             else {
//                 throw new Exception('Erreur: aucun identifiant de billet envoyé');
//             }
//         }
//     }
    
//     else {
//         listPosts();
//     }
// }
// catch(Exception $e) {
//     $errorMessage = $e->getMessage();
//     require 'view/errorView.php';
// }