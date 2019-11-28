<?php

ob_start();

if ( isset( $_SESSION['disconnect'] )) {
    ?>
    <div>
        <form action="index.php?action=disconnection" method="post">
        Confirmez-vous la demande de déconnexion?
        <br />
        <input type="submit" name="submit" value="Oui">
        </form>
    </div>
    <?php
}
else {
    ?>
    <div>
        Vous êtes maintenant déconnecté
    </div>
    <?php 
}

$content = ob_get_clean();

require_once 'view/backend/disconnectionTemplate.php';
?>