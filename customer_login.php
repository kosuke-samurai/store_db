<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_input.css">
    <title>たまりbar</title>
</head>

<body>
    <header>
        <h1>移住者さまログインページ</h1>
        <p>すべての項目をご記入ください</p>
    </header>

    <main>
        <form action="customer_login_act.php" method="POST">

            <input type="text" name="is_admin" value="0">

            <dl class="input">

                <dt class="required">ユーザー名</dt>
                <dd><input type="text" name="username" class="info" required></dd>

                <dt class="required">パスワード</dt>
                <dd><input type="text" name="password" class="info" required></dd>

                <button>ログイン</button>
                </div>
            </dl>
        </form>
        <button type=“button” onclick="location.href='customer_register_input.php'" class="register_button">新規登録</button>



    </main>
    <footer>@高橋</footer>

</body>

</html>