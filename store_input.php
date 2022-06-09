<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/store_input.css">
  <title>たまりbar</title>
</head>

<body>
  <header>
    <h1>店舗情報の入力</h1>
    <p>すべての項目をご記入ください</p>
  </header>

  <main>
    <form action="store_create.php" method="POST" enctype="multipart/form-data">

      <input type="text" name="filesurl" id="filesurl" value="">

      <dl class="input">

        <dt class="required">ユーザー名（管理用）</dt>
        <dd><input type="text" name="username" class="info" required></dd>

        <dt class="required">店舗名</dt>
        <dd><input type="text" name="name" class="info" required></dd>

        <!--
        <dt class="required">店舗メイン写真</dt>
        <dd><input type="file" name="picture" class="" required></dd>
-->
        <dt class="required">店舗メイン写真</dt>
        <dd><input type="file" onchange="uploadData()" id="files" name="Files[]" multiple required></dd>






        <dt class="required">カテゴリー</dt>
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

        <dt class="required">メイン客層は</dt>
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

        <dt class="required">お店の雰囲気をアピールしてください</dt>
        <dd><textarea type="textarea" name="moodtext" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="required">提供メニューをアピールしてください</dt>
        <dd><textarea type="textarea" name="foodtext" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="required">利用移住者に贈るメッセージを記入してください</dt>
        <dd><textarea type="textarea" name="message" cols="30" rows="5" class="info" required></textarea></dd>

        <dt class="required">利用できる時間帯は</dt>
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

        <dt class="required">予算</dt>
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

        <dt class="required">お店の開業日</dt>
        <dd><input type="date" name="openday" class="info" required></dd>

        <dt class="required">郵便番号（7桁ハイフンなし）</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required></dd>

        <dt class="required">住所</dt>
        <dd><input type="text" name="adress" class="info" required></dd>

        <dt class="required">電話番号</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required></dd>

        <div class="button">
          <button id="up">送信</button>
        </div>
      </dl>



    </form>


    <a href="store_manege.php">管理者用ページ</a>
  </main>
  <footer>@高橋</footer>

  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-storage.js"></script>

  <script>
    // Import the functions you need from the SDKs you need
    //import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.2/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries

    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: "FIREBASE-API-KEY",
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
      thisRef.put(file).then(res => {
        console.log("アップロード成功");
        alert("アップロード成功");

      }).catch(e => {
        console.log("Error " + e);

      }).then(
        storageRef.child(file.name).getDownloadURL().then(url => {
          const filesurl = document.getElementById("filesurl")
          //console.log(filesurl.value);
          console.log(url);
          filesurl.value = url;

        }).catch(e => {
          console.log(e);
        })
      );

      //URLダウンロード
      /*
      storageRef.child(file.name).getDownloadURL().then(url => {
        console.log(url);

      }).catch(e => {
        console.log(e);
      });
      */


    }

    /*
        function download() {
          storageRef.child(file.name).getDownloadURL().then(url => {
            console.log(url);

          }).catch(e => {
            console.log(e);
          });
        }
        */

    //const filesurl = document.getElementById("filesurl")
    //console.log(filesurl.value);



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