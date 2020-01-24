<?php

require_once 'model/Manager.php';

class PostManager extends Manager {

    public function getPosts( $firstPost ) {
                
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr
            FROM articles
            ORDER BY date_creation DESC
            LIMIT ?, ?' );
        $req->bindParam( 1, $firstPost, PDO::PARAM_INT );
        $req->bindParam( 2, $this->maxView, PDO::PARAM_INT );
        $req->execute();

        return $req;
    }


    public function getPost( $postId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr
            FROM articles
            WHERE id = ?');
        $req->execute( array( $postId ));
        $result = $req->fetch();
    
        return $result;
    }

    
    public function addPost( $title, $post ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'INSERT INTO articles( title, content, date_creation )
            VALUES( ?, ?, NOW() )' );
        $result = $req->execute( array( $title, $post ));
        
        return $result;
    }

    
    public function updatePost( $title, $post, $postId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'UPDATE articles
            SET title = ?, content = ?
            WHERE id = ?' );
        $result = $req->execute( array( $title, $post, $postId ));
        
        return $result;
    }


    public function deletePost( $postId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'DELETE articles, comments
            FROM articles
            INNER JOIN comments
            WHERE articles.id = ? AND comments.post_id = ?' );
        $result = $req->execute( array( $postId, $postId ));

        return $result;
    }
}