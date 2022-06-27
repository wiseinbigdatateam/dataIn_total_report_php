<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	$satisfaction_option_model_status = trim(sqlfilter($_REQUEST['satisfaction_option_model_status']));
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$cate_code1_arr = trim($_REQUEST['cate_code1_arr']);
	$cate_name1_arr = trim($_REQUEST['cate_name1_arr']);
	$cate_type1_arr = trim($_REQUEST['cate_type1_arr']);

	$cate_code1_arr2 = explode("|",$cate_code1_arr);
	$cate_name1_arr2 = explode("|",$cate_name1_arr);
	$cate_type1_arr2 = explode("|",$cate_type1_arr);
	
	$score_compare_year_arr = $_REQUEST['score_compare_year'];
	$score_compare_year_cnt = sizeof($score_compare_year_arr);
	$score_compare_arr = $_REQUEST['score_compare'];
	$score_compare_cnt = sizeof($score_compare_arr);

	$score_vench_year_arr = $_REQUEST['score_vench_year'];
	$score_vench_year_cnt = sizeof($score_vench_year_arr);
	$score_vench_arr = $_REQUEST['score_vench'];
	$score_vench_cnt = sizeof($score_vench_arr);

	$table1_view = trim(sqlfilter($_REQUEST['table1_view']));
	$table2_view = trim(sqlfilter($_REQUEST['table2_view']));

	//echo "table1_view = ".$table1_view."<br>";
	
	$compare_cnt = 0;
	for($k=0; $k<$score_compare_cnt; $k++){
		if($score_compare_arr[$k]){
			$compare_cnt = $compare_cnt+1;
		}
	}
	//echo "compare_cnt = ".$compare_cnt."<br>";
	
	if($table1_view == "table_yes"){
		if($compare_cnt < 1){
			error_frame("추세점수를 입력해 주세요.");
		}
	}
	
	//echo "table2_view = ".$table2_view."<br>";

	$vench_cnt = 0;
	for($k=0; $k<$score_vench_cnt; $k++){
		if($score_vench_arr[$k]){
			$vench_cnt = $vench_cnt+1;
		}
	}
	//echo "vench_cnt = ".$vench_cnt."<br>";

	if($table2_view == "table_yes"){
		if($vench_cnt < 1){
			error_frame("벤치마킹을 입력해 주세요.");
		}
	}
	
	// 기준년도
	$base_year = $_REQUEST['score_compare_base_year'];
	
	$sql = "UPDATE wise_analysis_report_satisfaction_option SET analysis_report_satisfaction_option_base_year = '$base_year' WHERE idx = '$satisfaction_option_idx'";
	mysqli_query($gconnet,$sql);

	$sql_group_del = "delete from wise_analysis_report_satisfaction_option_compare where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	$sql_group2_del = "delete from wise_analysis_report_satisfaction_option_compare_list where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group2_del = mysqli_query($gconnet,$sql_group2_del);
		
	/* 추세점수 비교입력 시작 */
	$satisfaction_option_action_compare_type = "C";
	for($i=0; $i<$score_compare_year_cnt; $i++){
		//echo $i." / year = ".$score_compare_year_arr[$i]."<br>";
		
		$satisfaction_option_action_compare_year = trim($score_compare_year_arr[$i]);

		$query_sub = "insert into wise_analysis_report_satisfaction_option_compare set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_compare_type = '".$satisfaction_option_action_compare_type."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_compare_year = '".$satisfaction_option_action_compare_year."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);

		$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option_compare where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$satisfaction_option_compare_idx = $mem_row2[idx]; 

		if($i == 0){
			$kst = 0;
			$ked = (sizeof($cate_code1_arr2)-1);
		} else {
			$kst = (sizeof($cate_code1_arr2)-1)*$i;
			$ked = $kst+(sizeof($cate_code1_arr2)-1); 
		}

		for($k=$kst; $k<$ked; $k++){
			//echo $k." / value = ".$score_compare_arr[$k]."<br>";
			
			if($i == 0){
				$sub_i = $k;
			} else {
				$sub_i = $k-$kst;
			}

			//echo "i = ".$i." / k = ".$k." / sub_i = ".$sub_i."<br>";

			$satisfaction_option_quiz_no = trim($cate_code1_arr2[$sub_i]);
			//$satisfaction_option_quiz_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_quiz_no,"quiz_title","");
			$satisfaction_option_quiz_title = trim($cate_name1_arr2[$sub_i]);
			$satisfaction_option_quiz_type = trim($cate_type1_arr2[$sub_i]);
			$satisfaction_option_quiz_value = trim($score_compare_arr[$k]);

			$query_sub2 = "insert into wise_analysis_report_satisfaction_option_compare_list set"; 
			$query_sub2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_sub2 .= " satisfaction_option_compare_idx = '".$satisfaction_option_compare_idx."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_no = '".$satisfaction_option_quiz_no."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_title = '".$satisfaction_option_quiz_title."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_type = '".$satisfaction_option_quiz_type."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_value = '".$satisfaction_option_quiz_value."', ";
			$query_sub2 .= " wdate = now()";
			echo "추세점수 = ".$query_sub2."<br>";
			$result_sub2 = mysqli_query($gconnet,$query_sub2);

		}
	}
	/* 추세점수 비교입력 종료 */

	/* 벤치마킹 비교입력 시작 */
	$satisfaction_option_action_vench_type = "V";
	for($i=0; $i<$score_vench_year_cnt; $i++){
		//echo $i." / year = ".$score_vench_year_arr[$i]."<br>";
		
		$satisfaction_option_action_vench_year = trim($score_vench_year_arr[$i]);

		$query_sub = "insert into wise_analysis_report_satisfaction_option_compare set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_compare_type = '".$satisfaction_option_action_vench_type."', ";
		$query_sub .= " analysis_report_satisfaction_option_action_compare_year = '".$satisfaction_option_action_vench_year."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);

		$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option_compare where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$satisfaction_option_vench_idx = $mem_row2[idx]; 

		if($i == 0){
			$kst = 0;
			$ked = sizeof($cate_code1_arr2);
		} else {
			$kst = sizeof($cate_code1_arr2)*$i;
			$ked = $kst+sizeof($cate_code1_arr2); 
		}

		//echo $i." / kst = ".$kst."<br>";
		//echo $i." / ked = ".$ked."<br>";

		for($k=$kst; $k<$ked; $k++){
			//echo $k." / value = ".$score_vench_arr[$k]."<br>";
			
			if($i == 0){
				$sub_i = $k;
			} else {
				$sub_i = $k-$kst;
			}

			
			$satisfaction_option_quiz_no = trim($cate_code1_arr2[$sub_i]);
			//$satisfaction_option_quiz_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_quiz_no,"quiz_title","");
			$satisfaction_option_quiz_title = trim($cate_name1_arr2[$sub_i]);
			$satisfaction_option_quiz_type = trim($cate_type1_arr2[$sub_i]);
			$satisfaction_option_quiz_value = trim($score_vench_arr[$k]);
			
			$query_sub2 = "insert into wise_analysis_report_satisfaction_option_compare_list set"; 
			$query_sub2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_sub2 .= " satisfaction_option_compare_idx = '".$satisfaction_option_vench_idx."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_no = '".$satisfaction_option_quiz_no."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_title = '".$satisfaction_option_quiz_title."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_type = '".$satisfaction_option_quiz_type."', ";
			$query_sub2 .= " analysis_report_satisfaction_option_quiz_value = '".$satisfaction_option_quiz_value."', ";
			$query_sub2 .= " wdate = now()";
			echo "벤치마킹 = ".$query_sub2."<br>";
			$result_sub2 = mysqli_query($gconnet,$query_sub2);

		}
	}
	/* 벤치마킹 비교입력 종료 */

	//exit;

	if($_REQUEST['satisfaction_option_model_status'] == "com"){
		frame_go("manjok_5.php?satisfaction_option_idx=".$satisfaction_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}
?>