<?
//mysqli_close($gconnet);
//echo $_SERVER['REMOTE_ADDR'];  183.96.82.136
//echo "현재 아이피 = ".$_SERVER['REMOTE_ADDR'];
//echo $_SERVER["DOCUMENT_ROOT"];

if($_SERVER['REMOTE_ADDR'] == "59.5.188.44" || $_SERVER['REMOTE_ADDR'] == "211.227.88.137"  || $_SERVER['REMOTE_ADDR'] == "218.237.253.251" || $_SESSION['wiz_session']['id'] == "dev" || $_SESSION['wiz_session']['id'] == "cslee1"){
	$show_iframe = true;
}
$show_iframe = true;
?>
<span style="width:210px;margin-left:150px;color:red;">* 관리자 확인용 영역입니다. 사무실IP, 개발테스트 아이디로 접속했을때만 보여집니다.</span>
<iframe name="_fra_admin" width="90%" height="300" style="display:<?=$show_iframe==TRUE?"":"none"?>"></iframe>
<iframe name="_fra_admin2" width="90%" height="300" style="display:<?=$show_iframe==TRUE?"":"none"?>"></iframe>
<iframe name="_fra_admin3" width="90%" height="300" style="display:<?=$show_iframe==TRUE?"":"none"?>"></iframe>
<iframe name="_fra_admin4" width="90%" height="300" style="display:<?=$show_iframe==TRUE?"":"none"?>"></iframe>
<iframe name="_fra_admin5" width="90%" height="300" style="display:<?=$show_iframe==TRUE?"":"none"?>"></iframe>
<div id="CalendarLayer" style="display:none; width:172px; height:250px; z-index:100;">
	<iframe name="CalendarFrame" src="/report/pro_inc/include_calendar.php" width="172" height="250" border="0" frameborder="0" scrolling="no"></iframe>
</div>
