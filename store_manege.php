<?php
// DB接続
session_start();
include("functions.php");
check_store_session_id();

//var_dump($_SESSION['id']);
//exit();

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

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]["user_id"] === $_SESSION['user_id']) {
            $hoge_array[] = array($result[$i]["id"]);
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
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_read.css">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
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
                <li class="nav-item"><a href="store_input.php">店舗を登録する</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['user_id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>

    </header>





    <main>

        <h2>登録店舗の一覧</h2>

        <ul class="storelist">
            <?php for ($i = 0; $i < count($result); $i++) : ?>
                <?php if ($result[$i]["user_id"] === $_SESSION['user_id']) : ?>


                    <li class="box">
                        <h2><?= $result[$i]["name"]; ?> </h2>
                        <a href='store_calendar.php?id=<?php echo $result[$i]['id']; ?>' class="">実施日の登録</a>
                        <a href='store_manege_edit.php?id=<?php echo $result[$i]['id']; ?>' class="">編集する</a>
                        <a href='store_manege_delete.php?id=<?php echo $result[$i]['id']; ?>' onclick="return confirm('削除したデータは復元できません。本当に削除しますか？')" class="">削除</a>
                    </li>


                <?php endif; ?>
            <?php endfor; ?>
        </ul>

        <div class="store_manege_make">
            <div>
                <button type=“button” onclick="location.href='store_input.php'" class="store_button input">店舗を登録する</button>
            </div>
        </div>
        <div class="store_manege_make">
            <div>
                <button type=“button” onclick="location.href='store_logout.php'" class="store_button input">ログアウト</button>
            </div>
        </div>

    </main>

    <script>
        //const hogeArray = <?= json_encode($hoge_array) ?>;
        //console.log(hogeArray);
    </script>
</body>

</html>