<?php 

require_once 'model/Manager.php';

class UserManager extends Manager {    

    public function addUser( $pseudo, $password ) {
        if ( !$this->getUserId( $pseudo )) {
            $db = $this->dbConnect();
            $req = $db->prepare( 'INSERT INTO users(pseudo, psswrd, date_inscription) VALUES (?, ?, NOW() )' );
            $result = $req->execute( array( $pseudo, $password ));

            return $result; // renvoi true si ajouté
        }
        else
            return 0;
    }

    public function getUserId( $pseudo ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id FROM users WHERE pseudo = ? ');
        $req->execute( array( $pseudo ));
        $result = $req->fetch();
        
        return $result; // renvoi l'ID dans un tableau, ou false
    }
    
    public function deleteUser(){

    }
}