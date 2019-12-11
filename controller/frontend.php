<?php

require_once 'model/PostManager.php';
require_once 'model/CommentManager.php';
require_once 'model/Pagination.php';

class Frontend {

    private $listPostsView = 3;
    private $postView = 5;

    public function __construct() {
        session_start();
    }

    public function listPosts($page) {   
        $postManager = new PostManager();
        $pagination = new Pagination();
        
        $postManager->setPostView($this->listPostsView);
        $posts = $postManager->getPosts($page);
        $pagination->setPostView($this->listPostsView);
        $pagesNumber = $pagination->getArticlesCount();
    
        require_once 'view/frontend/listPostsView.php';
    }

    public function post($id, $page) {
        $postManager = new PostManager();
        $commentManager = new CommentManager();
        $pagination = new Pagination();

        $post = $postManager->getPost($id);
        $commentManager->setPostView($this->postView);
        $comments = $commentManager->getComments($id, $page);
        $pagination->setPostView($this->postView);
        $pagesNumber = $pagination->getCommentsCount($id);
    
        require_once 'view/frontend/postView.php';
    }

    public function addComment($postId, $author, $comment) {
        try {
            $commentManager = new CommentManager();

            if ( !empty( $author ) && !empty( $comment ) ) {
                $affectedLines = $commentManager->postComment($postId, $author, $comment);
            } else {
                throw new Exception('Impossible d\'ajouter le commentaire!');
            }
        
            if ( $affectedLines === false ) {
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