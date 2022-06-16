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

function check_store_session_id()
{
  if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
    header('Location:store_login.php');
    exit();
  } else if ($_SESSION['is_admin'] === 0) {
    header('Location:store_login.php');
    exit();
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}

function check_customer_session_id()
{
  if (!isset($_SESSION["session_id"]) || $_SESSION["session_id"] != session_id()) {
    header('Location:customer_login.php');
    exit();
  } else if ($_SESSION['is_admin'] === 1) {
    header('Location:customer_login.php');
    exit();
  } else {
    session_regenerate_id(true);
    $_SESSION["session_id"] = session_id();
  }
}
