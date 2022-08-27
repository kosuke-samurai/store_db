<?php
//var_dump($_POST);
//exit();

include('functions.php');

if (
    !isset($_POST["owner_id"]) || $_POST["owner_id"] == "" ||
    !isset($_POST["store_id"]) || $_POST["store_id"] == "" ||
    !isset($_POST["open_day"]) || $_POST["open_day"] == "" ||
    !isset($_POST["start_hour"]) || $_POST["start_hour"] == "" ||
    !isset($_POST["close_hour"]) || $_POST["close_hour"] == "" ||
    !isset($_POST["customer_number"]) || $_POST["customer_number"] == "" ||
    !isset($_POST["secret_item"]) || $_POST["secret_item"] == "" ||
    !isset($_POST["item_url"]) || $_POST["item_url"] == "" ||
    !isset($_POST["item_detail"]) || $_POST["item_detail"] == "" ||
    !isset($_POST["is_deleted"]) || $_POST["is_deleted"] == ""
) {
    exit("データが足りません");
}

$owner_id = $_POST["owner_id"];
$store_id = $_POST["store_id"];
$open_day = $_POST["open_day"];
$start_hour = $_POST["start_hour"];
$close_hour = $_POST["close_hour"];
$customer_number = $_POST["customer_number"];
$secret_item = $_POST["secret_item"];
$item_url = $_POST["item_url"];
$item_detail = $_POST["item_detail"];
$is_deleted = $_POST["is_deleted"];


$pdo = connect_to_db();


$sql = "INSERT INTO store_reserve_table (event_id, owner_id, store_id, open_day, start_hour, close_hour, customer_number, secret_item, item_url, item_detail, is_deleted, created_at, updated_at) VALUES (NULL, :owner_id, :store_id, :open_day, :start_hour, :close_hour, :customer_number, :secret_item, :item_url, :item_detail, :is_deleted, now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':owner_id', $owner_id, PDO::PARAM_STR);
$stmt->bindValue(':store_id', $store_id, PDO::PARAM_STR);
$stmt->bindValue(':open_day', $open_day, PDO::PARAM_STR);
$stmt->bindValue(':start_hour', $start_hour, PDO::PARAM_STR);
$stmt->bindValue(':close_hour', $close_hour, PDO::PARAM_STR);
$stmt->bindValue(':customer_number', $customer_number, PDO::PARAM_STR);
$stmt->bindValue(':secret_item', $secret_item, PDO::PARAM_STR);
$stmt->bindValue(':item_url', $item_url, PDO::PARAM_STR);
$stmt->bindValue(':item_detail', $item_detail, PDO::PARAM_STR);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_STR);

// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ★SQL実行の処理★
header('Location:store_manege.php');
exit();
