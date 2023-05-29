<?php

session_start();
require_once 'auth.php';


            
$userid = checkAuth(); // Verifica l'autenticazione dell'utente

if ($userid === 0) { // Controlla se l'utente è autenticato
    $error_message = "Primo. Questo è un messaggio di errore di debug.";
    echo $error_message; 
    echo $userid;
            
    header("Location: home_login.php");
    exit;
}
            
// Carica le informazioni dell'utente loggato
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));


//ottengo l'id dell' utente e del preferito
$userid=mysqli_real_escape_string($conn,$userid);
$title=mysqli_real_escape_string($conn,$_GET['title']);


//eseguo la query per rimuovere
$query="DELETE  FROM preferiti where id='$userid' AND titolo='$title'";

$res=mysqli_query($conn,$query) or die (mysqli_error($conn));


// delete ritorna il numero di righe cancellate
if($res>0)
{
    //tutto ok
    echo json_encode(array('ok' => true));
}

//chiudo la connessione
mysqli_close($conn);