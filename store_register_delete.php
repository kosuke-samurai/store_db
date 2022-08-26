<?php
// データ受け取り
//var_dump($_GET);
//exit();
session_start();
include("functions.php");
check_store_session_id();

// DB接続


$id = $_SESSION["user_id"];

$pdo = connect_to_db();


// SQL実行
$sql = 'DELETE FROM users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location:store_login.php");
exit();
