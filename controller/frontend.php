<?php

require_once 'model/PostManager.php';
require_once 'model/CommentManager.php';
require_once 'model/Pagination.php';

class Frontend {

    private $listPostsView = 3;
    private $postView = 5;
    
    private $PostManager = '';
    private $CommentManager = '';
    private $Pagination = '';


    public function __construct() {
        session_start();
        $this->PostManager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->Pagination = new Pagination();
    }


    public function listPosts( $page ) {

        $this->PostManager->setMaxView( $this->listPostsView );
        $this->Pagination->setMaxView( $this->listPostsView );

        $firstPost = ( $page * $this->listPostsView ) - $this->listPostsView;
        
        $posts = $this->PostManager->getPosts( $firstPost );
        $pagesNumber = $this->Pagination->getArticlesCount();
    
        require_once 'view/frontend/listPostsView.php';
    }


    public function post( $id, $page ) {

        $this->Pagination->setMaxView( $this->postView );
        $this->CommentManager->setMaxView( $this->postView );
        
        $firstPost = ( $page * $this->postView ) - $this->postView;

        $post = $this->PostManager->getPost( $id );
        $comments = $this->CommentManager->getComments( $id, $firstPost );
        $pagesNumber = $this->Pagination->getCommentsCount( $id) ;
    
        require_once 'view/frontend/postView.php';
    }


    public function addComment( $postId, $author, $comment ) {
        try {
            if ( !empty( $author ) && !empty( $comment )) {
                $sendComment = $this->CommentManager->postComment( $postId, $author, $comment );
            } else {
                throw new Exception('Impossible d\'ajouter le commentaire!');
            }
        
            if ( $sendComment === false ) {
                throw new Exception('L\'ajout de commentaire à échoué');
            }
            else {
                header('Location: index.php?action=post&id=' . $postId);
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }
}