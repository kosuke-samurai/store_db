<?php
//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();


session_start();
include("functions.php");
check_store_session_id();


$ivent_id = (int)$_GET['id'];

$pdo = connect_to_db();

$sql = "SELECT * FROM users_table INNER JOIN (SELECT event_id, reserve_id, user_id, reserve_day, reserve_message, is_reserve FROM reserve_table INNER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day AND reserve_table.store_id = store_reserve_table.store_id) AS reserve_confirm_table ON reserve_confirm_table.user_id = users_table.id;";

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






?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_read.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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
    <header class="store_header">
        <div class="header__wrapper">
            <div>
                <h1 class="tamari_family">たまりbar</h1>
                <p class="tamari_family">移住者のコミュニティーが生まれる</p>
                <p>管理者名:<?= $_SESSION['username']; ?></p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_manege.php">管理者ページに戻る</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['user_id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>

    </header>



    <main>

        <h2>来店予約の一覧</h2>

        <ul class="storelist">
            <?php for ($i = 0; $i < count($result); $i++) : ?>

                <?php if ($result[$i]["event_id"] === $ivent_id && $result[$i]["is_reserve"] === 1) : ?>
                    <div>
                        <div class="box">
                            <li>
                                <ul class="detail">
                                    <li>
                                        <h3>顧客情報</h3>
                                    </li>
                                    <li>
                                        <p>来店日：<?= $result[$i]["reserve_day"]; ?></p>
                                    </li>
                                    <li>
                                        <p>来店者：<?= $result[$i]["username"]; ?></p>
                                    </li>
                                    <li>
                                        <p>伝達事項：<?= $result[$i]["reserve_message"]; ?></p>
                                    </li>
                                </ul>
                            </li>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
            <ul>

    </main>