<?php

class Pagination extends Manager {
    // private $pages = 0;

    // public function __construct( $_nbrPage, $_actualPage ) {
    //     $this->pages = $_nbrPages;
    //     $this->actualPage = $_actualPage;
    // }

    private function getArticlesPagesCount() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM articles');
        $exec = $req->execute();
        $count = $req->fetch();
        $result = $this->getPagesCount($count);

        return $result;
    }

    private function getCommentsPagesCount($post_id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM comments WHERE post_id = ' .$post_id);
        $exec = $req->execute();
        $count = $req->fetch();
        $result = $this->getPagesCount($count);

        return $result;
    }

    private function getPagesCount($count) {
        $result = array();
        $pages = ceil(intval($count[0]) / $this->postView);
        for ($i = 1; $i <= $pages; $i++) {
            $result[] = $i;
        }

        return $result;
    }

    public function getArticlesCount() {
        return $this->getArticlesPagesCount();
    }

    public function getCommentsCount($post_id) {
        return $this->getCommentsPagesCount($post_id);
    }





    
}