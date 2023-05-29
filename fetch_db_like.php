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
            



//contenuto tipo json
header('Content-Type=application/json');

//instauro una connessione php
$conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

//ottengo l'id di sessione
$userid = mysqli_real_escape_string($conn, $userid);


//eseguo la query
$query = "SELECT id,titolo,immagine,tipo  FROM preferiti where id='$userid'";

$res = mysqli_query($conn, $query) or die(mysqli_error($conn));

// verifico se sono presenti preferiti associati a quell'id
if (mysqli_num_rows($res) > 0) {
    while ($entry = mysqli_fetch_assoc($res)) {
        $preferiti[] = array('nome' => $entry['id'], 'title' => $entry['titolo'], 'img' => $entry['immagine'], 'tipo' => $entry['tipo']);
    }

    //torno un JSON che poi mi servirà nella fetch
    echo json_encode($preferiti);
}else{
    $preferiti[] = array('response'=>'not found');
    echo json_encode($preferiti);
}

mysqli_close($conn);
exit;