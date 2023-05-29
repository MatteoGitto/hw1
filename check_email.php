<?php   
    //Verifico l'unicita' dell'email nel database
    require_once 'dbconfig.php';

    header('Content-Type:application/json'); // imposta l'intestazione della risposta HTTP per indicare che il tipo di contenuto restituito e' JSON. 

    //Controllo che l'accesso sia legittimo
    if (!isset($_GET["q"])) {
        echo "Oops! Non dovresti essere qui! Questa pagina e' riservata agli utenti autorizzati :) \n Si prega di tornare indietro o contattare l'amministratore del sito per ulteriori informazioni";
        exit;
    }

    $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']);

    $email = mysqli_real_escape_string($conn, $_GET["q"]);

    $query = "SELECT email 
                FROM users
                WHERE email = '$email'";

    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

    $json=json_encode(array('exists' => mysqli_num_rows($res) > 0 ? true : false));

    echo $json; //ritorno il json

    mysqli_close($conn); //libero le risorse
?>
