<?php

class Backend {

    private $listPostsView = 5;
    private $isAdmin = '';
    private $page = '';

    private $PostManager = '';
    private $CommentManager = '';
    private $Pagination = '';
    private $UserManager = '';


    public function __construct() {
        session_start();
        $this->isAdmin = $_SESSION[ 'isAdmin' ];
        $this->page = ( isset( $_GET['page'] ) && !empty( $_GET['page'] )) ? intval( $_GET['page'] ) : 1;
        $this->PostManager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->Pagination = new Pagination();
        $this->UserManager = new UserManager();
    }


    public function adminPanel() {
        if ( $this->isAdmin === true ) {
        
            $this->PostManager->setPostView( $this->listPostsView );
            $posts = $this->PostManager->getPosts( $this->page );

            $this->Pagination->setPostView( $this->listPostsView );
            $pagesNumber = $this->Pagination->getArticlesCount();

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
                $add = $this->PostManager->addPost( $title, $post );

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
            $post = $this->PostManager->getPost( $postId );
            $post = $post['content'];

            $this->PostManager->setPostView( $this->listPostsView );
            $this->Pagination->setPostView( $this->listPostsView );

            $posts = $this->PostManager->getPosts( $this->page );
            $pagesNumber = $this->Pagination->getArticlesCount();

            require_once 'view/backend/postEdit.php';
        }
    }


    public function updatePost() {
        if ( $this->isAdmin === true ) {

            $post = $_POST[ 'mytextarea' ];
            $postId = $_GET[ 'postId' ];
            $post = strip_tags( $post );

            if ( !empty( $post ) && !empty( $postId ) ) { 
                $this->PostManager->updatePost( $post, $postId );
            }

            header( 'Location: index.php?action=administration' );
        }
    }


    public function deletePost() {
        if ( $this->isAdmin === true ) {

            $postId = $_GET[ 'postId' ];
            $this->PostManager->deletePost( $postId );
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


    public function reportComment() {
        $commentId = intval( $_GET[ 'commentId' ]);
        $user = $_GET[ 'user' ];
        $userId = intval( $this->UserManager->getUserId( $user ));
        $result = $this->CommentManager->reportedComments( $commentId, $userId );
        
        $rowCount = $result->rowCount();
        $resultAr = $result->fetchAll( PDO::FETCH_ASSOC );

        $commentCount = 0;
        $reported = 0;

        for ( $i = 0; $i < $rowCount; $i++ ) {
            if ( $resultAr[ $i ][ 'comment_id' ] ==  $commentId ) {
                $commentCount++;
                if ( $resultAr[ $i ][ 'user_id' ] ==  $userId ) {
                    $reported++;
                }
            }
        }

        if (( $commentCount < 3 ) && ( $reported === 0 )) {
            $this->CommentManager->reportComment( $commentId, $userId );
            require_once 'view/backend/validReportView.php';

        } elseif ( $commentCount === 3 ) {
            $errorMessage = 'Signalement impossible: le commentaire à déjà été suffisament signalé.' ;
            require_once 'view/errorView.php';

        } elseif ( $reported >= 1 ) {
            $errorMessage = 'Signalement impossible: vous avez déjà signalé ce commentaire.';
            require_once 'view/errorView.php';
        }
    }


    public function showReportedComment() {

    }


    public function editReportedComment() {

    }


    public function moderateComment( $commentId ) {
        
    }
}