<?php

require_once 'model/Manager.php';

class CommentManager extends Manager {

    public function getComments( $postId, $firstPost ) {
        try {
            if ( $firstPost > 0 ) {
                $firstPost = ( $firstPost * $this->postView ) - $this->postView;
            }
        
            $db = $this->dbConnect();
            $comments = $db->prepare( 'SELECT id, author, content, DATE_FORMAT( comment_date, \'%d/%m/%Y à %Hh%i\' ) AS comment_date_fr
                FROM comments
                WHERE post_id = ?
                ORDER BY comment_date
                DESC LIMIT ?, ?' );
            $comments->bindParam( 1, $postId, PDO::PARAM_INT );
            $comments->bindParam( 2, $firstPost, PDO::PARAM_INT );
            $comments->bindParam( 3, $this->postView, PDO::PARAM_INT );
            $comments->execute();

            if ( $comments === false ) {
                throw new Exception('Impossible de récupérer les billets');
            } else {
                return $comments;
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    public function postComment( $postId, $author, $comment ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'INSERT INTO comments( post_id, author, content, comment_date )
            VALUES( ?, ?, ?, NOW() )' );
        $result = $req->execute( array( $postId, $author, $comment ));

        return $result;
    }


    public function editComment( $comment, $commentId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'UPDATE comments SET content = ? WHERE id = ?' );
        $result = $req->execute( array( $comment, $commentId ));

        return $result;
    }


    public function deleteComment( $commentId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'DELETE FROM comments WHERE id = ?' );
        $result = $req->execute( array( $commentId ));

        return $result;
    }


    public function reportComment( $commentId, $userId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'INSERT INTO reports( comment_id, user_id, report_date )
            VALUES( ?, ?, NOW() )' );
        $result = $req->execute( array( $commentId, $userId ));

        return $result;
    }


    public function getReportedComments( $commentId, $userId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT comment_id, user_id
            FROM reports
            WHERE comment_id = ? OR user_id = ?' );
        $req->execute( array( $commentId, $userId ));

        return $req;
    }


    public function getUnmoderatedComments() {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT c.author, c.content, c.comment_date, r.report_date, r.comment_id, u.pseudo
            FROM reports r
            INNER JOIN comments c ON r.comment_id = c.id
            INNER JOIN users u ON r.user_id = u.id
            WHERE r.moderated = 0
            ORDER BY r.report_date' );
        $req->execute();

        return $req;
    }


    public function moderateComment( $commentId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'UPDATE reports
            SET moderated = 1, moderated_date = NOW()
            WHERE comment_id = ?' );
        $result = $req->execute( array( $commentId ));

        return $result;
    }
}