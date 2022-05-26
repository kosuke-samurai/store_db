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

$sql = "SELECT * FROM store_db";



$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
  $status = $stmt->execute();
  //fetchAll() 関数でデータ自体を取得する．
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//できているか確認する際、テーブルを見やすくするコツ
//echo '<pre>';
//var_dump($result);
//echo '</pre>';
//exit();

foreach($result as $record){

//header('Content-type: ' . $result['pictype']);
//echo $result['picture'];
} 
}catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  //exit();
}




?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_read.css">
    <title>たまりbar</title>
</head>
<body>
<header>
    <h1>店舗情報の一覧</h1>
    <p>ご利用できるお店</p>
</header>

<main>
<ul class="storelist">      
<?php for($i = 0; $i < count($result); $i++): ?>

    <div>
        <div class="box">
    <li>
    <h2><?= $result[$i]["name"]; ?> </h2>
    </li>
    <li>
    <img src="image.php?id=<?= $result[$i]['id']; ?>" width="auto" height="300">
    </li>
    <li>              
       <ul class="detail">
           <li><h3>基本情報</h3></li>
            <li>
            <p>お店のジャンル：<span class="bold"><?= $result[$i]["category"]; ?></span></p>
            </li>
            <li>
            <p>客層：<span class="bold"><?= $result[$i]["moodselect"]; ?></span></p>
            </li>
            <li>
            <p>予算：<span class="bold"><?= $result[$i]["budget"]; ?></span></p>
            </li>
            <li>
            <p>住所：<span class="bold"><?= $result[$i]["adress"]; ?></span></p>
            </li>
        </ul>
    </li>
    <li>
    <a href="store_move.php?id=<?php echo $result[$i]['id']; ?>" class="button">詳細を見る</a>
    </li>
  </div>
    </div>
<?php endfor; ?> 
<ul> 
</main>
        

    
    
    
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"> </script>
<script>




</script>
</body>

</html>