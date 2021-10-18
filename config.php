<?php 

try{
    $connect = new PDO("mysql:host=localhost;port=3306;dbname=users", 'root','');
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// echo 'success'; 
}catch(PDOException $e){
    // echo $e;
}


?>