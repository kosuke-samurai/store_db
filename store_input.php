<?php
//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();


session_start();
include("functions.php");
check_store_session_id();

//var_dump($_SESSION['username']);

?>

<!DOCTYPE html>
<html lang="ja">

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
        <li class="nav-item"><a href="index.php">トップに戻る</a></li>
        <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
        <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a></li>
      </ul>

    </div>

  </header>



  <main>

    <h2>店舗情報の入力</h2>

    <form action="store_create.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="filesurl" id="filesurl" value="">
      <input type="hidden" name="username" value="<?= $_SESSION['username']; ?>">

      <dl class="input">

        <dt class="store_required">店舗名</dt>
        <dd><input type="text" name="name" class="info" required></dd>

        <!--
        <dt class="required">店舗メイン写真</dt>
        <dd><input type="file" name="picture" class="" required></dd>
-->
        <dt class="store_required">店舗メイン写真</dt>
        <dd><input type="file" onchange="uploadData()" id="files" name="Files[]" multiple required></dd>






        <dt class="store_required">カテゴリー</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="category" value="居酒屋" class="category" required>居酒屋</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="バー" class="category" required>バー</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="カフェ" class="category" required>カフェ</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="その他" class="category" required>その他</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">メイン客層は</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="moodselect" value="20代ぐらいの人が多め" class="category" required>20代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="30代ぐらいの人が多め" class="category" required>30代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="40代ぐらいの人が多め" class="category" required>40代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="50代ぐらいの人が多め" class="category" required>50代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="60代以上ぐらいの人が多め" class="category" required>60代以上ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="お一人様が多め" class="category" required>お一人様が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="ファミリーが多め" class="category" required>ファミリーが多め</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">お店の雰囲気をアピールしてください</dt>
        <dd><textarea type="textarea" name="moodtext" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="store_required">提供メニューをアピールしてください</dt>
        <dd><textarea type="textarea" name="foodtext" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="store_required">利用移住者に贈るメッセージを記入してください</dt>
        <dd><textarea type="textarea" name="message" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="store_required">利用できる時間帯は</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="scene" value="お昼" class="category" required>お昼</label>
            </li>
            <li>
              <label><input type="radio" name="scene" value="夜" class="category" required>夜</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">予算</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="budget" value="~1000円" class="category" required>~1000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="1000円〜3000円" class="category" required>1000円〜3000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="3000円〜5000円" class="category" required>3000円〜5000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="5000円〜7000円" class="category" required>5000円〜7000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="7000円〜10000円" class="category" required>7000円〜10000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="10000円〜" class="category" required>10000円〜</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">お店の開業日</dt>
        <dd><input type="date" name="openday" class="info" required></dd>

        <dt class="store_required">郵便番号（7桁ハイフンなし）</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

        <dt class="store_required">住所</dt>
        <dd><input type="text" name="adress" class="info" required></dd>

        <dt class="store_required">電話番号</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required></dd>

        <div>
          <button id="up" class="store_button">送信</button>
        </div>
      </dl>



    </form>


  </main>
  <footer>@高橋、ぱくたそ</footer>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-storage.js"></script>

  <script>
    // Import the functions you need from the SDKs you need
    //import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.2/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const hogeArray = <?= json_encode(getenv('FIREBASE_KEY')); ?>;

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
    let storageRef = firebase.storage().ref("Store_main_img");


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
              const filesurl = document.getElementById("filesurl")
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

    /*
        storageRef.child(file.name).getDownloadURL().then(url => {
          console.log(url);
          filesurl.value = url;
        }).catch(e => {
          console.log(e);
        });
        */




    /*
        function download() {
          uploadData(() => {
            storageRef.child(file.name).getDownloadURL().then(url => {
              console.log(url);
              filesurl.value = url;
            }).catch(e => {
              console.log(e);
            });
          });
        }

        download();

        //const filesurl = document.getElementById("filesurl")
        //console.log(filesurl.value);

    */

    //画像の削除
    /*
    storageRef.child("bg_pattern4_yoru.png").delete().then(url => {
        alert("削除したよん");
    }).catch(e => {
        console.log(e);
    })
    */
  </script>
</body>

</html>