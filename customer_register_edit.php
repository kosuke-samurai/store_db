<?php
//var_dump($_GET);
//exit();
session_start();
include("functions.php");
check_customer_session_id();


$id = $_GET["id"];

$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM users_table WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($record);
//exit();


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->


    <link href='https://fonts.googleapis.com/css?family=Lato:400,300,700&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display+SC:400,700,900&amp;subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" type="text/css" href="css/swiper.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">

    <!--<link rel="stylesheet" href="css/store_input.css">-->
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>
</head>

<body>

    <header>
        <div class="container d-none d-sm-block logo" style="text-align: center;">
            <img class="img-fluid" src="images/logos/tamaribar_pc_logo.png" alt="">
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
                            <a class="nav-link" href="customer_logout.php">ログアウトする</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>



    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-12">
                <article class="content">
                    <section class="mb-5">
                        <h2 class="py-2">ユーザー情報の編集</h2>

                        <form action="customer_register_update.php" method="POST">

                            <input type="hidden" name="is_admin" value="<?= $record['is_admin'] ?>">
                            <input type="hidden" name="is_deleted" value="<?= $record['is_deleted'] ?>">
                            <input type="hidden" name="is_premier" value="<?= $record['is_premier'] ?>">


                            <div class="form-group row">
                                <label class="col-sm-2">ユーザー名</label>
                                <div class="col-sm-10">
                                    ユーザー名は変更できません</div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2">パスワード</label>
                                <div class="col-sm-10">
                                    パスワードは変更できません</div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">メール</label>
                                <div class="col-sm-10 animated-form-control">
                                    <input type="text" name="email" class="info text form-control" value="<?= $record['email'] ?>" required>
                                    <div class="tooltip2" id="emailalert">すでに登録されているため使えません</div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">郵便番号（ハイフンなし）</label>
                                <div class="col-sm-10 animated-form-control">
                                    <input type="text" pattern="^[0-9]*$" name="postadress" class="info text form-control" value="<?= $record['postadress'] ?>" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','prefectures','adress');">
                                </div>
                            </div>



                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label">都道府県</label>

                                <div class="col-sm-10 animated-form-control">
                                    <select name="prefectures" class="info text form-control">
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
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">以降の住所</label>
                                <div class="col-sm-10 animated-form-control">
                                    <input type="text" name="adress" class="info text form-control" value="<?= $record['adress'] ?>" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">電話番号</label>
                                <div class="col-sm-10 animated-form-control">
                                    <input type="text" pattern="^[0-9]*$" name="tell" class="info text form-control" value="<?= $record['tell'] ?>" required>
                                </div>
                            </div>

                            <div class="opening-button ">

                                <button id="up" class="btn btn-primary float-right">情報を更新する</button>
                            </div>

                        </form>
                    </section>
                </article>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1 col-md-12">

                <div class="opening-button" style="text-align: center;">
                    <a class="btn btn-primary" href='customer_register_delete.php?id=<?= $_SESSION['id']; ?>' onclick="return confirm('削除したデータは復元できません。本当に削除しますか？')" class="button">ユーザー情報を削除する</a>
                </div>
            </div>
        </div>
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