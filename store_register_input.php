<?php
session_start();
include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行

$sql = "SELECT * FROM users_table";

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
    $username = [];
    foreach ($result as $record) {

        //header('Content-type: ' . $result['pictype']);
        //echo $result['picture'];
        $username[] = array($record);
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>
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
                <li class="nav-item">オーナーさま管理者ページを作成します</li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>

            </ul>

        </div>

    </header>




    <main>

        <h2>店舗オーナー（管理者）さま新規登録</h2>

        <form action="store_register_create.php" method="POST">

            <input type="hidden" name="is_admin" value="1">
            <input type="hidden" name="is_deleted" value="0">

            <dl class="input">

                <dt class="store_required">ユーザー名（管理用）</dt>
                <dd><input type="text" name="username" id="username" onchange="inputName(this)" class="info" required></dd>

                <div class="tooltip" id="namealert">すでに登録されているため使えません</div>

                <dt class="store_required">メールアドレス</dt>
                <dd><input type="email" name="email" id="email" onchange="inputMail(this)" class="info" required></dd>

                <div class="tooltip2" id="emailalert">すでに登録されているため使えません</div>

                <dt class="store_required">パスワード</dt>
                <dd><input type="text" name="password" class="info" required></dd>


                <dt class="store_required">郵便番号（7桁ハイフンなし）</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

                <dt class="store_required">住所</dt>
                <dd><input type="text" name="adress" class="info" required></dd>

                <dt class="store_required">電話番号</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required></dd>


                <button id="up" class="store_button">送信</button>
            </dl>



        </form>



    </main>
    <footer>@高橋</footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        const hogeArray = <?= json_encode($username) ?>;
        console.log(hogeArray);
        console.log(hogeArray[0][0].username);

        let username = document.getElementById("username");
        let namealert = document.getElementById("namealert");



        function inputName($this) {
            //console.log($this.value);
            const count = {
                ng: 0,
            };
            for (i = 0; i < hogeArray.length; i++) {
                if (hogeArray[i][0].username != ($this.value)) {
                    console.log("OK");
                } else {
                    console.log("重複");
                    count["ng"]++;
                }
            }

            console.log(count["ng"]);

            if (count["ng"] > 0) {
                namealert.style.display = 'inline-block';
                document.getElementById("up").disabled = true;
                document.getElementById("up").style.background = "#d0d0d0";
            } else if (count["ng"] === 0) {
                namealert.style.display = 'none';
                document.getElementById("up").disabled = false;
                document.getElementById("up").style.background = "#3cb1b3";
            }
        }

        let email = document.getElementById("email");
        let emailalert = document.getElementById("emailalert");


        function inputMail($this) {

            const count = {
                ng: 0,
            };
            for (i = 0; i < hogeArray.length; i++) {
                if (hogeArray[i][0].email != ($this.value)) {
                    console.log("OK");
                } else {
                    console.log("重複");
                    count["ng"]++;
                }
            }

            console.log(count["ng"]);

            if (count["ng"] > 0) {
                emailalert.style.display = 'inline-block';
                document.getElementById("up").disabled = true;
                document.getElementById("up").style.background = "#d0d0d0";
            } else if (count["ng"] === 0) {
                emailalert.style.display = 'none';
                document.getElementById("up").disabled = false;
                document.getElementById("up").style.background = "#3cb1b3";
            }


        }
    </script>
</body>

</html>