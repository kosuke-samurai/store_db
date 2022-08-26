<?php
session_start();
include("functions.php");
check_store_session_id();

//var_dump($_GET);
$store_id = (int)$_GET['id'];

//イベント開催日
function getreservationday()
{
    $pdo = connect_to_db();

    $sql = "SELECT * FROM store_reserve_table";

    $stmt = $pdo->prepare($sql);

    try {
        $status = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $store_id = (int)$_GET['id'];
        $reservation_member = array();

        foreach ($result as $record) {

            if ($record["store_id"] === $store_id) {
                $day_out = strtotime((string)$record['open_day']);
                //登録された全ての日付情報を文字列として$day_outへ格納
                //echo $day_out;
                //echo date('Y-m-d', $day_out);
                //exit();

                $hour_out = "{$record['start_hour']}~{$record['close_hour']}";
                //予約された全ての日のそれぞれの人数を文字列として$member_outへ格納
                //例：echo $member_out; → 3

                //$item_out = $record['secret_item'];

                $reservation_member[date('Y-m-d', $day_out)] = $hour_out;
            }
        }
        ksort($reservation_member);
        return $reservation_member;
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
    }
}


//予約あり
function getreservationdeta()
{
    $pdo = connect_to_db();

    $sql = "SELECT event_id, customer_number, store_id, reserve_day, open_day, start_hour, close_hour, COUNT(is_reserve) AS reserve_count FROM (SELECT event_id, customer_number, reserve_table.store_id, reserve_day, is_reserve, open_day, start_hour, close_hour FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day AND reserve_table.store_id = store_reserve_table.store_id) AS reserve_record_table GROUP BY event_id
";

    //$sql =
    //  "SELECT * FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day";

    $stmt = $pdo->prepare($sql);

    try {
        $status = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $store_id = (int)$_GET['id'];
        $reservationdeta_member = array();
        //$reservationdeta_id =  array();

        foreach ($result as $record) {
            if ($record["store_id"] === $store_id) {
                $day_out = strtotime((string)$record['reserve_day']);
                //登録された全ての日付情報を文字列として$day_outへ格納
                //echo $day_out;
                //echo date('Y-m-d', $day_out);
                //exit();

                $hour_out = "{$record['start_hour']}~{$record['close_hour']}";
                //予約された全ての日のそれぞれの人数を文字列として$member_outへ格納
                //例：echo $member_out; → 3

                //$item_out = $record['secret_item'];

                //$reservationdeta_id[date('Y-m-d', $day_out)] = $id;
                $reservationdeta_member[date('Y-m-d', $day_out)] = $hour_out;
            }
        }
        ksort($reservationdeta_member);
        return $reservationdeta_member;
        //ksort($reservationdeta_id);
        //return $reservationdeta_id;
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
    }
}

//予約あり2
function getreservationdetadetail()
{
    $pdo = connect_to_db();

    $sql = "SELECT event_id, customer_number, store_id, reserve_day, open_day, start_hour, close_hour, COUNT(is_reserve) AS reserve_count FROM (SELECT event_id, customer_number, reserve_table.store_id, reserve_day, is_reserve, open_day, start_hour, close_hour FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day AND reserve_table.store_id = store_reserve_table.store_id) AS reserve_record_table GROUP BY event_id
";

    //$sql =
    //  "SELECT * FROM reserve_table LEFT OUTER JOIN store_reserve_table ON reserve_table.reserve_day = store_reserve_table.open_day";

    $stmt = $pdo->prepare($sql);

    try {
        $status = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $store_id = (int)$_GET['id'];
        $reservationdeta_member = array();
        //$reservationdeta_id =  array();

        foreach ($result as $record) {
            if ($record["store_id"] === $store_id) {
                $day_out = strtotime((string)$record['reserve_day']);

                $id = $record['event_id'];

                $reservationdeta_member[date('Y-m-d', $day_out)] = $id;
            }
        }
        ksort($reservationdeta_member);
        return $reservationdeta_member;
    } catch (PDOException $e) {
        echo json_encode(["sql error" => "{$e->getMessage()}"]);
    }
}


//カレンダーへの表示
$reservation_array = getreservationday();
//getreservation関数を$reservation_arrayに代入しておく
//var_dump($reservation_array);
$reservationdeta_array = getreservationdeta();
//var_dump($reservationdeta_array);

$getreservationdetadetail_array = getreservationdetadetail();

function reservation($date, $reservation_array)
{
    //カレンダーの日付と予約された日付を照合する関数
    if (array_key_exists($date, $reservation_array)) {
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
        $reservation_member = "<br/>登録済<br/>実施時間：<br/>$reservation_array[$date]";
        return $reservation_member;
    }
}

function reservationdeta($date, $reservationdeta_array)
{
    //カレンダーの日付と予約された日付を照合する関数
    if (array_key_exists($date, $reservationdeta_array)) {
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
        $reservationdeta_member = "<br/><span class='red'>予約あり</span><br/>実施時間：<br/>$reservationdeta_array[$date]";
        return $reservationdeta_member;
    }
}

function reservationdetadetail($date, $getreservationdetadetail_array)
{
    //カレンダーの日付と予約された日付を照合する関数
    if (array_key_exists($date, $getreservationdetadetail_array)) {
        //もし"カレンダーの日付"と"予約された日"が一致すれば以下を実行する
        $reservationdeta_member = "<br/><a class='bold' href='store_confirm_guest.php?id={$getreservationdetadetail_array[$date]}'>来店情報を確認する</a>";
        return $reservationdeta_member;
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
    $today = date('Y-m-j');

    //var_dump($date);

    //予約情報//
    $reservation = reservation(date("Y-m-d", strtotime($date)), $reservation_array);
    $reservationdeta = reservationdeta(date("Y-m-d", strtotime($date)), $reservationdeta_array);
    $reservationdetadetail = reservationdetadetail(date("Y-m-d", strtotime($date)), $getreservationdetadetail_array);

    $do_open = "<br/><a href='store_open_input.php?id={$store_id}&date={$date}'>登録する</a>";
    $old = '<br/><p>登録不可</p>';

    if ($date < $today) {
        $week .= '<td>' . $day . $old;
    } else if ($today == $date && reservation(date("Y-m-d", strtotime($date)), $reservation_array)) {
        $week .= '<td  class="today">' . $day . $reservation;
        //予約情報//
    } else if ($today == $date) {
        $week .= '<td class="today">' . $day . $do_open; //今日の場合はclassにtodayをつける
        //予約情報//
    } else if (reservationdeta(date("Y-m-d", strtotime($date)), $reservationdeta_array)) {
        $week .= '<td>' . $day . $reservationdeta . $reservationdetadetail;
    } else if (reservation(date("Y-m-d", strtotime($date)), $reservation_array)) {
        $week .= '<td>' . $day . $reservation;
    } else {
        $week .= '<td>' . $day . $do_open;
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

//表示名用
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
    <title>たまりbar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_read.css">
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

    <h2 class="tamari_family">予約可能日の登録<br />店名：<?php echo $store_name; ?></h2>



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

</body>

</html>