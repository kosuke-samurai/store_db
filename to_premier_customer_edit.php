<?php
//var_dump($_GET);
//exit();
session_start();
include("functions.php");
check_customer_session_id();


$id = $_SESSION['user_id'];

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


        </div>

    </header>

    <main>

        <h2>決済が完了しました。</br>有料プランをお楽しみください。</h2>
        <form action="customer_register_update.php" method="POST">

            <input type="text" name="is_premier" value="有料プラン">
            <input type="text" name="is_admin" value="<?= $record['is_admin'] ?>">
            <input type="text" name="is_deleted" value="<?= $record['is_deleted'] ?>">
            <input type="text" name="email" value="<?= $record['email'] ?>" required>
            <input type="text" name="postadress" value="<?= $record['postadress'] ?>">
            <input type="text" name="adress" value="<?= $record['adress'] ?>">
            <input type="text" name="tell" value="<?= $record['tell'] ?>">


            <div class="input">
                <button id="">有料プランでサービスに戻る</button>
            </div>

        </form>


    </main>
    <footer>@高橋</footer>

</body>

</html>