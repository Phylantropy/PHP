<?php

class Backend {

    private $listPostsView = 5;
    private $isAdmin = '';
    private $page = '';
    private $postManager = '';
    private $pagination = '';


    public function __construct() {
        session_start();
        $this->isAdmin = $_SESSION[ 'isAdmin' ];
        $this->page = ( isset( $_GET['page'] ) && !empty( $_GET['page'] )) ? intval( $_GET['page'] ) : 1;
        $this->postManager = new PostManager();
        $this->pagination = new Pagination();
    }


    public function adminPanel() {
        if ( $this->isAdmin === true ) {
        
            $this->postManager->setPostView($this->listPostsView);
            $posts = $this->postManager->getPosts($this->page);

            $this->pagination->setPostView($this->listPostsView);
            $pagesNumber = $this->pagination->getArticlesCount();

            require_once 'view/backend/adminPanel.php';
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function addPost() {
        if ( $this->isAdmin === true ) {

            $title = $_POST[ 'title' ];
            $post = $_POST[ 'mytextarea' ];
            $post = strip_tags( $post );

            $check = $this->checkAddPost( $title, $post );

            if ( $check ) {
                $add = $this->postManager->addPost( $title, $post );

                if ( $add ) {
                    header( 'Location: index.php?action=administration' );
                } else {
                    $errorMessage = 'Le billet n\'a pas pu être publié: ' .$add;
                    require_once 'view/errorViewAdmin.php';
                }
            }
        }
    }


    public function editPost() {
        if ( $this->isAdmin === true ) {
            $postId = $_GET[ 'postId' ];
            $post = $this->postManager->getPost( $postId );
            $post = $post['content'];

            $this->postManager->setPostView($this->listPostsView);
            $posts = $this->postManager->getPosts($this->page);

            $this->pagination->setPostView($this->listPostsView);
            $pagesNumber = $this->pagination->getArticlesCount();

            require_once 'view/backend/postEdit.php';
        }
    }


    public function updatePost() {
        if ( $this->isAdmin === true ) {
            $post = $_POST[ 'mytextarea' ];
            $postId = $_GET[ 'postId' ];
            $post = strip_tags( $post );

            if ( !empty( $post ) && !empty( $postId ) ) { 
                $this->postManager->updatePost( $post, $postId );
            }

            header( 'Location: index.php?action=administration' );
        }
    }


    public function deletePost() {
        if ( $this->isAdmin === true ) {
            $postId = $_GET[ 'postId' ];
            $this->postManager->deletePost( $postId );
            header( 'Location: index.php?action=administration' );
        }
    }

    
    private function checkAddPost( $title, $post ) {
        try {
            if ( empty( $title )) {
                throw new Exception( 'Veuillez saisir un titre' );
            }
            if ( empty( $post )) {
                throw new Exception( 'Veuillez saisir du texte' );
            }

            return 1;
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorViewAdmin.php';
        }
    }

}