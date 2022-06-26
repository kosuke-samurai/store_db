<?php

/*
function connect_to_db()
{
  $db = parse_url($_SERVER['CLEARDB_DATABASE_URL']);
  $db['dbname'] = ltrim($db['path'], '/');
  $dsn = "mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8";
  $user = $db['user'];
  $password = $db['pass'];
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
  );
  $dbh = new PDO($dsn, $user, $password, $options);
  return $dbh;
}
*/



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
