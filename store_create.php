<?php
session_start();
include("functions.php");
check_store_session_id();
//POSTデータ確認
//echo '<pre>';
//var_dump($_FILES["picture"]);
//echo '</pre>';
//exit();

//$content = file_get_contents($_FILES["picture"]["tmp_name"]);

//var_dump($content);
//exit();

// DB接続
if (
  !isset($_POST["user_id"]) || $_POST["user_id"] == "" ||
  !isset($_POST["name"]) || $_POST["name"] == "" ||
  //!isset($_FILES["picture"]) || $_FILES["picture"] == "" ||

  !isset($_POST["filesurl"]) || $_POST["filesurl"] == "" ||
  !isset($_POST["category"]) || $_POST["category"] == "" ||
  !isset($_POST["moodselect"]) || $_POST["moodselect"] == "" ||
  !isset($_POST["moodtext"]) || $_POST["moodtext"] == "" ||
  !isset($_POST["foodtext"]) || $_POST["foodtext"] == "" ||
  !isset($_POST["message"]) || $_POST["message"] == "" ||
  !isset($_POST["scene"]) || $_POST["scene"] == "" ||
  !isset($_POST["budget"]) || $_POST["budget"] == "" ||
  !isset($_POST["openday"]) || $_POST["openday"] == "" ||
  !isset($_POST["postadress"]) || $_POST["postadress"] == "" ||
  !isset($_POST["prefectures"]) || $_POST["prefectures"] == "" ||
  !isset($_POST["adress"]) || $_POST["adress"] == "" ||
  !isset($_POST["tell"]) || $_POST["tell"] == ""
) {
  exit("データが足りません");
}

//データの受取
$user_id = $_POST["user_id"];
$name = $_POST["name"];
//$picture = file_get_contents($_FILES["picture"]["tmp_name"]);
//$pictype = $_FILES["picture"]["type"];
//$picsize = $_FILES["picture"]["size"];

$filesurl = $_POST["filesurl"];
$category = $_POST["category"];
$moodselect = $_POST["moodselect"];
$moodtext = $_POST["moodtext"];
$foodtext = $_POST["foodtext"];
$message = $_POST["message"];
$scene = $_POST["scene"];
$budget = $_POST["budget"];
$openday = $_POST["openday"];
$postadress = $_POST["postadress"];
$prefectures = $_POST["prefectures"];
$adress = $_POST["adress"];
$tell = $_POST["tell"];

// DB接続 ※基本変えない。
$pdo = connect_to_db();

// 各種項目設定 ※基本変えない。dbnameを変えるだけ
//$dbn = 'mysql:dbname=gs_graduation_program;charset=utf8mb4;port=3306;host=localhost';
//$user = 'root';
//$pwd = '';


//try {
//  $pdo = new PDO($dbn, $user, $pwd);
//} catch (PDOException $e) {
// echo json_encode(["db error" => "{$e->getMessage()}"]);
// exit();
//}
// （「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる）

// ★SQL作成&実行★ ※基本変えない。$sql以下記載のコードはphpmyadminで実行できるのを確認してからそれをコピペ
$sql = "INSERT INTO store_db (id, user_id, name, filesurl, category, moodselect, moodtext, foodtext, message, scene, budget, openday, postadress, prefectures, adress, tell, created_at, updated_at) VALUES (NULL, :user_id, :name, :filesurl, :category, :moodselect, :moodtext, :foodtext, :message, :scene, :budget, :openday, :postadress, :prefectures, :adress, :tell,  now(), now())";

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
//$stmt->bindValue(':picture', $picture, PDO::PARAM_STR);
//$stmt->bindValue(':pictype', $pictype, PDO::PARAM_STR);
//$stmt->bindValue(':picsize', $picsize, PDO::PARAM_STR);

$stmt->bindValue(':filesurl', $filesurl, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':moodselect', $moodselect, PDO::PARAM_STR);
$stmt->bindValue(':moodtext', $moodtext, PDO::PARAM_STR);
$stmt->bindValue(':foodtext', $foodtext, PDO::PARAM_STR);
$stmt->bindValue(':message', $message, PDO::PARAM_STR);
$stmt->bindValue(':scene', $scene, PDO::PARAM_STR);
$stmt->bindValue(':budget', $budget, PDO::PARAM_STR);
$stmt->bindValue(':openday', $openday, PDO::PARAM_STR);
$stmt->bindValue(':postadress', $postadress, PDO::PARAM_STR);
$stmt->bindValue(':prefectures', $prefectures, PDO::PARAM_STR);
$stmt->bindValue(':adress', $adress, PDO::PARAM_STR);
$stmt->bindValue(':tell', $tell, PDO::PARAM_STR);


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
