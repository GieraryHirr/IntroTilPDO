<?php 
    session_start();
    require_once 'database.php';

    if(!isset($_SESSION['logged_id'])) {

        if (isset($_POST['login'])) {
            $id = filter_input(INPUT_POST, 'pnummer'); //Getting value from cpr input
            $pass = filter_input(INPUT_POST, 'pass'); //Getting value from cpr input

            $userQuery = $db->prepare('SELECT Person_ID, Adgangskode FROM medarbejder WHERE Person_ID = :login AND Adgangskode = :password ');
            $userQuery ->bindValue(':login', $id, PDO::PARAM_INT); //Bind value for login
            $userQuery ->bindValue(':password', $pass, PDO::PARAM_STR); //Bind value for password
            $userQuery ->execute();
            $user = $userQuery->fetch(); //Get respond from database

            if ($user && $pass) { //If user founded in database
                $_SESSION['logged_id'] = $id['Person_ID']; //craete session variabel 
                unset($_SESSION['bad_attempt']); //unser session variabel 
            } else {
                $_SESSION['bad_attempt'] = true; //set session variabel
                header('Location: index.php'); //go back to login page
                exit(); 
            }



        } else {
            header('Location: index.php'); //Go back to login page
            exit();
        }
    }


    $usersQuery = $db->query('SELECT * FROM medarbejder'); //query to database
    $users = $usersQuery->fetchAll(); //Get data from db into users array

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <title>Logged in</title>
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="app.js"></script>
</head>
    
<body>
    
    <div class="container2">
        <header>
            <h1>List of workers</h1>
        </header>

        <main>
            <article>

                <table>
                    <thead>
                        <tr><th colspan="11">Number of workers: <?= $usersQuery->rowCount()?></th></tr> <!-- Show number of workers -->
                        <tr>
                            <th>Person ID</th>
                            <th>Fornavn</th>
                            <th>Efternavn</th>
                            <th>TlfNr</th>
                            <th>AfdNavn</th>
                            <th>Titel</th>
                            <th>AfdNummer</th>
                            <th>PNummer</th>
                            <th>ProjektNavn</th>
                            <th>Timer</th>
                            <th>Placering</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($users as $user) {

                                //Loops needed to fetch user with correct values
                                $projektDeltagerQuery = $db->prepare('SELECT * FROM projekt_deltagere WHERE Person_ID = :person ');
                                $projektDeltagerQuery ->bindValue(':person', $user['Person_ID'], PDO::PARAM_STR); 
                                $projektDeltagerQuery ->execute();
                                $projektDeltagere = $projektDeltagerQuery->fetchAll();
                                foreach ($projektDeltagere as $projektDeltager) {
                                    $projektQuery = $db->prepare('SELECT * FROM projekt WHERE PNummer = :projektnr ');
                                    $projektQuery ->bindValue(':projektnr', $projektDeltager['PNummer'], PDO::PARAM_INT); 
                                    $projektQuery ->execute();
                                    $projekte = $projektQuery->fetchAll();
                                    foreach ($projekte as $projekt) {
                                        $afdelingsQuery = $db->prepare('SELECT * FROM afdeling WHERE AfdNummer = :AfdNr ');
                                        $afdelingsQuery ->bindValue(':AfdNr', $projekt['AfdNummer'], PDO::PARAM_INT);
                                        $afdelingsQuery ->execute();
                                        $afdelings = $afdelingsQuery->fetchAll();
                                        foreach ($afdelings as $afdeling) {
                                            if ($user['Person_ID'] == $_SESSION['logged_id']) {
                                                $_SESSION['kontotype'] = $afdeling['AfdNavn'];
                                            }

                                            echo    "<tr>
                                                        <td>{$user['Person_ID']}</td>
                                                        <td>{$user['Fornavn']}</td>
                                                        <td>{$user['Efternavn']}</td>
                                                        <td>{$user['TlfNr']}</td>
                                                        <td>{$afdeling['AfdNavn']}</td>
                                                        <td>{$user['Titel']}</td>
                                                        <td>{$projekt['AfdNummer']}</td>
                                                        <td>{$projektDeltager['PNummer']}</td>
                                                        <td>{$projekt['ProjektNavn']}</td>
                                                        <td>{$projektDeltager['Timer']}</td>
                                                        <td>{$afdeling['ByNavn']}</td>
                                                    </tr>";
                                        }
                                    }
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </article>
        </main>

        <?php 
            if($_SESSION['kontotype'] == 'Administration') { //Only members from Administration can see this echo
                echo ('
                <form method="post" action="update.php" autocomplete="off">
                <br/>
                <label>Person ID
                    <br/>
                    <input type="text" name="verifyID">
                    <br/> 
                </label>
    
    
                <label>Timer
                    <br/>
                    <input type="text" name="newtime">
                    <br/>
                </label>
    
                <input type="submit" value="Save"></form>'
        );
            }
        ?>
        
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>