<?php

class Pagination extends Manager {
    
    public function getArticlesCount() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM articles');
        $exec = $req->execute();
        $count = $req->fetch();
        $result = $this->getPagesCount($count);

        return $result;
    }


    public function getCommentsCount( $post_id ) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT COUNT(*)
            FROM comments
            WHERE post_id = ' .$post_id );
        $exec = $req->execute();
        $count = $req->fetch();
        $result = $this->getPagesCount($count);

        return $result;
    }


    private function getPagesCount( $count ) {
        $result = array();
        $pages = ceil( intval($count[0]) / $this->maxView );
        for ( $i = 1; $i <= $pages; $i++ ) {
            $result[] = $i;
        }

        return $result;
    }
}