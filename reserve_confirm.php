<?php
session_start();
include("functions.php");
check_customer_session_id();

$store_name = $_GET["store"];
$reserve_day = $_GET["reserve_day"];


$pdo = connect_to_db();


// SQL作成&実行

$sql = "SELECT * FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day AND reserve_table.store_name = store_reserve_table.store_name";



$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $output = "";
    foreach ($result as $record) {
        if ($store_name === $record["store_name"] && $reserve_day === $record["reserve_day"]) {
            //var_dump($record["secret_item"]);

            $output .= "<h2 class=tamari_family>予約が成立しました</h2>
        <dl class=input>
            <dt>予約日</dt>
            <dd>{$record["open_day"]}</dd>
            <dt>お時間</dt>
            <dd>{$record["open_hour"]}</dd>
            <dt>秘密のアイテム</dt>
            <dd>{$record["secret_item"]}</dd>
            <dt>写真（秘密のアイテム）</dt>
            <dd><img src='{$record["item_url"]}' width='200' height='auto'></dd>
            <dt>秘密のアイテムについて</dt>
            <dd>{$record["item_detail"]}</dd>
        </dl>";
        }
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
    $output .= "<h2>予約できませんでした</h2>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="stylesheet" href="css/store_read.css">
    <title>たまりbar</title>
</head>

<body>

    <header>
        <div class="header__wrapper">
            <div>
                <h1 class="tamari_family">たまりbar</h1>
                <p class="tamari_family">移住者のコミュニティーが生まれる</p>
                <p>ユーザー名:<?= $_SESSION['username']; ?></p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_read.php">店舗一覧に戻る</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="customer_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="customer_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>
    </header>


    <main>
        <?= $output ?>
    </main>
    <footer>@高橋、ぱくたそ</footer>
</body>

</html>