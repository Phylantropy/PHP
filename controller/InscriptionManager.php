<?php

require_once 'model/UserManager.php';

class InscriptionManager {

    private $pseudo = '';
    private $password = '';
    private $passwordCheck = '';
    private $paswwordHash = '';
    private $UserManager = '';
    
    public function __construct() {
        $this->pseudo = ( isset($_POST['pseudo']) && !empty($_POST['pseudo']) ) ? htmlentities($_POST['pseudo'], ENT_QUOTES ) : '';
        $this->password = ( isset($_POST['password']) && !empty($_POST['password']) ) ? htmlentities($_POST['password'], ENT_QUOTES ) : '';
        $this->passwordCheck = ( isset($_POST['passwordCheck']) && !empty($_POST['passwordCheck']) ) ? htmlentities($_POST['passwordCheck'], ENT_QUOTES ) : '';
        $this->UserManager = new UserManager();
    }


    private function checkVariables() {
        try {
            if ( $this->pseudo === '' ) {
                throw new Exception('Veuillez saisir un pseudo');
            }

            if ( $this->password === '' ) {
                throw new Exception('Veuillez saisir un mot de passe');
            }

            if ( $this->passwordCheck != $this->password ) {
                throw new Exception('Les mots de passe sont différents');
            }

            $this->passwordHash = password_hash( $this->password, PASSWORD_DEFAULT );
                require_once 'view/backend/validInscriptionView.php';
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    private function userExist() {
        try {
            if ( $this->checkVariables() ) {
                // $UserManager = new UserManager();
                $result = $this->UserManager->getUserId( $this->pseudo );

                if ( is_int($result )) {
                    throw new Exception('L\'utilisateur existe déjà');
                }
                else {
                    return false;
                }
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    public function addUser() {
        if ( $this->userExist() === false ) {
            // $UserManager = new UserManager();
            $result = $this->UserManager->addUser( $this->pseudo, $this->passwordHash);
            var_dump($result);
        }

        
                    
       
        // et affiche le message comme quoi le user a été rajouté
    }

    //affiche la vue en indiquant que l'usager a été ajouté

}