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

    private $id ='';
    private $page = '';
    private $author = '';
    private $comment = '';


    public function __construct() {
        $this->PostManager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->Pagination = new Pagination();

        $this->id = ( isset( $_GET['id'] ) && !empty( $_GET['id'] )) ? intval( $_GET['id'] ) : 0;
        $this->page = ( isset( $_GET['page'] ) && !empty( $_GET['page'] )) ? intval( $_GET['page'] ) : 1;
        $this->author = ( isset( $_COOKIE['pseudo'] ) && !empty( $_COOKIE['pseudo'] )) ? htmlentities( $_COOKIE['pseudo'], ENT_QUOTES ) : '';
        $this->comment = ( isset( $_POST['comment'] ) && !empty( $_POST['comment'] )) ? htmlentities( $_POST['comment'], ENT_QUOTES ) : '';
    }


    public function listPosts() {

        $this->PostManager->setMaxView( $this->listPostsView );
        $this->Pagination->setMaxView( $this->listPostsView );

        $firstPost = ( $this->page * $this->listPostsView ) - $this->listPostsView;
        
        $posts = $this->PostManager->getPosts( $firstPost );
        $pagesNumber = $this->Pagination->getArticlesCount();
    
        require_once 'view/frontend/listPostsView.php';
    }


    public function postView() {

        $this->Pagination->setMaxView( $this->postView );
        $this->CommentManager->setMaxView( $this->postView );
        
        $firstPost = ( $this->page * $this->postView ) - $this->postView;

        $post = $this->PostManager->getPost( $this->id );
        $comments = $this->CommentManager->getComments( $this->id, $firstPost );
        $pagesNumber = $this->Pagination->getCommentsCount( $this->id) ;
    
        require_once 'view/frontend/postView.php';
    }


    public function addComment() {
        try {
            if ( !empty( $this->author ) && !empty( $this->comment )) {
                $sendComment = $this->CommentManager->postComment( $this->id, $this->author, $this->comment );
            } else {
                throw new Exception('Impossible d\'ajouter le commentaire!');
            }
        
            if ( $sendComment === false ) {
                throw new Exception('L\'ajout de commentaire à échoué');
            }
            else {
                header('Location: index.php?action=post&id=' . $this->id);
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }
}