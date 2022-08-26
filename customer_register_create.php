<?php
//POSTデータ確認
//var_dump($_POST);
//exit();
include('functions.php');


if (
    !isset($_POST["username"]) || $_POST["username"] == "" ||
    !isset($_POST["email"]) || $_POST["email"] == "" ||
    !isset($_POST["password"]) || $_POST["password"] == "" ||
    !isset($_POST["postadress"]) || $_POST["postadress"] == "" ||
    !isset($_POST["prefectures"]) || $_POST["prefectures"] == "" ||
    !isset($_POST["adress"]) || $_POST["adress"] == "" ||
    !isset($_POST["tell"]) || $_POST["tell"] == "" ||
    !isset($_POST["is_premier"]) || $_POST["is_premier"] == "" ||
    !isset($_POST["is_admin"]) || $_POST["is_admin"] == "" ||
    !isset($_POST["is_deleted"]) || $_POST["is_deleted"] == ""
) {
    exit("データが足りません");
}

$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$postadress = $_POST["postadress"];
$prefectures = $_POST["prefectures"];
$adress = $_POST["adress"];
$tell = $_POST["tell"];
$is_premier = $_POST["is_premier"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];


$pdo = connect_to_db();

//password_hash($password, PASSWORD_DEFAULT);

//sql

$sql = "INSERT INTO users_table (id, username, email, password, postadress, prefectures, adress, tell, is_premier, is_admin, is_deleted, created_at, updated_at) VALUES (NULL, :username, :email, :password, :postadress, :prefectures, :adress, :tell, :is_premier, :is_admin, :is_deleted, now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
$stmt->bindValue(':postadress', $postadress, PDO::PARAM_STR);
$stmt->bindValue(':prefectures', $prefectures, PDO::PARAM_STR);
$stmt->bindValue(':adress', $adress, PDO::PARAM_STR);
$stmt->bindValue(':tell', $tell, PDO::PARAM_STR);
$stmt->bindValue(':is_premier', $is_premier, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ★SQL実行の処理★
header('Location:customer_login.php');
exit();
