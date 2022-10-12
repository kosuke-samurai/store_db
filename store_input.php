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

    <h2>店舗情報の入力</h2>

    <form action="store_create.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="filesurl" id="filesurl" value="">
      <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">

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
        <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','prefectures','adress');"></dd>

        <dt class="store_required">都道府県</dt>
        <dd>
          <select name="prefectures" class="info">
            <option value="" selected>都道府県</option>
            <option value="北海道">北海道</option>
            <option value="青森県">青森県</option>
            <option value="岩手県">岩手県</option>
            <option value="宮城県">宮城県</option>
            <option value="秋田県">秋田県</option>
            <option value="山形県">山形県</option>
            <option value="福島県">福島県</option>
            <option value="茨城県">茨城県</option>
            <option value="栃木県">栃木県</option>
            <option value="群馬県">群馬県</option>
            <option value="埼玉県">埼玉県</option>
            <option value="千葉県">千葉県</option>
            <option value="東京都">東京都</option>
            <option value="神奈川県">神奈川県</option>
            <option value="新潟県">新潟県</option>
            <option value="富山県">富山県</option>
            <option value="石川県">石川県</option>
            <option value="福井県">福井県</option>
            <option value="山梨県">山梨県</option>
            <option value="長野県">長野県</option>
            <option value="岐阜県">岐阜県</option>
            <option value="静岡県">静岡県</option>
            <option value="愛知県">愛知県</option>
            <option value="三重県">三重県</option>
            <option value="滋賀県">滋賀県</option>
            <option value="京都府">京都府</option>
            <option value="大阪府">大阪府</option>
            <option value="兵庫県">兵庫県</option>
            <option value="奈良県">奈良県</option>
            <option value="和歌山県">和歌山県</option>
            <option value="鳥取県">鳥取県</option>
            <option value="島根県">島根県</option>
            <option value="岡山県">岡山県</option>
            <option value="広島県">広島県</option>
            <option value="山口県">山口県</option>
            <option value="徳島県">徳島県</option>
            <option value="香川県">香川県</option>
            <option value="愛媛県">愛媛県</option>
            <option value="高知県">高知県</option>
            <option value="福岡県">福岡県</option>
            <option value="佐賀県">佐賀県</option>
            <option value="長崎県">長崎県</option>
            <option value="熊本県">熊本県</option>
            <option value="大分県">大分県</option>
            <option value="宮崎県">宮崎県</option>
            <option value="鹿児島県">鹿児島県</option>
            <option value="沖縄県">沖縄県</option>
          </select>
        </dd>

        <dt class="store_required">以降の住所</dt>
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