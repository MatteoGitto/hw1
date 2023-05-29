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

?>

<html>
    <?php 
        // Carica le informazioni dell'utente loggato
        $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));
        $userid = mysqli_real_escape_string($conn, $userid);
        $query = "SELECT * FROM users WHERE id = $userid";
        $res_1 = mysqli_query($conn, $query);
        $userinfo = mysqli_fetch_assoc($res_1);   
    ?>
<   head>
        <link rel='stylesheet' href='profile.css'>
        <script src='profile.js' defer></script>
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">

        <title>Discovery Weekly - <?php echo $userinfo['nome']." ".$userinfo['cognome'] ?></title>
    </head>

    <body>
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

                <div class="userInfo">
                    <div class="avatar" style="background-image: url(<?php echo $userinfo['propic'] == null ? "images/default.png" : $userinfo['propic'] ?>)">
                    </div>
                    <h1><?php echo $userinfo['nome']." ".$userinfo['cognome'] ?></h1>
                </div>               
            </nav>
        </header>

        <section id='Discovery'>
            <h1>Discovery</h1>
            <div class="loading">
            <img src="./images/loading.gif" class="hidden">
            </div>
            <div>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
                <iframe src="" width="300" height="380" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>
            </div>
        </section>

    </body>
</html>

<?php mysqli_close($conn); ?>
