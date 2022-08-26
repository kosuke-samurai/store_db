<?php

include('functions.php');


if (
    !isset($_POST["friend_id"]) || $_POST["friend_id"] == "" ||
    !isset($_POST["post_user_id"]) || $_POST["post_user_id"] == "" ||
    !isset($_POST["text"]) || $_POST["text"] == ""
) {
    exit("データが足りません");
}

$friend_id = $_POST["friend_id"];
$post_user_id = $_POST["post_user_id"];
$text = $_POST["text"];



$pdo = connect_to_db();


$sql = "INSERT INTO friend_chat_table (tweet_id, friend_id, post_user_id, text, created_at) VALUES (NULL, :friend_id, :post_user_id, :text, now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':friend_id', $friend_id, PDO::PARAM_STR);
$stmt->bindValue(':post_user_id', $post_user_id, PDO::PARAM_STR);
$stmt->bindValue(':text', $text, PDO::PARAM_STR);



// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ★SQL実行の処理★
header("Location:friend_chat.php?id={$friend_id}");
exit();
