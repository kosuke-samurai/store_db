<?php
//var_dump($_POST);
//exit();
include('functions.php');



if (
    !isset($_POST["user_id"]) || $_POST["user_id"] == "" ||
    !isset($_POST["store_id"]) || $_POST["store_id"] == "" ||
    !isset($_POST["reserve_day"]) || $_POST["reserve_day"] == "" ||
    !isset($_POST["is_reserve"]) || $_POST["is_reserve"] == "" ||
    !isset($_POST["reserve_message"]) || $_POST["reserve_message"] == "" ||
    !isset($_POST["is_admin"]) || $_POST["is_admin"] == "" ||
    !isset($_POST["is_deleted"]) || $_POST["is_deleted"] == ""
) {
    exit("データが足りません");
}

$user_id = $_POST["user_id"];
$store_id = $_POST["store_id"];
$reserve_day = $_POST["reserve_day"];
$reserve_message = $_POST["reserve_message"];
$is_reserve = $_POST["is_reserve"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];


$pdo = connect_to_db();

//予約重複確認
$sql = 'SELECT COUNT(*) FROM reserve_table WHERE user_id=:user_id AND store_id=:store_id AND reserve_day=:reserve_day';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':store_id', $store_id, PDO::PARAM_STR);
$stmt->bindValue(':reserve_day', $reserve_day, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$reserve_count = $stmt->fetchColumn();
//var_dump($reserve_count);
//exit();



//
if ($reserve_count != 0) {
    exit("すでに来店情報が登録されています");
} else {
    $sql = "INSERT INTO reserve_table (reserve_id, user_id, store_id, reserve_day, reserve_message, is_reserve, is_admin, is_deleted, created_at, updated_at) VALUES (NULL, :user_id, :store_id, :reserve_day, :reserve_message, :is_reserve, :is_admin, :is_deleted, now(), now())";
}



$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':store_id', $store_id, PDO::PARAM_STR);
$stmt->bindValue(':reserve_day', $reserve_day, PDO::PARAM_STR);
$stmt->bindValue(':reserve_message', $reserve_message, PDO::PARAM_STR);
$stmt->bindValue(':is_reserve', $is_reserve, PDO::PARAM_STR);
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
header("Location:reserve_confirm.php?id={$store_id}&reserve_day={$reserve_day}");
exit();
