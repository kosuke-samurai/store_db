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

    <title>たまりbar</title>

    <meta property="og:site_name" content="たまりBAR">
    <meta property="og:title" content="たまりBAR">
    <meta property="og:description" content="「秘密のアイテム」で移住者にコミュニティーを。地方圏移住を促す新たな飲食店予約サービス。">
    <meta property="og:url" content="https://tamaribar.herokuapp.com">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://tamaribar.herokuapp.com/img/tamaribar_ogp.png">
    <meta name="twitter:card" content="summary_large_image">


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
                            <a class="nav-link" href="customer_login.php">ログインする</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="customer_register_input.php">新規登録</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>



    <div class="container">
        <div class="row">
            <div class="col-md-12 hidden-xs">
                <div class="cover lead-photo"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-lg-10 offset-lg-1 menu-card page-indent" style="text-align: center;">
                <h2 class="decoration-stars">すべての移住者へ</h2>
                <h3 class="">偶然の出会いを生む、必然を</h3>
                <p>「たまりbar」は、移住者の皆さんへ向けた新しい飲食店予約のカタチです。</p>

                <p>移住した地で、友達が作れない。移住に興味があっても、新たな土地で人間関係が築けるか分からないーー。</p>
                <p>そんな皆さんへ「たまりbar」は、新たなコミュニティ創りのあり方を提供します。</p>

                <div class="opening-button">
                    <a href="customer_register_input.php" class="btn btn-primary">新規登録する</a>
                </div>
                <div class="opening-button">
                    <a href="customer_login.php" class="btn btn-primary">ログインする</a>
                </div>

                <div class="opening-button">
                    <a href="store_login.php">店舗オーナーの方はこちら</a>
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


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="javascript/acos.jquery.js"></script>
    <script src="javascript/script.js"></script>

</body>

</html>