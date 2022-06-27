<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
//exit;
// http://surveyin.kr/report/cron_damyun_report_sub_dev.php?damyun_option_idx=12
// http://114.207.246.199/report/cron_damyun_report_sub_dev.php?damyun_option_idx=12
$bbs_code = "damyun";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));
//echo "damyun_option_idx = ".$damyun_option_idx."<br>"; exit;

	$compet_info_sql = "select analysis_report_idx,analysis_report_damyun_option_percent,analysis_report_damyun_option_score,analysis_report_damyun_option_scorepoint from wise_analysis_report_damyun_option where 1 and idx='".$damyun_option_idx."'";
	/*if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}*/
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_frame_go("다시 진행해주세요.","damyun_1.php");
	}
	$row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($row['analysis_report_idx']);
	
	$sql_pre2 = "select idx from wise_analysis_report_damyun_100data where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$damyun_option_100data_idx = $mem_row2[idx]; 
	
	// 집단 구분 항목 
	$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_damyun_option_group.analysis_report_damyun_option_group_no) as quiz_no from wise_analysis_report_damyun_option_group where 1 and damyun_option_idx='".$damyun_option_idx."' and type='P' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_damyun_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_damyun_option_group_title'].",";
		}
	}
	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_quizno_arr = explode(",",$file_1_quizno);
	$file_1_title_arr = explode(",",$file_1_title);

	// 동일배점 설정 테이블
	$sql_file_2 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_damyun_option_samescyn_quiz.analysis_report_damyun_option_samescyn_quiz_no) as quiz_no from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx='".$damyun_option_idx."' order by idx asc";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_idx .= $row_file_2['idx'];
			$file_2_quizno .= $row_file_2['quiz_no'];
			$file_2_title .= $row_file_2['analysis_report_damyun_option_samescyn_quiz_title'];
		} else {
			$file_2_idx .= $row_file_2['idx'].",";
			$file_2_quizno .= $row_file_2['quiz_no'].",";
			$file_2_title .= $row_file_2['analysis_report_damyun_option_samescyn_quiz_title'].",";
		}
	}
	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);

	// 분석모델 항목 설정 테이블
	$sql_file_3 = "select idx,analysis_report_damyun_option_samescyn_title from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx='".$damyun_option_idx."' and (analysis_report_damyun_option_samescyn_title != '' or analysis_report_damyun_option_samescyn_title is null) order by idx asc";
	//echo $sql_file_3."<br>";
	$query_file_3 = mysqli_query($gconnet,$sql_file_3);
	$query_file_3_cnt = mysqli_num_rows($query_file_3);
	//echo $query_file_3_cnt."<br>";
	for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){ 
		$row_file_3 = mysqli_fetch_array($query_file_3);
		if($opt_i == $query_file_3_cnt-1){
			$file_3_idx .= $row_file_3['idx'];
			$file_3_title .= $row_file_3['analysis_report_damyun_option_samescyn_title'];
		} else {
			$file_3_idx .= $row_file_3['idx'].",";
			$file_3_title .= $row_file_3['analysis_report_damyun_option_samescyn_title'].",";
		}
	}
	$file_3_idx_arr = explode(",",$file_3_idx);
	$file_3_title_arr = explode(",",$file_3_title);
		
	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' order by data_no asc";
	//echo $sql_data_1."<br>"; exit;
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$damyun_100data_no = $row_data_1['data_no'];

			//if($opt_i > 0){exit;}
								
			######## 핵심구분 시작 #########
			//echo "file3 cnt = ".sizeof($file_3_idx_arr)."<br>"; exit;			
			for($opt_i2=0; $opt_i2<sizeof($file_3_idx_arr); $opt_i2++){ 
				$file_3_idx = trim($file_3_idx_arr[$opt_i2]);
				$file_3_title = trim($file_3_title_arr[$opt_i2]);

				$damyun_100data_quiz_val = get_calcurate_point_damyun_samescyn($damyun_option_idx,$damyun_100data_no,$file_3_idx);

				$query_in = "insert into wise_analysis_report_damyun_100data_detail set"; 
				$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
				$query_in .= " damyun_option_100data_idx = '".$damyun_option_100data_idx."', ";
				$query_in .= " analysis_report_damyun_100data_no = '".$damyun_100data_no."', ";
				$query_in .= " analysis_report_damyun_100data_model_no = '".$file_3_idx."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_title = '".$file_3_title."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_val = '".$damyun_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				$result_in = mysqli_query($gconnet,$query_in);

				//exit;
			}

			//exit;
			######## 핵심구분 종료 ######

			######## 총계 시작 #########

			$damyun_100data_quiz_val = round(get_calcurate_point_damyun_samescyn_total($damyun_option_idx,$query_file_2_cnt,$damyun_100data_no),$row['analysis_report_damyun_option_scorepoint']);

			$query_in = "insert into wise_analysis_report_damyun_100data_detail set"; 
			$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_in .= " damyun_option_100data_idx = '".$damyun_option_100data_idx."', ";
			$query_in .= " analysis_report_damyun_100data_no = '".$damyun_100data_no."', ";
			$query_in .= " analysis_report_damyun_100data_quiz_title = '총계', ";
			$query_in .= " analysis_report_damyun_100data_quiz_val = '".$damyun_100data_quiz_val."', ";
			$query_in .= " wdate = now() ";
			$result_in = mysqli_query($gconnet,$query_in);
			######## 총계 종료 ######
		
			//set_rst_damyun_tlc($damyun_option_idx,$damyun_option_100data_idx,$damyun_100data_no,$analysis_report_idx); // 응답자별 총점 및 그룹 저장 
			
	} // 웅답자 루프 종료 
	
	//echo "까지 종료 <br>";
	//exit;

	set_rst_damyun_tlc_align($damyun_option_idx,$damyun_option_100data_idx); // 100점환산 데이터 순위설정 

	######## 집단별점수 순위정리 시작 #############
	
	//echo "집단별점수 순위정리 종료 <br>";

	$analysis_report_damyun_option_percent = $row['analysis_report_damyun_option_percent'];

	// 문항
	$sql_file_2 = "select analysis_report_damyun_100data_quiz_no,analysis_report_damyun_100data_quiz_title from wise_analysis_report_damyun_100data_detail where 1 and damyun_option_idx='".$damyun_option_idx."' and analysis_report_damyun_100data_group_no = '0' and analysis_report_damyun_100data_no='1'";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_quizno .= $row_file_2['analysis_report_damyun_100data_quiz_no'];
			$file_2_title .= $row_file_2['analysis_report_damyun_100data_quiz_title'];
		} else {
			$file_2_quizno .= $row_file_2['analysis_report_damyun_100data_quiz_no'].",";
			$file_2_title .= $row_file_2['analysis_report_damyun_100data_quiz_title'].",";
		}
	}
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);
	
	for($opt2_i=0; $opt2_i<sizeof($file_2_quizno_arr); $opt2_i++){ // 문항루프 시작 
		$file_2_quizno2 = trim($file_2_quizno_arr[$opt2_i]);
		$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

		$analysis_report_damyun_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_2_quizno2,"quiz_type","");

		$query_in = "insert into wise_analysis_report_damyun_data set"; 
		$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_damyun_option_percent = '".$analysis_report_damyun_option_percent."', ";
		$query_in .= " analysis_report_damyun_option_data_no = '".$file_2_quizno2."', ";
		$query_in .= " analysis_report_damyun_option_data_type = '".$analysis_report_damyun_option_data_type."', ";
		$query_in .= " analysis_report_damyun_option_data_title = '".$file_2_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_data_idx = $mem_row2[idx]; 

		$analysis_report_damyun_data_quiz_val = get_damyun_data_val_avg2($damyun_option_idx,$analysis_report_idx,$file_2_quizno2);
		$query_in2 = "insert into wise_analysis_report_damyun_data_quiz set"; 
		$query_in2 .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_in2 .= " damyun_data_idx = '".$damyun_data_idx."', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_no = '".$file_2_quizno2."', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_val = '".$analysis_report_damyun_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		//for($ans_i=1; $ans_i<=$row['analysis_report_damyun_option_score']; $ans_i++){ // 집단별 점수 데이터가 보기번호 루프시작 
			
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
				$query_file_4 = mysqli_query($gconnet,$sql_file_4);
				$query_file_4_cnt = mysqli_num_rows($query_file_4);
				for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ 
					$row_file_4 = mysqli_fetch_array($query_file_4);

					$analysis_report_damyun_data_quiz_val = get_damyun_data_val_avg($damyun_option_idx,$analysis_report_idx,$file_2_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
					$query_in3 = "insert into wise_analysis_report_damyun_data_quiz set"; 
					$query_in3 .= " damyun_option_idx = '".$damyun_option_idx."', ";
					$query_in3 .= " damyun_data_idx = '".$damyun_data_idx."', ";
					$query_in3 .= " analysis_report_damyun_data_quiz_no = '".$file_1_quizno2."', ";
					$query_in3 .= " analysis_report_damyun_data_quiz_title = '".$row_file_4['data_val']."',";
					$query_in3 .= " analysis_report_damyun_data_quiz_val = '".$analysis_report_damyun_data_quiz_val."', ";
					$query_in3 .= " wdate = now() ";
					//echo $query_in3."<br>";
					$result_in3 = mysqli_query($gconnet,$query_in3);
				
				}

			} // 집단구분항목 루프 종료 

			//exit;
			
		//} // 집단별 점수 데이터가 보기번호 루프종료 

	} // 문항루프 종료 

	for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
		$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
		$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
		$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

		$analysis_report_damyun_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_1_quizno2,"quiz_type","");
		
		$query_in = "insert into wise_analysis_report_damyun_data set"; 
		$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_damyun_option_percent = '".$analysis_report_damyun_option_percent."', ";
		$query_in .= " analysis_report_damyun_option_data_no = '".$file_1_quizno2."', ";
		$query_in .= " analysis_report_damyun_option_data_type = '".$analysis_report_damyun_option_data_type."', ";
		$query_in .= " analysis_report_damyun_option_data_title = '".$file_1_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_data_idx = $mem_row2[idx]; 

		$analysis_report_damyun_data_quiz_val = get_damyun_data_val_avg2($damyun_option_idx,$analysis_report_idx,$file_1_quizno2);
		$query_in2 = "insert into wise_analysis_report_damyun_data_quiz set"; 
		$query_in2 .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query_in2 .= " damyun_data_idx = '".$damyun_data_idx."', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_no = '".$file_1_quizno2."', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_title = '총계', ";
		$query_in2 .= " analysis_report_damyun_data_quiz_val = '".$analysis_report_damyun_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
		$query_file_4 = mysqli_query($gconnet,$sql_file_4);
		$query_file_4_cnt = mysqli_num_rows($query_file_4);
		for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ 
			$row_file_4 = mysqli_fetch_array($query_file_4);

			$analysis_report_damyun_data_quiz_val = get_damyun_data_val_avg($damyun_option_idx,$analysis_report_idx,$file_1_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
			$query_in3 = "insert into wise_analysis_report_damyun_data_quiz set"; 
			$query_in3 .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_in3 .= " damyun_data_idx = '".$damyun_data_idx."', ";
			$query_in3 .= " analysis_report_damyun_data_quiz_no = '".$file_1_quizno2."', ";
			$query_in3 .= " analysis_report_damyun_data_quiz_title = '".$row_file_4['data_val']."', ";
			$query_in3 .= " analysis_report_damyun_data_quiz_val = '".$analysis_report_damyun_data_quiz_val."', ";
			$query_in3 .= " wdate = now() ";
			//echo $query_in3."<br>";
			$result_in3 = mysqli_query($gconnet,$query_in3);
		}

	} // 집단구분항목 루프 종료 

	//set_report_damyun_data_total_align($damyun_option_idx,$analysis_report_idx); // 집단별 총점 및 순위 설정 
	
	######## 집단별점수 순위정리 종료 #############
	
	$inc_report_query_2 = "update wise_analysis_myreport set report_status='com',report_edate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	//echo $inc_report_query_2."<br>";
	$inc_report_result_2 = mysqli_query($gconnet,$inc_report_query_2);

?>