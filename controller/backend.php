<?php

require_once 'model/PostManager.php';
require_once 'model/CommentManager.php';

class Backend {

    private $listPostsView = 1;
    private $isAdmin = '';


    public function __construct() {
        session_start();
        $this->isAdmin = $_SESSION[ 'isAdmin' ];
    }


    public function adminPanel() {
        if ( $this->isAdmin === true ) {
            $postManager = new PostManager();
        
            $postManager->setPostView($this->listPostsView);
            $posts = $postManager->getPosts(1);
        
            require_once 'view/backend/adminPanel.php';
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function addPost() {
        if ( $this->isAdmin === true ) {
            try {
                $title = $_POST[ 'title' ];
                $post = $_POST[ 'mytextarea' ];

                if ( empty( $title )) {
                    throw new Exception( 'Veuillez saisir un titre' );
                }
                if ( empty( $post )) {
                    throw new Exception( 'Veuillez saisir du texte' );
                }
                if ( !empty( $title ) && !empty( $post )) {
                    $postManager = new PostManager();
                    $postManager->addPost( $title, $post );
                }

                header( 'Location: index.php?action=administration' );
            }
            catch(Exception $e) {
                $errorMessage = $e->getMessage();
                require_once 'view/errorViewAdmin.php';
            }
        }
    }

}