<?php

require_once 'controller/Backend.php';
require_once 'controller/Frontend.php';
require_once 'controller/InscriptionManager.php';
require_once 'controller/ConnectionManager.php';



$id = ( isset( $_GET['id'] ) && !empty( $_GET['id'] )) ? intval( $_GET['id'] ) : 0;
$page = ( isset( $_GET['page'] ) && !empty( $_GET['page'] )) ? intval( $_GET['page'] ) : 1;
$author = ( isset( $_COOKIE['pseudo'] ) && !empty( $_COOKIE['pseudo'] )) ? htmlentities( $_COOKIE['pseudo'], ENT_QUOTES ) : '';
$comment = ( isset( $_POST['comment'] ) && !empty( $_POST['comment'] )) ? htmlentities( $_POST['comment'], ENT_QUOTES ) : '';

$methods = [
    'listPosts' => [ $page ],
    'post' => [ $id, $page],
    'addComment' => [ $id, $author, $comment ],
    'subscribe' => [],
    'subscription' => [],
    'connectionView' => [],
    'connection' => [],
    'disconnection' => [],
    'administration' => [],
    'addPost' => [],
    'editPost' => [],
    'updatePost' => [],
    'deletePost' => [],
    'reportComment' => [],
    'newPost' => [],
    'commentsModeration' => [],
    'editReportedComment' => [],
    'moderateComment' => [],
    'deleteReportedComment' => []
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

    case 'disconnection':
        $result = new ConnectionManager();
        $result->disconnection();
        break;

    case 'administration':
        $result = new Backend();
        $result->adminPanel();
        break;

    case 'addPost':
        $result = new Backend();
        $result->addPost();
        break;

    case 'editPost':
        $result = new Backend();
        $result->editPostPanel();
        break;
        
    case 'updatePost':
        $result = new Backend();
        $result->updatePost();
        break;
        
    case 'deletePost':
        $result = new Backend();
        $result->deletePost();
        break;
        
    case 'reportComment':
        $result = new Backend();
        $result->reportComment();
        break;

    case 'newPost':
        $result = new Backend();
        $result->newPostPanel();
        break;

    case 'commentsModeration':
        $result = new Backend();
        $result->reportedComments();
        break;
    
    case 'moderateComment':
        $result = new Backend();
        $result->moderateComment();
        break;
        
    case 'deleteReportedComment':
        $result = new Backend();
        $result->deleteReportedComment();
        break;

    default:
        call_user_func_array( [ new Frontend(), $action ], $methods[ $action ] );
}