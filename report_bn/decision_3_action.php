<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "decision";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	$decision_option_status = trim(sqlfilter($_REQUEST['decision_option_status']));
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	
	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$decision_option_idx){  
		error_frame_go("다시 진행해주세요.","decision_1.php");
	}

	$analysis_report_decision_option_scorepoint = trim(sqlfilter($_REQUEST['decision_option_scorepoint']));
	$analysis_report_decision_option_scorepoint2 = trim(sqlfilter($_REQUEST['decision_option_scorepoint2']));
	$analysis_report_decision_option_calpath = trim(sqlfilter($_REQUEST['decision_option_calpath']));
	$analysis_report_decision_option_calpath2 = trim(sqlfilter($_REQUEST['decision_option_calpath2']));
	$analysis_report_decision_option_case = trim(sqlfilter($_REQUEST['decision_option_case']));
	$analysis_report_decision_option_case_no = trim(sqlfilter($_REQUEST['decision_option_case_no']));

	if(!$analysis_report_decision_option_scorepoint){
		$analysis_report_decision_option_scorepoint = 1;
	}
	if(!$analysis_report_decision_option_scorepoint2){
		$analysis_report_decision_option_scorepoint2 = 1;
	}

	$query = "update wise_analysis_report_decision_option set"; 
	$query .= " analysis_report_decision_option_scorepoint = '".$analysis_report_decision_option_scorepoint."', ";
	$query .= " analysis_report_decision_option_scorepoint2 = '".$analysis_report_decision_option_scorepoint2."', ";
	$query .= " analysis_report_decision_option_calpath = '".$analysis_report_decision_option_calpath."', ";
	$query .= " analysis_report_decision_option_calpath2 = '".$analysis_report_decision_option_calpath2."', ";
	$query .= " analysis_report_decision_option_case = '".$analysis_report_decision_option_case."', ";
	$query .= " analysis_report_decision_option_case_no = '".$analysis_report_decision_option_case_no."' ";
	$query .= " where 1 and idx='".$decision_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	$result = mysqli_query($gconnet,$query);
	
	############ 케이스 처리 시작 ##########
	$decision_point_case_v = trim($_REQUEST['decision_point_case_v']);
	//echo $decision_point_case_v."<br><br>";
	$decision_point_case_arr = explode('pop_t on',$decision_point_case_v);
	$decision_point_case_arr_c = explode('pop_c on',$decision_point_case_v);
	//echo $decision_point_case_arr_c[1]."<br><br>";
	//exit;
	
	$sql_group_del = "delete from wise_analysis_report_decision_option_point_case where 1 and decision_option_idx = '".$decision_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($decision_point_case_arr); $i++){
		$decision_point_case_arr2 = explode('id="quiz_no_',$decision_point_case_arr[$i]);
		$decision_point_case_arr3 = explode('"><button>',$decision_point_case_arr2[1]);
		$decision_point_case_arr4 = explode('<a href="javascript:',$decision_point_case_arr_c[$i]);
		$decision_point_case_arr5 = explode(';"',$decision_point_case_arr4[1]);

		if($i == sizeof($decision_point_case_arr)-1){
			//echo "arr_4 = ".$decision_point_case_arr4[1]."<br><br>";
		}
		
		$analysis_report_decision_option_case_no = trim($decision_point_case_arr3[0]);
		$analysis_report_decision_option_case_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_case_no,"quiz_title","");
		$analysis_report_decision_option_case_content = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_case_no,"quiz_content","");
		$analysis_report_decision_option_case_answer = trim($decision_point_case_arr5[0]);

		$query_sub = "insert into wise_analysis_report_decision_option_point_case set"; 
		$query_sub .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_sub .= " analysis_report_decision_option_case_no = '".$analysis_report_decision_option_case_no."', ";
		$query_sub .= " analysis_report_decision_option_case_title = '".$analysis_report_decision_option_case_title."', ";
		$query_sub .= " analysis_report_decision_option_case_content = '".$analysis_report_decision_option_case_content."', ";
		$query_sub .= " analysis_report_decision_option_case_answer = '".$analysis_report_decision_option_case_answer."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 케이스 처리 종료 ##########

	############ 집단별 처리 시작 ##########
	$decision_point_quiz_v = trim($_REQUEST['decision_point_quiz_v']);
	$decision_point_quiz_arr = explode('<li id="',$decision_point_quiz_v);
	
	$sql_group_del = "delete from wise_analysis_report_decision_option_point_quiz where 1 and decision_option_idx = '".$decision_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($decision_point_quiz_arr); $i++){
		
		$decision_point_quiz_arr2 = explode('<a href="javascript:',$decision_point_quiz_arr[$i]);
		$decision_point_quiz_arr3 = explode(';"',$decision_point_quiz_arr2[1]);
		
		$analysis_report_decision_option_action_quiz_no = trim($decision_point_quiz_arr3[0]);
		$analysis_report_decision_option_action_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_action_quiz_no,"quiz_type","");
		$analysis_report_decision_option_action_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_action_quiz_no,"quiz_title","");

		$query_sub = "insert into wise_analysis_report_decision_option_point_quiz set"; 
		$query_sub .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_sub .= " analysis_report_decision_option_action_quiz_no = '".$analysis_report_decision_option_action_quiz_no."', ";
		$query_sub .= " analysis_report_decision_option_action_quiz_type = '".$analysis_report_decision_option_action_quiz_type."', ";
		$query_sub .= " analysis_report_decision_option_action_quiz_title = '".$analysis_report_decision_option_action_quiz_title."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 집단별 처리 종료 ##########
		
	if($_REQUEST['decision_option_status'] == "com"){
		frame_go("decision_4.php?decision_option_idx=".$decision_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}

?>