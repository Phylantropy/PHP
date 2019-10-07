<?php

require_once 'model/UserManager.php';

class InscriptionManager {

    private $pseudo = ( isset($_POST['pseudo']) && !empty($_POST['pseudo']) ) ? htmlentities($_POST['pseudo'], ENT_QUOTES ) : '';
    private $password = ( isset($_POST['password']) && !empty($_POST['password']) ) ? htmlentities($_POST['password'], ENT_QUOTES ) : '';
    private $passwordCheck = ( isset($_POST['passwordCheck']) && !empty($_POST['passwordCheck']) ) ? htmlentities($_POST['passwordCheck'], ENT_QUOTES ) : '';
    private $passwordHash = '';


    private function checkVariables() {
        try {
            if ($this->pseudo !== '') {
                if ($this->password !== '') {
                    if ($this->passwordCheck == $this->password) {

                        $this->passwordHash = password_hash( $this->password, PASSWORD_DEFAULT ); 
                        return true;
                    }
                    else {
                        throw new Exception('Les mots de passe sont différents');
                    }
                }
                else {
                    throw new Exception('Veuillez saisir un mot de passe');
                }
            }
            else {
                throw new Exception('Veuillez saisir un pseudo');
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    private function userExist() {
        try {
            if ( $this->checkVariables() ) {
                $uManager = new UserManager();
                $result = $uManager->getUserId( $this->pseudo );

                if ( $result ) {
                    throw new Exception('L\'utilisateur existe déjà');
                }
                else {
                    return $result;
                }
            }
        }
        catch(Exception $e) {
            $errorMessage = $e->getMessage();
            require_once 'view/errorView.php';
        }
    }


    public function addUser() {
        if ( !$this->userExist() ) {
            $result = $uManager->addUser( $this->pseudo, $this->passwordHash);
        }
        
                    
        return $result;
        // vérifie que le user n'existe pas
        // puis le rajoute
        // et affiche le message comme quoi le user a été rajouté
    }

    //reçoit et vérifie les données du routeur

    //si les données sont OK, ajoute un utilisateur
    //si les données sont incorrecte, retour un message d'erreur sur la page d'inscription

    //affiche la vue en indiquant que l'usager a été ajouté

}