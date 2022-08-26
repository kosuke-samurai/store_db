<?php

include('functions.php');


if (
    !isset($_POST["my_id"]) || $_POST["my_id"] == "" ||
    !isset($_POST["to_user"]) || $_POST["to_user"] == "" ||
    !isset($_POST["store_name"]) || $_POST["store_name"] == "" ||
    !isset($_POST["reserve_day"]) || $_POST["reserve_day"] == ""
) {
    exit("データが足りません");
}

$my_id = $_POST["my_id"];
$to_user = $_POST["to_user"];
$store_name = $_POST["store_name"];
$reserve_day = $_POST["reserve_day"];



$pdo = connect_to_db();

//password_hash($password, PASSWORD_DEFAULT);

//sql

$sql = "INSERT INTO fiend_request_table (fiend_request_id, my_id, to_user, store_name, reserve_day, created_at, updated_at) VALUES (NULL, :my_id, :to_user, :store_name, :reserve_day, now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':my_id', $my_id, PDO::PARAM_STR);
$stmt->bindValue(':to_user', $to_user, PDO::PARAM_STR);
$stmt->bindValue(':store_name', $store_name, PDO::PARAM_STR);
$stmt->bindValue(':reserve_day', $reserve_day, PDO::PARAM_STR);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ★SQL実行の処理★
header("Location:customer_mypage.php?id={$my_id}");
exit();
