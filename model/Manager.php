<?php

class Manager {

    public function __construct () {
        $postView;
    }

    public function setPostView ($view) {
        $this->postView = $view;
    }

    protected function dbConnect() {
        $db = new PDO('mysql:host=localhost;dbname=P4blog;charset=utf8', 'blog', 'toto1234', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        if ($db === false) {
            throw new Exception('Impossible de se connecter à la base de donnée');
        }
        else {
            return $db;
        }
    }
}