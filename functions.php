<?php

function connect_to_db()
{
$dbn = 'mysql:dbname=gs_graduation_program;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';

//[return]にすることに留意！
try {
  return new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}

}