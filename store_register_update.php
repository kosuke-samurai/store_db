<?php
session_start();
include("functions.php");
check_store_session_id();

$pdo = connect_to_db();
//var_dump($_POST);
//exit();



// DB接続
if (
    !isset($_POST["email"]) || $_POST["email"] == "" ||
    !isset($_POST["postadress"]) || $_POST["postadress"] == "" ||
    !isset($_POST["adress"]) || $_POST["adress"] == "" ||
    !isset($_POST["tell"]) || $_POST["tell"] == "" ||
    !isset($_POST["is_admin"]) || $_POST["is_admin"] == "" ||
    !isset($_POST["is_deleted"]) || $_POST["is_deleted"] == ""
) {
    exit("データが足りません");
}

$id = $_SESSION["id"];

$email = $_POST["email"];
$postadress = $_POST["postadress"];
$adress = $_POST["adress"];
$tell = $_POST["tell"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];

//sql
$sql = 'UPDATE users_table SET email=:email, postadress=:postadress, adress=:adress, tell=:tell, is_admin=:is_admin, is_deleted=:is_deleted, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':postadress', $postadress, PDO::PARAM_STR);
$stmt->bindValue(':adress', $adress, PDO::PARAM_STR);
$stmt->bindValue(':tell', $tell, PDO::PARAM_STR);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_STR);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:store_login.php");
exit();
