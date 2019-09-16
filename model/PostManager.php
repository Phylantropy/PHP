<?php

require_once 'model/Manager.php';

class PostManager extends Manager {
    public function getPosts() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS date_creation_fr FROM articles ORDER BY date_creation DESC LIMIT 0, 5');

        if ($req === false) {
            throw new Exception('Impossible de récupérer les billets');
        }
        else {
            return $req;
        }
    }

    public function getPost($postId) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr FROM articles WHERE id = ?');
        $req->execute(array($postId) );
        $post = $req->fetch();

        // var_dump($req->fetchAll() );
    
        return $post;
    }
}