<?php
session_start();
include("functions.php");
check_customer_session_id();

//var_dump($_SESSION['username']);
//var_dump($_SESSION['adress']);
//var_dump($_SESSION['id']);

//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();

//var_dump($_ENV['YAHOO_MAP_KEY']);


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

  //mb_language("Japanese"); //文字コードの設定
  //mb_internal_encoding("UTF-8");

  $address = "{$result[$i]["prefectures"]}{$result[$i]["adress"]}";
  $apikey = getenv('YAHOO_MAP_KEY');
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

//mb_language("Japanese"); //文字コードの設定
//mb_internal_encoding("UTF-8");

//住所（梅田スカイビル）を入れて緯度経度を求める。
$address = "{$_SESSION['prefectures']}{$_SESSION['adress']}";
$apikey = getenv('YAHOO_MAP_KEY');
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
  <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->

  <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC:400,700,900&amp;subset=latin-ext" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/animate.css">
  <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
  <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">

  <!--<link rel="stylesheet" href="css/store_read.css">-->
  <style>
    #map {
      width: 100%;
      height: 300px;

    }
  </style>
  <title>たまりBAR</title>

  <meta property="og:site_name" content="たまりBAR">
  <meta property="og:title" content="たまりBAR">
  <meta property="og:description" content="「秘密のアイテム」で移住者にコミュニティーを。地方圏移住を促す新たな飲食店予約サービス。">
  <meta property="og:url" content="https://tamaribar.herokuapp.com">
  <meta property="og:type" content="article">
  <meta property="og:image" content="https://tamaribar.herokuapp.com/img/tamaribar_ogp.png">
  <meta name="twitter:card" content="summary_large_image">

</head>

<body>



  <header>
    <div class="container d-none d-sm-block logo" style="text-align: center;">
      <img class="img-fluid" src="images/logos/tamaribar_pc_logo.png" alt="">
      <p class="sub-title">ユーザー名:<?= $_SESSION['username']; ?>さま</p>
    </div>

    <div class="container my-2 my-md-4">
      <nav class="navbar navbar-expand-sm navbar-light">
        <a class="navbar-brand d-sm-none" href="index.php"><img class="img-fluid" src="images/logos/tamaribar_logo.png" alt=""></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-sm-center" id="main-navbar">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="customer_mypage.php?id=<?= $_SESSION['user_id']; ?>">ともだち</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php">トップに戻る</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="customer_logout.php">ログアウトする</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="customer_register_edit.php?id=<?= $_SESSION['user_id']; ?>">ユーザー情報の編集</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>


  <h2 class="tamari_family"><?= $_SESSION['username']; ?> さま周辺のお店</h2>
  <div id="map"></div>



  <h2 class="tamari_family"><?= $_SESSION['username']; ?> さま周辺のお店の一覧</h2>

  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1 col-md-12">


        <?php for ($i = 0; $i < count($result); $i++) : ?>

          <?php if ($result[$i]["prefectures"] === $_SESSION['prefectures']) : ?>
            <article>
              <div style="text-align: center">
                <img src="<?= $result[$i]['filesurl']; ?>" class="store-photo">
              </div>

              <div class="blog-post" data-acos="fadeInUp">
                <div class="blog-post-header">
                  <p class="categories store-categories"><?= $result[$i]["category"]; ?></p>
                  <h2>
                    <a href="store_move.php?id=<?php echo $result[$i]['id']; ?>"><?= $result[$i]["name"]; ?> </a>
                  </h2>

                  <div class="row">
                    <div class="col-sm-6 blog-post-author">
                      <?= $result[$i]["moodselect"]; ?>
                    </div>
                    <div class="col-sm-6 blog-post-date">
                      <?= $result[$i]["budget"]; ?>
                    </div>
                  </div>
                </div>

                <div class="blog-post-body">
                  <h3>移住者の皆さんへメッセージ</h3>
                  <p><?= $result[$i]["message"]; ?></p>
                  <br>
                  <p class="adress">住所: <?= $result[$i]["prefectures"]; ?><?= $result[$i]["adress"]; ?></p>
                </div>
              </div>
            </article>
          <?php endif; ?>
        <?php endfor; ?>
        <ul>
      </div>
    </div>
  </div>

  <footer class="page-footer">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="divider"></div>
          <div class="text-center">
            <a href="index.html"><img src="images/logos/tamaribar_logo.png" alt="" class="logo"></a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <p>© タカハシ</p>
      </div>
    </div>
    </div>
  </footer>




  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="javascript/acos.jquery.js"></script>
  <script src="javascript/script.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=<?= getenv('GOOGLE_MAP_KEY'); ?>"></script>
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


</body>

</html>