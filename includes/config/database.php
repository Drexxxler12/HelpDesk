<?php
//require_once '../app.php';


function conectarDB() {
    $db = mysqli_connect('localhost', 'root', 'root', 'helpdesk');
    if(!$db){
        echo "mistake";
        exit;
    }
  // echo 'se conecto bien';
    return $db;
}
