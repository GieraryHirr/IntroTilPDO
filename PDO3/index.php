<?php
session_start();

if (isset($_SESSION['logged_id'])) { //If we are allready logged in our session
    header('Location: adminPanel.php'); //Go to main panel
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>PDO</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">

    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <!--[if lt IE 9]>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">

        <header>
            <h1>TEC</h1>
        </header>

        <main>
            <article>
                <form method="post" action="login.php">

                    <label>Login <!-- If variabel given_pnummer is set, put value in input -->
                        <input type="text" name="pnummer" <?= isset($_SESSION['given_pnummer']) ? 'value="' . $_SESSION['given_pnummer'] . '"' :'' ?>> 
                    </label>
                    
                    <label>Password
                        <input type="password" name="pass">
                    </label>

                    <input type="submit" value="Log In">

                    <?php

                        if(isset($_SESSION['bad_attempt'])) { //If login or password are wrong
                            echo'<p>Wrong login or password</p>';
                            unset($_SESSION['bad_attempt']);
                        }

                        if (isset($_SESSION['given_pnummer'])) { //If we used wrong character
                            echo '<p>Wrong login, you can use only numbers!';
                            unset($_SESSION['given_pnummer']);
                        }
                    ?>
                </form>
            </article>
        </main>

    </div>
</body>
</html>