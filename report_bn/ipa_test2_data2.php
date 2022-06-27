<? include "./inc/header.php"; ?>
<?
	$sql_file_1 = "select distinct(analysis_report_satisfaction_100data_no) from wise_analysis_report_satisfaction_100data_detail where 1 order by CONVERT(analysis_report_satisfaction_100data_no, UNSIGNED) asc"; // 독립변수 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	
	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
		$row_file_1 = mysqli_fetch_array($query_file_1);
		
		$opt_sql = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title,analysis_report_satisfaction_100data_quiz_val from wise_analysis_report_satisfaction_100data_detail where 1 and analysis_report_satisfaction_100data_quiz_title='고객만족도' and analysis_report_satisfaction_100data_no='".$row_file_1['analysis_report_satisfaction_100data_no']."'";
		$opt_query = mysqli_query($gconnet,$opt_sql);
		$opt_cnt = mysqli_num_rows($opt_query);
	
		for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
			$opt_row = mysqli_fetch_array($opt_query);

			if($opt_i2 == $opt_cnt-1){
				$batting_spe = "";
				$row_l = "), <br>";	
			} else {
				$batting_spe = ",";
				$row_l = "";	
			}
			
			if($opt_i2 == 0){
				$row_f = "array(";
			} else {
				$row_f = "";
			}

			echo $row_f.$opt_row['analysis_report_satisfaction_100data_quiz_val'].$batting_spe.$row_l;

		}
	}
?>