<?php
//var_dump($_POST);
//exit();
include('functions.php');

if (
    !isset($_POST["username"]) || $_POST["username"] == "" ||
    !isset($_POST["store_name"]) || $_POST["store_name"] == "" ||
    !isset($_POST["reserve_day"]) || $_POST["reserve_day"] == "" ||
    !isset($_POST["is_admin"]) || $_POST["is_admin"] == "" ||
    !isset($_POST["is_deleted"]) || $_POST["is_deleted"] == ""
) {
    exit("データが足りません");
}

$username = $_POST["username"];
$store_name = $_POST["store_name"];
$reserve_day = $_POST["reserve_day"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];


$pdo = connect_to_db();


$sql = "INSERT INTO reserve_table (reserve_id, username, store_name, reserve_day, is_admin, is_deleted, created_at, updated_at) VALUES (NULL, :username, :store_name, :reserve_day, :is_admin, :is_deleted, now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':store_name', $store_name, PDO::PARAM_STR);
$stmt->bindValue(':reserve_day', $reserve_day, PDO::PARAM_STR);
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
header("Location:reserve_confirm.php?store={$store_name}&reserve_day={$reserve_day}");
exit();
