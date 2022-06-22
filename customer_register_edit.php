<?php
//var_dump($_GET);
//exit();
session_start();
include("functions.php");
check_customer_session_id();


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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
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
                <li class="nav-item"><a href="customer_logout.php">ログアウトする</a></li>

            </ul>

        </div>

    </header>

    <main>

        <h2>ユーザー情報の編集</h2>
        <form action="customer_register_update.php" method="POST">

            <input type="text" name="is_admin" value="<?= $record['is_admin'] ?>">
            <input type="text" name="is_deleted" value="<?= $record['is_deleted'] ?>">


            <dl class="input">

                <dt class="required">ユーザー名（管理用）</dt>
                <dd>ユーザー名は変更できません</dd>

                <dt class="required">パスワード</dt>
                <dd>パスワードは変更できません</dd>

                <dt class="required">メールアドレス</dt>
                <dd><input type="text" name="email" class="info" value="<?= $record['email'] ?>" required></dd>

                <dt class=" required">郵便番号（7桁ハイフンなし）</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" value="<?= $record['postadress'] ?>" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

                <dt class="required">住所</dt>
                <dd><input type="text" name="adress" class="info" value="<?= $record['adress'] ?>" required></dd>

                <dt class="required">電話番号</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" value="<?= $record['tell'] ?>" required></dd>


                <button id="">情報を更新する</button>

            </dl>
        </form>
        <div class="store_manege_make">
            <div class="button">
                <a href='customer_register_delete.php?id=<?= $_SESSION['id']; ?>' onclick="return confirm('削除したデータは復元できません。本当に削除しますか？')" class="button">ユーザー情報を削除する</a>
            </div>
        </div>

    </main>
    <footer>@高橋</footer>

</body>

</html>