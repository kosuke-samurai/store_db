<?php
session_start();
include("functions.php");
check_customer_session_id();

$user_id = (int)$_GET['id'];

$pdo = connect_to_db();


$sql = "SELECT DISTINCT chat_table_1.user_id,chat_table_1.event_id,chat_table_1.reserve_day,chat_table_1.name,chat_table_2.username FROM (SELECT user_id,username,event_id,reserve_day,name FROM users_table LEFT OUTER JOIN (SELECT event_id, user_id, reserve_day, reserve_message, name FROM reserve_table LEFT OUTER JOIN (SELECT event_id, name, store_reserve_table.open_day, store_id FROM store_reserve_table LEFT OUTER JOIN store_db ON store_reserve_table.store_id = store_db.id) AS event_store_table ON reserve_table.reserve_day = event_store_table.open_day AND reserve_table.store_id = event_store_table.store_id) AS reserve_confirm_table ON reserve_confirm_table.user_id = users_table.id) AS chat_table_1 INNER JOIN  (SELECT user_id,username,event_id,reserve_day,name FROM users_table LEFT OUTER JOIN (SELECT event_id, user_id, reserve_day, reserve_message, name FROM reserve_table LEFT OUTER JOIN (SELECT event_id, name, store_reserve_table.open_day, store_id FROM store_reserve_table LEFT OUTER JOIN store_db ON store_reserve_table.store_id = store_db.id) AS event_store_table ON reserve_table.reserve_day = event_store_table.open_day AND reserve_table.store_id = event_store_table.store_id) AS reserve_confirm_table ON reserve_confirm_table.user_id = users_table.id) AS chat_table_2 ON chat_table_1.event_id = chat_table_2.event_id";

$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $record) {

        //var_dump($result);
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
}


//友達リクエスト

$fiend_request_sql = "SELECT DISTINCT id, username, store_name, reserve_day, to_user FROM users_table INNER JOIN fiend_request_table ON users_table.id = fiend_request_table.my_id";
$fiend_request_stmt = $pdo->prepare($fiend_request_sql);

// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $fiend_request_stmt->execute();

    $fiend_request_result = $fiend_request_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fiend_request_result as $record) {

        //var_dump($fiend_request_result);
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
}

//友達
$fiend_sql = "SELECT DISTINCT friend_id, first_user_id, second_user_id, friend_table.created_at, id, username FROM friend_table INNER JOIN users_table ON friend_table.first_user_id=users_table.id OR friend_table.second_user_id= users_table.id;";
$fiend_stmt = $pdo->prepare($fiend_sql);

// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $fiend_stmt->execute();

    $fiend_result = $fiend_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($fiend_result as $record) {

        //var_dump($fiend_request_result);
    }
} catch (PDOException $e) {
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





    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">

                <h2 style="padding: 60px 0;">会った可能性があるユーザー</h2>

                <?php for ($i = 0; $i < count($result); $i++) : ?>
                    <?php if ($result[$i]["user_id"] === $user_id && $_SESSION['username'] !== $result[$i]["username"]) : ?>

                        <article style="padding: 20px 0;">

                            <div class="blog-post" data-acos="fadeInUp">

                                <div class="blog-post-body">
                                    <h3><?= $result[$i]["username"]; ?></h3>
                                    <p style="font-size: 16px; text-align: center; ">会ったお店：<?= $result[$i]["name"]; ?></p>

                                    <p style="font-size: 16px; text-align: center; ">会った日：<?= $result[$i]["reserve_day"]; ?></p>

                                    <form action="fiend_request_act.php" method="POST" class="form-horizontal" style="text-align: center; ">
                                        <input type="hidden" name="my_id" value="<?= $user_id; ?>">
                                        <input type="hidden" name="to_user" value="<?= $result[$i]["username"]; ?>">
                                        <input type="hidden" name="store_name" value="<?= $result[$i]["name"]; ?>">
                                        <input type="hidden" name="reserve_day" value="<?= $result[$i]["reserve_day"]; ?>">
                                        <div class="opening-button" style="text-align: center;">
                                            <button id="up" class="btn btn-primary">友達リクエストを送る</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </article>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">

                <h2 style="padding: 60px 0;">ともだちリクエストあり</h2>


                <?php for ($i = 0; $i < count($fiend_request_result); $i++) : ?>
                    <?php if ($fiend_request_result[$i]["to_user"] === $_SESSION['username']) : ?>


                        <article style="padding: 20px 0;">

                            <div class="blog-post" data-acos="fadeInUp">

                                <div class="blog-post-body">
                                    <h3><?= $fiend_request_result[$i]["username"]; ?></h3>
                                    <p style="font-size: 16px; text-align: center; ">会ったお店：<?= $fiend_request_result[$i]["store_name"]; ?></p>
                                    <p style="font-size: 16px; text-align: center; ">会った日：<?= $result[$i]["reserve_day"]; ?></p>

                                    <form action="fiend_act.php" method="POST" class="form-horizontal" style="text-align: center; ">
                                        <input type="hidden" name="first_user_id" value="<?= $_SESSION['user_id']; ?>">
                                        <input type="hidden" name="second_user_id" value="<?= $fiend_request_result[$i]["id"]; ?>">
                                        <div class="opening-button" style="text-align: center;">
                                            <button id="up" class="btn btn-primary">リクエストを承認する</button>
                                        </div>
                                    </form>
                                    </li>
                                    </ul>
                                    </li>
                                </div>
                            </div>

                        </article>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>
    </div>



    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">

                <h2 style="padding: 60px 0;">ともだち</h2>



                <?php for ($i = 0; $i < count($fiend_result); $i++) : ?>

                    <?php if (($fiend_result[$i]["first_user_id"] === $_SESSION['user_id'] || $fiend_result[$i]["second_user_id"] === $_SESSION['user_id']) && $fiend_result[$i]["username"] !== $_SESSION['username']) : ?>
                        <article style="padding: 20px 0;">

                            <div class="blog-post" data-acos="fadeInUp">

                                <div class="blog-post-body">
                                    <h3><?= $fiend_result[$i]["username"]; ?></h3>
                                    <p style="font-size: 16px; text-align: center; ">ともだちになった日：<?= $fiend_result[$i]["created_at"]; ?></p>
                                    <div style="text-align: center; ">
                                        <a href="friend_chat.php?id=<?php echo $fiend_result[$i]['friend_id']; ?>" class="">チャットを始める</a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endif; ?>
                <?php endfor; ?>

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

</body>

</html>