<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
//exit;
// http://surveyin.kr/report/cron_damyun_report_dev.php 
// http://114.207.246.199/report/cron_damyun_report_dev.php 
$bbs_code = "damyun";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_status='tmp' and report_type='damyun' order by idx desc limit 0,1";
$inc_report_query = mysqli_query($gconnet,$inc_report_sql);
for ($inc_report_i=0; $inc_report_i<mysqli_num_rows($inc_report_query); $inc_report_i++){ // 보고서 추출대상 루프 시작 
	$inc_report_row = mysqli_fetch_array($inc_report_query);
	
	$damyun_option_idx = trim($inc_report_row['report_idx']);
	$damyun_option_report_title = trim($inc_report_row['report_title']);
	$memid = trim($inc_report_row['memid']);
	$subid = trim($inc_report_row['subid']);

	$inc_report_query_1 = "update wise_analysis_myreport set report_sdate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	$inc_report_result_1 = mysqli_query($gconnet,$inc_report_query_1);
	
	$sql_file_0 = "select damyun_option_idx from wise_analysis_report_damyun_100data where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		$sql_del_0 = "delete from wise_analysis_report_damyun_100data where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_0 = mysqli_query($gconnet,$sql_del_0);
		$sql_del_1 = "delete from wise_analysis_report_damyun_100data_detail where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_1 = mysqli_query($gconnet,$sql_del_1);
		//$sql_del_13 = "delete from wise_analysis_report_damyun_100data_detail_case where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		//$query_del_13 = mysqli_query($gconnet,$sql_del_13);
		$sql_del_2 = "delete from wise_analysis_report_damyun_100data_tlc where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_2 = mysqli_query($gconnet,$sql_del_2);
		//$sql_del_14 = "delete from wise_analysis_report_damyun_100data_tlc_case where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		//$query_del_14 = mysqli_query($gconnet,$sql_del_14);
		$sql_del_3 = "delete from wise_analysis_report_damyun_data where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_3 = mysqli_query($gconnet,$sql_del_3);
		$sql_del_4 = "delete from wise_analysis_report_damyun_data_quiz where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_4 = mysqli_query($gconnet,$sql_del_4);
		$sql_del_5 = "delete from wise_analysis_report_damyun_data_ratio where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_5 = mysqli_query($gconnet,$sql_del_5);
		/*$sql_del_6 = "delete from wise_analysis_report_damyun_data2 where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_6 = mysqli_query($gconnet,$sql_del_6);
		$sql_del_7 = "delete from wise_analysis_report_damyun_data2_data where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_7 = mysqli_query($gconnet,$sql_del_7);
		$sql_del_8 = "delete from wise_analysis_report_damyun_data2_data_quiz where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_8 = mysqli_query($gconnet,$sql_del_8);
		$sql_del_9 = "delete from wise_analysis_report_damyun_data2_data_ratio where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_9 = mysqli_query($gconnet,$sql_del_9);
		$sql_del_10 = "delete from wise_analysis_report_damyun_statistics where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_10 = mysqli_query($gconnet,$sql_del_10);
		$sql_del_11 = "delete from wise_analysis_report_damyun_statistics_group where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_11 = mysqli_query($gconnet,$sql_del_11);
		$sql_del_12 = "delete from wise_analysis_report_damyun_statistics_group_detail where 1 and damyun_option_idx = '".$damyun_option_idx."'"; 
		$query_del_12 = mysqli_query($gconnet,$sql_del_12);*/
	}

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
	
	$query = "insert into wise_analysis_report_damyun_100data set"; 
	$query .= " damyun_option_idx = '".$damyun_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " damyun_option_report_title = '".$damyun_option_report_title."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_damyun_100data where 1 order by idx desc limit 0,1"; 
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
		
			######## raw data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$damyun_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo "raw data = ".$sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				$damyun_100data_no = $row_data_2['data_no'];
				$damyun_100data_quiz_no = $row_data_2['quiz_no'];
				$damyun_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$damyun_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				if($damyun_100data_quiz_no < 6){
					$damyun_100data_quiz_val = $row_data_2['data_val'];
				} else {
					$damyun_100data_quiz_val = get_calcurate_point_damyun($damyun_option_idx,$row_data_2['data_val']);	
				}

				$query_in = "insert into wise_analysis_report_damyun_100data_detail set"; 
				$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
				$query_in .= " damyun_option_100data_idx = '".$damyun_option_100data_idx."', ";
				$query_in .= " analysis_report_damyun_100data_no = '".$damyun_100data_no."', ";
				$query_in .= " analysis_report_damyun_100data_group_no = '0', ";
				$query_in .= " analysis_report_damyun_100data_quiz_no = '".$damyun_100data_quiz_no."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_title = '".$damyun_100data_quiz_title."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_val = '".$damyun_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				$result_in = mysqli_query($gconnet,$query_in);
			
			} // 로우데이터 루프 종료
			######## raw data 시작 ############

			######## 가중치 data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$damyun_100data_no."' and quiz_no in (".$file_2_quizno.") order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo "가중치 data = ".$sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				$damyun_100data_no = $row_data_2['data_no'];
				$damyun_100data_quiz_no = $row_data_2['quiz_no'];
				$damyun_100data_quiz_title = "가중치_".get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$damyun_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				//$damyun_100data_quiz_val = round(get_calcurate_point_damyun_samescyn_quiz($damyun_option_idx,$analysis_report_idx,$row_data_2['quiz_no'],$row_data_2['data_val']),$row['analysis_report_damyun_option_scorepoint']);

				$damyun_100data_quiz_val = get_calcurate_point_damyun_samescyn_quiz($damyun_option_idx,$analysis_report_idx,$row_data_2['quiz_no'],$row_data_2['data_val']);
				
				$query_in = "insert into wise_analysis_report_damyun_100data_detail set"; 
				$query_in .= " damyun_option_idx = '".$damyun_option_idx."', ";
				$query_in .= " damyun_option_100data_idx = '".$damyun_option_100data_idx."', ";
				$query_in .= " analysis_report_damyun_100data_no = '".$damyun_100data_no."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_no = '".$damyun_100data_quiz_no."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_title = '".$damyun_100data_quiz_title."', ";
				$query_in .= " analysis_report_damyun_100data_quiz_val = '".$damyun_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				$result_in = mysqli_query($gconnet,$query_in);

				//exit;
			
			} // 로우데이터 루프 종료
			######## 가중치 data 시작 ############

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

} // 보고서 추출대상 루프 종료 
?>