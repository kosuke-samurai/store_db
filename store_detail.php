<?php
//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();

//session_start();
//include("functions.php");
//check_customer_session_id();

//mb_language("Japanese"); //文字コードの設定
//mb_internal_encoding("UTF-8");

$address = "{$detail["prefectures"]}{$detail["adress"]}";
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
?>

<!DOCTYPE html>
<html lang="en">

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

    <!--<link rel="stylesheet" href="css/store_detail.css">-->
    <style>
        #map-canvas {
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
                            <a class="nav-link" href="store_read.php">店舗一覧に戻る</a>
                        </li>
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



    <h2 class="tamari_family">店舗情報の詳細</h2>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">

                <article>
                    <div style="text-align: center">
                        <img src="<?= $detail['filesurl']; ?>" class="store-photo">
                    </div>
                    <div class="blog-post" data-acos="fadeInUp">
                        <div class="blog-post-header">
                            <p class="categories store-categories"><?php echo $detail["category"]; ?></p>
                            <h2 style="color: #AF2045;"><?php echo $detail['name'] ?></h2>

                            <div class="row">
                                <div class="col-sm-6 blog-post-author">
                                    <?php echo $detail["moodselect"]; ?>
                                </div>
                                <div class="col-sm-6 blog-post-date">
                                    <?php echo $detail["budget"]; ?>
                                </div>
                            </div>
                        </div>

                        <div class="blog-post-header">
                            <div class="row">
                                <div class="col-sm-6 blog-post-author">
                                    〒<?php echo $detail["postadress"]; ?>
                                </div>
                                <div class="col-sm-6 blog-post-date">
                                    <?php echo $detail["prefectures"]; ?><?php echo $detail["adress"]; ?>
                                </div>
                            </div>
                        </div>

                        <div class="blog-post-header">
                            <div class="row">
                                <div class="col-sm-6 blog-post-author">
                                    ☎：<?php echo $detail["tell"]; ?>
                                </div>
                                <div class="col-sm-6 blog-post-date">
                                    開業日：<?php echo $detail["openday"]; ?></div>
                            </div>
                        </div>

                        <div class="blog-post-body">
                            <h3>移住者の皆さんへメッセージ</h3>
                            <p><?php echo $detail["message"]; ?></p>

                            <h3>店内の雰囲気</h3>
                            <p><?php echo $detail["moodtext"]; ?></p>

                            <h3>メニュー</h3>
                            <p><?php echo $detail["foodtext"]; ?></p>

                        </div>
                    </div>
                </article>

            </div>
        </div>
    </div>


    </ul>
    <h1>アクセス</h1>
    <div id="map-canvas"></div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">



                <div class="opening-button" style="text-align: center;">
                    <a href="reserve.php?id=<?php echo $detail['id'] ?>" class="btn btn-primary">「待ち人」として予約する(600円/1回)</a>
                </div>
                <div class="opening-button" style="text-align: center;">
                    <a href="visit.php?id=<?php echo $detail['id'] ?>" class="btn btn-primary">待ち人を探しに行く(無料)</a>
                </div>

                <div class="opening-button" style="text-align: center;">
                    <a href="store_read.php" class="btn btn-primary">リストに戻る</a>
                </div>


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
        const keido = <?= json_encode($lon) ?>;
        console.log(keido);
        const ido = <?= json_encode($lat) ?>;
        console.log(ido);

        function makeMap(lat, lng) {
            var canvas = document.getElementById('map-canvas'); // 地図を表示する要素を取得

            var latlng = new google.maps.LatLng(lat, lng); // 中心の位置（緯度、経度）

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
            });

            var mapOptions = { // マップのオプション
                zoom: 17,
                center: latlng,
            };

            var map = new google.maps.Map(canvas, mapOptions); //作成
            //return map;

            //ピン建てる
            var markerOptions = {
                map: map,
                position: latlng,
            };
            var marker = new google.maps.Marker(markerOptions);
        }

        //ページのロードが完了したら地図を読み込む
        window.onload = function() {
            makeMap(ido, keido);
        };
    </script>
</body>

</html>