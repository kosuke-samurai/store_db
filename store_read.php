<?php
session_start();
include("functions.php");
check_customer_session_id();

//var_dump($_SESSION['username']);
//var_dump($_SESSION['adress']);
//var_dump($_SESSION['id']);


$pdo = connect_to_db();


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

  foreach ($result as $record) {

    //header('Content-type: ' . $result['pictype']);
    //echo $result['picture'];
  }
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  //exit();
}

//緯度経度抽出

$idokeido = [];

for ($i = 0; $i < count($result); $i++) {

  mb_language("Japanese"); //文字コードの設定
  mb_internal_encoding("UTF-8");

  $address = $result[$i]["adress"];
  $apikey = "＜API-KEY＞";
  $address = urlencode($address);
  $url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address;
  $contents = file_get_contents($url);
  $contents = json_decode($contents);
  $Coordinates = $contents->Feature[0]->Geometry->Coordinates;
  $geo = explode(",", $Coordinates);
  $lon = $geo[0];
  $lat = $geo[1];
  //echo "緯度：" . $lat . " 経度：" . $lon;

  //[]使ったらできた！
  $idokeido[] =  array($result[$i]["name"], $lat, $lon);
}

//var_dump($idokeido);
//exit();


//お客の緯度経度抽出※

mb_language("Japanese"); //文字コードの設定
mb_internal_encoding("UTF-8");
//住所（梅田スカイビル）を入れて緯度経度を求める。
$address = $_SESSION['adress'];
$apikey = "＜API-KEY＞";
$address = urlencode($address);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon = $geo[0];
$lat = $geo[1];
//echo "緯度：" . $lat . " 経度：" . $lon;
$customer_idokeido =  array($lat, $lon);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/store_read.css">
  <style>
    #map {
      width: 100%;
      height: 300px;

    }
  </style>
  <title>たまりbar</title>
</head>

<body>
  <header>
    <h1>店舗情報の一覧</h1>
    <p><?= $_SESSION['username']; ?> さま周辺のお店(<a href="customer_logout.php">ログアウトする</a>)(<a href="customer_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a>)</p>

  </header>

  <div id="map"></div>
  <main>
    <ul class="storelist">
      <?php for ($i = 0; $i < count($result); $i++) : ?>

        <div>
          <div class="box">
            <li>
              <h2><?= $result[$i]["name"]; ?> </h2>
            </li>
            <li>
              <img src="<?= $result[$i]['filesurl']; ?>" width="auto" height="300">
            </li>
            <li>
              <ul class="detail">
                <li>
                  <h3>基本情報</h3>
                </li>
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


  <script src="https://maps.googleapis.com/maps/api/js?key=＜API-KEY＞"></script>
  <script>
    const idokeido = <?= json_encode($idokeido) ?>;
    console.log(idokeido);
    console.log(idokeido[0][1]);
    const customer_idokeido = <?= json_encode($customer_idokeido) ?>;



    var map;
    var marker = [];
    var infoWindow = [];

    function initMap() {
      // 地図の作成
      var mapLatLng = new google.maps.LatLng(customer_idokeido[0], customer_idokeido[1]); // 緯度経度のデータ作成
      map = new google.maps.Map(document.getElementById('map'), { // #sampleに地図を埋め込む
        center: mapLatLng, // 地図の中心を指定
        zoom: 13 // 地図のズームを指定
      });

      // マーカー毎の処理
      for (var i = 0; i < idokeido.length; i++) {
        console.log(idokeido[i][1]);
        markerLatLng = new google.maps.LatLng(idokeido[i][1], idokeido[i][2]); // 緯度経度のデータ作成

        marker[i] = new google.maps.Marker({ // マーカーの追加
          position: markerLatLng, // マーカーを立てる位置を指定
          map: map // マーカーを立てる地図を指定
        });

        infoWindow[i] = new google.maps.InfoWindow({ // 吹き出しの追加
          content: '<div>' + idokeido[i][0] + '</div>' // 吹き出しに表示する内容
        });
        markerEvent(i);

      }

      function markerEvent(i) {
        marker[i].addListener('click', function() { // マーカーをクリックしたとき
          infoWindow[i].open(map, marker[i]); // 吹き出しの表示
        });
      }

    }






    window.onload = function() {
      initMap();
    };
  </script>




  </main>


</body>

</html>