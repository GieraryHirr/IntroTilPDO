<?php

$config = require_once 'config.php'; //required config.php file

try {

    //New object of class PDO
    $db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8",$config['user'],$config['password'], 
    [
        PDO::ATTR_EMULATE_PREPARES => false, //Better safety, lesser performance.
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //PDO can describe error.

    ]);

} catch (PDOException $error) { //Catching error
    echo $error -> getMessage();
    exit('Database error');
}

?>