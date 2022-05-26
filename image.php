<?php

// DB接続
// 各種項目設定 ※基本変えない。dbnameを変えるだけ
$dbn ='mysql:dbname=gs_graduation_program;charset=utf8mb4;port=3306;host=localhost';
$user = 'root';
$pwd = '';


try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// （「dbError:...」が表示されたらdb接続でエラーが発生していることがわかる）


// SQL作成&実行
//$sql = "SELECT todo, deadline FROM todo_table ORDER BY deadline DESC";
$sql = "SELECT id, name, picture, pictype, picsize, category, moodselect, budget, adress FROM store_db WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);

  $status = $stmt->execute();

  $result = $stmt->fetch(PDO::FETCH_ASSOC);



    header('Content-type: ' . $result['pictype']);
    echo $result['picture'];





?>