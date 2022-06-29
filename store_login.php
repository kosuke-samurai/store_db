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
                <li class="nav-item">管理者情報でログインしてください</li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
            </ul>

        </div>

    </header>





    <main>

        <h2>管理者ログイン</h2>

        <form action="store_login_act.php" method="POST">

            <input type="hidden" name="is_admin" value="1">

            <dl class="input">

                <dt class="store_required">ユーザー名</dt>
                <dd><input type="text" name="username" class="info" required></dd>

                <dt class="store_required">パスワード</dt>
                <dd><input type="text" name="password" class="info" required></dd>

                <button class="store_button">ログイン</button>
                </div>
            </dl>

        </form>
        <button type=“button” onclick="location.href='store_register_input.php'" class="store_button input">新規登録</button>



    </main>
    <footer>@高橋</footer>

</body>

</html>