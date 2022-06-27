<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "service";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	$service_option_idx = trim(sqlfilter($_REQUEST['service_option_idx']));
	$service_option_status = trim(sqlfilter($_REQUEST['service_option_status']));
	$service_option_report_title = trim(sqlfilter($_REQUEST['service_option_report_title']));

	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	
	$sql_file_0 = "select service_option_idx from wise_analysis_report_service_100data where 1 and service_option_idx = '".$service_option_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		$sql_del_0 = "delete from wise_analysis_report_service_100data where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_0 = mysqli_query($gconnet,$sql_del_0);
		$sql_del_1 = "delete from wise_analysis_report_service_100data_detail where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_1 = mysqli_query($gconnet,$sql_del_1);
		$sql_del_13 = "delete from wise_analysis_report_service_100data_detail_case where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_13 = mysqli_query($gconnet,$sql_del_13);
		$sql_del_2 = "delete from wise_analysis_report_service_100data_tlc where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_2 = mysqli_query($gconnet,$sql_del_2);
		$sql_del_14 = "delete from wise_analysis_report_service_100data_tlc_case where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_14 = mysqli_query($gconnet,$sql_del_14);
		$sql_del_3 = "delete from wise_analysis_report_service_data where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_3 = mysqli_query($gconnet,$sql_del_3);
		$sql_del_4 = "delete from wise_analysis_report_service_data_quiz where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_4 = mysqli_query($gconnet,$sql_del_4);
		$sql_del_5 = "delete from wise_analysis_report_service_data_ratio where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_5 = mysqli_query($gconnet,$sql_del_5);
		$sql_del_6 = "delete from wise_analysis_report_service_data2 where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_6 = mysqli_query($gconnet,$sql_del_6);
		$sql_del_7 = "delete from wise_analysis_report_service_data2_data where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_7 = mysqli_query($gconnet,$sql_del_7);
		$sql_del_8 = "delete from wise_analysis_report_service_data2_data_quiz where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_8 = mysqli_query($gconnet,$sql_del_8);
		$sql_del_9 = "delete from wise_analysis_report_service_data2_data_ratio where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_9 = mysqli_query($gconnet,$sql_del_9);
		$sql_del_10 = "delete from wise_analysis_report_service_statistics where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_10 = mysqli_query($gconnet,$sql_del_10);
		$sql_del_11 = "delete from wise_analysis_report_service_statistics_group where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_11 = mysqli_query($gconnet,$sql_del_11);
		$sql_del_12 = "delete from wise_analysis_report_service_statistics_group_detail where 1 and service_option_idx = '".$service_option_idx."'"; 
		$query_del_12 = mysqli_query($gconnet,$sql_del_12);
	}

	$compet_info_sql = "select analysis_report_idx,analysis_report_service_option_percent,analysis_report_service_option_score from wise_analysis_report_service_option where 1 and idx='".$service_option_idx."'";
	if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_frame_go("다시 진행해주세요.","service_1.php");
	}
	$row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($row['analysis_report_idx']);
	
	$query = "insert into wise_analysis_report_service_100data set"; 
	$query .= " service_option_idx = '".$service_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " service_option_report_title = '".$service_option_report_title."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_service_100data where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$service_option_100data_idx = $mem_row2[idx]; 
	
	// 집단 구분 항목 
	$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_group.analysis_report_service_option_group_no) as quiz_no from wise_analysis_report_service_option_group where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_service_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_service_option_group_title'].",";
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
		$service_100data_no = $row_data_1['data_no'];

		//if($opt_i > 0){exit;}
		
		######## raw data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$service_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo $sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				//echo "quiz_no = ".$row_data_2['quiz_no']."<br>";

				$service_100data_no = $row_data_2['data_no'];
				$service_100data_quiz_no = $row_data_2['quiz_no'];
				$service_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$service_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				if($row_data_2['analysis_idx'] == "10" && ($row_data_2['quiz_no'] >= "15" && $row_data_2['quiz_no'] <= "18")){
					$service_100data_quiz_val = $row_data_2['data_val'];
				} else {
					if(trim($service_100data_quiz_conf) == "Y"){
						$service_100data_quiz_val = $row_data_2['data_val'];
					} else {
						$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);
					}
				}

				$query_in = "insert into wise_analysis_report_service_100data_detail set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
				$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
				$query_in .= " analysis_report_service_100data_quiz_no = '".$service_100data_quiz_no."', ";
				$query_in .= " analysis_report_service_100data_quiz_title = '".$service_100data_quiz_title."', ";
				$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
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

				$service_100data_quiz_val = get_service_gquiz_val($service_100data_no,$analysis_report_idx,$file_1_quizno2);
				
				$query_in = "insert into wise_analysis_report_service_100data_detail set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
				$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
				$query_in .= " analysis_report_service_100data_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_service_100data_quiz_title = '".$file_1_title2."', ";
				$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo $query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			} // 집단구분항목 루프 종료 
		######## 집단구분항목  종료 #############

		set_rst_service_tlc($service_option_idx,$service_option_100data_idx,$service_100data_no,$analysis_report_idx); // 응답자별 총점 및 그룹 저장 
			
	} // 웅답자 루프 종료 

	//exit;

	set_rst_service_tlc_align($service_option_idx,$service_option_100data_idx); // 100점환산 데이터 순위설정 

########### 케이스 선택지에 따른 100점환산 데이터 별도저장 시작 ######
$sql_prev_2 = "select idx from wise_analysis_report_service_option_point_case where 1 and service_option_idx='".$service_option_idx."'"; 
$query_prev_2 = mysqli_query($gconnet,$sql_prev_2);
$query_prev_2_cnt = mysqli_num_rows($query_prev_2);
	
if($query_prev_2_cnt > 0){ // 케이스 설정한값이 있다면 시작 

	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no in (select quiz_no from wise_analysis_quiz where 1 and idx in (select analysis_report_service_option_case_no from wise_analysis_report_service_option_point_case where 1 and service_option_idx='".$service_option_idx."')) and data_val=(select analysis_report_service_option_case_answer from wise_analysis_report_service_option_point_case where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_option_case_no=(select idx from wise_analysis_quiz where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no=wise_analysis_data.quiz_no)) order by data_no asc";
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$service_100data_no = $row_data_1['data_no'];

		//if($opt_i > 0){exit;}
		
		######## raw data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$service_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo $sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				//echo "quiz_no = ".$row_data_2['quiz_no']."<br>";

				$service_100data_no = $row_data_2['data_no'];
				$service_100data_quiz_no = $row_data_2['quiz_no'];
				$service_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$service_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				if($row_data_2['analysis_idx'] == "10" && ($row_data_2['quiz_no'] >= "15" && $row_data_2['quiz_no'] <= "18")){
					$service_100data_quiz_val = $row_data_2['data_val'];
				} else {
					if(trim($service_100data_quiz_conf) == "Y"){
						$service_100data_quiz_val = $row_data_2['data_val'];
					} else {
						$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);
					}
				}

				$query_in = "insert into wise_analysis_report_service_100data_detail_case set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
				$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
				$query_in .= " analysis_report_service_100data_quiz_no = '".$service_100data_quiz_no."', ";
				$query_in .= " analysis_report_service_100data_quiz_title = '".$service_100data_quiz_title."', ";
				$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
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

				$service_100data_quiz_val = get_service_gquiz_val($service_100data_no,$analysis_report_idx,$file_1_quizno2);
				
				$query_in = "insert into wise_analysis_report_service_100data_detail_case set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
				$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
				$query_in .= " analysis_report_service_100data_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_service_100data_quiz_title = '".$file_1_title2."', ";
				$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo $query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			} // 집단구분항목 루프 종료 
		######## 집단구분항목  종료 #############
		
		set_rst_service_tlc_case($service_option_idx,$service_option_100data_idx,$service_100data_no,$analysis_report_idx); // 응답자별 총점 및 그룹 저장 

	} // 웅답자 루프 종료 
} // 케이스 설정한값이 있다면 종료 
########### 케이스 선택지에 따른 100점환산 데이터 별도저장 종료 ######

	######## 집단별점수 순위정리 시작 #############
	
	$analysis_report_service_option_percent = $row['analysis_report_service_option_percent'];

	// 문항
	$sql_file_2 = "select analysis_report_service_100data_quiz_no,analysis_report_service_100data_quiz_title from wise_analysis_report_service_100data_detail where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_100data_quiz_title not in ('집단구분항목1','집단구분항목2','집단구분항목3','성별','연령','부서','직급') and analysis_report_service_100data_no='1'";
	
	//$sql_file_2 = "select analysis_report_service_100data_quiz_no,analysis_report_service_100data_quiz_title from wise_analysis_report_service_100data_detail where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_100data_quiz_title not in ('집단구분항목1','집단구분항목2','집단구분항목3','성별','연령','부서','직급') order by analysis_report_service_100data_no asc limit 0,1";
	
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_quizno .= $row_file_2['analysis_report_service_100data_quiz_no'];
			$file_2_title .= $row_file_2['analysis_report_service_100data_quiz_title'];
		} else {
			$file_2_quizno .= $row_file_2['analysis_report_service_100data_quiz_no'].",";
			$file_2_title .= $row_file_2['analysis_report_service_100data_quiz_title'].",";
		}
	}
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);
	
	for($opt2_i=0; $opt2_i<sizeof($file_2_quizno_arr); $opt2_i++){ // 문항루프 시작 
		$file_2_quizno2 = trim($file_2_quizno_arr[$opt2_i]);
		$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

		$analysis_report_service_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_2_quizno2,"quiz_type","");

		$query_in = "insert into wise_analysis_report_service_data set"; 
		$query_in .= " service_option_idx = '".$service_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_service_option_percent = '".$analysis_report_service_option_percent."', ";
		$query_in .= " analysis_report_service_option_data_no = '".$file_2_quizno2."', ";
		$query_in .= " analysis_report_service_option_data_type = '".$analysis_report_service_option_data_type."', ";
		$query_in .= " analysis_report_service_option_data_title = '".$file_2_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_service_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$service_data_idx = $mem_row2[idx]; 

		$analysis_report_service_data_quiz_val = get_service_data_val_avg2($service_option_idx,$analysis_report_idx,$file_2_quizno2);
		$query_in2 = "insert into wise_analysis_report_service_data_quiz set"; 
		$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
		$query_in2 .= " service_data_idx = '".$service_data_idx."', ";
		$query_in2 .= " analysis_report_service_data_quiz_no = '".$file_2_quizno2."', ";
		$query_in2 .= " analysis_report_service_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		//for($ans_i=1; $ans_i<=$row['analysis_report_service_option_score']; $ans_i++){ // 집단별 점수 데이터가 보기번호 루프시작 
			
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='10' and quiz_no='".$file_1_quizno2."' order by data_val asc";
				$query_file_4 = mysqli_query($gconnet,$sql_file_4);
				$query_file_4_cnt = mysqli_num_rows($query_file_4);
				for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ 
					$row_file_4 = mysqli_fetch_array($query_file_4);

					$analysis_report_service_data_quiz_val = get_service_data_val_avg($service_option_idx,$analysis_report_idx,$file_2_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
					$query_in3 = "insert into wise_analysis_report_service_data_quiz set"; 
					$query_in3 .= " service_option_idx = '".$service_option_idx."', ";
					$query_in3 .= " service_data_idx = '".$service_data_idx."', ";
					$query_in3 .= " analysis_report_service_data_quiz_no = '".$file_1_quizno2."', ";
					$query_in3 .= " analysis_report_service_data_quiz_title = '".$row_file_4['data_val']." 의 평균', ";
					$query_in3 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
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

		$analysis_report_service_option_data_type = get_data_colname("wise_analysis_quiz","quiz_no",$file_1_quizno2,"quiz_type","");
		
		$query_in = "insert into wise_analysis_report_service_data set"; 
		$query_in .= " service_option_idx = '".$service_option_idx."', ";
		$query_in .= " analysis_report_idx = '".$analysis_report_idx."', ";
		$query_in .= " analysis_report_service_option_percent = '".$analysis_report_service_option_percent."', ";
		$query_in .= " analysis_report_service_option_data_no = '".$file_1_quizno2."', ";
		$query_in .= " analysis_report_service_option_data_type = '".$analysis_report_service_option_data_type."', ";
		$query_in .= " analysis_report_service_option_data_title = '집단구분 - ".$file_1_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre2 = "select idx from wise_analysis_report_service_data where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$service_data_idx = $mem_row2[idx]; 

		$analysis_report_service_data_quiz_val = get_service_data_val_avg2($service_option_idx,$analysis_report_idx,$file_1_quizno2);
		$query_in2 = "insert into wise_analysis_report_service_data_quiz set"; 
		$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
		$query_in2 .= " service_data_idx = '".$service_data_idx."', ";
		$query_in2 .= " analysis_report_service_data_quiz_no = '".$file_1_quizno2."', ";
		$query_in2 .= " analysis_report_service_data_quiz_title = '전체', ";
		$query_in2 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2);

		$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
		$query_file_4 = mysqli_query($gconnet,$sql_file_4);
		$query_file_4_cnt = mysqli_num_rows($query_file_4);
		for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ 
			$row_file_4 = mysqli_fetch_array($query_file_4);

			$analysis_report_service_data_quiz_val = get_service_data_val_avg($service_option_idx,$analysis_report_idx,$file_1_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
			$query_in3 = "insert into wise_analysis_report_service_data_quiz set"; 
			$query_in3 .= " service_option_idx = '".$service_option_idx."', ";
			$query_in3 .= " service_data_idx = '".$service_data_idx."', ";
			$query_in3 .= " analysis_report_service_data_quiz_no = '".$file_1_quizno2."', ";
			$query_in3 .= " analysis_report_service_data_quiz_title = '".$row_file_4['data_val']." 의 평균', ";
			$query_in3 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
			$query_in3 .= " wdate = now() ";
			//echo $query_in3."<br>";
			$result_in3 = mysqli_query($gconnet,$query_in3);
		}

	} // 집단구분항목 루프 종료 

	set_report_service_data_total_align($service_option_idx,$analysis_report_idx); // 집단별 총점 및 순위 설정 
	
	######## 집단별점수 순위정리 종료 #############

	######## 집단구분/등급분포 시작 #############
	for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
		$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
		$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
		$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
		
		$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
		$query_file_4 = mysqli_query($gconnet,$sql_file_4);
		$query_file_4_cnt = mysqli_num_rows($query_file_4);
		for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ // 문항별 보기루프 시작 
			$row_file_4 = mysqli_fetch_array($query_file_4);
			
			$frequency_no = $row_file_4['data_val'];
			$frequency_title = $row_file_4['data_val'];
			$ratio_no = $row_file_4['data_val'];
			$ratio_title = $row_file_4['data_val'];
			$frequency_val = get_frequency_val_service($service_option_idx,$analysis_report_idx,$file_1_quizno2,$frequency_no);
			$ratio_val = get_ratio_val_service($service_option_idx,$analysis_report_idx,$file_1_quizno2,$frequency_no);

			$query_in = "insert into wise_analysis_report_service_data_ratio set"; 
			$query_in .= " service_option_idx = '".$service_option_idx."', ";
			$query_in .= " service_data_idx = '".$file_1_quizno2."', ";
			$query_in .= " analysis_report_service_data_frequency_no = '".$frequency_no."', ";
			$query_in .= " analysis_report_service_data_frequency_title = '".$frequency_title."', ";
			$query_in .= " analysis_report_service_data_frequency_val = '".$frequency_val."', ";
			$query_in .= " analysis_report_service_data_ratio_no = '".$ratio_no."', ";
			$query_in .= " analysis_report_service_data_ratio_title = '".$ratio_title."', ";
			$query_in .= " analysis_report_service_data_ratio_val = '".$ratio_val."', ";
			$query_in .= " wdate = now() ";
			//echo $query_in."<br>"; //exit;
			$result_in = mysqli_query($gconnet,$query_in);

			$sql_file_2 = "select idx from wise_analysis_report_service_option_levelyn where 1 and service_option_idx='".$service_option_idx."' order by idx asc"; // 등급기준
			$query_file_2 = mysqli_query($gconnet,$sql_file_2);
			$query_file_2_cnt = mysqli_num_rows($query_file_2);
			for($opt2_i=0; $opt2_i<$query_file_2_cnt; $opt2_i++){ // 등급별 루프 시작 
				$row_file_2 = mysqli_fetch_array($query_file_2);

				$frequency_val2 = get_frequency_val_service($service_option_idx,$analysis_report_idx,$file_1_quizno2,$frequency_no,$row_file_2['idx']);
				$ratio_val2 = get_ratio_val_service($service_option_idx,$analysis_report_idx,$file_1_quizno2,$frequency_no,$row_file_2['idx']);

				$query_in2 = "insert into wise_analysis_report_service_data_ratio set"; 
				$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
				$query_in2 .= " service_data_idx = '".$file_1_quizno2."', ";
				$query_in2 .= " service_data_level_idx = '".$row_file_2['idx']."', ";
				$query_in2 .= " analysis_report_service_data_frequency_no = '".$frequency_no."', ";
				$query_in2 .= " analysis_report_service_data_frequency_title = '".$frequency_title."', ";
				$query_in2 .= " analysis_report_service_data_frequency_val = '".$frequency_val2."', ";
				$query_in2 .= " analysis_report_service_data_ratio_no = '".$ratio_no."', ";
				$query_in2 .= " analysis_report_service_data_ratio_title = '".$ratio_title."', ";
				$query_in2 .= " analysis_report_service_data_ratio_val = '".$ratio_val2."', ";
				$query_in2 .= " wdate = now() ";
				//echo $query_in2."<br>"; //exit;
				$result_in2 = mysqli_query($gconnet,$query_in2);
			
			} // 등급별 루프 종료

		} // 문항별 보기루프 종료 
	} // 집단구분항목 루프 종료 
	
	$frequency_val = get_frequency_val_service($service_option_idx,$analysis_report_idx,"","");
	$ratio_val = get_ratio_val_service($service_option_idx,$analysis_report_idx,"","");
	
	$query_in3 = "insert into wise_analysis_report_service_data_ratio set"; 
	$query_in3 .= " service_option_idx = '".$service_option_idx."', ";
	$query_in3 .= " analysis_report_service_data_frequency_title = '합계', ";
	$query_in3 .= " analysis_report_service_data_frequency_val = '".$frequency_val."', ";
	$query_in3 .= " analysis_report_service_data_ratio_title = '합계', ";
	$query_in3 .= " analysis_report_service_data_ratio_val = '".$ratio_val."', ";
	$query_in3 .= " wdate = now() ";
	$result_in3 = mysqli_query($gconnet,$query_in3);
	######## 집단구분/등급분포 종료 #############	
	
######## IPA 입력 시작 ###########
$data_ipa_x_val = get_ipa_x_val_service($service_option_idx);
$data_ipa_y_val = get_ipa_y_val_service($service_option_idx);

//echo "data_ipa_x_val = ".$data_ipa_x_val."<br>";
//echo "data_ipa_y_val = ".$data_ipa_y_val."<br>";
		
	$query = "insert into wise_analysis_report_service_statistics set"; 
	$query .= " service_option_idx = '".$service_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " wdate = now() ";
	//echo "st = ".$query."<br>";
	$result = mysqli_query($gconnet,$query);

	$sql_pre = "select idx from wise_analysis_report_service_statistics where 1 order by idx desc limit 0,1"; 
	$result_pre  = mysqli_query($gconnet,$sql_pre);
	$mem_row = mysqli_fetch_array($result_pre);
	$service_statistics_idx = $mem_row[idx];

	$query_in = "insert into wise_analysis_report_service_statistics_group set"; 
	$query_in .= " service_option_idx = '".$service_option_idx."', ";
	$query_in .= " service_statistics_idx = '".$service_statistics_idx."', ";
	$query_in .= " analysis_report_service_statistics_group_title = 'Y 절편', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre_2 = "select idx from wise_analysis_report_service_statistics_group where 1 order by idx desc limit 0,1"; 
	$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
	$mem_row_2 = mysqli_fetch_array($result_pre_2);
	$service_statistics_group_idx = $mem_row_2[idx];

	$query_in2 = "insert wise_analysis_report_service_statistics_group_detail set"; 
	$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
	$query_in2 .= " service_statistics_idx = '".$service_statistics_idx."', ";
	$query_in2 .= " service_statistics_group_idx = '".$service_statistics_group_idx."', ";
	//$query_in2 .= " analysis_report_service_statistics_group2_no = '".$analysis_report_service_statistics_group2_no."', ";
	//$query_in2 .= " analysis_report_service_statistics_group2_title = '".$analysis_report_service_statistics_group2_title."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_data = '".$analysis_report_service_statistics_ipa_data."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_stder = '".$analysis_report_service_statistics_ipa_stder."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_t = '".$analysis_report_service_statistics_ipa_t."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_pval = '".$analysis_report_service_statistics_ipa_pval."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_min95 = '".$analysis_report_service_statistics_ipa_min95."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_max95 = '".$analysis_report_service_statistics_ipa_max95."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_tabval = '".$analysis_report_service_statistics_ipa_tabval."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_ratio = '".$analysis_report_service_statistics_ipa_ratio."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_stf = '".$analysis_report_service_statistics_ipa_stf."', ";
	$query_in2 .= " analysis_report_service_statistics_ipa_imt = '".$analysis_report_service_statistics_ipa_imt."', ";
	$query_in2 .= " analysis_report_service_statistics_frequency_1 = '".$analysis_report_service_statistics_frequency_1."', ";
	$query_in2 .= " analysis_report_service_statistics_frequency_2 = '".$analysis_report_service_statistics_frequency_2."', ";
	$query_in2 .= " analysis_report_service_statistics_frequency_3 = '".$analysis_report_service_statistics_frequency_3."', ";
	$query_in2 .= " analysis_report_service_statistics_frequency_4 = '".$analysis_report_service_statistics_frequency_4."', ";
	$query_in2 .= " analysis_report_service_statistics_frequency_total = '".$analysis_report_service_statistics_frequency_total."', ";
	$query_in2 .= " analysis_report_service_statistics_ratio_1 = '".$analysis_report_service_statistics_ratio_1."', ";
	$query_in2 .= " analysis_report_service_statistics_ratio_2 = '".$analysis_report_service_statistics_ratio_2."', ";
	$query_in2 .= " analysis_report_service_statistics_ratio_3 = '".$analysis_report_service_statistics_ratio_3."', ";
	$query_in2 .= " analysis_report_service_statistics_ratio_4 = '".$analysis_report_service_statistics_ratio_4."', ";
	$query_in2 .= " analysis_report_service_statistics_ratio_total = '".$analysis_report_service_statistics_ratio_total."', ";
	$query_in2 .= " wdate = now() ";
	$result_in2 = mysqli_query($gconnet,$query_in2); // Y 절편 
	
	if($data_ipa_x_val && $data_ipa_y_val){ // ipa 데이터 X , Y 값 있다 시작 

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

		//echo "ipa_total_t = ".$ipa_total_t."<br>";
		
		if($query_file_1_cnt == 0){ // 집단구분항목이 없을때 시작 
			$analysis_report_service_statistics_ipa_t = round($getTStats[$opt3_i],14);
			if($analysis_report_service_statistics_ipa_t < 0){
				$analysis_report_service_statistics_ipa_t = $analysis_report_service_statistics_ipa_t*-1;
			}

			//$ipa_total_ratio = round($analysis_report_service_statistics_ipa_t/$ipa_total_t,3);
			$ipa_total_ratio = round($ipa_total_t/$ipa_total_t,3);
			$ipa_total_stf = get_perq_ipa_avg_service($service_option_idx,"","");
			$ipa_total_imt = $ipa_total_ratio;
			$analysis_report_service_statistics_frequency_total = "";
			$analysis_report_service_statistics_ratio_total = "";
		} else { // 집단구분항목이 있을때 시작 
			$ipa_total_ratio = 0; // 전체합 1로 변환 합계
			$ipa_total_stf = 0; // 서비스평가 합계
			$ipa_total_imt = 0; // 중요도 합계
			//echo "배열 = ".sizeof($file_1_idx_arr)."<br>";
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$query_in = "insert into wise_analysis_report_service_statistics_group set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_statistics_idx = '".$service_statistics_idx."', ";
				$query_in .= " analysis_report_service_statistics_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_service_statistics_group_title = '".$file_1_title2."', ";
				$query_in .= " wdate = now() ";
				$result_in = mysqli_query($gconnet,$query_in);

				$sql_pre_2 = "select idx from wise_analysis_report_service_statistics_group where 1 order by idx desc limit 0,1"; 
				$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
				$mem_row_2 = mysqli_fetch_array($result_pre_2);
				$service_statistics_group_idx = $mem_row_2[idx];
		
				$analysis_report_service_statistics_ipa_t = round($getTStats[$opt3_i],14);
				if($analysis_report_service_statistics_ipa_t < 0){
					$analysis_report_service_statistics_ipa_t = $analysis_report_service_statistics_ipa_t*-1;
				}
				$analysis_report_service_statistics_ipa_tabval = round($getTStats[$opt3_i],14);
				if($analysis_report_service_statistics_ipa_tabval < 0){
					$analysis_report_service_statistics_ipa_tabval = $analysis_report_service_statistics_ipa_tabval*-1;
				}
				$analysis_report_service_statistics_ipa_ratio = round($analysis_report_service_statistics_ipa_t/$ipa_total_t,3);
				$analysis_report_service_statistics_ipa_stf = get_perq_ipa_avg_service($service_option_idx,$file_1_idx2,$file_1_title2); // 문항별 평균 서비스평가(?) - 확인필요 
				//$analysis_report_service_statistics_ipa_stf = get_perq_ipa_avg_service($service_option_idx,$file_1_quizno2,$file_1_title2); // 문항별 평균 서비스평가(?) - 확인필요  
				$analysis_report_service_statistics_ipa_imt = $analysis_report_service_statistics_ipa_ratio; // 중요도 

				$query_in2 = "insert wise_analysis_report_service_statistics_group_detail set"; 
				$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
				$query_in2 .= " service_statistics_idx = '".$service_statistics_idx."', ";
				$query_in2 .= " service_statistics_group_idx = '".$service_statistics_group_idx."', ";
				//$query_in2 .= " analysis_report_service_statistics_group2_no = '".$analysis_report_service_statistics_group2_no."', ";
				//$query_in2 .= " analysis_report_service_statistics_group2_title = '".$analysis_report_service_statistics_group2_title."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_data = '".$analysis_report_service_statistics_ipa_data."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_stder = '".$analysis_report_service_statistics_ipa_stder."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_t = '".$analysis_report_service_statistics_ipa_t."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_pval = '".$analysis_report_service_statistics_ipa_pval."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_min95 = '".$analysis_report_service_statistics_ipa_min95."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_max95 = '".$analysis_report_service_statistics_ipa_max95."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_tabval = '".$analysis_report_service_statistics_ipa_tabval."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_ratio = '".$analysis_report_service_statistics_ipa_ratio."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_stf = '".$analysis_report_service_statistics_ipa_stf."', ";
				$query_in2 .= " analysis_report_service_statistics_ipa_imt = '".$analysis_report_service_statistics_ipa_imt."', ";
				$query_in2 .= " analysis_report_service_statistics_frequency_1 = '".$analysis_report_service_statistics_frequency_1."', ";
				$query_in2 .= " analysis_report_service_statistics_frequency_2 = '".$analysis_report_service_statistics_frequency_2."', ";
				$query_in2 .= " analysis_report_service_statistics_frequency_3 = '".$analysis_report_service_statistics_frequency_3."', ";
				$query_in2 .= " analysis_report_service_statistics_frequency_4 = '".$analysis_report_service_statistics_frequency_4."', ";
				$query_in2 .= " analysis_report_service_statistics_frequency_total = '".$analysis_report_service_statistics_frequency_total."', ";
				$query_in2 .= " analysis_report_service_statistics_ratio_1 = '".$analysis_report_service_statistics_ratio_1."', ";
				$query_in2 .= " analysis_report_service_statistics_ratio_2 = '".$analysis_report_service_statistics_ratio_2."', ";
				$query_in2 .= " analysis_report_service_statistics_ratio_3 = '".$analysis_report_service_statistics_ratio_3."', ";
				$query_in2 .= " analysis_report_service_statistics_ratio_4 = '".$analysis_report_service_statistics_ratio_4."', ";
				$query_in2 .= " analysis_report_service_statistics_ratio_total = '".$analysis_report_service_statistics_ratio_total."', ";
				$query_in2 .= " wdate = now() ";
				$result_in2 = mysqli_query($gconnet,$query_in2); 
		
				$ipa_total_ratio = $ipa_total_ratio+$analysis_report_service_statistics_ipa_ratio;
				$ipa_total_stf = $ipa_total_stf+$analysis_report_service_statistics_ipa_stf;
				$ipa_total_imt = $ipa_total_imt+$analysis_report_service_statistics_ipa_imt;
	
			} // 집단구분항목 루프 종료 

		} // 집단구분항목이 있을때 종료 

	} // ipa 데이터 X , Y 값 있다 종료

		$query_in = "insert into wise_analysis_report_service_statistics_group set"; 
		$query_in .= " service_option_idx = '".$service_option_idx."', ";
		$query_in .= " service_statistics_idx = '".$service_statistics_idx."', ";
		$query_in .= " analysis_report_service_statistics_group_title = '합계', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_service_statistics_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$service_statistics_group_idx = $mem_row_2[idx];

		$query_in2 = "insert wise_analysis_report_service_statistics_group_detail set"; 
		$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
		$query_in2 .= " service_statistics_idx = '".$service_statistics_idx."', ";
		$query_in2 .= " service_statistics_group_idx = '".$service_statistics_group_idx."', ";
		//$query_in2 .= " analysis_report_service_statistics_group2_no = '".$analysis_report_service_statistics_group2_no."', ";
		//$query_in2 .= " analysis_report_service_statistics_group2_title = '".$analysis_report_service_statistics_group2_title."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_t = '".$ipa_total_t."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_tabval = '".$ipa_total_t."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_ratio = '".$ipa_total_ratio."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_stf = '".$ipa_total_stf."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_imt = '".$ipa_total_imt."', ";
		$query_in2 .= " analysis_report_service_statistics_frequency_total = '".$analysis_report_service_statistics_frequency_total."', ";
		$query_in2 .= " analysis_report_service_statistics_ratio_total = '".$analysis_report_service_statistics_ratio_total."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2); // 합계

		$query_in = "insert into wise_analysis_report_service_statistics_group set"; 
		$query_in .= " service_option_idx = '".$service_option_idx."', ";
		$query_in .= " service_statistics_idx = '".$service_statistics_idx."', ";
		$query_in .= " analysis_report_service_statistics_group_title = '평균', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_service_statistics_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$service_statistics_group_idx = $mem_row_2[idx];
		
		if($query_file_1_cnt == 0){ // 집단구분항목이 없을때 시작 
			$ipa_avg_stf = round($ipa_total_stf/sizeof($file_1_idx_arr),3); 
			$ipa_avg_imt = round($ipa_total_imt/sizeof($file_1_idx_arr),3); 
		} else {
			$ipa_avg_stf = 0; 
			$ipa_avg_imt = 0; 
		}

		$query_in2 = "insert wise_analysis_report_service_statistics_group_detail set"; 
		$query_in2 .= " service_option_idx = '".$service_option_idx."', ";
		$query_in2 .= " service_statistics_idx = '".$service_statistics_idx."', ";
		$query_in2 .= " service_statistics_group_idx = '".$service_statistics_group_idx."', ";
		//$query_in2 .= " analysis_report_service_statistics_group2_no = '".$analysis_report_service_statistics_group2_no."', ";
		//$query_in2 .= " analysis_report_service_statistics_group2_title = '".$analysis_report_service_statistics_group2_title."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_stf = '".$ipa_avg_stf."', ";
		$query_in2 .= " analysis_report_service_statistics_ipa_imt = '".$ipa_avg_imt."', ";
		$query_in2 .= " wdate = now() ";
		$result_in2 = mysqli_query($gconnet,$query_in2); // 평균

######## IPA 입력 종료 ###########

error_frame("보고서가 저장되었습니다.");
?>	