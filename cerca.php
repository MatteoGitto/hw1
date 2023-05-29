<?php
session_start(); // Aggiungi questa riga per avviare la sessione

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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap" rel="stylesheet">
        <link rel="stylesheet"  href="cerca.css">
        <script src="cerca.js" defer="true"></script>
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
        <title>Cerca cio' che vuoi</title>
    </head>
    <body>
        <div class="style">
            <header>
                <nav>
                    <img src="logo.png" id="logo">

                    <a href="home.php">Home</a>
                    <a href="profile.php">Profilo</a>
                    <a href="artisti.php">Artisti</a>
                    <a href="cerca.php">Cerca</a>
                    <a href="logout.php">Logout</a>
                    <div id="search">
                        <img src="./images/ricerca.png" >
                        <input type="text" id="search_bar">
                    </div>
                </nav>
            </header>
        </div>
        <div id="menu">
          <div></div>
          <div></div>
          <div></div>
        </div>
        <h1>Ascolta nuova musica</h1>
        <a class="subtitle">
            Cerca nuovi artisti, album e molto altro con Discovery Weekly!
        </a>

        <section id="profile_user">
            <div>
                <img src="./images/music.png">
                <h1>Eccoti <?php echo $ans['username'] ?></h1>
                <p>
                    Esplora e ascolta!
                </p>
            </div>
        </section>

        <main id="main-container">
            <section id="contents_hidden">
                <div id="container_album" >
                    <h4>Album</h4>
                    <div class="here">
                    </div>
                </div>

                <div id="container_Tracks" >
                    <h4>Tracks</h4>
                    <div class="here">
                    </div>
                </div>

                <div id="Container_Artists" >
                    <h4>Artists</h4>
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
