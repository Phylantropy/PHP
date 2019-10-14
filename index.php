<?php

require_once 'controller/frontend.php';
require_once 'controller/InscriptionManager.php';
require_once 'controller/ConnectionManager.php';



$id = ( isset( $_GET['id'] ) && !empty( $_GET['id'] )) ? intval( $_GET['id'] ) : 0;
$page = ( isset( $_GET['page'] ) && !empty( $_GET['page'] )) ? intval( $_GET['page'] ) : 1;
$author = ( isset( $_POST['author'] ) && !empty( $_GET['author'] )) ? htmlentities( $_POST['author'], ENT_QUOTES ) : '';
$comment = ( isset( $_POST['comment'] ) && !empty( $_GET['comment'] )) ? htmlentities( $_POST['comment'], ENT_QUOTES ) : '';

$methods = [
    'listPosts' => [ $page ],
    'post' => [ $id, $page],
    'addComment' => [ $id, $author, $comment ],
    'subscribe' => [],
    'subscription' => [],
    'connectionView' => [],
    'connection' => []
];


$action =  ( !isset($_GET['action']) || empty( $_GET['action'] )) ? 'listPosts' : (array_key_exists( $_GET['action'], $methods ) ? $_GET['action'] : 'listPosts');


switch ( $action ) {
    case 'subscribe':
        require_once 'view/backend/inscriptionView.php';
        break;

    case 'subscription':
        $result = new InscriptionManager();
        $result->addUser();
        break;

    case 'connectionView':
        require_once 'view/backend/connectionView.php';
        break;

    case 'connection':
        $result = new ConnectionManager();
        $result->connectUser();
        break;

    default:
        call_user_func_array( [ new Frontend(), $action ], $methods[ $action ] );
}










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