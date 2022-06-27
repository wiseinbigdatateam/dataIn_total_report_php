<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));

	$sql_file_0 = "select satisfaction_option_idx,analysis_report_idx,satisfaction_option_report_title from wise_analysis_report_satisfaction_100data where 1 ";
	if($satisfaction_option_idx){
		$sql_file_0 .= " and satisfaction_option_idx='".$satisfaction_option_idx."'";
	}
	$sql_file_0 .= " order by idx desc limit 0,1";

	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);

	$pay_str = $row_file_0['satisfaction_option_report_title'];
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d")."_".date("H-i-s").".csv";

	header("Content-type: text/csv; charset=UTF-8");
	header("Content-Disposition: attachment; filename=$filename");
	header( "Content-Description: PHP5 Generated Data" );

	$satisfaction_option_idx = $row_file_0['satisfaction_option_idx'];

	$sql_file_1 = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_no='1'"; // 문항
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'];
		} else {
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);

	$sql_file_2 = "select distinct analysis_report_satisfaction_100data_no from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by CONVERT(analysis_report_satisfaction_100data_no, UNSIGNED) asc"; // 응답 데이터
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	// 엑셀파일 문항제목(셀제목) 처리
	$title = "\xEF\xBB\xBF"; 		// UTF-8 BOM -- 한글글자셋 인식용
	$title .= "NO";

	for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
		$file_1_title2 = trim($file_1_title_arr[$opt_i]);

		$title .= ",".$file_1_title2;
	}

	echo $title."\n";

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
		$row_file_2 = mysqli_fetch_array($query_file_2);
		$data_no = $row_file_2['analysis_report_satisfaction_100data_no'];

		$total_print = "";
		$total_print .= $data_no;
		for($opt2_i=0; $opt2_i<sizeof($file_1_title_arr); $opt2_i++){
			$file_1_idx2 = trim($file_1_idx_arr[$opt2_i]);
			$file_1_title2 = trim($file_1_title_arr[$opt2_i]);

			$total_print .= ",".get_satisfaction_100data_no_val($satisfaction_option_idx,$data_no,$file_1_idx2,$file_1_title2);
		}
		echo $total_print."\n";
	}
?>