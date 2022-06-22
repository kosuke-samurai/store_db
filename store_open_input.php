<?php
session_start();
include('functions.php');
check_store_session_id();

//var_dump($_GET);

$open_day = $_GET["date"];
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
                <p>管理者名:<?= $_SESSION['username']; ?></p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_manege.php">管理者ページに戻る</a></li>
                <li class="nav-item"><a href="top.php">トップに戻る</a></li>
                <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>

    </header>




    <main>

        <h2>実施日の登録</h2>

        <form action="store_open_create.php" method="POST">

            <input type="text" name="is_admin" value="1">
            <input type="text" name="is_deleted" value="0">
            <input type="text" name="item_url" id="item_url" value="">
            <input type="text" name="username" value="<?= $_SESSION['username'] ?>">
            <input type="text" name="store_name" value="<?= $store_name ?>">
            <input type="date" name="open_day" value="<?= $open_day ?>">

            <dl class="input">

                <dt class="store_required">ユーザー名（管理用）</dt>
                <dd><?= $_SESSION['username'] ?></dd>

                <dt class="store_required">店名</dt>
                <dd><?= $store_name ?></dd>

                <dt class="store_required">予約可能日</dt>
                <dd><?= $open_day ?></dd>

                <dt class="store_required">実施時間(目安：2時間)</dt>
                <dd><input type="text" name="open_hour" class="info" required></dd>

                <dt class="store_required">秘密のアイテム</dt>
                <dd><input type="text" name="secret_item" class="info" required></dd>

                <dt class="store_required">秘密のアイテムの写真</dt>
                <dd><input type="file" onchange="uploadData()" id="files" name="Files[]" multiple required></dd>

                <dt class="store_required">秘密のアイテムについての説明</dt>
                <dd><textarea type="textarea" name="item_detail" class="info" required></textarea></dd>



                <div>
                    <button id="up" class="store_button">送信</button>
                </div>
            </dl>

        </form>

    </main>
    <footer>@高橋</footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-storage.js"></script>

    <script>
        // Import the functions you need from the SDKs you need
        //import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.2/firebase-app.js";
        // TODO: Add SDKs for Firebase products that you want to use
        // https://firebase.google.com/docs/web/setup#available-libraries

        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: "＜API-KEY＞",
            authDomain: "graduationprogram-45052.firebaseapp.com",
            projectId: "graduationprogram-45052",
            storageBucket: "graduationprogram-45052.appspot.com",
            messagingSenderId: "1072965734538",
            appId: "1:1072965734538:web:df27027e247be303ca5d73"
        };

        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);

        //"Images"=フォルダ名
        let storageRef = firebase.storage().ref("secret_item_img");


        function uploadData() {
            let file = document.getElementById('files').files[0];
            console.log(file);
            console.log(file.name);

            let thisRef = storageRef.child(file.name)

            //アップロードの処理！
            thisRef.put(file)
                .then(res => {
                    console.log(res)
                    console.log("アップロード成功");
                    alert("アップロード成功");
                    storageRef.child(file.name).getDownloadURL()
                        .then(url => {
                            const filesurl = document.getElementById("item_url")
                            //console.log(filesurl.value);
                            console.log(url);
                            filesurl.value = url;

                        }).catch(e => {
                            console.log(e);
                        })
                }).catch(e => {
                    console.log("Error " + e);

                }).then(
                    //URLダウンロード
                    // storageRef.child(file.name).getDownloadURL().then(url => {
                    //   const filesurl = document.getElementById("filesurl")
                    //   //console.log(filesurl.value);
                    //   console.log(url);
                    //   filesurl.value = url;

                    // }).catch(e => {
                    //   console.log(e);
                    // })
                );

        }
    </script>

</body>

</html>