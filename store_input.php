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
      
     <dl class="input">
      <dt class="required">店舗名</dt>  
      <dd><input type="text" name="name" class="info" required></dd>

      <dt class="required">店舗メイン写真</dt>  
      <dd><input type="file" name="picture" class="" required></dd>
    
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
        <button>送信</button>
      </div>
      </dl>

    

  </form>

    
  <a href="read.php">管理者用ページ</a>
   </main>
   <footer>@高橋</footer>
</body>
</html>