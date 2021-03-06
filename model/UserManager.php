<?php 

require_once 'model/Manager.php';


class UserManager extends Manager {    

    public function getUserId( $pseudo ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT id
            FROM users
            WHERE pseudo = ?
            LIMIT 1' );
        $req->execute([ $pseudo ]);
        $result = $req->fetch();

        $result = intval( $result[0] );

        return $result;
    }
    


    public function getUserPassword( $id ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT psswrd
            FROM users
            WHERE id = ?
            LIMIT 1' );
        $req->execute([ $id ]);
        $result = $req->fetch();

        $result = strval( $result[0] );

        return $result;        
    }


    public function addUser( $pseudo, $password ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'INSERT INTO users(pseudo, psswrd, date_inscription)
            VALUES (?, ?, NOW() )' );
        $result = $req->execute( array( $pseudo, $password ));

        return $result;
    
    }


    public function isAdmin( $id ) {
        $db = $this->dbConnect();
        $req = $db->prepare( 'SELECT isAdmin
            FROM users
            WHERE id = ?
            LIMIT 1' );
        $req->execute([ $id ]);
        $result = $req->fetch();

        $result = intval( $result[0] );

        return $result;        
    }
}