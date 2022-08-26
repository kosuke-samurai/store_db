<?php
session_start();
include('functions.php');

require_once('vendor/autoload.php');
\Stripe\Stripe::setApiKey('sk_test_51LRFA1AYLwjaAQ1eJH97aZr6tQElNpr7uqgwasHuTxm2dulB13GODQWVvpcZa8xnIqNUQ7G3el4kH6fPDqxuQIKP00htOSAycJ');

$session = \Stripe\Checkout\Session::create([
    'payment_method_types' => ['card'],
    'mode' => 'payment',
    'line_items' => [
        ['price' => 'price_1LXOOVAYLwjaAQ1eplAucGyD', 'quantity' => 1],
    ],

    'success_url' => 'http://localhost/gs/gs_tamaribar/premier_customer_register_input.php',
    'cancel_url' => 'http://example.com/cancel',
]);
?>

<html>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>
</head>


<body>
    <header>
        <div class="header__wrapper">
            <div class="tamari_family">
                <h1>たまりbar</h1>
                <p>移住者のコミュニティーが生まれる</p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="customer_login.php">ログイン</a></li>
            </ul>

        </div>
    </header>

    <main>

        <h2>有料プランではじめる</h2>

        <div class="input">
            <button id="checkout-button">決済に進む</button>
        </div>
    </main>

    <footer>@高橋</footer>

    <script>
        var stripe = Stripe('pk_test_51LRFA1AYLwjaAQ1eahyroYg4KErxAxSp55hG3WzJHMnnlc0uGcuowke3woeXwV2YzbYzDn16gzpEf4n0hzs4Ras400Kvl5Txqv');
        const btn = document.getElementById("checkout-button")
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            stripe.redirectToCheckout({
                sessionId: "<?php echo $session->id; ?>"
            });
        });
    </script>
</body>

</html>