<? include $_SERVER["DOCUMENT_ROOT"]."/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
$user_name = trim(sqlfilter($_REQUEST['user_name']));
$idx = trim(sqlfilter($_REQUEST['idx']));
$resJSON = array("success"=>"false", "msg"=>"");

$type_str = "닉네임";
	
if($user_name){
	if(!$idx){
		$query_name = "select idx from member_info where user_name = '".$user_name."' and del_yn='N'";
	} else { 
		$query_name = "select idx from member_info where user_name = '".$user_name."' and idx != '".$idx."' and del_yn='N'";
	}
	$result_name = mysqli_query($gconnet,$query_name);
	
	if(mysqli_num_rows($result_name)==0){
		$resJSON["success"] = "true";
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:green;">Available name</font>';
		} else {	
			$resJSON["msg"] = '<font style="color:green;">사용 가능한 '.$type_str.' 입니다.</font>';
		}
		echo json_encode($resJSON);
	} else {
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:red;">Duplicate name</font>';
		} else {
			$resJSON["msg"] = '<font style="color:red;">이미 등록된 '.$type_str.' 입니다.</font>';
		}
		echo json_encode($resJSON);
		exit;
	}
}
?>
