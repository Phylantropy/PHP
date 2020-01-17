<?php

class Manager {

    public function __construct () {
        $maxView;
    }

    public function setMaxView ( $view ) {
        $this->maxView = $view;
    }

    protected function dbConnect() {
        $db = new PDO('mysql:host=localhost;dbname=P4blog;charset=utf8', 'blog', 'toto1234', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        return $db;
    }
}