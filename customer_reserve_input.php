<?php
session_start();
include('functions.php');
check_customer_session_id();

//var_dump($_GET);

$reserve_date = $_GET["date"];
$store_name = $_GET['store'];
//var_dump($reserve_date);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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

    <h2 class="tamari_family">予約内容の確認</h2>



    <main>
        <form action="customer_reserve_create.php" method="POST">

            <input type="hidden" name="is_admin" value="0">
            <input type="hidden" name="is_deleted" value="0">
            <input type="hidden" name="username" value="<?= $_SESSION['username']; ?>">
            <input type="hidden" name="store_name" value="<?= $store_name; ?>">
            <input type="hidden" name="reserve_day" value="<?= $reserve_date; ?>">

            <dl class="input">

                <dt class="required">ユーザー名</dt>
                <dd><?= $_SESSION['username']; ?></dd>

                <dt class="required">予約するお店</dt>
                <dd><?= $store_name; ?></dd>

                <dt class="required">予約日</dt>
                <dd><?= $reserve_date; ?></dd>



                <button id="up">この内容で予約する</button>

            </dl>

        </form>

    </main>
    <footer>@高橋、ぱくたそ</footer>

</body>

</html>