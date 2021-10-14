<?php 
        session_start();
        if(!empty($_SESSION['logged_id'])) { //If user is logged
            unset($_SESSION['logged_id']); //Clear variabel
            header('Location: index.php'); //navigate to new page
        } else {
            header('Location: index.php'); //navigate to new page
        }

?>