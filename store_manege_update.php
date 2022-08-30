<?php
session_start();
include("functions.php");
check_store_session_id();

$pdo = connect_to_db();
//var_dump($_POST);
//exit();

//$content = file_get_contents($_FILES["picture"]["tmp_name"]);
//var_dump($content);
//exit();

// DB接続
if (
  !isset($_POST["id"]) || $_POST["id"] == "" ||
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
$id = $_POST["id"];
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

//sql
$sql = 'UPDATE store_db SET name=:name, filesurl=:filesurl, category=:category, moodselect=:moodselect, moodtext=:moodtext, foodtext=:foodtext, message=:message, scene=:scene, budget=:budget, openday=:openday, postadress=:postadress, prefectures=:prefectures, adress=:adress, tell=:tell, username=:username, updated_at=now() WHERE id=:id';

$stmt = $pdo->prepare($sql);

// バインド変数を設定 ※基本変えない。バインド変数が多ければココで追加
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
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);


try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

header("Location:store_manege.php");
exit();
