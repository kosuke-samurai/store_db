<?php
// データ受け取り
//var_dump($_GET);
//exit();


// DB接続
include('functions.php');

$id = $_GET["id"];

$pdo = connect_to_db();


// SQL実行
$sql = 'DELETE FROM store_db WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:store_manege.php");
exit();
