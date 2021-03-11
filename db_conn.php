<?php 

$sName = "https://selene.hud.ac.uk/phpmyadmin/";
$uName = "u1952998";
$pass = "AA05mar21aa";
$db_name = "u1952998";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
                    $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo "Connection failed : ". $e->getMessage();
}