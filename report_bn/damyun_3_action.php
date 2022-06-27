<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "damyun";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;

	$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$damyun_option_status = trim(sqlfilter($_REQUEST['damyun_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$damyun_option_idx){  
		error_frame_go("다시 진행해주세요.","damyun_1.php");
	}

	$analysis_report_damyun_option_score = trim(sqlfilter($_REQUEST['damyun_option_score']));
	$analysis_report_damyun_option_percent = trim(sqlfilter($_REQUEST['damyun_option_percent']));
	$analysis_report_damyun_option_scorepoint = trim(sqlfilter($_REQUEST['damyun_option_scorepoint']));
	$analysis_report_damyun_option_scorepoint2 = trim(sqlfilter($_REQUEST['damyun_option_scorepoint2']));
	$analysis_report_damyun_option_case = trim(sqlfilter($_REQUEST['damyun_option_case']));
	
	$query = "update wise_analysis_report_damyun_option set"; 
	$query .= " analysis_report_damyun_option_score = '".$analysis_report_damyun_option_score."', ";
	$query .= " analysis_report_damyun_option_percent = '".$analysis_report_damyun_option_percent."', ";
	$query .= " analysis_report_damyun_option_scorepoint = '".$analysis_report_damyun_option_scorepoint."', ";
	$query .= " analysis_report_damyun_option_scorepoint2 = '".$analysis_report_damyun_option_scorepoint2."', ";
	$query .= " analysis_report_damyun_option_case = '".$analysis_report_damyun_option_case."' ";
	$query .= " where 1 and idx='".$damyun_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	$result = mysqli_query($gconnet,$query);
	
	############ 케이스 처리 시작 ##########
	$damyun_point_case_v = trim($_REQUEST['damyun_point_case_v']);
	//echo $damyun_point_case_v."<br><br>";
	$damyun_point_case_arr = explode('pop_t on',$damyun_point_case_v);
	$damyun_point_case_arr_c = explode('pop_c on',$damyun_point_case_v);
	//echo $damyun_point_case_arr_c[1]."<br><br>";
	//exit;
	
	$sql_group_del = "delete from wise_analysis_report_damyun_option_point_case where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($damyun_point_case_arr); $i++){
		$damyun_point_case_arr2 = explode('id="quiz_no_',$damyun_point_case_arr[$i]);
		$damyun_point_case_arr3 = explode('"><button>',$damyun_point_case_arr2[1]);
		$damyun_point_case_arr4 = explode('<a href="javascript:',$damyun_point_case_arr_c[$i]);
		$damyun_point_case_arr5 = explode(';"',$damyun_point_case_arr4[1]);

		if($i == sizeof($damyun_point_case_arr)-1){
			//echo "arr_4 = ".$damyun_point_case_arr4[1]."<br><br>";
		}
		
		$analysis_report_damyun_option_case_no = trim($damyun_point_case_arr3[0]);
		$analysis_report_damyun_option_case_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_case_no,"quiz_title","");
		$analysis_report_damyun_option_case_content = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_case_no,"quiz_content","");
		$analysis_report_damyun_option_case_answer = trim($damyun_point_case_arr5[0]);

		$query_sub = "insert into wise_analysis_report_damyun_option_point_case set"; 
		$query_sub .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_sub .= " analysis_report_damyun_option_case_no = '".$analysis_report_damyun_option_case_no."', ";
		$query_sub .= " analysis_report_damyun_option_case_title = '".$analysis_report_damyun_option_case_title."', ";
		$query_sub .= " analysis_report_damyun_option_case_content = '".$analysis_report_damyun_option_case_content."', ";
		$query_sub .= " analysis_report_damyun_option_case_answer = '".$analysis_report_damyun_option_case_answer."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}
	############ 케이스 처리 종료 ##########

	############ 가중치 처리 시작 ##########

	$damyun_point_weight_v = trim($_REQUEST['damyun_point_weight_v']);
	//echo "가중치 = ".
	
	$sql_group_del2 = "delete from wise_analysis_report_damyun_option_point_weight where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group_del2 = mysqli_query($gconnet,$sql_group_del2);

	$sql_group_del3 = "delete from wise_analysis_report_damyun_option_point_weight_estimate where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group_del3 = mysqli_query($gconnet,$sql_group_del3);
	
	$damyun_point_weight_v = $_REQUEST['damyun_point_weight_v'];
	$damyun_point_weight_v_arr = explode('<li id="',$damyun_point_weight_v);
	$damyun_point_weight_v_arr2 = explode('<a href="javascript:',$damyun_point_weight_v_arr[1]);
	$damyun_point_weight_v_arr3 = explode(';"',$damyun_point_weight_v_arr2[1]);

	$analysis_report_damyun_option_weight_quiz_no = trim($damyun_point_weight_v_arr3[0]);
	$analysis_report_damyun_option_weight_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_weight_quiz_no,"quiz_type","");
	$analysis_report_damyun_option_weight_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_weight_quiz_no,"quiz_title","");

	$query_sub2 = "insert into wise_analysis_report_damyun_option_point_weight set"; 
	$query_sub2 .= " damyun_option_idx = '".$damyun_option_idx."', ";
	$query_sub2 .= " analysis_report_damyun_option_weight_quiz_no = '".$analysis_report_damyun_option_weight_quiz_no."', ";
	$query_sub2 .= " analysis_report_damyun_option_weight_quiz_type = '".$analysis_report_damyun_option_weight_quiz_type."', ";
	$query_sub2 .= " analysis_report_damyun_option_weight_quiz_title = '".$analysis_report_damyun_option_weight_quiz_title."', ";
	$query_sub2 .= " wdate = now()";
	//echo $query_sub2."<br>"; exit;
	$result_sub2 = mysqli_query($gconnet,$query_sub2);

	$sql_pre2 = "select idx from wise_analysis_report_damyun_option_point_weight where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$damyun_option_weight_idx = $mem_row2[idx]; 

	/*$sql_file_3 = "select * from wise_analysis_report_damyun_option_point_weight_estimate where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_weight_idx='".$damyun_option_weight_idx."' order by idx asc"; 
	$query_file_3 = mysqli_query($gconnet,$sql_file_3);
	$query_file_3_cnt = mysqli_num_rows($query_file_3);
	if($query_file_3_cnt == 0){
		$query_file_3_cnt = 4;
	}*/

	$query_file_3_cnt = trim(sqlfilter($_REQUEST['query_file_3_cnt']));

	for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){
		$analysis_report_damyun_option_weight_estimate_title = trim(sqlfilter($_REQUEST['option_weight_estimate_title_'.$opt_i.'']));
		$analysis_report_damyun_option_weight_estimate_val1 = trim(sqlfilter($_REQUEST['option_weight_estimate_val1_'.$opt_i.'']));
		$analysis_report_damyun_option_weight_estimate_val2 = trim(sqlfilter($_REQUEST['option_weight_estimate_val2_'.$opt_i.'']));
		$analysis_report_damyun_option_weight_estimate_val3 = trim(sqlfilter($_REQUEST['option_weight_estimate_val3_'.$opt_i.'']));

		$query_sub3 = "insert into wise_analysis_report_damyun_option_point_weight_estimate set"; 
		$query_sub3 .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_sub3 .= " damyun_option_weight_idx = '".$damyun_option_weight_idx."', ";
		$query_sub3 .= " analysis_report_damyun_option_weight_estimate_title = '".$analysis_report_damyun_option_weight_estimate_title."', ";
		$query_sub3 .= " analysis_report_damyun_option_weight_estimate_val1 = '".$analysis_report_damyun_option_weight_estimate_val1."', ";
		$query_sub3 .= " analysis_report_damyun_option_weight_estimate_val2 = '".$analysis_report_damyun_option_weight_estimate_val2."', ";
		$query_sub3 .= " analysis_report_damyun_option_weight_estimate_val3 = '".$analysis_report_damyun_option_weight_estimate_val3."', ";
		$query_sub3 .= " wdate = now()";
		//echo $query_sub3."<br>"; //exit;
		$result_sub3 = mysqli_query($gconnet,$query_sub3);
	}
	############ 가중치 처리 종료 ##########

	if($_REQUEST['damyun_option_status'] == "com"){
		frame_go("damyun_4.php?damyun_option_idx=".$damyun_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}

?>