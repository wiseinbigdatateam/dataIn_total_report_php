<? include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    </style>
   <link rel="stylesheet" href="./css/main.css">
   <link rel="stylesheet" href="./css/jquery.mCustomScrollbar.css">
   <link rel="stylesheet" href="./css/selectables.css">
   <?if(basename($_SERVER['PHP_SELF']) == "decision_2.php"){?>
		<link rel="stylesheet" href="./css/mindmap_2.css">
   <?}else{?>
		<link rel="stylesheet" href="./css/mindmap.css">
   <?}?>
    <meta charset="UTF-8">
    <title>Document</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="./js/manjok.js"></script>
    <script src="./js/jquery-ui.js"></script>
    <script src="./js/jquery.mCustomScrollbar.js"></script>
    <script src='./js/jquery.multisortable.js'></script>
    <script src='./js/jquery.connectingLine.js'></script>
    <script src='./js/selectables.js'></script>
   <?if(basename($_SERVER['PHP_SELF']) == "decision_2.php"){?>
		<script src='./js/mindmap_2.js'></script>
   <?}else{?>
		<script src='./js/mindmap.js'></script>
   <?}?>
    <script src='./js/modal.js'></script>
    <script src='./js/guide.js'></script>
	<script src="./js/common_js.js"></script>
</head>

