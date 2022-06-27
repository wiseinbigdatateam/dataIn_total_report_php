<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "service";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;

	$service_option_idx = trim(sqlfilter($_REQUEST['service_option_idx']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$service_option_status = trim(sqlfilter($_REQUEST['service_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$service_option_idx){  
		error_frame_go("다시 진행해주세요.","service_1.php");
	}

	$analysis_report_service_option_score = trim(sqlfilter($_REQUEST['service_option_score']));
	$analysis_report_service_option_percent = trim(sqlfilter($_REQUEST['service_option_percent']));
	$analysis_report_service_option_scorepoint = trim(sqlfilter($_REQUEST['service_option_scorepoint']));
	$analysis_report_service_option_scorepoint2 = trim(sqlfilter($_REQUEST['service_option_scorepoint2']));

	if(!$analysis_report_service_option_scorepoint){
		$analysis_report_service_option_scorepoint = 1;
	}
	if(!$analysis_report_service_option_scorepoint2){
		$analysis_report_service_option_scorepoint2 = 1;
	}
	
	$query = "update wise_analysis_report_service_option set"; 
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " analysis_report_service_option_score = '".$analysis_report_service_option_score."', ";
	$query .= " analysis_report_service_option_percent = '".$analysis_report_service_option_percent."', ";
	$query .= " analysis_report_service_option_scorepoint = '".$analysis_report_service_option_scorepoint."', ";
	$query .= " analysis_report_service_option_scorepoint2 = '".$analysis_report_service_option_scorepoint2."' ";
	$query .= " where 1 and idx='".$service_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	$result = mysqli_query($gconnet,$query);
	
	############ 케이스 처리 시작 ##########
	$service_point_case_v = trim($_REQUEST['service_point_case_v']);
	//echo $service_point_case_v."<br><br>";
	$service_point_case_arr = explode('pop_t on',$service_point_case_v);
	$service_point_case_arr_c = explode('pop_c on',$service_point_case_v);
	//echo $service_point_case_arr_c[1]."<br><br>";
	//exit;
	
	$sql_group_del = "delete from wise_analysis_report_service_option_point_case where 1 and service_option_idx = '".$service_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($service_point_case_arr); $i++){
		$service_point_case_arr2 = explode('id="quiz_no_',$service_point_case_arr[$i]);
		$service_point_case_arr3 = explode('"><button>',$service_point_case_arr2[1]);
		$service_point_case_arr4 = explode('<a href="javascript:',$service_point_case_arr_c[$i]);
		$service_point_case_arr5 = explode(';"',$service_point_case_arr4[1]);

		if($i == sizeof($service_point_case_arr)-1){
			//echo "arr_4 = ".$service_point_case_arr4[1]."<br><br>";
		}
		
		$analysis_report_service_option_case_no = trim($service_point_case_arr3[0]);
		$analysis_report_service_option_case_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_service_option_case_no,"quiz_title","");
		$analysis_report_service_option_case_content = get_data_colname("wise_analysis_quiz","idx",$analysis_report_service_option_case_no,"quiz_content","");
		$analysis_report_service_option_case_answer = trim($service_point_case_arr5[0]);

		$query_sub = "insert into wise_analysis_report_service_option_point_case set"; 
		$query_sub .= " service_option_idx = '".$service_option_idx."', ";
		$query_sub .= " analysis_report_service_option_case_no = '".$analysis_report_service_option_case_no."', ";
		$query_sub .= " analysis_report_service_option_case_title = '".$analysis_report_service_option_case_title."', ";
		$query_sub .= " analysis_report_service_option_case_content = '".$analysis_report_service_option_case_content."', ";
		$query_sub .= " analysis_report_service_option_case_answer = '".$analysis_report_service_option_case_answer."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 케이스 처리 종료 ##########

	if($_REQUEST['service_option_status'] == "com"){
		frame_go("service_4.php?service_option_idx=".$service_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}

?>