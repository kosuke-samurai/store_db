<?php
// データ受け取り
//var_dump($_POST);
//exit();


// DB接続
session_start();
include('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];
$is_admin = $_POST['is_admin'];
//$adress = $_POST['adress'];


//$hash = password_hash($password, PASSWORD_DEFAULT);
//var_dump($hash);
//exit();

$pdo = connect_to_db();

// SQL実行

$sql = 'SELECT * FROM users_table WHERE username=:username AND is_admin=:is_admin AND is_deleted=0';


$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
//$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザ有無で条件分岐
$val = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$val) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=customer_login.php>ログイン</a>";
    exit();
} else if (password_verify($_POST['password'], $val['password']) && $val['is_admin'] === 1) {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['id'] = $val['id'];
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    $_SESSION['adress'] = $val['adress'];
    header("Location:store_manege.php");
    exit();
} else if (password_verify($_POST['password'], $val['password']) && $val['is_admin'] === 0) {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['id'] = $val['id'];
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    $_SESSION['adress'] = $val['adress'];
    header("Location:store_read.php");
    exit();
} else {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=customer_login.php>ログイン</a>";
    exit();
} 
/*
if (!$val) {
    echo "<p>ログイン情報に誤りがあります</p>";
    echo "<a href=todo_login.php>ログイン</a>";
    exit();
} else {
    $_SESSION = array();
    $_SESSION['session_id'] = session_id();
    $_SESSION['is_admin'] = $val['is_admin'];
    $_SESSION['username'] = $val['username'];
    header("Location:todo_read.php");
    exit();
}
*/
