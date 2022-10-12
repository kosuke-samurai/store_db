<?php

//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();

session_start();
include('functions.php');
check_store_session_id();

//var_dump($_GET);

$open_day = $_GET["date"];
$store_id = (int)$_GET['id'];
//var_dump($open_day);

//表示名用
$pdo = connect_to_db();
$sql = "SELECT * FROM store_db";
$stmt = $pdo->prepare($sql);

try {
    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]["id"] === $store_id) {
            $store_name = $result[$i]["name"];
        }
    }

    foreach ($result as $record) {

        //header('Content-type: ' . $result['pictype']);
        //echo $result['picture'];
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    //exit();
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
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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
                <p>管理者名:<?= $_SESSION['username']; ?></p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_manege.php">管理者ページに戻る</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['user_id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>

    </header>




    <main>

        <h2>実施日の登録</h2>

        <form action="store_open_create.php" method="POST">


            <input type="hidden" name="item_url" id="item_url" value="">
            <input type="hidden" name="owner_id" value="<?= $_SESSION['user_id']; ?>">
            <input type="hidden" name="store_id" value="<?= $store_id; ?>"><br />
            <input type="hidden" name="open_day" value="<?= $open_day; ?>">
            <input type="hidden" name="is_deleted" value="0">

            <dl class="input">

                <dt class="store_required">ユーザー名（管理用）</dt>
                <dd><?= $_SESSION['username']; ?></dd>

                <dt class="store_required">店名</dt>
                <dd><?= $store_name; ?></dd>

                <dt class="store_required">予約可能日</dt>
                <dd><?= $open_day; ?></dd>

                <dt class="store_required">実施時間(目安：2時間)</dt>
                <dd><input type="time" name="start_hour" step="900" list="data-list" class="" required>~<input type="time" name="close_hour" step="900" list="data-list" class="" required></dd>
                <datalist id="data-list">
                    <option value="00:00"></option>
                    <option value="00:15"></option>
                    <option value="00:30"></option>
                    <option value="00:45"></option>

                    <option value="01:00"></option>
                    <option value="01:15"></option>
                    <option value="01:30"></option>
                    <option value="01:45"></option>

                    <option value="02:00"></option>
                    <option value="02:15"></option>
                    <option value="02:30"></option>
                    <option value="02:45"></option>

                    <option value="02:00"></option>
                    <option value="02:15"></option>
                    <option value="02:30"></option>
                    <option value="02:45"></option>

                    <option value="03:00"></option>
                    <option value="03:15"></option>
                    <option value="03:30"></option>
                    <option value="03:45"></option>

                    <option value="04:00"></option>
                    <option value="04:15"></option>
                    <option value="04:30"></option>
                    <option value="04:45"></option>

                    <option value="05:00"></option>
                    <option value="05:15"></option>
                    <option value="05:30"></option>
                    <option value="05:45"></option>

                    <option value="06:00"></option>
                    <option value="06:15"></option>
                    <option value="06:30"></option>
                    <option value="06:45"></option>

                    <option value="07:00"></option>
                    <option value="07:15"></option>
                    <option value="07:30"></option>
                    <option value="07:45"></option>

                    <option value="08:00"></option>
                    <option value="08:15"></option>
                    <option value="08:30"></option>
                    <option value="08:45"></option>

                    <option value="09:00"></option>
                    <option value="09:15"></option>
                    <option value="09:30"></option>
                    <option value="09:45"></option>

                    <option value="10:00"></option>
                    <option value="10:15"></option>
                    <option value="10:30"></option>
                    <option value="10:45"></option>

                    <option value="11:00"></option>
                    <option value="11:15"></option>
                    <option value="11:30"></option>
                    <option value="11:45"></option>

                    <option value="12:00"></option>
                    <option value="12:15"></option>
                    <option value="12:30"></option>
                    <option value="12:45"></option>

                    <option value="13:00"></option>
                    <option value="13:15"></option>
                    <option value="13:30"></option>
                    <option value="13:45"></option>


                    <option value="14:00"></option>
                    <option value="14:15"></option>
                    <option value="14:30"></option>
                    <option value="14:45"></option>

                    <option value="15:00"></option>
                    <option value="15:15"></option>
                    <option value="15:30"></option>
                    <option value="15:45"></option>

                    <option value="16:00"></option>
                    <option value="16:15"></option>
                    <option value="16:30"></option>
                    <option value="16:45"></option>

                    <option value="17:00"></option>
                    <option value="17:15"></option>
                    <option value="17:30"></option>
                    <option value="17:45"></option>

                    <option value="18:00"></option>
                    <option value="18:15"></option>
                    <option value="18:30"></option>
                    <option value="18:45"></option>

                    <option value="19:00"></option>
                    <option value="19:15"></option>
                    <option value="19:30"></option>
                    <option value="19:45"></option>

                    <option value="20:00"></option>
                    <option value="20:15"></option>
                    <option value="20:30"></option>
                    <option value="20:45"></option>

                    <option value="21:00"></option>
                    <option value="21:15"></option>
                    <option value="21:30"></option>
                    <option value="21:45"></option>

                    <option value="22:00"></option>
                    <option value="22:15"></option>
                    <option value="22:30"></option>
                    <option value="22:45"></option>

                    <option value="23:00"></option>
                    <option value="23:15"></option>
                    <option value="23:30"></option>
                    <option value="23:45"></option>
                </datalist>

                <dt class="store_required">利用可能人数</dt>
                <dd><input type="number" name="customer_number" class="info" required></dd>

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

        const hogeArray = <?= json_encode(getenv('FIREBASE_KEY')); ?>;
        //console.log(hogeArray);

        // Your web app's Firebase configuration
        const firebaseConfig = {
            apiKey: hogeArray,
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