<?php

require_once 'model/UserManager.php';

class ConnectionManager {

    private $login = '';
    private $psswrd = '';
    private $UserManager = '';


    public function __construct() {
        $this->login = ( isset($_POST['login']) && !empty($_POST['login']) ) ? htmlspecialchars($_POST['login'], ENT_QUOTES ) : '';
        $this->psswrd = ( isset($_POST['password']) && !empty($_POST['password']) ) ? htmlspecialchars($_POST['password'], ENT_QUOTES ) : '';
        $this->UserManager = new UserManager();
    }


    public function connectUser() {
        try {
            $id = $this->UserManager->getUserId( $this->login );
            $psswrdSaved = $this->UserManager->getUserPassword( $id );
            $passwordIsCorrect = password_verify( $this->psswrd, $psswrdSaved );
            $isAdmin = $this->UserManager->isAdmin( $id );

            if ( (!is_int( $id )) || ( !$passwordIsCorrect )) {
                throw new Exception('Le login ou le mot de passe sont incorrecte');
            }

            $_SESSION['id'] = $id;
            $_SESSION['pseudo'] = $this->login;
            $_SESSION['isAdmin'] = ( $isAdmin ) ? true : false;

            setcookie( 'pseudo', $this->login, time() + 3600, null, null, false, true );
            setcookie( 'password', $psswrdSaved, time() + 3600, null, null, false, true );
            
            require_once 'view/backend/validConnectionView.php';
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/backend/connectionView.php';
        }
    }


    public function disconnection() {
        try {
            if ( ( !isset( $_SESSION['id'] )) || ( empty( $_SESSION['id'] )) && ( !isset( $_COOKIE['pseudo'] )) ) {
                throw new Exception('Vous n\'êtes pas connecté');
            }
            
            if ( isset( $_POST['disconnect'] )) {
                $this->disconnectUser();

            } elseif ( isset( $_SESSION['id'] ) && ( !isset( $_POST['submit'] ) )) {
                require_once 'view/backend/disconnectionView.php';
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    public function disconnectUser() {
        session_unset();
        session_destroy();

        setcookie( 'pseudo', '', time() - 100, null, null, false, true);
        setcookie( 'password', '', time() - 100, null, null, false, true);

        require_once 'view/backend/disconnectionView.php';
    }
}
