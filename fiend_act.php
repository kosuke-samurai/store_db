<?php

include('functions.php');


if (
    !isset($_POST["first_user_id"]) || $_POST["first_user_id"] == "" ||
    !isset($_POST["second_user_id"]) || $_POST["second_user_id"] == ""
) {
    exit("データが足りません");
}

$first_user_id = $_POST["first_user_id"];
$second_user_id = $_POST["second_user_id"];




$pdo = connect_to_db();

//password_hash($password, PASSWORD_DEFAULT);

//sql

$sql = "INSERT INTO friend_table (friend_id, first_user_id, second_user_id, created_at) VALUES (NULL, :first_user_id, :second_user_id, now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':first_user_id', $first_user_id, PDO::PARAM_STR);
$stmt->bindValue(':second_user_id', $second_user_id, PDO::PARAM_STR);



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
