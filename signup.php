<?php
    require_once 'auth.php';

    if (checkAuth()) {
        header("Location: home.php");
        exit;
    }   

    // Verifica esistenza dati POST
    if (!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["name"]) && 
        !empty($_POST["cognome"]) && !empty($_POST["confirm_password"]) && !empty($_POST["allow"]))
    {
        $error = array();
        $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

        
        //USERNAME
        // Controlla che l'username rispetti il pattern specificato
        if(!preg_match('/^[a-zA-Z0-9_]{1,15}$/', $_POST['username'])) {
            $error[] = "Username non valido";
        } else {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            // Cerco se l'username esiste gia' o se appartiene a una delle 3 parole chiave indicate
            $query = "SELECT username FROM users WHERE username = '$username'";
            $res = mysqli_query($conn, $query);
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Username in uso";
            }
        }

        //PASSWORD
        if (strlen($_POST["password"]) < 8) {
            $error[] = "La password deve contenere almeno 8 caratteri.";
        } 

        //CONFERMA PASSWORD
        if (strcmp($_POST["password"], $_POST["confirm_password"]) != 0) {
            $error[] = "Le password non coincidono";
        }

        //EMAIL
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error[] = "Email non valida";
        } else {
            $email = mysqli_real_escape_string($conn, strtolower($_POST['email']));
            $res = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
            if (mysqli_num_rows($res) > 0) {
                $error[] = "Email in uso";
            }
        }

        //UPLOAD PROFILE-PIC
        if (count($error) == 0) { 
            if ($_FILES['profile_pic']['size'] != 0) {
                $file = $_FILES['profile_pic'];
                $type = exif_imagetype($file['tmp_name']);
                $allowedExt = array(IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif');
                if (isset($allowedExt[$type])) {
                    if ($file['error'] === 0) {
                        if ($file['size'] < 7000000) {
                            $fileNameNew = uniqid('', true).".".$allowedExt[$type];
                            $fileDestination = './images/profile/'.$fileNameNew;
                            move_uploaded_file($file['tmp_name'], $fileDestination);
                        } else {
                            $error[] = "L'immagine non deve avere dimensioni maggiori di 7MB";
                        }
                    } else {
                        $error[] = "Errore nel carimento del file";
                    }
                } else {
                    $error[] = "I formati consentiti sono .png, .jpeg, .jpg e .gif";
                }
            }else{
                echo "Non hai caricato nessuna immagine";
            }
        }

        //REGISTRAZIONE NEL DATABASE
        if (count($error) == 0) {
            $name = mysqli_real_escape_string($conn, $_POST['name']);
            $cognome = mysqli_real_escape_string($conn, $_POST['cognome']);

            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $password = password_hash($password, PASSWORD_BCRYPT);

            $query = "INSERT INTO users(username, password, nome, cognome, email, propic) VALUES('$username', '$password', '$name', '$cognome', '$email', '$fileDestination')";
            
            if (mysqli_query($conn, $query)) {
                $_SESSION["user_id"] = $_POST["username"];
                $_SESSION["user_id"] = mysqli_insert_id($conn);
                mysqli_close($conn);
                header("Location: home.php");
                exit;
            } else {
                $error[] = "Errore di connessione al Database";
            }
        }

        mysqli_close($conn);
    }
    else if (isset($_POST["username"])) {
        $error = array("Riempi tutti i campi");
    }

?>


<html>
    <head>
        <link rel='stylesheet' href='signup.css'>
        <script src='signup.js' defer></script>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
        <meta charset="utf-8">


        <link href="https://fonts.googleapis.com/css2?family=Special+Elite&display=swap" rel="stylesheet">
        <title>Signup - Discovery Weekly</title>
    </head>
    <body>
        <main>
            <section>
                <h1>Discovery Weekly</h1>
                <h1>Esplora la musica ogni settimana, registrati gratuitamente!</h1>
                <form name='signup' method='post' enctype="multipart/form-data" autocomplete="off">
                    <div class="names">
                        <div class="name">
                            <label for='name'>Nome</label>
                            <!-- Se il submit non va a buon fine, il server reindirizza su questa stessa pagina, quindi va ricaricata con i valori precedentemente inseriti -->
                            <input type='text' name='name' <?php if(isset($_POST["name"])){echo "value=".$_POST["name"];} ?> >
                            <div><img src="./images/close.png"/><span>Devi inserire il tuo nome</span></div>
                        </div>
                        <div class="cognome">
                            <label for='cognome'>Cognome</label>
                            <input type='text' name='cognome' <?php if(isset($_POST["cognome"])){echo "value=".$_POST["cognome"];} ?> >
                            <div><img src="./images/close.png"/><span>Devi inserire il tuo cognome</span></div>
                        </div>
                    </div>

                    <div class="username">
                        <label for='username'>Username</label>
                        <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                        <div><img src="./images/close.png"/><span>Nome utente non disponibile</span></div>
                    </div>

                    <div class="email">
                        <label for='email'>Email</label>
                        <input type='text' name='email' <?php if(isset($_POST["email"])){echo "value=".$_POST["email"];} ?>>
                        <div><img src="./images/close.png"/><span>Indirizzo email non valido</span></div>
                    </div>

                    <div class="password">
                        <label for='password'>Password</label>
                        <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                        <div><img src="./images/close.png"/><span>Inserisci almeno 8 caratteri</span></div>
                    </div>

                    <div class="confirm_password">
                        <label for='confirm_password'>Conferma Password</label>
                        <input type='password' name='confirm_password' <?php if(isset($_POST["confirm_password"])){echo "value=".$_POST["confirm_password"];} ?>>
                        <div><img src="./images/close.png"/><span>Le password non coincidono</span></div>
                    </div>

                    <div class="fileupload">
                        <label for='profile_pic'>Scegli un'immagine profilo</label>
                        <input type='file' name='profile_pic' accept='.jpg, .jpeg, image/gif, image/png' id="upload_original">
                        <div id="upload"><div class="file_name">Seleziona un file...</div><div class="file_size"></div></div>
                        <span>Le dimensioni del file superano 7 MB</span>
                    </div>

                    <div class="allow"> 
                        <input type='checkbox' name='allow' value="1" <?php if(isset($_POST["allow"])){echo $_POST["allow"] ? "checked" : "";} ?>>
                        <label for='allow'>Accetto i termini e condizioni d'uso di Musity.</label>
                    </div>

                    <?php if(isset($error)) {
                        foreach($error as $err) {
                            echo "<div class='close_error'><img src='./images/close.png'/><span>".$err."</span></div>";
                        }
                    } ?>

                    <div class="submit">
                        <input type='submit' value="Registrati" id="submit">
                    </div>
                </form>
                <div class="signup">Hai un account? <a href="home_login.php">Accedi</a>
            </section>
        </main>
    </body>
</html>