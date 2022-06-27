<?php
include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드
include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/db_conn_datain.php"; // 데이터인 DB 접속

$memid = $_SESSION['wiz_session']['id'];

$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];

if($mode == "datacopy") {

	// 2022-01-17 : 로그인 데이터 권한 확인 ----- kky
	$permit_chk = check_payment_permit($memid, "project");
	if($permit_chk['chk'] == false) {
		echo "ERR|".$permit_chk['msg'];
		exit;
	}

	$sql = "SELECT * FROM wise_analysis_main WHERE idx = '$idx'";
	$result = mysqli_query($dconnet, $sql);
	$row = mysqli_fetch_object($result);

	if($row->idx == "") {
		echo "ERR|프로젝트를 선택하세요.";
		exit;
	}

	$sql = "INSERT INTO wise_analysis_main (idx,memid,subid,analysis_type,analysis_title,analysis_org,data_cnt,data_type,data_key,permit_delete,permit_modify,permit_copy,wdate,mv_sdate,mv_edate,mv_idx,mv_status)
					VALUES('','$row->memid','$row->subid','$row->analysis_type','$row->analysis_title','$row->analysis_org','$row->data_cnt','$row->data_type','$row->data_key','$row->permit_delete','$row->permit_modify','$row->permit_copy',now(),now(),'','$row->idx','N')";
	mysqli_query($gconnet, $sql);

	//echo $sql."<br>";

	$analysis_idx = mysqli_insert_id($gconnet);

	$analysis_title = $row->analysis_title;

	$sql = "SELECT * FROM wise_analysis_quiz WHERE analysis_idx = '$idx'";
	$result = mysqli_query($dconnet, $sql);
	while($row = mysqli_fetch_object($result)) {
		// 2021-11-05 : 문항 보기 개행문자 제거 ----- kky
		$row->quiz_value = trim(str_replace("\n", "", str_replace("\r\n", "", $row->quiz_value)));

		$in_sql = "INSERT INTO wise_analysis_quiz (idx,analysis_idx,quiz_no,quiz_conf,quiz_delete,quiz_type,quiz_type2,quiz_title,quiz_content,quiz_value,quiz_cnt,answer_cnt,min_val,max_val,wdate)
							VALUES ('','$analysis_idx','$row->quiz_no','$row->quiz_conf','$row->quiz_delete','$row->quiz_type','$row->quiz_type2','$row->quiz_title','$row->quiz_content','$row->quiz_value','$row->quiz_cnt','$row->answer_cnt','$row->min_val','$row->max_val',now())";
		$in_result = mysqli_query($gconnet, $in_sql);
	/*
	echo "<pre>";
	print_r($result);
	echo "</pre>";
	*/
	}

	//echo $sql."<br>";

	$in_val_sql = "";
	$sql = "SELECT * FROM wise_analysis_data WHERE analysis_idx = '$idx'";
	$result = mysqli_query($dconnet, $sql);
	while($row = mysqli_fetch_object($result)) {

		if($in_val_sql != "") $in_val_sql .= ",";
		$in_val_sql .= "('','$analysis_idx','$row->quiz_no','$row->answer_no','$row->data_no','$row->data_val','$row->data_miss',now())";
		///mysqli_query($gconnet, $in_sql) or die(mysqli_error());

		//echo $in_val_sql;

	}

	if($in_val_sql != "") {
		// 업로드 디렉토리 생성
		$upfile_path = $_SERVER["DOCUMENT_ROOT"]."/report/project/data/".$memid;
		if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

		$upfile_name = $upfile_path."/data_".$analysis_idx.".sql";

		$fp = fopen($upfile_name, "a+");
		ob_start();

		$in_sql = "INSERT INTO wise_analysis_data (idx,analysis_idx,quiz_no,answer_no,data_no,data_val,data_miss,wdate) VALUES ".$in_val_sql.";";

		echo $in_sql;

		$msg = ob_get_contents();
		ob_end_clean();
		fwrite($fp, $msg);
		fclose($fp);

		exec("mysql -uwiseadmin -pwise1357! dataIn < ".$upfile_name);

		//unlink($upfile_name);

	}

	//echo $sql."<br>";

	$sql = "UPDATE wise_analysis_main SET mv_edate = now(), mv_status = 'Y' WHERE idx = '$analysis_idx'";
	$result = mysqli_query($gconnet, $sql);

	//echo $sql."<br>";

	// 2022-01-17 : 권한 업데이트 ----- kky
	update_payment_permit($memid, "report_inscnt");

	echo "OK|".$analysis_idx."|".$analysis_title;
} else if($mode == "datadelete") {

	$sql = "DELETE FROM wise_analysis_main WHERE idx = '$idx'";
	mysqli_query($gconnet, $sql);

	$sql = "DELETE FROM wise_analysis_quiz WHERE analysis_idx = '$idx'";
	mysqli_query($gconnet, $sql);

	$sql = "DELETE FROM wise_analysis_data WHERE analysis_idx = '$idx'";
	mysqli_query($gconnet, $sql);

	// 모델 보고서 삭제

	// 2022-01-17 : 권한 업데이트 ----- kky
	update_payment_permit($memid, "report_delcnt");

	echo "OK";

}
?>