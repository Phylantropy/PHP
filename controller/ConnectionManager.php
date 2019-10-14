<?php

require_once 'model/UserManager.php';

class ConnectionManager {

    private $login = '';
    private $psswrd = '';
    private $UserManager = '';

    public function __construct() {
        $this->login = ( isset($_POST['login']) && !empty($_POST['login']) ) ? htmlentities($_POST['login'], ENT_QUOTES ) : '';
        $this->psswrd = ( isset($_POST['password']) && !empty($_POST['password']) ) ? htmlentities($_POST['password'], ENT_QUOTES ) : '';
        $this->UserManager = new UserManager();
    }

    public function connectUser() {
        try {
            $id = $this->UserManager->getUserId( $this->login );

            if ( !is_int( $id ) ) {
                throw new Exception('Le login ou le mot de passe sont incorrecte');
            }

            $psswrdSaved = $this->UserManager->getUserPassword( $id );
            $passwordIsCorrect = password_verify( $this->psswrd, $psswrdSaved );

            if ( !$passwordIsCorrect) {
                throw new Exception('Le login ou le mot de passe sont incorrecte');
            }

            session_start();
            $_SESSION['id'] = $id;
            $_SESSION['pseudo'] = $this->login;
            require_once 'view/backend/validConnectionView.php';
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


}
