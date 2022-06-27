<? include $_SERVER["DOCUMENT_ROOT"]."/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
$user_id = trim(sqlfilter($_REQUEST['user_id']));
$idx = trim(sqlfilter($_REQUEST['idx']));
$resJSON = array("success"=>"false", "msg"=>"");
$user_id = str_replace("-","",$user_id);
$type = trim(sqlfilter($_REQUEST['type']));

$type_str = "사업자 번호";

if($user_id){
	if(!$idx){
		$query_id = "select idx from member_info where 1 and replace(com_num,'-','') = '".$user_id."' and del_yn='N'";
	} else { 
		$query_id = "select idx from member_info where 1 and replace(com_num,'-','') = '".$user_id."' and idx != '".$idx."' and del_yn='N'";
	}

	//echo $query_id."<br>";

	$result_id = mysqli_query($gconnet,$query_id);
	
	if(mysqli_num_rows($result_id)==0){
		$resJSON["success"] = "true";
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:green;">Available ID</font>';
		} else {	
			$resJSON["msg"] = '<font style="color:green;">사용 가능한 '.$type_str.' 입니다.</font>';
		}
		//echo $resJSON; exit;
		echo json_encode($resJSON);
	} else {
		if($type == "ENG"){
			$resJSON["msg"] = '<font style="color:red;">Duplicate ID</font>';
		} else {
			$resJSON["msg"] = '<font style="color:red;">이미 등록된 '.$type_str.' 입니다.</font>';
		}
		echo json_encode($resJSON);
		exit;
	}
}
?>
