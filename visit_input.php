<?php
session_start();
include('functions.php');
check_premier_customer_session_id();

//var_dump($_GET);

$reserve_date = $_GET["date"];
$store_id = (int)$_GET['id'];
//var_dump($reserve_date);

//表示用
$pdo = connect_to_db();
$sql = "SELECT * FROM store_db";
$stmt = $pdo->prepare($sql);

try {

    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($result); $i++) {
        $store_id = (int)$_GET['id'];

        if ($result[$i]["id"] === $store_id) {
            $store_name = $result[$i]["name"];
        }
    }
    foreach ($result as $record) {

        //header('Content-type: ' . $result['pictype']);
        //echo $result['picture'];
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->
    <!-- <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">-->
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->

    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC:400,700,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--<link rel="stylesheet" href="css/store_input.css">-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>
</head>

<body class="home-page">
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

    <h2 class="decoration-stars">内容の確認</h2>

    <section class="menu" style="text-align: center;">
        <div class="container">
            <div class="row">
                <div class=margin-auto>

                    <article>
                        <div>
                            <div>

                                <form action="visit_create.php" method="POST">

                                    <input type="hidden" name="is_admin" value="0">
                                    <input type="hidden" name="is_deleted" value="0">
                                    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                                    <input type="hidden" name="store_id" value="<?= $store_id; ?>">
                                    <input type="hidden" name="reserve_day" value="<?= $reserve_date; ?>">
                                    <input type="hidden" name="is_reserve" value="0">
                                    <input type="hidden" name="reserve_message" value="null">



                                    <h3>ユーザー名</h3>
                                    <p class="price"><?= $_SESSION['username']; ?></p>


                                    <h3>行くお店</h3>
                                    <p class="price"><?= $store_name; ?></p>

                                    <h3>訪問日</span></h3>
                                    <p class="price"><?= $reserve_date; ?></p>


                                    <div class="opening-button ">
                                        <button id="up" class="btn btn-primary float-right">このお店に行く</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>


    </section>



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