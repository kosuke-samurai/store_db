<?php

session_start();
include("functions.php");
check_customer_session_id();



$store_id = (int)$_GET["id"];
$reserve_day = $_GET["reserve_day"];


$pdo = connect_to_db();


// SQL作成&実行

$sql = "SELECT * FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day AND reserve_table.store_id = store_reserve_table.store_id";



$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = "";
    foreach ($result as $record) {
        if ($store_id === $record["store_id"] && $reserve_day === $record["reserve_day"] && $_SESSION["user_id"] === $record["user_id"]) {
            //var_dump($record["secret_item"]);

            $output .= "<h2>お待ちしております</h2>
        <div class=container>
        <div class=row>
            <div class=margin-auto>

             <article style=padding: 200px 0;>
             <div>
             <div>

            <h3>秘密のアイテム</h3>
            <p>{$record["secret_item"]}</p>

            <h3>写真（秘密のアイテム）</h3>
            <img src='{$record["item_url"]}' width='200' height='auto'>

            <h3>ご利用日 </h3>
            <p>{$record["open_day"]}</p>

            <h3>お時間</h3>
            <p>{$record["start_hour"]}~{$record["close_hour"]}</p>
            

        </div>
        </div>
        </article>
        </div>
        </div>
        </div>
        ";
        }
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
    $output .= "<h2>利用登録を再度お試しください</h2>";
}

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

    <!--<link rel="stylesheet" href="css/store_read.css">-->
    <title>たまりbar</title>
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


    <div style="text-align: center;">
        <?= $output ?>
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

</body>

</html>