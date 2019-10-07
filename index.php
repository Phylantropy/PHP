<?php

require_once 'controller/frontend.php';
// require_once 'controller/InscriptionManager.php';



$id = ( isset($_GET['id']) ) ? intval( $_GET['id'] ) : 0; //corriger les empty
$page = ( isset($_GET['page']) ) ? intval( $_GET['page'] ) : 1;
$author = ( isset($_POST['author']) ) ? htmlentities( $_POST['author'], ENT_QUOTES ) : '';
$comment = ( isset($_POST['comment']) ) ? htmlentities( $_POST['comment'], ENT_QUOTES ) : '';

$methods = array(
    'listPosts' => array( $page ),
    'post' => array( $id, $page),
    'addComment' => array( $id, $author, $comment )
);

$action =  ( !isset($_GET['action']) || empty( $_GET['action'])) ? 'listPosts' : (array_key_exists( $_GET['action'], $methods ) ? $_GET['action'] : 'listPosts');

call_user_func_array( array( new Frontend(), $action), $methods[$action] );










// $frontend = new Frontend();

// try {
//     switch ( $action ) {
//         case 'listPosts':
//             $frontend->listPosts($page);
//             break;
            
//         case 'post':
//             $frontend->post($id, $page);
//             break;

//         case 'addComment':
//             if ($author !== '') {
//                 if ($comment !== '') {
//                     $frontend->addComment($id, $author, $comment);
//                 }
//                 else {
//                     throw new Exception('Aucun texte dans le commentaire');
//                 }
//             }
//             else {
//                 throw new Exception('Aucun auteur d\'indiqué');
//             }
//             break;

//         default:
//             $frontend->listPosts($page);
//     }
// }
// catch(Exception $e) {
//     $errorMessage = $e->getMessage();
//     require_once 'view/errorView.php';
// }