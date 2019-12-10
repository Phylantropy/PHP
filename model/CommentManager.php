<?php

require_once 'model/Manager.php';

class CommentManager extends Manager {

    public function getComments($postId, $firstPost) {
        try {
            if ($firstPost > 0) {
                $firstPost = ($firstPost * $this->postView) - $this->postView;
            }
        
            $db = $this->dbConnect();
            $comments = $db->prepare('SELECT id, author, content, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%i\') AS comment_date_fr FROM comments WHERE post_id = ? ORDER BY comment_date DESC LIMIT ?, ?');
            $comments->bindParam(1, $postId, PDO::PARAM_INT);
            $comments->bindParam(2, $firstPost, PDO::PARAM_INT);
            $comments->bindParam(3, $this->postView, PDO::PARAM_INT);
            $comments->execute();

            if ($comments === false) {
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

    public function postComment($postId, $author, $comment) {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comments(post_id, author, content, comment_date) VALUES(?, ?, ?, NOW() )');
        $affectedLines = $comments->execute(array($postId, $author, $comment));

        return $affectedLines;
    }
}