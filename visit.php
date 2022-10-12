<?php
session_start();
include("functions.php");
check_customer_session_id();

//var_dump($_GET);
$store_id = (int)$_GET['id'];
//var_dump($store_name);
//exit();



//イベント情報
function getopen()
{
    $pdo = connect_to_db();

    //$sql = "SELECT * FROM reserve_table";
    $sql = "SELECT * FROM store_reserve_table";

    $stmt = $pdo->prepare($sql);

    try {
        $status = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $store_id = (int)$_GET['id'];
        $open_member = array();

        foreach ($result as $record) {

            if ($record["store_id"] === $store_id) {
                //var_dump($record['id']);


                $open_out = strtotime((string)$record['open_day']);
                //var_dump($open_out);

                $hour_out = "{$record['start_hour']}~{$record['close_hour']}";

                $open_member[date('Y-m-d', $open_out)] = $hour_out;
            }
        }
        ksort($open_member);
        return $open_member;
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
    }
}



$open_array = getopen();
//var_dump($open_array);


function open($date, $open_array)
{
    //カレンダーの日付と予約された日付を照合する関数
    if (array_key_exists($date, $open_array)) {
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
        $store_id = (int)$_GET['id'];
        $open_member = "<br/><a href='visit_input.php?id={$store_id}&date={$date}' class='bold'>お店に行く</a><br/>時間：{$open_array[$date]}";
        return $open_member;
    }
}


//***/
//タイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');

//前月・次月リンクが選択された場合は、GETパラメーターから年月を取得
if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    //今月の年月を表示
    $ym = date('Y-m');
    $store_id = (int)$_GET['id'];
}

//タイムスタンプ（どの時刻を基準にするか）を作成し、フォーマットをチェックする
//strtotime('Y-m-01')
$timestamp = strtotime($ym . '-01');
if ($timestamp === false) { //エラー対策として形式チェックを追加
    //falseが返ってきた時は、現在の年月・タイムスタンプを取得
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

//今月の日付　フォーマット　例）2020-10-2
$today = date('Y-m-j');

//カレンダーのタイトルを作成　例）2020年10月
$html_title = date('Y年n月', $timestamp); //date(表示する内容,基準)

//前月・次月の年月を取得
//strtotime(,基準)
$prev = date('Y-m', strtotime('-1 month', $timestamp));
$next = date('Y-m', strtotime('+1 month', $timestamp));

//該当月の日数を取得
$day_count = date('t', $timestamp);

//１日が何曜日か
$youbi = date('w', $timestamp);

//カレンダー作成の準備
$weeks = [];
$week = '';

//第１週目：空のセルを追加
//str_repeat(文字列, 反復回数)
$week .= str_repeat('<td></td>', $youbi);

for ($day = 1; $day <= $day_count; $day++, $youbi++) {

    $date = $ym . '-' . $day; //2020-00-00


    //var_dump($date);

    //予約情報//
    $open = open(date("Y-m-d", strtotime($date)), $open_array);

    $donot_reserve = '<br/><p>待ち人はいません</p>';
    $old = '<p>選択不可</p>';

    if ($date < $today) {
        $week .= '<td>' . $day . $old;
    } else if ($today == $date) {
        $week .= '<td class="today">' . $day . $donot_reserve; //今日の場合はclassにtodayをつける
    } else if (open(date("Y-m-d", strtotime($date)), $open_array)) {
        $week .= '<td>' . $day . $open;
    } else {
        $week .= '<td>' . $day . $donot_reserve;
    }
    $week .= '</td>';

    if ($youbi % 7 == 6 || $day == $day_count) { //週終わり、月終わりの場合
        //%は余りを求める、||はまたは
        //土曜日を取得

        if ($day == $day_count) { //月の最終日、空セルを追加
            $week .= str_repeat('<td></td>', 6 - ($youbi % 7));
        }

        $weeks[] = '<tr>' . $week . '</tr>'; //weeks配列にtrと$weekを追加

        $week = ''; //weekをリセット
    }
}

//表示用
$pdo = connect_to_db();
$sql = "SELECT * FROM store_db";
$stmt = $pdo->prepare($sql);

try {

    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    for ($i = 0; $i < count($result); $i++) {
        $store_id = (int)$_GET['id'];

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


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>たまりBAR</title>

    <meta property="og:site_name" content="たまりBAR">
    <meta property="og:title" content="たまりBAR">
    <meta property="og:description" content="「秘密のアイテム」で移住者にコミュニティーを。地方圏移住を促す新たな飲食店予約サービス。">
    <meta property="og:url" content="https://tamaribar.herokuapp.com">
    <meta property="og:type" content="article">
    <meta property="og:image" content="https://tamaribar.herokuapp.com/img/tamaribar_ogp.png">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->


    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC:400,700,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!-- <link rel="stylesheet" href="css/store_read.css">-->
    <style>
        h3 {
            margin-bottom: 30px;
        }

        th {
            height: 30px;
            text-align: center;
        }

        td {
            height: 100px;
        }

        .today {
            background: orange;
            /*--日付が今日の場合は背景オレンジ--*/
        }

        .red {
            color: red;
            font-weight: bold;
        }

        .bold {
            font-weight: bold;
        }

        th:nth-of-type(1),
        td:nth-of-type(1) {
            /*--日曜日は赤--*/
            color: red;
        }

        th:nth-of-type(7),
        td:nth-of-type(7) {
            /*--土曜日は青--*/
            color: blue;
        }
    </style>
</head>

<body>

    <header>
        <div class="container d-none d-sm-block logo" style="text-align: center;">
            <img class="img-fluid" src="images/logos/tamaribar_pc_logo.png" alt="">
            <p class="sub-title">ユーザー名:<?= $_SESSION['username']; ?>さま</p>
        </div>

        <div class="container my-2 my-md-4">
            <nav class="navbar navbar-expand-sm navbar-light">
                <a class="navbar-brand d-sm-none" href="index.php"><img class="img-fluid" src="images/logos/tamaribar_logo.png" alt=""></a> <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse justify-content-sm-center" id="main-navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="store_read.php">店舗一覧に戻る</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_mypage.php?id=<?= $_SESSION['user_id']; ?>">ともだち</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">トップに戻る</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_logout.php">ログアウトする</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_register_edit.php?id=<?= $_SESSION['user_id']; ?>">ユーザー情報の編集</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <h2 class="tamari_family"><?= $store_name ?>の利用ページ</h2>



    <div class="container">
        <h3><a href="?ym=<?php echo $prev; ?>&id=<?php echo $store_id; ?>">&lt;</a><?php echo $html_title; ?><a href="?ym=<?php echo $next; ?>&id=<?php echo $store_id; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
            foreach ($weeks as $week) {
                echo $week;
            }
            ?>
        </table>
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="divider"></div>
                    <div class="text-center">
                        <a href="index.html"><img src="images/logos/tamaribar_logo.png" alt="" class="logo"></a>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <p>© タカハシ</p>
            </div>
        </div>
        </div>
    </footer>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/acos.jquery.js"></script>
    <script src="javascript/script.js"></script>

</body>

</html>