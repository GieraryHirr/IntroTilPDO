<?php

session_start();

if (!isset($_SESSION['logged_id'])) {

    if (isset($_POST['pnummer']) && isset($_POST['pass'])) {
        $cpr = filter_input(INPUT_POST,'pnummer', FILTER_VALIDATE_INT); //If cpr is incorrect, cpr variabel takes value of null or false.
        $pass = $_POST['pass'];

        if (empty($cpr)) { //If cpr empty
            $_SESSION['given_pnummer'] = $_POST['pnummer'];
            header('Location: index.php');
            //exit();
            
            
        } else {
            
            require_once 'database.php';
            $userQuery = $db->prepare('SELECT Person_ID, Adgangskode FROM medarbejder WHERE Person_ID = :login AND Adgangskode = :password');
            $userQuery ->bindValue(':login', $cpr, PDO::PARAM_INT);
            $userQuery ->bindValue(':password', $pass, PDO::PARAM_STR);
            $userQuery ->execute();

            if ($userQuery->rowCount() == 1) {
                
                $user = $userQuery->fetch(); //Taking respond from database
                $_SESSION['logged_id'] = $user['Person_ID'];
                unset($_SESSION['bad_attempt']);
                header('Location: adminPanel.php');
                

            }else {
                $_SESSION['bad_attempt'] = true;
                header('Location: index.php');
                exit();
            }

        }

    } else {
        header('Location: adminPanel.php');
        exit();
    }
}
?>