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

	$pay_str = $row_file_0['satisfaction_option_report_title']."_만족도지수";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d")."_".date("H-i-s").".csv";

	header("Content-type: text/csv; charset=UTF-8");
	header("Content-Disposition: attachment; filename=$filename");
	header( "Content-Description: PHP5 Generated Data" );

	$satisfaction_option_idx = $row_file_0['satisfaction_option_idx'];
	$analysis_report_idx = $row_file_0['analysis_report_idx'];

	//$sql_file_1 = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_no='1' and analysis_report_satisfaction_100data_quiz_title not in ('고객만족도_상하','충성도_상하','고객충성집단')"; // 문항

	$sql_file_1 = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_no='1' and (analysis_report_satisfaction_100data_quiz_no in (select quiz_no from wise_analysis_quiz where 1 and analysis_idx='".$analysis_report_idx."' and (idx in (select analysis_report_satisfaction_option_group_no from wise_analysis_report_satisfaction_option_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."') or idx in (select analysis_report_satisfaction_option_factor_no from wise_analysis_report_satisfaction_option_model_quiz where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and  analysis_report_satisfaction_option_factor_type='P'))) or analysis_report_satisfaction_100data_quiz_no is null) and analysis_report_satisfaction_100data_quiz_title not in ('고객만족도_상하','충성도_상하','고객충성집단')"; // 문항

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

	$sql_file_2 = "select satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title from wise_analysis_report_satisfaction_data_group_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' group by satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title order by satisfaction_data_group_idx asc,CONVERT(analysis_report_satisfaction_data_group2_no, UNSIGNED) asc"; // 그룹 데이터
	//echo "sql_file_2 = ".$sql_file_2."<br>";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	// 엑셀파일 문항제목(셀제목) 처리
	$title = "\xEF\xBB\xBF"; 		// UTF-8 BOM -- 한글글자셋 인식용
	$title .= "NO";

			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);

				$title .= ",".$file_1_title2;
		<?
			}
			echo $title."\n";

			for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
				$row_file_2 = mysqli_fetch_array($query_file_2);

				$sql_file_3 = "select analysis_report_satisfaction_data_group_title from wise_analysis_report_satisfaction_data_group where 1 and idx='".$row_file_2['satisfaction_data_group_idx']."' and satisfaction_option_idx='".$satisfaction_option_idx."'";
				$query_file_3 = mysqli_query($gconnet,$sql_file_3);
				$row_file_3 = mysqli_fetch_array($query_file_3);

				$total_print = "";
				if($group_title != $row_file_3['analysis_report_satisfaction_data_group_title']){
					$total_print .= $row_file_3['analysis_report_satisfaction_data_group_title'];
				}
				if($total_print != "") $total_print .= ",";
				$total_print .= $row_file_2['analysis_report_satisfaction_data_group2_no']." = ".$row_file_2['analysis_report_satisfaction_data_group2_title'];

				for($opt2_i=0; $opt2_i<sizeof($file_1_title_arr); $opt2_i++){
					$file_1_idx2 = trim($file_1_idx_arr[$opt2_i]);
					$file_1_title2 = trim($file_1_title_arr[$opt2_i]);

					if($total_print != "") $total_print .= ",";
					$total_print .= get_satisfaction_data_group_detail($satisfaction_option_idx,$row_file_2['satisfaction_data_group_idx'],$row_file_2['analysis_report_satisfaction_data_group2_no'],$file_1_idx2,$file_1_title2);
				}
				echo $total_print."\n";
			$group_title = $row_file_3['analysis_report_satisfaction_data_group_title'];
			}
		?>