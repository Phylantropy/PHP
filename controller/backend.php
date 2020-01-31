<?php

require_once 'model/PostManager.php';
require_once 'model/CommentManager.php';
require_once 'model/Pagination.php';

class Backend {

    private $listPostsView = 5;
    private $commentsView = 6;
    private $isAdmin = '';
    private $page = '';

    private $PostManager = '';
    private $CommentManager = '';
    private $Pagination = '';
    private $UserManager = '';


    public function __construct() {
        $this->isAdmin = ( isset( $_SESSION[ 'isAdmin' ] ) && !empty( $_SESSION[ 'isAdmin' ] )) ?  $_SESSION[ 'isAdmin' ] : false;
        $this->page = ( isset( $_GET[ 'page' ] ) && !empty( $_GET[ 'page' ] )) ? htmlspecialchars( intval( $_GET['page'] )) : 1;
        $this->PostManager = new PostManager();
        $this->CommentManager = new CommentManager();
        $this->Pagination = new Pagination();
        $this->UserManager = new UserManager();
    }


    private function listPosts() {
        $this->PostManager->setMaxView( $this->listPostsView );
        $this->Pagination->setMaxView( $this->listPostsView );

        $firstPost = ( $this->page * $this->listPostsView ) - $this->listPostsView;
        
        $posts = $this->PostManager->getPosts( $firstPost );
        $pagesNumber = $this->Pagination->getArticlesCount();

        if ( func_num_args() === 3 ) {
            $postId = func_get_arg(1);
            $post = func_get_arg(2);
        }

        require_once func_get_arg(0);
    }


    public function adminPanel() {
        if ( $this->isAdmin === true ) {

            $view = 'view/backend/adminPanel.php';

            $this->listPosts( $view );
        }
        else {
            header( 'Location: index.php' );
        }
    }
    
    
    public function newPostPanel() {
        if ( $this->isAdmin === true ) {

            $view = 'view/backend/newPostPanel.php';

            $this->listPosts( $view );
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function addPost() {
        if ( $this->isAdmin === true ) {

            $title = htmlspecialchars( strip_tags( $_POST[ 'title' ]));
            $post = htmlspecialchars( strip_tags( $_POST[ 'mytextarea' ]));
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
        else {
            header( 'Location: index.php' );
        }
    }


    public function editPostPanel() {
        if ( $this->isAdmin === true ) {

            $postId = htmlspecialchars( intval( $_GET[ 'postId' ]));
            $post = $this->PostManager->getPost( $postId );
            $view = 'view/backend/editPanel.php';

            $this->listPosts( $view, $postId, $post );
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function updatePost() {
        if ( $this->isAdmin === true ) {

            $postId = intval( htmlspecialchars( $_GET[ 'postId' ]));
            $post = htmlspecialchars( strip_tags( $_POST[ 'mytextarea' ] ));
            $title = htmlspecialchars( strip_tags( $_POST[ 'title' ] ));

            if ( !empty( $title ) && !empty( $post ) && !empty( $postId )) {
                $this->PostManager->updatePost( $title, $post, $postId );
            }

            header( 'Location: index.php?action=administration' );
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function deletePost() {
        if ( $this->isAdmin === true ) {

            $postId = intval( htmlspecialchars( $_GET[ 'postId' ]));
            $this->PostManager->deletePost( $postId );
            header( 'Location: index.php?action=administration' );
        }
        else {
            header( 'Location: index.php' );
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
        catch( Exception $e ) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorViewAdmin.php';
        }
    }


    public function reportComment() {
        try {
            if ( !isset( $_GET[ 'commentId' ] ) || !isset( $_GET[ 'user' ] )) {
                header( 'Location: index.php' );
            }

            $commentId = htmlspecialchars( intval( $_GET[ 'commentId' ]));
            $user = htmlspecialchars( strip_tags( $_GET[ 'user' ]));

            $commentAuthor = $this->CommentManager->getCommentAuthor( $commentId );
            $commentAuthor = $commentAuthor->fetchAll();
            $commentAuthor = $commentAuthor[0]['author'];
 
            if ( $user == $commentAuthor ) {
                throw new Exception( 'Signalement impossible: vous êtes l\'auteur du commentaire.' );
            }

            $userId = intval( $this->UserManager->getUserId( $user ));            
            $result = $this->CommentManager->getReportedComments( $commentId, $userId );
            
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
                throw new Exception( 'Signalement impossible: le commentaire à déjà été suffisament signalé.' );

            } elseif ( $reported >= 1 ) {
                throw new Exception( 'Signalement impossible: vous avez déjà signalé ce commentaire.' );
            }
        }
        catch( Exception $e ) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    public function reportedComments() {
        if ( $this->isAdmin === true ) {
            $comments = $this->CommentManager->getUnmoderatedComments();
            $commentsPdoCount = $comments->rowCount();
            $commentsPDO = $comments->fetchAll( PDO::FETCH_ASSOC );

            $commentsArr = [];

            for ( $commentId = '', $i = 0 ; $i < $commentsPdoCount; $i++ ) {

                if ( $commentId != $commentsPDO[$i][ 'comment_id' ]  ) {
                   $commentsArr[] = $commentsPDO[$i];
                }

                $commentId = $commentsPDO[$i][ 'comment_id' ];
            }

            $this->page--;
            $firstComment = ( $this->page * $this->commentsView );
            $commentsCount = count( $commentsArr );
            $pageCount = ceil( $commentsCount / $this->commentsView );

            require_once 'view/backend/commentsPanel.php';
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function moderateComment() {
        if ( $this->isAdmin === true ) {
            $comment = htmlspecialchars( $_POST[ 'comment' ]);
            $commentId = htmlspecialchars( intval( $_GET[ 'commentId' ]));

            $this->CommentManager->editComment( $comment, $commentId );
            $this->CommentManager->moderateComment( $commentId );
            $this->reportedComments();
        }
        else {
            header( 'Location: index.php' );
        }
    }


    public function deleteReportedComment() {
        if ( $this->isAdmin === true ) {
            $commentId = htmlspecialchars( intval( $_GET[ 'commentId' ]));

            $this->CommentManager->deleteComment( $commentId );
            $this->CommentManager->moderateComment( $commentId );
            $this->reportedComments();
        }
        else {
            header( 'Location: index.php' );
        }
    }
}