<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$satisfaction_option_idx = trim($_REQUEST['satisfaction_option_idx']);
	
	/*$sql_prev_1 = "select analysis_report_satisfaction_option_variable_title from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X' order by idx asc"; // 독립변수 
	$query_prev_1 = mysqli_query($GLOBALS['gconnet'],$sql_prev_1);
	$query_prev_1_cnt = mysqli_num_rows($query_prev_1);
	$search_prev_1 = "";
	for($opt_prev_1=0; $opt_prev_1<$query_prev_1_cnt; $opt_prev_1++){
		$row_prev_1 = mysqli_fetch_array($query_prev_1);
		if($opt_prev_1 == $query_prev_1_cnt-1){
			$search_prev_1 .= "'".trim($row_prev_1['analysis_report_satisfaction_option_variable_title'])."'";
		} else {
			$search_prev_1 .= "'".trim($row_prev_1['analysis_report_satisfaction_option_variable_title'])."',";	
		}
	}
		
	$data_ipa_x_val = array();
	if(!$search_prev_1){ // 독립변수 없음 
	} else { // 독립변수 있음
		$sql_file_1 = "select distinct(analysis_report_satisfaction_100data_no) from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by CONVERT(analysis_report_satisfaction_100data_no, UNSIGNED) asc";
		$query_file_1 = mysqli_query($GLOBALS['gconnet'],$sql_file_1);
		$query_file_1_cnt = mysqli_num_rows($query_file_1);
		
		for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
			$row_file_1 = mysqli_fetch_array($query_file_1);
					
			$opt_sql = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title,analysis_report_satisfaction_100data_quiz_val from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_quiz_title in (".$search_prev_1.") and analysis_report_satisfaction_100data_no='".$row_file_1['analysis_report_satisfaction_100data_no']."' order by analysis_report_satisfaction_100data_model_no asc";
			//echo $opt_sql."<br>";
			$opt_query = mysqli_query($GLOBALS['gconnet'],$opt_sql);
			$opt_cnt = mysqli_num_rows($opt_query);
			//echo $opt_cnt."<br>";
			for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
				$opt_row = mysqli_fetch_array($opt_query);
				$data_ipa_x_val[$opt_i][$opt_i2] = $opt_row['analysis_report_satisfaction_100data_quiz_val'];
			}
			
		}
	} // 독립변수 있음 종료

	$sql_prev_1 = "select analysis_report_satisfaction_option_variable_title from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='Y' order by idx asc"; // 종속변수 
	$query_prev_1 = mysqli_query($GLOBALS['gconnet'],$sql_prev_1);
	$query_prev_1_cnt = mysqli_num_rows($query_prev_1);
	$search_prev_1 = "";
	for($opt_prev_1=0; $opt_prev_1<$query_prev_1_cnt; $opt_prev_1++){
		$row_prev_1 = mysqli_fetch_array($query_prev_1);
		if($opt_prev_1 == $query_prev_1_cnt-1){
			$search_prev_1 .= "'".trim($row_prev_1['analysis_report_satisfaction_option_variable_title'])."'";
		} else {
			$search_prev_1 .= "'".trim($row_prev_1['analysis_report_satisfaction_option_variable_title'])."',";	
		}
	}
	
	$data_ipa_y_val = array();
	if(!$search_prev_1){ // 종속변수 없음 
	} else { // 종속변수 있음
		$sql_file_1 = "select distinct(analysis_report_satisfaction_100data_no) from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by CONVERT(analysis_report_satisfaction_100data_no, UNSIGNED) asc";
		$query_file_1 = mysqli_query($GLOBALS['gconnet'],$sql_file_1);
		$query_file_1_cnt = mysqli_num_rows($query_file_1);
		
		for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
			$row_file_1 = mysqli_fetch_array($query_file_1);
					
			$opt_sql = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title,analysis_report_satisfaction_100data_quiz_val from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_quiz_title in (".$search_prev_1.") and analysis_report_satisfaction_100data_no='".$row_file_1['analysis_report_satisfaction_100data_no']."' order by analysis_report_satisfaction_100data_model_no asc";
			//echo $opt_sql."<br>";
			$opt_query = mysqli_query($GLOBALS['gconnet'],$opt_sql);
			$opt_cnt = mysqli_num_rows($opt_query);
			//echo $opt_cnt."<br>";
			for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
				$opt_row = mysqli_fetch_array($opt_query);
				$data_ipa_y_val[$opt_i][$opt_i2] = $opt_row['analysis_report_satisfaction_100data_quiz_val'];
			}
			
		}
	} // 종속변수 있음 종료

	/*for($row=0; $row<$query_file_1_cnt; $row++) {
	   for($column=0; $column < count($data_ipa_y_val[$row]); $column++){
		    echo $data_ipa_y_val[$row][$column].",";
	    }
       echo "<br>";
	}
	exit;*/

	$data_ipa_x_val = get_ipa_x_val($satisfaction_option_idx);
	$data_ipa_y_val = get_ipa_y_val($satisfaction_option_idx);

	include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_ipa_data.php"; // IPA 데이터 추출 인클루드
	
?>