<?php
require_once 'auth.php';

session_start(); // Aggiungi questa riga per avviare la sessione

$userid = checkAuth(); // Verifica l'autenticazione dell'utente

if ($userid === 0) { // Controlla se l'utente e' autenticato
    $error_message = "Questo e' un messaggio di errore di debug.";
    echo $error_message; 
    echo $userid;

    header("Location: home_login.php");
    exit;
}

// Verifica se la libreria cURL e' attiva
/*if (function_exists('curl_version')) {
    echo "La libreria cURL e' attiva sul server.";
} else {
    echo "La libreria cURL non e' attiva sul server.";
}*/

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
        <link rel="stylesheet"  href="home.css">
        <script src="home.js" defer="true"></script>
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
        <title>Home</title>
    </head>
    <body>  
        <div class="style">
            <header>
                <nav>
                    <input type="checkbox" id="menu-toggle" display="hidden"  src="./images/menu_icon.png">
                    <label for="menu-toggle" id="menu-icon"></label>
                    <img src="logo.png" id="logo">

                    <a href="home.php">Home</a>
                    <a href="profile.php">Profilo</a>
                    <a href="artisti.php">Artisti</a>
                    <a href="cerca.php">Cerca</a>
                    <a href="logout.php">Logout</a>
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
            Esplora ogni settimana nuovi artisti, album e molto altro con Discovery Weekly!
        </a>

        <section id="profile_user">
            <div>
                <img src="./images/music.png">
                <h1>Benvenuto <?php echo $ans['username'] ?></h1>
                <p>
                    La tua pagina personalizzata, tutta la tua musica. Esplora e ascolta!
                </p>
            </div>
        </section>

        <main id="main-container">
            <section id="contents">

                <div id="preferiti_albums" >
                    <h1>Album-PREFERITI</h1>
                    <div class="here">
                    </div>
                </div>

                <div id="preferiti_tracks" >
                    <h1>Tracks-PREFERITI</h1>
                    <div class="here">
                    </div>
                </div>

                <div id="preferiti_artists">
                    <h1>Artists-PREFERITI</h1>
                    <div class="here">
                    </div>
                </div>

            </section>

            <main  id="lyrics">
                <section>
                    <h1>Cerca la canzone che ti piace!</h1>
                    <form>
                        <div>
                            <label>
                                <input type="text" name="artista" id="artist" placeholder="Artista">
                            </label>
                        </div>
                        <div>
                            <label>
                                <input type="text" name="titolo" id="song" placeholder="Titolo canzone">
                            </label>
                        </div>
                        <div>
                            <label>&nbsp;<input type="button" id="invio" value="Cerca"></label>
                        </div>
                    </form>
                    <iframe class="hidden" src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                </section>
                <section>
                    <div id="testo"></div> <!-- Testo = Se si clicca nel blcco Spotify esce il teso della canzone -->
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
        </main>
    </body>
</html>
<?php mysqli_close($conn); ?>