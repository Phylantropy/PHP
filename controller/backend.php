<?php

require_once 'model/InscriptionManager.php';

$pseudo = ( isset($_POST['pseudo']) ) ? htmlentities($_POST['pseudo'], ENT_QUOTES ) : '';
$password = ( isset($_POST['password']) ) ? htmlentities($_POST['password'], ENT_QUOTES ) : '';
$passwordCheck = ( isset($_POST['passwordCheck']) ) ? htmlentities($_POST['passwordCheck'], ENT_QUOTES ) : '';

try {
    if ($pseudo !== '') {
        if ($password !== '') {
            if ($passwordCheck !== $password) {
                echo 'c tout bon!';
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
        
}