<?php

mb_language("Japanese"); //文字コードの設定
mb_internal_encoding("UTF-8");
//住所（梅田スカイビル）を入れて緯度経度を求める。
$address = "大阪府大阪市北区大淀中１丁目１−８７";
$apikey = "＜API-KEY＞";
$address = urlencode($address);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon = $geo[0];
$lat = $geo[1];
//echo "緯度：" . $lat . " 経度：" . $lon;
