<?php

//PDO MySQL接続
function connectDB(){

  $dsn = 'mysql:dbname=anzangame_db;host=localhost;charset=utf8';
  $user = 'g07spnitb9';
  $password = 'anzangamedbpass';

  try{
    $pdo = new PDO($dsn, $user, $password);
  }catch(PDOException $e){
    //var_dump($e->getMessage());
    exit('' . $e->getMessage());
  }

  return $pdo;
}

?>
