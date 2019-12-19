<?php

require_once 'model/Manager.php';

class PostManager extends Manager {

    public function getPosts( $firstPost ) {
        if ( $firstPost > 0 ) {
            $firstPost = ( $firstPost * $this->postView ) - $this->postView;
        }
        
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM articles ORDER BY date_creation DESC LIMIT ?, ?' );
        $req->bindParam( 1, $firstPost, PDO::PARAM_INT );
        $req->bindParam( 2, $this->postView, PDO::PARAM_INT );
        $req->execute();

        if ($req === false) {
            throw new Exception( 'Impossible de récupérer les billets' );
        }
        else {
            return $req;
        }
    }

    
    public function getPost( $postId ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM articles WHERE id = ?');
        $req->execute( array( $postId ));
        $post = $req->fetch();

        // var_dump($req->fetchAll() );
    
        return $post;
    }


    public function addPost( $title, $post ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'INSERT INTO articles( title, content, date_creation ) VALUES( ?, ?, NOW() )' );
        $result= $req->execute( array( $title, $post ));
        
        return $result;
    }
}