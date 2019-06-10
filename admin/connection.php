<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'shop';

try{
    $con = new PDO("mysql:host=localhost;dbname=$dbname",$username,$password);
    $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Failed In Connect To Database";
}


?>
