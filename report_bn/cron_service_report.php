<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
// http://surveyin.kr/report/cron_service_report.php
$bbs_code = "service";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

//$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_status='tmp' and report_type='service' and report_sdate is null order by idx desc limit 0,1";

$idx = trim(sqlfilter($_REQUEST['idx']));
if($idx){
	$top_where = " and idx='".$idx."'";
}

if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
	$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_type='service' ".$top_where." order by idx desc limit 0,1";
} else {
	$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_status='tmp' and report_type='service' ".$top_where." order by idx desc limit 0,1";
}

//echo $inc_report_sql."<br>"; //exit;

$inc_report_query = mysqli_query($gconnet,$inc_report_sql);
for ($inc_report_i=0; $inc_report_i<mysqli_num_rows($inc_report_query); $inc_report_i++){ // 보고서 추출대상 루프 시작 
	$inc_report_row = mysqli_fetch_array($inc_report_query);
	
	$service_option_idx = trim($inc_report_row['report_idx']);
	$service_option_report_title = trim($inc_report_row['report_title']);
	$memid = trim($inc_report_row['memid']);
	$subid = trim($inc_report_row['subid']);

	$inc_report_query_1 = "update wise_analysis_myreport set report_sdate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	$inc_report_result_1 = mysqli_query($gconnet,$inc_report_query_1);
	
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

	$compet_info_sql = "select analysis_report_idx,analysis_report_service_option_percent,analysis_report_service_option_score,analysis_report_service_option_scorepoint from wise_analysis_report_service_option where 1 and idx='".$service_option_idx."'";
	/*if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}*/
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_frame_go("다시 진행해주세요.","service_1.php");
	}
	$row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($row['analysis_report_idx']);
	$analysis_service_option_scorepoint = trim($row['analysis_report_service_option_scorepoint']);
	
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
	//echo "집단구분항목 쿼리 = ".$sql_file_1."<br>"; //exit;
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	
	//echo "집단구분 cnt = ".$query_file_1_cnt."<br>"; exit;

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
	//echo "file_1_idx = ".$file_1_idx."<br>"; //exit;
	
	if($query_file_1_cnt > 0){
		$file_1_idx_arr = explode(",",$file_1_idx);
		$file_1_quizno_arr = explode(",",$file_1_quizno);
		$file_1_title_arr = explode(",",$file_1_title);
	}
	
	// 분석모델설정 - 동일배점 테이블
	$sql_file_2 = "select * from wise_analysis_report_service_option_samescyn where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_idx .= $row_file_2['idx'];
			$file_2_title .= $row_file_2['analysis_report_service_option_samescyn_title'];
		} else {
			$file_2_idx .= $row_file_2['idx'].",";
			$file_2_title .= $row_file_2['analysis_report_service_option_samescyn_title'].",";
		}
	}
	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_2_title_arr = explode(",",$file_2_title);

	// 모델설정 테이블
	$sql_file_4 = "select idx,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_samescyn_quiz.analysis_report_service_option_samescyn_quiz_no) as quiz_no from wise_analysis_report_service_option_samescyn_quiz where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
	$query_file_4 = mysqli_query($gconnet,$sql_file_4);
	$query_file_4_cnt = mysqli_num_rows($query_file_4);
	
	$model_quiz_no = "";
	for($opt_i=0; $opt_i<$query_file_4_cnt; $opt_i++){ 
		$row_file_4 = mysqli_fetch_array($query_file_4);
		
		if($opt_i == $query_file_4_cnt-1){
			$model_quiz_no_arr .= $row_file_4['quiz_no'];
		} else {
			$model_quiz_no_arr .= $row_file_4['quiz_no'].",";
		}
	}

	// 케이스 설정 테이블
	
		$sql_file_3 = "select idx,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_point_case.analysis_report_service_option_case_no) as quiz_no,analysis_report_service_option_case_answer as quiz_answ from wise_analysis_report_service_option_point_case where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
		$query_file_3 = mysqli_query($gconnet,$sql_file_3);
		$query_file_3_cnt = mysqli_num_rows($query_file_3);
		
		if($query_file_3_cnt == 0){
			$case_where = "";
		} else {
			for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){ // 케이스 설정 루프 시작 
				$row_file_3 = mysqli_fetch_array($query_file_3);
			
				if($opt_i == 0){
					$sql_file_3_sub = "select distinct(data_no) as data_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$row_file_3['quiz_no']."' and data_val='".$row_file_3['quiz_answ']."' order by data_no asc";
				} else {
					$sql_file_3_sub = "select distinct(data_no) as data_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$row_file_3['quiz_no']."' and data_val='".$row_file_3['quiz_answ']."' and data_no in (".$case_data.") order by data_no asc";
				}
				//echo "케이스 쿼리 = ".$sql_file_3_sub."<br>";
				$query_file_3_sub = mysqli_query($gconnet,$sql_file_3_sub);
				$query_file_3_sub_cnt = mysqli_num_rows($query_file_3_sub);
			
				$case_data = "";
				for($opt_i_sub=0; $opt_i_sub<$query_file_3_sub_cnt; $opt_i_sub++){
					$row_file_3_sub = mysqli_fetch_array($query_file_3_sub);
					//echo "문항번호 ".$row_file_3['quiz_no']." 가 ".$row_file_3['quiz_answ']." 인 조건 ".$opt_i_sub." = ".$row_file_3_sub['data_no']."<br>"; 
					if($opt_i_sub == $query_file_3_sub_cnt-1){
						$case_data .= $row_file_3_sub['data_no'];
					} else {
						$case_data .= $row_file_3_sub['data_no'].",";
					}
				}
			
				//echo "case_data = ".$case_data."<br>";
			} // 케이스 설정 루프 종료
			
			$case_where = " and data_no in (".$case_data.")";
		}

	$case_data_arr = explode(",",$case_data);
		
	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' ".$case_where." order by data_no asc";
	//echo $sql_data_1."<br>"; EXIT;
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$service_100data_no = $row_data_1['data_no'];

		//if($opt_i > 0){exit;}
		
		######## raw data 시작 ############
			$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$service_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo $sql_data_2."<br>"; exit;
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				//echo "quiz_no = ".$row_data_2['quiz_no']."<br>";

				$service_100data_no = $row_data_2['data_no'];
				$service_100data_quiz_no = $row_data_2['quiz_no'];
				$service_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$service_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				/*if($row_data_2['analysis_idx'] == "10" && ($row_data_2['quiz_no'] >= "15" && $row_data_2['quiz_no'] <= "18")){
					$service_100data_quiz_val = zero_point_set($row_data_2['data_val'],$service_option_scorepoint);
				} else {
					if(trim($service_100data_quiz_conf) == "Y"){
						$service_100data_quiz_val = zero_point_set($row_data_2['data_val'],$service_option_scorepoint);
					} else {
						$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);
					}
				}*/

				/*if(trim($service_100data_quiz_conf) == "Y"){
					//$service_100data_quiz_val = zero_point_set($row_data_2['data_val'],$service_option_scorepoint);
					$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);
				} else {
					$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);
				}*/

				$service_100data_quiz_val = get_calcurate_point_service($service_option_idx,$row_data_2['data_val']);

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
		
		//echo "집단구분 11 cnt = ".sizeof($file_1_idx_arr)."<br>";
		//echo "집단구분 11 cnt fst = ".$file_1_idx_arr[0]."<br>";
		//exit;

		######## 집단구분항목 시작 #############
		if($file_1_idx_arr[0]){
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$service_100data_quiz_val = get_service_gquiz_val($service_100data_no,$analysis_report_idx,$file_1_quizno2);
				//$service_100data_quiz_val = zero_point_set($service_100data_quiz_val,$service_option_scorepoint);
				
				$query_in = "insert into wise_analysis_report_service_100data_detail set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
				$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
				$query_in .= " analysis_report_service_100data_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_service_100data_quiz_title = '".$file_1_title2."', ";
				$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo "집단구분항목 = ".$query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			} // 집단구분항목 루프 종료
		}
		######## 집단구분항목  종료 #############
		//exit;	
		######## 모델-동일배점 시작 #############

		//echo "동일배점 = ".sizeof($file_2_idx_arr)."<br>";
		
			for($opt3_i=0; $opt3_i<sizeof($file_2_idx_arr); $opt3_i++){ // 모델-동일배점 루프 시작 
				$file_2_idx2 = trim($file_2_idx_arr[$opt3_i]);
				$file_2_title2 = trim($file_2_title_arr[$opt3_i]);

				//if($opt_i > 0){exit;}

				$service_100data_quiz_val = get_service_option_model_quiz_avg($service_option_100data_idx,$service_100data_no,$service_option_idx,$file_2_idx2);
				
				//if($file_2_title2){
					$query_in = "insert into wise_analysis_report_service_100data_detail set"; 
					$query_in .= " service_option_idx = '".$service_option_idx."', ";
					$query_in .= " service_option_100data_idx = '".$service_option_100data_idx."', ";
					$query_in .= " analysis_report_service_100data_no = '".$service_100data_no."', ";
					$query_in .= " analysis_report_service_100data_model_no = '".$file_2_idx2."', ";
					$query_in .= " analysis_report_service_100data_quiz_title = '".$file_2_title2."', ";
					$query_in .= " analysis_report_service_100data_quiz_val = '".$service_100data_quiz_val."', ";
					$query_in .= " wdate = now() ";
					//echo $query_in."<br>"; //exit;
					$result_in = mysqli_query($gconnet,$query_in);
				//}

			} // 모델-동일배점 루프 종료 
		######## 모델-동일배점 종료 #############
		
		//exit;

		set_rst_service_tlc($service_option_idx,$service_option_100data_idx,$service_100data_no,$analysis_report_idx); // 응답자별 총점 및 그룹 저장 
			
	} // 웅답자 루프 종료 

	//exit;

	set_rst_service_tlc_align($service_option_idx,$service_option_100data_idx); // 100점환산 데이터 순위설정 

	######## 집단별점수 순위정리 시작 #############
	
	$analysis_report_service_option_percent = $row['analysis_report_service_option_percent'];
	
	$file_2_quizno = "";
	$file_2_title = "";

	// 문항
	$sql_file_0 = "select analysis_report_service_100data_no from wise_analysis_report_service_100data_detail where 1 and service_option_idx='".$service_option_idx."' order by idx asc limit 0,1";
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	
	if($model_quiz_no_arr){
		$sql_file_2 = "select analysis_report_service_100data_quiz_no,analysis_report_service_100data_quiz_title from wise_analysis_report_service_100data_detail where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_100data_quiz_no in (".$model_quiz_no_arr.") and analysis_report_service_100data_no='".$row_file_0['analysis_report_service_100data_no']."'";
	} else {
		$sql_file_2 = "select analysis_report_service_100data_quiz_no,analysis_report_service_100data_quiz_title from wise_analysis_report_service_100data_detail where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_100data_no='".$row_file_0['analysis_report_service_100data_no']."'";
	}
	
	//echo "sql_file2 = ".$sql_file_2."<br>"; exit;

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

	//echo "file_2_title = ".$file_2_title."<br>"; exit;

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
		//echo $query_in."<br>";
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
		if($file_1_idx_arr[0]){	
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
				$query_file_4 = mysqli_query($gconnet,$sql_file_4);
				$query_file_4_cnt = mysqli_num_rows($query_file_4);
				for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ 
					$row_file_4 = mysqli_fetch_array($query_file_4);

					$analysis_report_service_data_quiz_val = get_service_data_val_avg($service_option_idx,$analysis_report_idx,$file_2_quizno2,$file_1_quizno2,$row_file_4['data_val']);

					$analysis_report_service_data_quiz_tot = get_service_data_val_avg_tot($service_option_idx,$analysis_report_idx,$file_2_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
					$query_in3 = "insert into wise_analysis_report_service_data_quiz set"; 
					$query_in3 .= " service_option_idx = '".$service_option_idx."', ";
					$query_in3 .= " service_data_idx = '".$service_data_idx."', ";
					$query_in3 .= " analysis_report_service_data_quiz_no = '".$file_1_quizno2."', ";
					$query_in3 .= " analysis_report_service_data_quiz_title = '".$row_file_4['data_val']." 의 평균', ";
					$query_in3 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
					$query_in3 .= " analysis_report_service_data_quiz_tot = '".$analysis_report_service_data_quiz_tot."', ";
					$query_in3 .= " wdate = now() ";
					//echo $query_in3."<br>";
					$result_in3 = mysqli_query($gconnet,$query_in3);
				
				}
			} // 집단구분항목 루프 종료 
		}
			//exit;
			
		//} // 집단별 점수 데이터가 보기번호 루프종료 

	} // 문항루프 종료 
	
	if($file_1_idx_arr[0]){
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

			$analysis_report_service_data_quiz_tot = get_service_data_val_avg_tot($service_option_idx,$analysis_report_idx,$file_1_quizno2,$file_1_quizno2,$row_file_4['data_val']);
			
			$query_in3 = "insert into wise_analysis_report_service_data_quiz set"; 
			$query_in3 .= " service_option_idx = '".$service_option_idx."', ";
			$query_in3 .= " service_data_idx = '".$service_data_idx."', ";
			$query_in3 .= " analysis_report_service_data_quiz_no = '".$file_1_quizno2."', ";
			$query_in3 .= " analysis_report_service_data_quiz_title = '".$row_file_4['data_val']." 의 평균', ";
			$query_in3 .= " analysis_report_service_data_quiz_val = '".$analysis_report_service_data_quiz_val."', ";
			$query_in3 .= " analysis_report_service_data_quiz_tot = '".$analysis_report_service_data_quiz_tot."', ";
			$query_in3 .= " wdate = now() ";
			//echo $query_in3."<br>";
			$result_in3 = mysqli_query($gconnet,$query_in3);
		}
	  } // 집단구분항목 루프 종료 
	}
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
	
	
	// 집단 구분 항목 -> 종속아닌 분석모델 
	
	//$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_group.analysis_report_service_option_group_no) as quiz_no from wise_analysis_report_service_option_group where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
	//echo "집단구분항목 쿼리 = ".$sql_file_1."<br>"; //exit;
	
	$file_1_idx = "";
	$file_1_quizno = "";
	$file_1_title = "";

	//$sql_file_1 = "select idx,analysis_report_service_option_samescyn_quiz_title,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_samescyn_quiz.analysis_report_service_option_samescyn_quiz_no) as quiz_no from wise_analysis_report_service_option_samescyn_quiz where 1 and service_option_idx='".$service_option_idx."' and service_option_samescyn_idx in (select idx from wise_analysis_report_service_option_samescyn where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_option_samescyn_jongs != 'Y') order by idx asc"; // 종속아닌 분석모델 

	$sql_file_1 = "select idx,analysis_report_service_option_samescyn_title from wise_analysis_report_service_option_samescyn where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_option_samescyn_jongs != 'Y' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_title .= $row_file_1['analysis_report_service_option_samescyn_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_title .= $row_file_1['analysis_report_service_option_samescyn_title'].",";
		}
	}
	
	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);

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
		$ipa_total_t = zero_point_set($ipa_total_t,$analysis_service_option_scorepoint);

		//echo "ipa_total_t = ".$ipa_total_t."<br>";
		
		if($query_file_1_cnt == 0){ // 집단구분항목이 없을때 시작 
			$analysis_report_service_statistics_ipa_t = zero_point_set($getTStats[$opt3_i],$analysis_service_option_scorepoint);
			if($analysis_report_service_statistics_ipa_t < 0){
				$analysis_report_service_statistics_ipa_t = $analysis_report_service_statistics_ipa_t*-1;
			}

			//$ipa_total_ratio = zero_point_set($analysis_report_service_statistics_ipa_t/$ipa_total_t,3);
			$ipa_total_ratio = zero_point_set($ipa_total_t/$ipa_total_t,$analysis_service_option_scorepoint);
			$ipa_total_stf = get_perq_ipa_avg_service($service_option_idx,"","");
			$ipa_total_imt = $ipa_total_ratio;
			$analysis_report_service_statistics_frequency_total = "";
			$analysis_report_service_statistics_ratio_total = "";
		} else { // 집단구분항목이 있을때 시작 


			$ipa_total_ratio = 0; // 전체합 1로 변환 합계
			$ipa_total_stf = 0; // 서비스평가 합계
			$ipa_total_imt = 0; // 중요도 합계
			//echo "배열 = ".sizeof($file_1_idx_arr)."<br>";


			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 비종속 분석모델 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				$query_in = "insert into wise_analysis_report_service_statistics_group set"; 
				$query_in .= " service_option_idx = '".$service_option_idx."', ";
				$query_in .= " service_statistics_idx = '".$service_statistics_idx."', ";
				$query_in .= " analysis_report_service_statistics_group_no = '".$file_1_idx2."', ";
				$query_in .= " analysis_report_service_statistics_group_title = '".$file_1_title2."', ";
				$query_in .= " wdate = now() ";
				echo "wise_analysis_report_service_statistics_group = ".$query_in."<br>";
				$result_in = mysqli_query($gconnet,$query_in);

				$sql_pre_2 = "select idx from wise_analysis_report_service_statistics_group where 1 order by idx desc limit 0,1"; 
				$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
				$mem_row_2 = mysqli_fetch_array($result_pre_2);
				$service_statistics_group_idx = $mem_row_2[idx];
		
				$analysis_report_service_statistics_ipa_t = zero_point_set($getTStats[$opt3_i],$analysis_service_option_scorepoint);
				if($analysis_report_service_statistics_ipa_t < 0){
					$analysis_report_service_statistics_ipa_t = $analysis_report_service_statistics_ipa_t*-1;
				}
				$analysis_report_service_statistics_ipa_tabval = zero_point_set($getTStats[$opt3_i],$analysis_service_option_scorepoint);
				if($analysis_report_service_statistics_ipa_tabval < 0){
					$analysis_report_service_statistics_ipa_tabval = $analysis_report_service_statistics_ipa_tabval*-1;
				}
				$analysis_report_service_statistics_ipa_ratio = zero_point_set($analysis_report_service_statistics_ipa_t/$ipa_total_t,$analysis_service_option_scorepoint);
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
	
			} // 비종속 분석모델 루프 종료

		} // 비종속 분석모델 있을때 종료 

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

		echo "total_ratio = ".$ipa_total_ratio."<br>";
		echo "ipa_total_stf = ".$ipa_total_stf."<br>";
		echo "ipa_total_imt = ".$ipa_total_imt."<br>";
		echo "배열길이 = ".sizeof($file_1_idx_arr)."<br>";
				
		if(sizeof($file_1_idx_arr) > 0){ // 집단구분항목이 없을때 시작 
			$ipa_avg_stf = zero_point_set($ipa_total_stf/sizeof($file_1_idx_arr),$analysis_service_option_scorepoint); 
			$ipa_avg_imt = zero_point_set($ipa_total_imt/sizeof($file_1_idx_arr),$analysis_service_option_scorepoint); 
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

	$inc_report_query_2 = "update wise_analysis_myreport set report_status='com',report_edate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	//echo $inc_report_query_2."<br>";
	$inc_report_result_2 = mysqli_query($gconnet,$inc_report_query_2);

	$from_email = "cs@surveyin.kr";
	$from_name = "데이터인";
	$to_email = $inc_report_row['report_email'];

	$subject = "[데이터인] 서비스 평가모델 보고서가 생성 되었습니다.";
		
	$content = "
		<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:646px;border:1px solid #dddddd;border-top:3px solid #3e4348;\">
       <tr>
        <td colspan=\"3\" style=\"height:23px;\"></td>
    </tr>
    <tr>
        <td style=\"width:56px;\"></td>
        <td style=\"width:533px;\">
            <table cellpadding=\"0\" cellspacing=\"0\" style=\"width:533px;height:209px;\">
                <tr>
                    <td style=\"height:43px;border-bottom:2px solid #333;font-weight:bold;font-size:20px;font-family:'맑은 고딕','Malgun Gothic';color:#333333;\">안녕하세요, 데이터 인 입니다.</td>
                </tr>
                <tr>
                    <td style=\"height:70px;background-color:#f7f7f7;\"></td>
                </tr>
                <tr>
                    <td style=\"text-align:center;font-weight:bold;font-size:16px;font-family:'돋움','Dotum';color:#333333;line-height:23px;background-color:#f7f7f7;\">설정하신 옵션에 따른 서비스 평가모델 보고서 생성이 완료 되었습니다.</td>
                </tr>
                <tr>
                    <td style=\"height:12px;background-color:#f7f7f7;\"></td>
                </tr>
                 <tr>
                    <td style=\"text-align:center;font-weight:bold;font-size:16px;font-family:'돋움','Dotum';color:#333333;line-height:23px;background-color:#f7f7f7;\">'나의 보고서 관리' 메뉴를 통해서 보고서를 다운로드 하실 수 있습니다.</td>
                </tr>
				<tr>
                    <td style=\"height:12px;background-color:#f7f7f7;\"></td>
                </tr>
                <tr>
                    <td style=\"text-align:center;font-size:13px;font-family:'돋움','Dotum';color:#666666;line-height:16px;background-color:#f7f7f7;\"><font style=\"font-size:16px;color:#e03f4e;font-weight:bold;\"><a href='http://surveyin.kr/report/my-report.php' target='_blank'>http://surveyin.kr/report/my-report.php</a></td>
                </tr>
                <tr>
                    <td style=\"height:70px;border-bottom:1px solid #ddd;background-color:#f7f7f7;\"></td>
                </tr>
             </table>
        </td>
        <td style=\"width:55px;\"></td>
    </tr>
    <tr>
        <td colspan=\"3\" style=\"height:45px;\"></td>
    </tr>
   </table>
		";
	
	//mail_utf($from_email,$from_name,$to_email,$subject,$content);

	$url = "http://webmarker2.cafe24.com/out_mail.php";
		$data = array(
			"FROMEMAIL" => $from_email, // 보내는 메일 
			"FROMNAME" => $from_name, // 보내는사람 이름 
			"tomail" => $to_email, // 받는메일 
			"SUBJECT" => $subject, // 메일제목 
			"content" => $content // 메일내용
		);

		$out_mail = get_curl_post($url,$data,"");

} // 보고서 추출대상 루프 종료 

	error_frame("보고서 생성이 완료 되었습니다.");
?>