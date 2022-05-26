

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_detail.css">
    <title>たまりbar</title>
</head>
<body>

<header>
    <h1>店舗情報の詳細</h1>
</header>
     
<main>
<h1><?php echo $detail['name']?></h1>
<img src="image.php?id=<?= $detail['id']; ?>" width="auto" height="300">
<ul class="detail">
    <li><h3>詳細情報</h3></li>
    <li>
    <p>お店のジャンル：<span class="bold"><?php echo $detail["category"]; ?></span></p>
    </li>
    <li>
    <p>客層：<span class="bold"><?php echo $detail["moodselect"]; ?></span></p>
    </li>
    <li>
    <p>雰囲気：<span class="bold"><?php echo $detail["moodtext"]; ?></span></p>
    </li>  
    <li>
    <p>料理・飲み物：<span class="bold"><?php echo $detail["foodtext"]; ?></span></p>
    </li> 
    <li>
    <p>店のメッセージ：<span class="bold"><?php echo $detail["message"]; ?></span></p>
    </li>    
    <li>
    <p>予算：<span class="bold"><?php echo $detail["budget"]; ?></span></p>
    </li>
    <li>
    <p>住所：<span class="bold">〒<span class="mgr-100"><?php echo $detail["postadress"]; ?></span><?php echo $detail["adress"]; ?></span></p>
    </li> 
    <li>
    <p>電話：<span class="bold"><?php echo $detail["tell"]; ?></span></p>
    </li>
    <li>
    <p>開業日：<span class="bold"><?php echo $detail["openday"]; ?></span></p>
    </li> 

    </ul>
<div class="buttonli">
<p><a href="store_read.php" class="button">リストに戻る</a></p>
</div>
 </main>

 
    
</body>
</html>
