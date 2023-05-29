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
            

            //faccio l'escape prima dela query
            $userid=mysqli_real_escape_string($conn,$userid);
            $json_title=mysqli_real_escape_string($conn,$_GET['title']);
            $json_img=mysqli_real_escape_string($conn,$_GET['immagine']);
            $json_type=mysqli_real_escape_string($conn,$_GET['type']);



//eseguo la query per inserire i valori nel db
            $query="INSERT INTO  preferiti(id,titolo,immagine,tipo) values('$userid','$json_title','$json_img','$json_type')";
            mysqli_query($conn,$query);


            //una volta inserito il contenuto chiudo la connessione al  db

            mysqli_close($conn);


?>