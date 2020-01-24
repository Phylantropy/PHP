<?php
ob_start();

if ( isset( $_SESSION['id'] )) { ?>
    <div>
        <form action="index.php?action=disconnection" method="post">
        Confirmez-vous la demande de déconnexion?
        <br />
        <input type="submit" name="disconnect" value="Oui">
        </form>
    </div>
<?php
}
else { ?>
    <p>Vous êtes maintenant déconnecté</p>
<?php 
}

$content = ob_get_clean();

require_once 'view/backend/disconnectionTemplate.php';