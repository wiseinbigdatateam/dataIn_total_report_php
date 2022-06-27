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

	$factor_no_x_g = $_REQUEST['factor_no_x_g']; // 표본특성문항
	$factor_no_x_g_arr = explode('<li id="',$factor_no_x_g);

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$decision_option_idx){  
		error_frame_go("다시 진행해주세요.","decision_1.php");
	}

	$sql_pre2 = "select idx from wise_analysis_report_decision_option_model where 1 and decision_option_idx='".$decision_option_idx."' order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$decision_option_model_idx = $mem_row2[idx]; 

	for($i=1; $i<sizeof($factor_no_x_g_arr); $i++){
		$desicion_option_data_arr2 = explode('<a href="javascript:',$factor_no_x_g_arr[$i]);
		$desicion_option_data_arr3 = explode(';"',$desicion_option_data_arr2[1]);
		
		$analysis_report_decision_option_model_quiz_no = trim($desicion_option_data_arr3[0]);
		
		if($_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.'']){
			$analysis_report_decision_option_model_quiz_title = $_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.''];
		} else {
			$analysis_report_decision_option_model_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_model_quiz_no,"quiz_title","");
		}

		$query_sub = "update wise_analysis_report_decision_option_model_quiz set"; 
		$query_sub .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."' ";
		$query_sub .= " where 1 and decision_option_idx = '".$decision_option_idx."' and decision_option_model_idx = '".$decision_option_model_idx."' and analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."' ";
		//echo $query_sub."<br>";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}

	if($_REQUEST['decision_option_status'] == "com"){
		frame_go("decision_3.php?decision_option_idx=".$decision_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}
?>