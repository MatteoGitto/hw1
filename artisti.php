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

// Esegui la query per ottenere le informazioni sull'utente
$userid = mysqli_real_escape_string($conn, $userid);
$query = "SELECT username, nome, cognome FROM users WHERE id = '$userid'";
/*$error_message = "Questo è un messaggio di errore di debug.";
echo $error_message;
echo $userid;*/

$info = mysqli_query($conn, $query);

if (mysqli_num_rows($info) === 1) {
    $ans = mysqli_fetch_assoc($info);
} else {
    $error = "Non abbiamo lo user con quell'id";
}
?>


<html>
    <head>
        <meta charset="utf-8">
        <title>Artisti</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
        <script src="artisti.js" defer ></script>
        <link rel="stylesheet" href="artisti.css">
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
    </head>

    <body>

        <header>
            <nav>
                <img src="logo.png" id="logo">

                <a href="home.php">Home</a>
                <a href="profile.php">Profilo</a>
                <a href="artisti.php">Artisti</a>
                <a href="cerca.php">Cerca</a>
                <a href="logout.php">Logout</a>

            
            </nav>
        </header>

        <main>
            <div id="template">
                <section id="profile">
                    <div>
                        <h1> Eccoti <?php echo $ans['username'] ?></h1>
                        <p>In questa sezione puoi scoprire gli artisti che abbiamo selezionato per questa settimana</p>
                    </div>
                </section>
            </div> 

            <section id="contents">
                <div id="artisti" >
                    <h1>Artisti</h1>
                    <div class="here">
                    </div>
                </div>
            </section>
        </main>

        <footer class="style">
            <em>Discovery Weekly</em>
            <p>Nome: Matteo Gitto Matricola: 1000015842</p>
            <br>
            <a class="button1" href="https://it-it.facebook.com"></a>
            <a class="button2" href="https://twitter.com/?lang=it"></a>
            <a class="button3" href="https://www.instagram.com"></a>
        </footer>
    </body>
</html>
<?php mysqli_close($conn); ?>