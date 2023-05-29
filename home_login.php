<?php
    include 'auth.php';
    session_start();

    if (checkAuth()) {
        header('Location: home.php');
        exit;
    }


    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $conn = mysqli_connect($db_config['host'], $db_config['user'], $db_config['password'], $db_config['name']) or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        $query = "SELECT * FROM users WHERE username='$username'";

        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);

            if (password_verify($password, $entry['password'])) {
                $_SESSION['username'] = $entry['username'];
                $_SESSION['id'] = $entry['id'];
                var_dump($_SESSION);

                mysqli_free_result($res);
                mysqli_close($conn);
                echo $_SESSION['id'];
                header('Location: home.php');
                exit;
            } else {
                $error = "Password errata :(";
            }
        } else {
            $error = "Credenziali non valide :(";
        }
    } else if (isset($_POST["username"]) || isset($_POST["password"])) {
        $error = "Inserisci username e password";
    }
?>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
        <link rel="stylesheet" href="home_login.css">
        <link rel="shortcut icon" href="logo.ico" type="image/x-icon">
        <title>Login-Discovery Weekly</title>
    </head>

    <body>
        <section>
            <div id="main">
                <form name="login" method="post">
                   <img src="logo.png">
                   <h1>Per continuare, accedi a Discovery Weekly</h1>

                   <div class="username">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="user" maxlength="15" <?php if (isset($_POST["username"])){echo "value='".$_POST["username"]."'";} ?>>
                   </div>

                   <div class="password">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="pass" maxlength="15">
                   </div>

                   <div class="submit_container">
                        <div class="login">  
                            <input type="submit" id="invio" value="Login">
                        </div> 
                   </div>

                   <?php if (!empty($error)): ?>
                   <div class="error">
                        <?php echo $error; ?>
                   </div>
                   <?php endif; ?>

                   <div class="signup"><h1>Non hai un account?</h1></div>
                   <div class="signup-btn-container"><a class="signup-btn" href="signup.php">ISCRIVITI A DISCOVERY WEEKLY</a></div>
                </form>
            </div>
        </section>
    </body>
</html>
