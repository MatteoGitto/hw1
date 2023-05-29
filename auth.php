<?php
    //controllo se l'user e' gia' autenticato... Cosi non chiedo di effettuare il login alla pagina
    require 'dbconfig.php';

    function checkAuth() {
        // Se esiste gia' una sessione, la ritorno, altrimenti ritorno 0
        if(isset($_SESSION['id'])) {
            return $_SESSION['id'];
        } else 
            return 0;
    }
?>