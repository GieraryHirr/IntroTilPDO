<?php 
    session_start();
        if (isset($_POST['verifyID']) && isset($_POST['newtime'])) { //
            $id = filter_input(INPUT_POST,'verifyID', FILTER_VALIDATE_INT); //If ID is not a number, ID variabel takes value of null or false.
            $time = filter_input(INPUT_POST,'newtime', FILTER_VALIDATE_INT); //If ID is not a number, time variabel takes value of null or false.

            if(empty($time)) {
                header('Location: adminPanel.php');
                //$_SESSION['emptyHours'] = 1;
                exit();
            }

            require_once 'database.php';
            $userTimeQuery = $db->prepare('UPDATE projekt_deltagere SET Timer = :hour WHERE Person_ID = :pID');
            $userTimeQuery ->bindValue(':pID', $id, PDO::PARAM_INT);
            $userTimeQuery ->bindValue(':hour', $time, PDO::PARAM_INT);
            $userTimeQuery ->execute();
            header('Location: adminPanel.php');
        }
?>