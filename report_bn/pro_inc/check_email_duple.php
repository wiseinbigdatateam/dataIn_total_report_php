<? include $_SERVER["DOCUMENT_ROOT"]."/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
$user_email = trim(sqlfilter($_REQUEST['user_email']));
$idx = trim(sqlfilter($_REQUEST['idx']));
$resJSON = array("success"=>"false", "msg"=>"");

$type_str = "이메일";
	
if($user_email){
	if(!$idx){
		$query_email = "select idx from member_info where email = '".$user_email."' and del_yn='N'";
	} else { 
		$query_email = "select idx from member_info where email = '".$user_email."' and idx != '".$idx."' and del_yn='N'";
	}
	$result_email = mysqli_query($gconnet,$query_email);
	
	if(mysqli_num_rows($result_email)==0){
		$resJSON["success"] = "true";
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:green;">Available email</font>';
		} else {	
			$resJSON["msg"] = '<font style="color:green;">사용 가능한 '.$type_str.' 입니다.</font>';
		}
		echo json_encode($resJSON);
	} else {
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:red;">Duplicate email</font>';
		} else {
			$resJSON["msg"] = '<font style="color:red;">이미 등록된 '.$type_str.' 입니다.</font>';
		}
		echo json_encode($resJSON);
		exit;
	}
}
?>
