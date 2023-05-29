<?php

//richiedo l'autenticazione
require_once 'auth.php';

//specifico il tipo di file
header('Content-Type: application/json');



// A seconda del tipo scelto, eseguo una funzione diversa
switch($_GET['type']) {
    case 'album': spotify_album(); break;
    case 'artist': spotify_artist(); break;
    case 'track': spotify_track(); break;
    default: break;
}



function spotify_album() {

    $client_id = 'ed91a4ffa6684b3f83320ecf2248c48b';
    $client_secret = '9edfa9c86840493287c19f944775d89b';

    // ACCESS TOKEN
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Eseguo la POST
    curl_setopt($ch, CURLOPT_POST, 1);
    # Setto body e header della POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret)));
    $token=json_decode(curl_exec($ch), true);
    curl_close($ch);


    // QUERY EFFETTIVA
    $query = urlencode($_GET["q"]);
    $type=urlencode($_GET['type']);
    $url = 'https://api.spotify.com/v1/search?q='.$query.'&type='.$type.'&limit=8';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Imposto il token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token']));
    $res=curl_exec($ch);
    curl_close($ch);

    echo $res;
}


function spotify_track() {

    $client_id = 'ed91a4ffa6684b3f83320ecf2248c48b';
    $client_secret = '9edfa9c86840493287c19f944775d89b';

    // ACCESS TOKEN
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Eseguo la POST
    curl_setopt($ch, CURLOPT_POST, 1);
    # Setto body e header della POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret)));
    $token=json_decode(curl_exec($ch), true);
    curl_close($ch);


    // QUERY EFFETTIVA
    $query = urlencode($_GET["q"]);
    $type=urlencode($_GET['type']);
    $url = 'https://api.spotify.com/v1/search?q='.$query.'&type='.$type.'&limit=10';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Imposto il token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token']));
    $res=curl_exec($ch);
    curl_close($ch);

    echo $res;
}




function spotify_artist() {

    $client_id = 'ed91a4ffa6684b3f83320ecf2248c48b';
    $client_secret = '9edfa9c86840493287c19f944775d89b';

    // ACCESS TOKEN
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Eseguo la POST
    curl_setopt($ch, CURLOPT_POST, 1);
    # Setto body e header della POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Basic '.base64_encode($client_id.':'.$client_secret)));
    $token=json_decode(curl_exec($ch), true);
    curl_close($ch);


    // QUERY EFFETTIVA
    $query = urlencode($_GET["q"]);
    $type=urlencode($_GET['type']);
    $url = 'https://api.spotify.com/v1/search?q='.$query.'&type='.$type.'&limit=10';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    # Imposto il token
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$token['access_token']));
    $res=curl_exec($ch);
    curl_close($ch);

    echo $res;
}



?>

