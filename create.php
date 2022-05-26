<?php
//var_dump($_POST);
//exit();

$name = $_POST["name"];
$old = $_POST["old"];
$sex = $_POST["sex"];
$opinion = $_POST["opinion"];
$location = $_POST["location"];

//（変数をスペースでつなげて最後に改行をいれる）
$write_data = "{$name},{$old},{$sex},{$opinion},{$location}\n";

//書き込み先のファイルを開く
$file = fopen("data/opinion.csv","a");
//他の人が書き込まないようファイルをロックする
flock($file, LOCK_EX);

//ファイルに書き込む
fwrite($file, $write_data);

//ロックを解除する
flock($file, LOCK_UN);
//ファイルを閉じる
fclose($file);

//表示はtodo_txt_input.phpの状態に
header("Location:thankyou.php");

?>
