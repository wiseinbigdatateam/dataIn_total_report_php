<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "service";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));
	$decision_option_status = trim(sqlfilter($_REQUEST['decision_option_status']));
	$decision_option_report_title = trim(sqlfilter($_REQUEST['decision_option_report_title']));

	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	
	$sql_file_0 = "select decision_option_idx from wise_analysis_report_decision_100data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		$sql_del_0 = "delete from wise_analysis_report_decision_100data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_0 = mysqli_query($gconnet,$sql_del_0);
		$sql_del_1 = "delete from wise_analysis_report_decision_100data_detail where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_1 = mysqli_query($gconnet,$sql_del_1);
		$sql_del_2 = "delete from wise_analysis_report_decision_100data_tlc where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_2 = mysqli_query($gconnet,$sql_del_2);
		$sql_del_3 = "delete from wise_analysis_report_decision_data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_3 = mysqli_query($gconnet,$sql_del_3);
		$sql_del_4 = "delete from wise_analysis_report_decision_data_quiz where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_4 = mysqli_query($gconnet,$sql_del_4);
		$sql_del_5 = "delete from wise_analysis_report_decision_data_ratio where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_5 = mysqli_query($gconnet,$sql_del_5);
		$sql_del_6 = "delete from wise_analysis_report_decision_data2 where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_6 = mysqli_query($gconnet,$sql_del_6);
		$sql_del_7 = "delete from wise_analysis_report_decision_data2_data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_7 = mysqli_query($gconnet,$sql_del_7);
		$sql_del_8 = "delete from wise_analysis_report_decision_data2_data_quiz where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_8 = mysqli_query($gconnet,$sql_del_8);
		$sql_del_9 = "delete from wise_analysis_report_decision_data2_data_ratio where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_9 = mysqli_query($gconnet,$sql_del_9);
		$sql_del_10 = "delete from wise_analysis_report_decision_statistics where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_10 = mysqli_query($gconnet,$sql_del_10);
		$sql_del_11 = "delete from wise_analysis_report_decision_statistics_group where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_11 = mysqli_query($gconnet,$sql_del_11);
		$sql_del_12 = "delete from wise_analysis_report_decision_statistics_group_detail where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_12 = mysqli_query($gconnet,$sql_del_12);
	}

	$compet_info_sql = "select analysis_report_idx,analysis_report_decision_option_percent,analysis_report_decision_option_score from wise_analysis_report_decision_option where 1 and idx='".$decision_option_idx."'";
	if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_frame_go("다시 진행해주세요.","decision_1.php");
	}
	$row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($row['analysis_report_idx']);
	
	$query = "insert into wise_analysis_report_decision_100data set"; 
	$query .= " decision_option_idx = '".$decision_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " decision_option_report_title = '".$decision_option_report_title."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_decision_100data where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$decision_option_100data_idx = $mem_row2[idx]; 
	
	// 집단 구분 항목 
	$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_group.analysis_report_decision_option_group_no) as quiz_no from wise_analysis_report_decision_option_group where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'].",";
		}
	}
	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_quizno_arr = explode(",",$file_1_quizno);
	$file_1_title_arr = explode(",",$file_1_title);
		
	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' order by data_no asc";
	//echo $sql_data_1."<br>";
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$decision_100data_no = $row_data_1['data_no'];

		//if($opt_i > 0){exit;}
		
		######## raw data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$decision_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo $sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				//echo "quiz_no = ".$row_data_2['quiz_no']."<br>";

				$decision_100data_no = $row_data_2['data_no'];
				$decision_100data_quiz_no = $row_data_2['quiz_no'];
				$decision_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$decision_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				if($row_data_2['analysis_idx'] == "10" && ($row_data_2['quiz_no'] >= "15" && $row_data_2['quiz_no'] <= "18")){
					$decision_100data_quiz_val = $row_data_2['data_val'];
				} else {
					if(trim($decision_100data_quiz_conf) == "Y"){
						$decision_100data_quiz_val = $row_data_2['data_val'];
					} else {
						$decision_100data_quiz_val = get_calcurate_point_service($decision_option_idx,$row_data_2['data_val']);
					}
				}

				$query_in = "insert into wise_analysis_report_decision_100data_detail set"; 
				$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
				$query_in .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
				$query_in .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
				$query_in .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
				$query_in .= " analysis_report_decision_100data_quiz_title = '".$decision_100data_quiz_title."', ";
				$query_in .= " analysis_report_decision_100data_quiz_val = '".$decision_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo $query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			
			} // 로우데이터 루프 종료
		######## raw data 시작 ############

		######## 집단구분항목 시작 #############
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$decision_100data_quiz_val = get_decision_gquiz_val($decision_100data_no,$analysis_report_idx,$file_1_quizno2);
				
				$query_in = "insert into wise_analysis_report_decision_100data_detail set"; 
				$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
				$query_in .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
				$query_in .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
				$query_in .= " analysis_report_decision_100data_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_decision_100data_quiz_title = '".$file_1_title2."', ";
				$query_in .= " analysis_report_decision_100data_quiz_val = '".$decision_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo $query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			} // 집단구분항목 루프 종료 
		######## 집단구분항목  종료 #############

		set_rst_decision_tlc($decision_option_idx,$decision_option_100data_idx,$decision_100data_no,$analysis_report_idx); // 응답자별 총점 및 그룹 저장 
			
	} // 웅답자 루프 종료 

	//exit;

	set_rst_decision_tlc_align($decision_option_idx,$decision_option_100data_idx); // 100점환산 데이터 순위설정 

	######## 집단별점수 순위정리 시작 #############
	
	$analysis_report_decision_option_percent = $row['analysis_report_decision_option_percent'];

	// 문항
	$sql_file_2 = "select analysis_report_decision_100data_quiz_no,analysis_report_decision_100data_quiz_title from wise_analysis_report_decision_100data_detail where 1 and decision_option_idx='".$decision_option_idx."' and analysis_report_decision_100data_quiz_title not in ('집단구분항목1','집단구분항목2','집단구분항목3','성별','연령','부서','직급') and analysis_report_decision_100data_no='1'";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_quizno .= $row_file_2['analysis_report_decision_100data_quiz_no'];
			$file_2_title .= $row_file_2['analysis_report_decision_100data_quiz_title'];
		} else {
			$file_2_quizno .= $row_file_2['analysis_report_decision_100data_quiz_no'].",";
			$file_2_title .= $row_file_2['analysis_report_decision_100data_quiz_title'].",";
		}
	}
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);
	
	for($opt2_i=0; $opt2_i<sizeof($file_2_quizno_arr); $opt2_i++){ // 문항루프 시작 
		$file_2_quizno2 = trim($file_2_quizno_arr[$opt2_i]);
		$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

		$analysis_report_decision_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_2_quizno2,"quiz_type","");

		$query_in = "insert into wise_analysis_report_decision_data set"; 
		$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_decision_option_percent = '".$analysis_report_decision_option_percent."', ";
		$query_in .= " analysis_report_decision_option_data_no = '".$file_2_quizno2."', ";
		$query_in .= " analysis_report_decision_option_data_type = '".$analysis_report_decision_option_data_type."', ";
		$query_in .= " analysis_report_decision_option_data_title = '".$file_2_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_decision_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$decision_data_idx = $mem_row2[idx]; 

		$analysis_report_decision_data_quiz_val = get_decision_data_val_avg2($decision_option_idx,$analysis_report_idx,$file_2_quizno2);
		$query_in2 = "insert into wise_analysis_report_decision_data_quiz set"; 
		$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in2 .= " decision_data_idx = '".$decision_data_idx."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_2_quizno2."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		for($ans_i=1; $ans_i<=$row['analysis_report_decision_option_score']; $ans_i++){ // 집단별 점수 데이터가 보기번호 루프시작 
			
			$analysis_report_decision_data_quiz_val = get_decision_data_val_avg($decision_option_idx,$analysis_report_idx,$ans_i,$file_2_quizno2);
			
			$query_in3 = "insert into wise_analysis_report_decision_data_quiz set"; 
			$query_in3 .= " decision_option_idx = '".$decision_option_idx."', ";
			$query_in3 .= " decision_data_idx = '".$decision_data_idx."', ";
			$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_2_quizno2."', ";
			$query_in3 .= " analysis_report_decision_data_quiz_title = '".$ans_i." 의 평균', ";
			$query_in3 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
			$query_in3 .= " wdate = now() ";
			$result_in3 = mysqli_query($gconnet,$query_in3);

		} // 집단별 점수 데이터가 보기번호 루프종료 

	} // 문항루프 종료 

	for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
		$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
		$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
		$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

		$analysis_report_decision_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_1_quizno2,"quiz_type","");
		
		$query_in = "insert into wise_analysis_report_decision_data set"; 
		$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_decision_option_percent = '".$analysis_report_decision_option_percent."', ";
		$query_in .= " analysis_report_decision_option_data_no = '".$file_1_quizno2."', ";
		$query_in .= " analysis_report_decision_option_data_type = '".$analysis_report_decision_option_data_type."', ";
		$query_in .= " analysis_report_decision_option_data_title = '집단구분 - ".$file_1_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_decision_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$decision_data_idx = $mem_row2[idx]; 

		$analysis_report_decision_data_quiz_val = get_decision_data_val_avg2($decision_option_idx,$analysis_report_idx,$file_1_quizno2);
		$query_in2 = "insert into wise_analysis_report_decision_data_quiz set"; 
		$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in2 .= " decision_data_idx = '".$decision_data_idx."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_1_quizno2."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		for($ans_i=1; $ans_i<=$row['analysis_report_decision_option_score']; $ans_i++){ // 집단별 점수 데이터가 보기번호 루프시작 
			
			$analysis_report_decision_data_quiz_val = get_decision_data_val_avg($decision_option_idx,$analysis_report_idx,$ans_i,$file_1_quizno2);
			
			$query_in2 = "insert into wise_analysis_report_decision_data_quiz set"; 
			$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
			$query_in2 .= " decision_data_idx = '".$decision_data_idx."', ";
			$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_1_quizno2."', ";
			$query_in2 .= " analysis_report_decision_data_quiz_title = '".$ans_i." 의 평균', ";
			$query_in2 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
			$query_in2 .= " wdate = now() ";
			$result_in2 = mysqli_query($gconnet,$query_in2);
		} // 집단별 점수 데이터가 보기번호 루프종료 

	} // 집단구분항목 루프 종료 

	$query_in = "insert into wise_analysis_report_decision_data set"; 
	$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
	$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query_in .= " analysis_report_decision_option_data_title = '총점', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre2 = "select idx from wise_analysis_report_decision_data where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$decision_data_idx = $mem_row2[idx]; 

	for($opt2_i=0; $opt2_i<sizeof($file_2_quizno_arr); $opt2_i++){ // 문항루프 시작 
		$file_2_quizno2 = trim($file_2_quizno_arr[$opt2_i]);
		$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

		$analysis_report_decision_data_quiz_val = get_decision_data_val_avg_tot1($decision_option_idx,$file_2_quizno2);
		$query_in2 = "insert into wise_analysis_report_decision_data_quiz set"; 
		$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in2 .= " decision_data_idx = '".$decision_data_idx."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_2_quizno2."', ";
		$query_in2 .= " analysis_report_decision_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		for($ans_i=1; $ans_i<=$row['analysis_report_decision_option_score']; $ans_i++){ // 집단별 점수 데이터가 보기번호 루프시작 
			
			$analysis_report_decision_data_quiz_val = get_decision_data_val_avg_tot2($decision_option_idx,$file_2_quizno2,$ans_i);
			
			$query_in3 = "insert into wise_analysis_report_decision_data_quiz set"; 
			$query_in3 .= " decision_option_idx = '".$decision_option_idx."', ";
			$query_in3 .= " decision_data_idx = '".$decision_data_idx."', ";
			$query_in2 .= " analysis_report_decision_data_quiz_no = '".$file_2_quizno2."', ";
			$query_in3 .= " analysis_report_decision_data_quiz_title = '".$ans_i." 의 평균', ";
			$query_in3 .= " analysis_report_decision_data_quiz_val = '".$analysis_report_decision_data_quiz_val."', ";
			$query_in3 .= " wdate = now() ";
			$result_in3 = mysqli_query($gconnet,$query_in3);

		} // 집단별 점수 데이터가 보기번호 루프종료 
		
	} // 문항루프 종료 
	
	######## 집단별점수 순위정리 종료 #############

######## IPA 입력 시작 ###########
$data_ipa_x_val = get_ipa_x_val_service($decision_option_idx);
$data_ipa_y_val = get_ipa_y_val_service($decision_option_idx);

if($data_ipa_x_val && $data_ipa_y_val){
		
	$query = "insert into wise_analysis_report_decision_statistics set"; 
	$query .= " decision_option_idx = '".$decision_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre = "select idx from wise_analysis_report_decision_statistics where 1 order by idx desc limit 0,1"; 
	$result_pre  = mysqli_query($gconnet,$sql_pre);
	$mem_row = mysqli_fetch_array($result_pre);
	$decision_statistics_idx = $mem_row[idx];

	$query_in = "insert into wise_analysis_report_decision_statistics_group set"; 
	$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
	$query_in .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
	$query_in .= " analysis_report_decision_statistics_group_title = 'Y 절편', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre_2 = "select idx from wise_analysis_report_decision_statistics_group where 1 order by idx desc limit 0,1"; 
	$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
	$mem_row_2 = mysqli_fetch_array($result_pre_2);
	$decision_statistics_group_idx = $mem_row_2[idx];

	$query_in2 = "insert wise_analysis_report_decision_statistics_group_detail set"; 
	$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
	$query_in2 .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
	$query_in2 .= " decision_statistics_group_idx = '".$decision_statistics_group_idx."', ";
	//$query_in2 .= " analysis_report_decision_statistics_group2_no = '".$analysis_report_decision_statistics_group2_no."', ";
	//$query_in2 .= " analysis_report_decision_statistics_group2_title = '".$analysis_report_decision_statistics_group2_title."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_data = '".$analysis_report_decision_statistics_ipa_data."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_stder = '".$analysis_report_decision_statistics_ipa_stder."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_t = '".$analysis_report_decision_statistics_ipa_t."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_pval = '".$analysis_report_decision_statistics_ipa_pval."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_min95 = '".$analysis_report_decision_statistics_ipa_min95."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_max95 = '".$analysis_report_decision_statistics_ipa_max95."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_tabval = '".$analysis_report_decision_statistics_ipa_tabval."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_ratio = '".$analysis_report_decision_statistics_ipa_ratio."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_stf = '".$analysis_report_decision_statistics_ipa_stf."', ";
	$query_in2 .= " analysis_report_decision_statistics_ipa_imt = '".$analysis_report_decision_statistics_ipa_imt."', ";
	$query_in2 .= " analysis_report_decision_statistics_frequency_1 = '".$analysis_report_decision_statistics_frequency_1."', ";
	$query_in2 .= " analysis_report_decision_statistics_frequency_2 = '".$analysis_report_decision_statistics_frequency_2."', ";
	$query_in2 .= " analysis_report_decision_statistics_frequency_3 = '".$analysis_report_decision_statistics_frequency_3."', ";
	$query_in2 .= " analysis_report_decision_statistics_frequency_4 = '".$analysis_report_decision_statistics_frequency_4."', ";
	$query_in2 .= " analysis_report_decision_statistics_frequency_total = '".$analysis_report_decision_statistics_frequency_total."', ";
	$query_in2 .= " analysis_report_decision_statistics_ratio_1 = '".$analysis_report_decision_statistics_ratio_1."', ";
	$query_in2 .= " analysis_report_decision_statistics_ratio_2 = '".$analysis_report_decision_statistics_ratio_2."', ";
	$query_in2 .= " analysis_report_decision_statistics_ratio_3 = '".$analysis_report_decision_statistics_ratio_3."', ";
	$query_in2 .= " analysis_report_decision_statistics_ratio_4 = '".$analysis_report_decision_statistics_ratio_4."', ";
	$query_in2 .= " analysis_report_decision_statistics_ratio_total = '".$analysis_report_decision_statistics_ratio_total."', ";
	$query_in2 .= " wdate = now() ";
	$result_in2 = mysqli_query($gconnet,$query_in2); // Y 절편 
	
	################## 집단구분항목 추출 시작 ################
	/*$file_1_idx = "";
	$file_1_title = "";

	$sql_file_1 = "select * from wise_analysis_report_decision_option_group where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['analysis_report_decision_option_group_no'];
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['analysis_report_decision_option_group_no'].",";
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);*/
	################# 집단구분항목 추출 종료 ################

		include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_ipa_data.php"; // IPA 데이터 추출 인클루드
	
		$ipa_total_t = 0;
		//echo "T cnt = ".sizeof($getTStats)."<br>";
		for($ipa_t_i=0; $ipa_t_i<sizeof($getTStats); $ipa_t_i++){ // T 계수 배열수만큼 루프 시작  
			//echo $ipa_t_i." : ".$getTStats[$ipa_t_i]."<br>";
			if($getTStats[$ipa_t_i] < 0){
				$ipa_t = $getTStats[$ipa_t_i]*-1;
			} else {
				$ipa_t = $getTStats[$ipa_t_i];
			}
			$ipa_total_t = $ipa_total_t + $ipa_t; // t 통계량 합계
		} // T 계수 배열수만큼 루프 종료 
		$ipa_total_t = round($ipa_total_t,14);
	
		$ipa_total_ratio = 0; // 전체합 1로 변환 합계
		$ipa_total_stf = 0; // 서비스평가 합계
		$ipa_total_imt = 0; // 중요도 합계
		for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
			$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
			$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
			$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

			$query_in = "insert into wise_analysis_report_decision_statistics_group set"; 
			$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
			$query_in .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
			$query_in .= " analysis_report_decision_statistics_group_no = '".$file_1_idx2."', ";
			$query_in .= " analysis_report_decision_statistics_group_title = '".$file_1_title2."', ";
			$query_in .= " wdate = now() ";
			$result_in = mysqli_query($gconnet,$query_in);

			$sql_pre_2 = "select idx from wise_analysis_report_decision_statistics_group where 1 order by idx desc limit 0,1"; 
			$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
			$mem_row_2 = mysqli_fetch_array($result_pre_2);
			$decision_statistics_group_idx = $mem_row_2[idx];
		
			$analysis_report_decision_statistics_ipa_t = round($getTStats[$opt3_i],14);
			if($analysis_report_decision_statistics_ipa_t < 0){
				$analysis_report_decision_statistics_ipa_t = $analysis_report_decision_statistics_ipa_t*-1;
			}
			$analysis_report_decision_statistics_ipa_tabval = round($getTStats[$opt3_i],14);
			if($analysis_report_decision_statistics_ipa_tabval < 0){
				$analysis_report_decision_statistics_ipa_tabval = $analysis_report_decision_statistics_ipa_tabval*-1;
			}
			$analysis_report_decision_statistics_ipa_ratio = round($analysis_report_decision_statistics_ipa_t/$ipa_total_t,3);
			$analysis_report_decision_statistics_ipa_stf = get_perq_ipa_avg_service($decision_option_idx,$file_1_idx2,$file_1_title2); // 문항별 평균 서비스평가(?) - 확인필요 
			//$analysis_report_decision_statistics_ipa_stf = get_perq_ipa_avg_service($decision_option_idx,$file_1_quizno2,$file_1_title2); // 문항별 평균 서비스평가(?) - 확인필요  
			$analysis_report_decision_statistics_ipa_imt = $analysis_report_decision_statistics_ipa_ratio; // 중요도 

			$query_in2 = "insert wise_analysis_report_decision_statistics_group_detail set"; 
			$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
			$query_in2 .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
			$query_in2 .= " decision_statistics_group_idx = '".$decision_statistics_group_idx."', ";
			//$query_in2 .= " analysis_report_decision_statistics_group2_no = '".$analysis_report_decision_statistics_group2_no."', ";
			//$query_in2 .= " analysis_report_decision_statistics_group2_title = '".$analysis_report_decision_statistics_group2_title."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_data = '".$analysis_report_decision_statistics_ipa_data."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_stder = '".$analysis_report_decision_statistics_ipa_stder."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_t = '".$analysis_report_decision_statistics_ipa_t."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_pval = '".$analysis_report_decision_statistics_ipa_pval."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_min95 = '".$analysis_report_decision_statistics_ipa_min95."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_max95 = '".$analysis_report_decision_statistics_ipa_max95."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_tabval = '".$analysis_report_decision_statistics_ipa_tabval."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_ratio = '".$analysis_report_decision_statistics_ipa_ratio."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_stf = '".$analysis_report_decision_statistics_ipa_stf."', ";
			$query_in2 .= " analysis_report_decision_statistics_ipa_imt = '".$analysis_report_decision_statistics_ipa_imt."', ";
			$query_in2 .= " analysis_report_decision_statistics_frequency_1 = '".$analysis_report_decision_statistics_frequency_1."', ";
			$query_in2 .= " analysis_report_decision_statistics_frequency_2 = '".$analysis_report_decision_statistics_frequency_2."', ";
			$query_in2 .= " analysis_report_decision_statistics_frequency_3 = '".$analysis_report_decision_statistics_frequency_3."', ";
			$query_in2 .= " analysis_report_decision_statistics_frequency_4 = '".$analysis_report_decision_statistics_frequency_4."', ";
			$query_in2 .= " analysis_report_decision_statistics_frequency_total = '".$analysis_report_decision_statistics_frequency_total."', ";
			$query_in2 .= " analysis_report_decision_statistics_ratio_1 = '".$analysis_report_decision_statistics_ratio_1."', ";
			$query_in2 .= " analysis_report_decision_statistics_ratio_2 = '".$analysis_report_decision_statistics_ratio_2."', ";
			$query_in2 .= " analysis_report_decision_statistics_ratio_3 = '".$analysis_report_decision_statistics_ratio_3."', ";
			$query_in2 .= " analysis_report_decision_statistics_ratio_4 = '".$analysis_report_decision_statistics_ratio_4."', ";
			$query_in2 .= " analysis_report_decision_statistics_ratio_total = '".$analysis_report_decision_statistics_ratio_total."', ";
			$query_in2 .= " wdate = now() ";
			$result_in2 = mysqli_query($gconnet,$query_in2); 
		
			$ipa_total_ratio = $ipa_total_ratio+$analysis_report_decision_statistics_ipa_ratio;
			$ipa_total_stf = $ipa_total_stf+$analysis_report_decision_statistics_ipa_stf;
			$ipa_total_imt = $ipa_total_imt+$analysis_report_decision_statistics_ipa_imt;
	
		} // 집단구분항목 루프 종료 

		$query_in = "insert into wise_analysis_report_decision_statistics_group set"; 
		$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
		$query_in .= " analysis_report_decision_statistics_group_title = '합계', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_decision_statistics_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$decision_statistics_group_idx = $mem_row_2[idx];

		$query_in2 = "insert wise_analysis_report_decision_statistics_group_detail set"; 
		$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in2 .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
		$query_in2 .= " decision_statistics_group_idx = '".$decision_statistics_group_idx."', ";
		//$query_in2 .= " analysis_report_decision_statistics_group2_no = '".$analysis_report_decision_statistics_group2_no."', ";
		//$query_in2 .= " analysis_report_decision_statistics_group2_title = '".$analysis_report_decision_statistics_group2_title."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_t = '".$ipa_total_t."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_tabval = '".$ipa_total_t."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_ratio = '".$ipa_total_ratio."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_stf = '".$ipa_total_stf."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_imt = '".$ipa_total_imt."', ";
		$query_in2 .= " analysis_report_decision_statistics_frequency_total = '".$analysis_report_decision_statistics_frequency_total."', ";
		$query_in2 .= " analysis_report_decision_statistics_ratio_total = '".$analysis_report_decision_statistics_ratio_total."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2); // 합계

		$query_in = "insert into wise_analysis_report_decision_statistics_group set"; 
		$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
		$query_in .= " analysis_report_decision_statistics_group_title = '평균', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_decision_statistics_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$decision_statistics_group_idx = $mem_row_2[idx];

		$ipa_avg_stf = round($ipa_total_stf/sizeof($file_1_idx_arr),3); 
		$ipa_avg_imt = round($ipa_total_imt/sizeof($file_1_idx_arr),3); 

		$query_in2 = "insert wise_analysis_report_decision_statistics_group_detail set"; 
		$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query_in2 .= " decision_statistics_idx = '".$decision_statistics_idx."', ";
		$query_in2 .= " decision_statistics_group_idx = '".$decision_statistics_group_idx."', ";
		//$query_in2 .= " analysis_report_decision_statistics_group2_no = '".$analysis_report_decision_statistics_group2_no."', ";
		//$query_in2 .= " analysis_report_decision_statistics_group2_title = '".$analysis_report_decision_statistics_group2_title."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_stf = '".$ipa_avg_stf."', ";
		$query_in2 .= " analysis_report_decision_statistics_ipa_imt = '".$ipa_avg_imt."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2); // 평균
}
######## IPA 입력 종료 ###########

error_frame("보고서가 저장되었습니다.");
		
?>	