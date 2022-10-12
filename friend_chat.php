<?php
session_start();
include("functions.php");
check_customer_session_id();

$friend_id = (int)$_GET['id'];
$user_id = $_SESSION["user_id"];

$pdo = connect_to_db();

//判別

$sql = 'SELECT COUNT(*) FROM friend_table WHERE friend_id=:friend_id AND first_user_id<>:user_id AND second_user_id<>:user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':friend_id', $friend_id, PDO::PARAM_STR);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$chat_count = $stmt->fetchColumn();
//var_dump($chat_count);
//exit();


//判別2

$sql = 'SELECT COUNT(*) FROM friend_table WHERE friend_id=:friend_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':friend_id', $friend_id, PDO::PARAM_STR);


try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$friend_count = $stmt->fetchColumn();
//var_dump($friend_count);


if ($friend_count === 0) {
    exit("このページは閲覧できません");
} else if ($chat_count != 0) {
    exit("このページは閲覧できません");
} else {
    $sql = "SELECT tweet_id, friend_id, post_user_id, text, friend_chat_table.created_at, username FROM friend_chat_table INNER JOIN users_table ON friend_chat_table.post_user_id=users_table.id ORDER BY friend_chat_table.created_at ASC";
}


//表示系

//$sql = "SELECT tweet_id, friend_id, post_user_id, text, friend_chat_table.created_at, username FROM friend_chat_table INNER JOIN users_table ON friend_chat_table.post_user_id=users_table.id ORDER BY friend_chat_table.created_at ASC";
$stmt = $pdo->prepare($sql);


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

//お名前

$name_sql = "SELECT friend_id, first_user_id, second_user_id, id, username FROM friend_table INNER JOIN users_table ON friend_table.first_user_id=users_table.id OR friend_table.second_user_id=users_table.id";
$name_stmt = $pdo->prepare($name_sql);


try {
    $name_status = $name_stmt->execute();
    $name_result = $name_stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($name_result as $record) {

        //var_dump($result);
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

    <!--<link rel="stylesheet" href="css/store_read.css"> -->

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


    <main class="chat-container">
        <?php for ($i = 0; $i < count($name_result); $i++) : ?>
            <?php if ($name_result[$i]["friend_id"] === $friend_id && ($name_result[$i]["first_user_id"] !== $_SESSION['user_id'] || $name_result[$i]["second_user_id"] !== $_SESSION['user_id']) && $name_result[$i]["username"] !== $_SESSION['username']) : ?>
                <h2><?= $name_result[$i]["username"]; ?>とのチャット</h2>
            <?php endif; ?>
        <?php endfor; ?>



        <div id="area" class="contents scroll">
        </div>

        <div class="form-group">
            <form action="friend_chat_act.php" method="POST">
                <input type="hidden" name="friend_id" value="<?= $friend_id; ?>">
                <input type="hidden" name="post_user_id" value="<?= $_SESSION['user_id']; ?>">


                <div class="message-area-text">
                    <textarea id="inp" type="textarea" name="text" class="newMessage form-control" autocomplete="nope"></textarea>
                </div>
                <div class="opening-button" style="text-align: center;">
                    <button type="submit" class="btn btn-primary" onclick="pushMessage()">送信</button>
                </div>
            </form>
        </div>


    </main>


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


    <script>
        const result = <?= json_encode($result) ?>;
        console.log(result[0]);

        const myid = <?= json_encode($_SESSION['user_id']) ?>;
        console.log(myid);

        const friend_id = <?= json_encode($friend_id) ?>;
        console.log(friend_id);


        for (let i = 0; i < result.length; i++) {
            if (result[i]["friend_id"] === friend_id) {
                if (result[i]["post_user_id"] === myid) {
                    //console.log(result[i]["text"]);

                    const text = document.getElementById('area');

                    text.innerHTML += "<div class='speech-bubble'>" + "<div class='sb-bubble sb-line3-name sb-right'>" + result[i]["username"] + "</div>" + "</div>" + "<div class='speech-bubble'>" + " <div class='sb-bubble sb-line3 sb-right'> " + result[i]["text"] + "</div>" + "</div>" + "<div class='speech-bubble'>" + "<div class='sb-bubble sb-line3-name sb-right'>" + result[i]["created_at"] + "</div>" + "</div>";

                } else {
                    const text = document.getElementById('area');
                    text.innerHTML += "<div class='speech-bubble'>" + "<div class='sb-bubble sb-line3-name sb-left'>" + result[i]["username"] + "</div>" + "</div>" + "<div class='speech-bubble'>" + " <div class='sb-bubble sb-line3 sb-left'> " + result[i]["text"] + "</div>" + "</div>" + "<div class='speech-bubble'>" + "<div class='sb-bubble sb-line3-name sb-left'>" + result[i]["created_at"] + "</div>" + "</div>";
                }
            }
        };
    </script>


</body>

</html>