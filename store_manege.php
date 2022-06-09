<?php
// DB接続
include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行

$sql = "SELECT * FROM store_db";



$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //できているか確認する際、テーブルを見やすくするコツ
    //echo '<pre>';
    //var_dump($result);
    //echo '</pre>';
    //exit();

    for ($i = 0; $i < count($result); $i++) {
        if ($result[$i]["username"] === "わたし") {
            $hoge_array[] = array($result[$i]["id"]);
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
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/store_read.css">
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <title>たまりbar</title>
</head>

<body>
    <header>
        <h1>登録した情報の一覧</h1>
        <p>（店舗オーナー様ページ）</p>
    </header>


    <main>
        <ul class="storelist">
            <?php for ($i = 0; $i < count($result); $i++) : ?>
                <?php if ($result[$i]["username"] === "わたし") : ?>

                    <div>
                        <div class="box">
                            <li>
                                <h2><?= $result[$i]["name"]; ?> </h2>
                                <a href='store_manege_edit.php?id=<?php echo $result[$i]['id']; ?>' class="">編集する</a>
                                <a href='store_manege_delete.php?id=<?php echo $result[$i]['id']; ?>' onclick="return confirm('削除したデータは復元できません。本当に削除しますか？')" class="">削除</button>
                            </li>
                        </div>
                    </div>

                <?php endif; ?>
            <?php endfor; ?>
        </ul>

        <div class="store_manege_make">
            <div>
                <a href="store_input.php" class="button">新規作成</a>
            </div>
        </div>
    </main>

    <script>
        //const hogeArray = <?= json_encode($hoge_array) ?>;
        //console.log(hogeArray);
    </script>
</body>

</html>