<?php
//postされたデータを元にjsonを更新します。
//ボタンが押されるたびにこのphpが呼び出され、処理が走ります。

//postデータが入っていない場合は強制終了
//URLの直接入力などをシャットアウトします。
if(!isset($_POST["path"]) && !isset($_POST["dir"]) && !isset($_POST["jsonFilename"])){
	exit;
}

$path = $_POST["path"];
$dir = $_POST["dir"];
$jsonFilename = $_POST["jsonFilename"];

require_once 'GoodBtn.php';
$goodBtn = new GoodBtn($dir,$jsonFilename,null,false);
$arg = $goodBtn->updateJson($path); //jsonを更新して返す

//jsonデータとして出力
header('Content-type: application/json');
echo json_encode($arg,JSON_UNESCAPED_UNICODE);
