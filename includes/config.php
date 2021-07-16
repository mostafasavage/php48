<?php 
/*
    PDO => PHP Data Object 
*/
$dsn = 'mysql:host=localhost;dbname=web';
$username = "root";
$password = '';

try{
     $con = new PDO($dsn , $username , $password) ; 
    // echo "You are connected" ;
}catch(PDOException $error){
   echo $error->getMessage();
}
?>