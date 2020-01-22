<?php
$dir = "/goodbtn"; //フォルダのパス
//$jsonFilename = "data.json"; //jsonのファイル名
//$icon = "heart";
require_once $_SERVER['DOCUMENT_ROOT'] . $dir .'/GoodBtn.php';
$goodBtn = new GoodBtn($dir);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>いいねボタンのテスト</title>
<link rel="stylesheet" type="text/css" href="demo.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<?php $goodBtn->head(); ?>
</head>
<body>
<div id="wrapper">


<?php require 'pager.php'; ?>
