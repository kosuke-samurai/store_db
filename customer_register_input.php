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

    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>
</head>

<body>
    <header>
        <div class="header__wrapper">
            <div class="tamari_family">
                <h1>たまりbar</h1>
                <p>移住者のコミュニティーが生まれる</p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="top.php">トップに戻る</a></li>
                <li class="nav-item"><a href="customer_login.php">ログイン</a></li>
            </ul>

        </div>
    </header>



    <main>

        <h2>すべての項目を記入して新規登録</h2>

        <form action="customer_register_create.php" method="POST">

            <input type="text" name="is_admin" value="0">
            <input type="text" name="is_deleted" value="0">

            <dl class="input">

                <dt class="required">ユーザー名</dt>
                <dd><input type="text" name="username" id="username" onchange="inputName(this)" class="info" required></dd>

                <div class="tooltip" id="namealert">すでに登録されているため使えません</div>


                <dt class="required">メールアドレス</dt>
                <dd><input type="email" name="email" id="email" onchange="inputMail(this)" class="info" required></dd>

                <div class="tooltip2" id="emailalert">すでに登録されているため使えません</div>

                <dt class="required">パスワード</dt>
                <dd><input type="text" name="password" class="info" required></dd>


                <dt class="required">郵便番号（7桁ハイフンなし）</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

                <dt class="required">住所</dt>
                <dd><input type="text" name="adress" class="info" required></dd>

                <dt class="required">電話番号</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required></dd>

                <div>
                    <button id="up">送信</button>
                </div>
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
                document.getElementById("up").style.background = "#3cb371";
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
                document.getElementById("up").style.background = "#3cb371";
            }


        }
    </script>

</body>

</html>