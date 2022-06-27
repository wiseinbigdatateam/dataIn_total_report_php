<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	$satisfaction_option_status = trim(sqlfilter($_REQUEST['satisfaction_option_status']));
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));

	if(!$satisfaction_option_idx){  
		error_frame_go("다시 진행해주세요.","manjok_1.php");
	}

	$analysis_report_satisfaction_option_score = trim(sqlfilter($_REQUEST['satisfaction_option_score']));
	$analysis_report_satisfaction_option_percent = trim(sqlfilter($_REQUEST['satisfaction_option_percent']));
	$analysis_report_satisfaction_option_scorepoint = trim(sqlfilter($_REQUEST['satisfaction_option_scorepoint']));
	$analysis_report_satisfaction_option_scorepoint2 = trim(sqlfilter($_REQUEST['satisfaction_option_scorepoint2']));
	$analysis_report_satisfaction_option_loyer = trim(sqlfilter($_REQUEST['satisfaction_option_loyer']));

	$satisfaction_option_loyer_stf = trim($_REQUEST['satisfaction_option_loyer_stf']);
	$satisfaction_option_loyer_lyt = trim($_REQUEST['satisfaction_option_loyer_lyt']);

	$satisfaction_option_loyer_stf_arr = explode('href="javascript:',$satisfaction_option_loyer_stf);
	$satisfaction_option_loyer_stf_arr2 = explode(';" class="',$satisfaction_option_loyer_stf_arr[1]);
	$satisfaction_option_loyer_stfno = $satisfaction_option_loyer_stf_arr2[0];
	$satisfaction_option_loyer_stftitle = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_loyer_stfno,"quiz_title","");

	$satisfaction_option_loyer_lyt_arr = explode('href="javascript:',$satisfaction_option_loyer_lyt);
	$satisfaction_option_loyer_lyt_arr2 = explode(';" class="',$satisfaction_option_loyer_lyt_arr[1]);
	$satisfaction_option_loyer_lytno = $satisfaction_option_loyer_lyt_arr2[0];
	$satisfaction_option_loyer_lyttitle = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_loyer_lytno,"quiz_title","");

	if(!$analysis_report_satisfaction_option_scorepoint){
		$analysis_report_satisfaction_option_scorepoint = 1;
	}
	if(!$analysis_report_satisfaction_option_scorepoint2){
		$analysis_report_satisfaction_option_scorepoint2 = 1;
	}
	if($analysis_report_satisfaction_option_loyer != "Y"){
		$analysis_report_satisfaction_option_loyer = "N";
	}

	$query = "update wise_analysis_report_satisfaction_option set"; 
	$query .= " analysis_report_satisfaction_option_score = '".$analysis_report_satisfaction_option_score."', ";
	$query .= " analysis_report_satisfaction_option_percent = '".$analysis_report_satisfaction_option_percent."', ";
	$query .= " analysis_report_satisfaction_option_scorepoint = '".$analysis_report_satisfaction_option_scorepoint."', ";
	$query .= " analysis_report_satisfaction_option_scorepoint2 = '".$analysis_report_satisfaction_option_scorepoint2."', ";
	$query .= " analysis_report_satisfaction_option_loyer = '".$analysis_report_satisfaction_option_loyer."', ";

	$query .= " analysis_report_satisfaction_option_loyer_stfno = '".$satisfaction_option_loyer_stfno."', ";
	$query .= " analysis_report_satisfaction_option_loyer_stftitle = '".$satisfaction_option_loyer_stftitle."', ";
	$query .= " analysis_report_satisfaction_option_loyer_lytno = '".$satisfaction_option_loyer_lytno."', ";
	$query .= " analysis_report_satisfaction_option_loyer_lyttitle = '".$satisfaction_option_loyer_lyttitle."' ";

	//echo $query; exit;

	$query .= " where 1 and idx='".$satisfaction_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}

	//echo "query = ".$query."<br>";
	$result = mysqli_query($gconnet,$query);
	
	############ 케이스 처리 시작 ##########
	$satisfaction_point_case_v = trim($_REQUEST['satisfaction_point_case_v']);
	//echo $satisfaction_point_case_v."<br><br>";
	$satisfaction_point_case_arr = explode('pop_t on',$satisfaction_point_case_v);
	$satisfaction_point_case_arr_c = explode('pop_c on',$satisfaction_point_case_v);
	//echo $satisfaction_point_case_arr_c[1]."<br><br>";
	//exit;
	
	$sql_group_del = "delete from wise_analysis_report_satisfaction_option_point_case where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($satisfaction_point_case_arr); $i++){
		$satisfaction_point_case_arr2 = explode('id="quiz_no_',$satisfaction_point_case_arr[$i]);
		$satisfaction_point_case_arr3 = explode('"><button>',$satisfaction_point_case_arr2[1]);
		$satisfaction_point_case_arr4 = explode('<a href="javascript:',$satisfaction_point_case_arr_c[$i]);
		$satisfaction_point_case_arr5 = explode(';"',$satisfaction_point_case_arr4[1]);

		if($i == sizeof($satisfaction_point_case_arr)-1){
			//echo "arr_4 = ".$satisfaction_point_case_arr4[1]."<br><br>";
		}
		
		$analysis_report_satisfaction_option_case_no = trim($satisfaction_point_case_arr3[0]);
		$analysis_report_satisfaction_option_case_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_case_no,"quiz_title","");
		$analysis_report_satisfaction_option_case_content = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_case_no,"quiz_content","");
		$analysis_report_satisfaction_option_case_answer = trim($satisfaction_point_case_arr5[0]);

		$query_sub = "insert into wise_analysis_report_satisfaction_option_point_case set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_case_no = '".$analysis_report_satisfaction_option_case_no."', ";
		$query_sub .= " analysis_report_satisfaction_option_case_title = '".$analysis_report_satisfaction_option_case_title."', ";
		$query_sub .= " analysis_report_satisfaction_option_case_content = '".$analysis_report_satisfaction_option_case_content."', ";
		$query_sub .= " analysis_report_satisfaction_option_case_answer = '".$analysis_report_satisfaction_option_case_answer."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 케이스 처리 종료 ##########

	############ 행동특성문항 처리 시작 ##########
	$satisfaction_point_quiz_v = trim($_REQUEST['satisfaction_point_quiz_v']);
	$satisfaction_point_quiz_arr = explode('<li id="',$satisfaction_point_quiz_v);
	
	$sql_group_del = "delete from wise_analysis_report_satisfaction_option_point_quiz where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($satisfaction_point_quiz_arr); $i++){
		
		$satisfaction_point_quiz_arr2 = explode('<a href="javascript:',$satisfaction_point_quiz_arr[$i]);
		$satisfaction_point_quiz_arr3 = explode(';"',$satisfaction_point_quiz_arr2[1]);
		
		$analysis_report_satisfaction_option_action_quiz_no = trim($satisfaction_point_quiz_arr3[0]);
		$analysis_report_satisfaction_option_action_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_action_quiz_no,"quiz_type","");
		$analysis_report_satisfaction_option_action_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_action_quiz_no,"quiz_title","");

		$query_sub = "insert into wise_analysis_report_satisfaction_option_point_quiz set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_quiz_no = '".$analysis_report_satisfaction_option_action_quiz_no."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_quiz_type = '".$analysis_report_satisfaction_option_action_quiz_type."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_quiz_title = '".$analysis_report_satisfaction_option_action_quiz_title."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 행동특성문항 처리 종료 ##########
		
	if($_REQUEST['satisfaction_option_status'] == "com"){
		frame_go("manjok_4.php?satisfaction_option_idx=".$satisfaction_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}
?>