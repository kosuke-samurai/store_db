<?php
session_start();
include("functions.php");
check_store_session_id();

// DB接続
//var_dump($_GET);
//exit();

$id = $_GET["id"];

$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($record);
//exit();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
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
                <p>管理者ページ</p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_manege.php">管理者ページに戻る</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>

            </ul>

        </div>

    </header>


    <h2>管理者情報の編集</h2>


    <main>
        <form action="store_register_update.php" method="POST">

            <input type="hidden" name="is_admin" value="<?= $record['is_admin'] ?>">
            <input type="hidden" name="is_deleted" value="<?= $record['is_deleted'] ?>">

            <dl class="input">

                <dt class="store_required">ユーザー名（管理用）</dt>
                <dd>ユーザー名は変更できません</dd>

                <dt class="store_required">パスワード</dt>
                <dd>パスワードは変更できません</dd>

                <dt class="store_required">メールアドレス</dt>
                <dd><input type="text" name="email" class="info" value="<?= $record['email'] ?>" required></dd>

                <dt class="store_required">郵便番号（7桁ハイフンなし）</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" value="<?= $record['postadress'] ?>" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

                <dt class="store_required">住所</dt>
                <dd><input type="text" name="adress" class="info" value="<?= $record['adress'] ?>" required></dd>

                <dt class="store_required">電話番号</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" value="<?= $record['tell'] ?>" required></dd>


                <div>
                    <button id="up" class="store_button">情報を更新する</button>
                </div>

            </dl>
        </form>
        <div class="store_manege_make">
            <div class="store_button">
                <a href='store_register_delete.php?id=<?= $_SESSION['id']; ?>' onclick="return confirm('削除したデータは復元できません。本当に削除しますか？')" class="store_button">ユーザー情報を削除する</a>
            </div>
        </div>

    </main>
    <footer>@高橋</footer>

</body>

</html>