<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
// http://surveyin.kr/report/cron_satisfaction_report.php
$bbs_code = "contentment";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

$inc_report_sql = "select * from wise_analysis_myreport where 1 and idx='88'";
//$inc_report_sql = "select * from wise_analysis_myreport where 1 and idx='17'";
$inc_report_query = mysqli_query($gconnet,$inc_report_sql);
for ($inc_report_i=0; $inc_report_i<mysqli_num_rows($inc_report_query); $inc_report_i++){ // 보고서 추출대상 루프 시작 
	$inc_report_row = mysqli_fetch_array($inc_report_query);
		
	$satisfaction_option_idx = trim($inc_report_row['report_idx']);
	$satisfaction_option_report_title = trim($inc_report_row['report_title']);
	$memid = trim($inc_report_row['memid']);
	$subid = trim($inc_report_row['subid']);

	$inc_report_query_1 = "update wise_analysis_myreport set report_sdate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	//$inc_report_result_1 = mysqli_query($gconnet,$inc_report_query_1);

	$sql_file_0 = "select satisfaction_option_idx from wise_analysis_report_satisfaction_100data where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		/*$sql_del_0 = "delete from wise_analysis_report_satisfaction_100data where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_0 = mysqli_query($gconnet,$sql_del_0);
		$sql_del_1 = "delete from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_1 = mysqli_query($gconnet,$sql_del_1);
		$sql_del_2 = "delete from wise_analysis_report_satisfaction_data where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_2 = mysqli_query($gconnet,$sql_del_2);
		$sql_del_3 = "delete from wise_analysis_report_satisfaction_data_group where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_3 = mysqli_query($gconnet,$sql_del_3);
		$sql_del_4 = "delete from wise_analysis_report_satisfaction_data_group_detail where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_4 = mysqli_query($gconnet,$sql_del_4);
		$sql_del_5 = "delete from wise_analysis_report_satisfaction_statistics where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_5 = mysqli_query($gconnet,$sql_del_5);
		$sql_del_6 = "delete from wise_analysis_report_satisfaction_statistics_group where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_6 = mysqli_query($gconnet,$sql_del_6);
		$sql_del_7 = "delete from wise_analysis_report_satisfaction_statistics_group_detail where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'"; 
		$query_del_7 = mysqli_query($gconnet,$sql_del_7);*/
	}
	
	$compet_info_sql = "select analysis_report_idx,analysis_report_satisfaction_option_scorepoint,analysis_report_satisfaction_option_percent,(select quiz_no from wise_analysis_quiz where 1 and idx=a.analysis_report_satisfaction_option_loyer_stfno) as quiz_no_stf,(select quiz_no from wise_analysis_quiz where 1 and idx=a.analysis_report_satisfaction_option_loyer_lytno) as quiz_no_lyt from wise_analysis_report_satisfaction_option a where 1 and idx='".$satisfaction_option_idx."'";
	/*if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}*/
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	
	$row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($row['analysis_report_idx']);
	$satisfaction_option_scorepoint = $row['analysis_report_satisfaction_option_scorepoint'];
	$satisfaction_option_percent = trim($row['analysis_report_satisfaction_option_percent']);
	$quiz_no_stf = trim($row['quiz_no_stf']);
	$quiz_no_lyt = trim($row['quiz_no_lyt']);
	
	$query = "insert into wise_analysis_report_satisfaction_100data set"; 
	$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query .= " satisfaction_option_report_title = '".$satisfaction_option_report_title."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " wdate = now() ";
	//$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_satisfaction_100data where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$satisfaction_option_100data_idx = $mem_row2[idx]; 
	
	$sql_file_1 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_title .= $row_file_1['analysis_report_satisfaction_option_variable_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_title .= $row_file_1['analysis_report_satisfaction_option_variable_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);
	
	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' order by data_no asc";
	//echo $sql_data_1."<br>";
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$satisfaction_100data_no = $row_data_1['data_no'];

		//if($opt_i > 2){exit;}
		
		######## raw data 시작 ############
		/*	$sql_data_2 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$satisfaction_100data_no."' order by CONVERT(quiz_no, UNSIGNED) asc";
			//echo $sql_data_2."<br>";
			$query_data_2 = mysqli_query($gconnet,$sql_data_2);

			for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 루프 시작 
				$row_data_2 = mysqli_fetch_array($query_data_2);

				//echo "quiz_no = ".$row_data_2['quiz_no']."<br>";

				$satisfaction_100data_no = $row_data_2['data_no'];
				$satisfaction_100data_quiz_no = $row_data_2['quiz_no'];
				$satisfaction_100data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_title"," and analysis_idx='".$row_data_2['analysis_idx']."'");
		
				$satisfaction_100data_quiz_conf = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_2['quiz_no'],"quiz_conf"," and analysis_idx='".$row_data_2['analysis_idx']."'");
				
				if($row_data_2['analysis_idx'] == "8" && ($row_data_2['quiz_no'] >= "38" && $row_data_2['quiz_no'] <= "45")){
					$satisfaction_100data_quiz_val = $row_data_2['data_val'];
				} else {
					if(trim($satisfaction_100data_quiz_conf) == "Y"){
						$satisfaction_100data_quiz_val = $row_data_2['data_val'];
					} else {
						$satisfaction_100data_quiz_val = get_calcurate_point($satisfaction_option_idx,$row_data_2['data_val']);
					}
				}

				$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
				$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
				$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
				$query_in .= " analysis_report_satisfaction_100data_quiz_no = '".$satisfaction_100data_quiz_no."', ";
				$query_in .= " analysis_report_satisfaction_100data_quiz_title = '".$satisfaction_100data_quiz_title."', ";
				$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_quiz_val."', ";
				$query_in .= " wdate = now() ";
				//echo $query_in."<br>"; //exit;
				$result_in = mysqli_query($gconnet,$query_in);
			
			} // 로우데이터 루프 종료 */
		######## raw data 시작 ############

		######## 독립변수 시작 #############
		/*	
			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 독립변수 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

				//if($opt_i > 0){exit;}

				$satisfaction_100data_quiz_val = get_satisf_option_model_quiz_avg($satisfaction_option_100data_idx,$satisfaction_100data_no,$satisfaction_option_idx,$file_1_idx2);
				
				//if($file_1_title2){
					$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
					$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
					$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
					$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
					$query_in .= " analysis_report_satisfaction_100data_model_no = '".$file_1_idx2."', ";
					$query_in .= " analysis_report_satisfaction_100data_quiz_title = '".$file_1_title2."', ";
					$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_quiz_val."', ";
					$query_in .= " wdate = now() ";
					//echo $query_in."<br>"; //exit;
					$result_in = mysqli_query($gconnet,$query_in);
				//}

			} // 독립변수 루프 종료 */
		######## 독립변수 종료 #############
			//exit;
		######## CSI 시작 ##########
			$satisfaction_100data_csi_val = get_satisf_csi_avg($satisfaction_option_idx,$satisfaction_option_100data_idx,$satisfaction_100data_no);
			//exit;
			$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
			$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
			$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_title = 'CSI', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_csi_val."', ";
			$query_in .= " wdate = now() ";
			echo $query_in."<br>"; exit;
			//$result_in = mysqli_query($gconnet,$query_in);
		######## CSI 종료 ##########

		//exit;

			$s_100data_satisfval = get_satisf_100data_satisfval($satisfaction_option_idx,$satisfaction_100data_no,$quiz_no_stf);
			$s_100data_loyalval = get_satisf_100data_satisfval($satisfaction_option_idx,$satisfaction_100data_no,$quiz_no_lyt);
			if($s_100data_satisfval >= $satisfaction_100data_csi_val){
				$satisfaction_100data_satisfval = 1;
			} else {
				$satisfaction_100data_satisfval = 0;
			}
			if($s_100data_loyalval >= $satisfaction_100data_csi_val){
				$satisfaction_100data_loyalval = 1;
			} else {
				$satisfaction_100data_loyalval = 0;
			}

			if($satisfaction_100data_satisfval == "1" && $satisfaction_100data_loyalval == "1"){
				$satisfaction_100data_loyal_groupval = "4(우량충성집단)";
			} elseif($satisfaction_100data_satisfval == "1" && $satisfaction_100data_loyalval == "0"){
				$satisfaction_100data_loyal_groupval = "2(타성적충성집단)";
			} elseif($satisfaction_100data_satisfval == "0" && $satisfaction_100data_loyalval == "1"){
				$satisfaction_100data_loyal_groupval = "3(잠재적충성집단)";
			} elseif($satisfaction_100data_satisfval == "0" && $satisfaction_100data_loyalval == "0"){
				$satisfaction_100data_loyal_groupval = "1(비충성집단)";
			}

			$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
			$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
			$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_title = '고객만족도_상하', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_satisfval."', ";
			$query_in .= " wdate = now() ";
			$result_in = mysqli_query($gconnet,$query_in);

			$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
			$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
			$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_title = '충성도_상하', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_loyalval."', ";
			$query_in .= " wdate = now() ";
			$result_in = mysqli_query($gconnet,$query_in);

			$query_in = "insert into wise_analysis_report_satisfaction_100data_detail set"; 
			$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_in .= " satisfaction_option_100data_idx = '".$satisfaction_option_100data_idx."', ";
			$query_in .= " analysis_report_satisfaction_100data_no = '".$satisfaction_100data_no."', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_title = '고객충성집단', ";
			$query_in .= " analysis_report_satisfaction_100data_quiz_val = '".$satisfaction_100data_loyal_groupval."', ";
			$query_in .= " wdate = now() ";
			$result_in = mysqli_query($gconnet,$query_in);

	} // 웅답자 루프 종료 

	######## 만족도 지수 입력시작 ############
	
	$query = "insert into wise_analysis_report_satisfaction_data set"; 
	$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " analysis_report_satisfaction_option_percent = '".$satisfaction_option_percent."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre = "select idx from wise_analysis_report_satisfaction_data where 1 order by idx desc limit 0,1"; 
	$result_pre  = mysqli_query($gconnet,$sql_pre);
	$mem_row = mysqli_fetch_array($result_pre);
	$satisfaction_data_idx = $mem_row[idx];
	
	//$sql_data_1 = "select distinct(quiz_no) as quiz_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and (quiz_no in (select quiz_no from wise_analysis_quiz where 1 and analysis_idx='".$analysis_report_idx."' and quiz_conf='Y') or quiz_no='38') order by CONVERT(quiz_no, UNSIGNED) desc";
	$sql_data_1 = "select distinct(quiz_no) as quiz_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no in (select quiz_no from wise_analysis_quiz where 1 and analysis_idx='".$analysis_report_idx."' and idx in (select analysis_report_satisfaction_option_group_no from wise_analysis_report_satisfaction_option_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."')) order by CONVERT(quiz_no, UNSIGNED) desc";
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	
	for($opt_i=0; $opt_i<mysqli_num_rows($query_data_1); $opt_i++){ // 로우데이터 그룹별 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);

		//if($opt_i > 0){exit;}

		$analysis_report_satisfaction_data_group_no = $row_data_1['quiz_no'];
		$analysis_report_satisfaction_data_group_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_1['quiz_no'],"quiz_title"," and analysis_idx='".$analysis_report_idx."'");

		$query_in = "insert into wise_analysis_report_satisfaction_data_group set"; 
		$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_in .= " satisfaction_data_idx = '".$satisfaction_data_idx."', ";
		$query_in .= " analysis_report_satisfaction_data_group_no = '".$analysis_report_satisfaction_data_group_no."', ";
		$query_in .= " analysis_report_satisfaction_data_group_title = '".$analysis_report_satisfaction_data_group_title."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_satisfaction_data_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$satisfaction_data_group_idx = $mem_row_2[idx];

		$sql_data_2 = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$analysis_report_satisfaction_data_group_no."' ";
		//echo "sql_data_2 : ".$sql_data_2."<br>";
		$query_data_2 = mysqli_query($gconnet,$sql_data_2);

		for($opt2_i=0; $opt2_i<mysqli_num_rows($query_data_2); $opt2_i++){ // 로우데이터 그룹별 세부문항 루프 시작 
			$row_data_2 = mysqli_fetch_array($query_data_2);

			$analysis_report_satisfaction_data_group2_no = $row_data_2['data_val'];

			$analysis_report_satisfaction_data_group2_title_arr = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_1['quiz_no'],"quiz_value"," and analysis_idx='".$analysis_report_idx."'");
			$analysis_report_satisfaction_data_group2_title_arr2 = explode($row_data_2['data_val']."|",$analysis_report_satisfaction_data_group2_title_arr);
			$analysis_report_satisfaction_data_group2_title_arr3 = explode("^",$analysis_report_satisfaction_data_group2_title_arr2[1]);
			$analysis_report_satisfaction_data_group2_title = trim($analysis_report_satisfaction_data_group2_title_arr3[0]);

			//$sql_data_3 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='1' order by CONVERT(quiz_no, UNSIGNED) asc";

			$sql_data_3 = "select * from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='1' and quiz_no in (select quiz_no from wise_analysis_quiz where 1 and analysis_idx='".$analysis_report_idx."' and (idx in (select analysis_report_satisfaction_option_group_no from wise_analysis_report_satisfaction_option_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."') or idx in (select analysis_report_satisfaction_option_factor_no from wise_analysis_report_satisfaction_option_model_quiz where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and  analysis_report_satisfaction_option_factor_type='P'))) order by CONVERT(quiz_no, UNSIGNED) asc";
			
			$query_data_3 = mysqli_query($gconnet,$sql_data_3);

			for($opt3_i=0; $opt3_i<mysqli_num_rows($query_data_3); $opt3_i++){ // 로우데이터 루프 시작 
				$row_data_3 = mysqli_fetch_array($query_data_3);

				$analysis_report_satisfaction_data_quiz_no = $row_data_3['quiz_no'];
				$analysis_report_satisfaction_data_quiz_title = get_data_colname("wise_analysis_quiz","quiz_no",$row_data_3['quiz_no'],"quiz_title"," and analysis_idx='".$analysis_report_idx."'");
			    $analysis_report_satisfaction_data_quiz_val = get_satisf_data_group_detail_avg($satisfaction_option_idx,$analysis_report_idx,$row_data_1['quiz_no'],$row_data_2['data_val'],$row_data_3['quiz_no']);
	
				$query_in2 = "insert into wise_analysis_report_satisfaction_data_group_detail set"; 
				$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query_in2 .= " satisfaction_data_idx = '".$satisfaction_data_idx."', ";
				$query_in2 .= " satisfaction_data_group_idx = '".$satisfaction_data_group_idx."', ";
				$query_in2 .= " analysis_report_satisfaction_data_group2_no = '".$analysis_report_satisfaction_data_group2_no."', ";
				$query_in2 .= " analysis_report_satisfaction_data_group2_title = '".$analysis_report_satisfaction_data_group2_title."', ";
				$query_in2 .= " analysis_report_satisfaction_data_quiz_no = '".$analysis_report_satisfaction_data_quiz_no."', ";
				$query_in2 .= " analysis_report_satisfaction_data_quiz_title = '".$analysis_report_satisfaction_data_quiz_title."', ";
				$query_in2 .= " analysis_report_satisfaction_data_quiz_val = '".$analysis_report_satisfaction_data_quiz_val."', ";
				$query_in2 .= " wdate = now() ";
				$result_in2 = mysqli_query($gconnet,$query_in2);

			} // 로우데이터 루프 종료 

			for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 독립변수 루프 시작 
				$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
				$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
				
				$analysis_report_satisfaction_data_quiz_val = get_satisf_data_group_detail_avg2($satisfaction_option_idx,$analysis_report_idx,$row_data_1['quiz_no'],$row_data_2['data_val'],$file_1_title2);
								
				$query_in2 = "insert into wise_analysis_report_satisfaction_data_group_detail set"; 
				$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query_in2 .= " satisfaction_data_idx = '".$satisfaction_data_idx."', ";
				$query_in2 .= " satisfaction_data_group_idx = '".$satisfaction_data_group_idx."', ";
				$query_in2 .= " analysis_report_satisfaction_data_group2_no = '".$analysis_report_satisfaction_data_group2_no."', ";
				$query_in2 .= " analysis_report_satisfaction_data_group2_title = '".$analysis_report_satisfaction_data_group2_title."', ";
				$query_in2 .= " analysis_report_satisfaction_data_model_no = '".$file_1_idx2."', ";
				$query_in2 .= " analysis_report_satisfaction_data_quiz_title = '".$file_1_title2."', ";
				$query_in2 .= " analysis_report_satisfaction_data_quiz_val = '".$analysis_report_satisfaction_data_quiz_val."', ";
				$query_in2 .= " wdate = now() ";
				$result_in2 = mysqli_query($gconnet,$query_in2);
			} // 독립변수 루프 종료 

			$analysis_report_satisfaction_data_quiz_val = get_satisf_data_group_detail_avg2($satisfaction_option_idx,$analysis_report_idx,$row_data_1['quiz_no'],$row_data_2['data_val'],"CSI");

			$query_in2 = "insert into wise_analysis_report_satisfaction_data_group_detail set"; 
			$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query_in2 .= " satisfaction_data_idx = '".$satisfaction_data_idx."', ";
			$query_in2 .= " satisfaction_data_group_idx = '".$satisfaction_data_group_idx."', ";
			$query_in2 .= " analysis_report_satisfaction_data_group2_no = '".$analysis_report_satisfaction_data_group2_no."', ";
			$query_in2 .= " analysis_report_satisfaction_data_group2_title = '".$analysis_report_satisfaction_data_group2_title."', ";
			$query_in2 .= " analysis_report_satisfaction_data_quiz_title = 'CSI', ";
			$query_in2 .= " analysis_report_satisfaction_data_quiz_val = '".$analysis_report_satisfaction_data_quiz_val."', ";
			$query_in2 .= " wdate = now() ";
			$result_in2 = mysqli_query($gconnet,$query_in2); // CSI 
		
		}  // 로우데이터 그룹별 세부문항 루프 종료 
	
	} // 로우데이터 그룹별 루프 종료 

	######## 만족도 지수 입력종료 ############
	
	######## IPA 입력 시작 ###########
	
	$query = "insert into wise_analysis_report_satisfaction_statistics set"; 
	$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " wdate = now() ";
	$result = mysqli_query($gconnet,$query);

	$sql_pre = "select idx from wise_analysis_report_satisfaction_statistics where 1 order by idx desc limit 0,1"; 
	$result_pre  = mysqli_query($gconnet,$sql_pre);
	$mem_row = mysqli_fetch_array($result_pre);
	$satisfaction_statistics_idx = $mem_row[idx];

	$query_in = "insert into wise_analysis_report_satisfaction_statistics_group set"; 
	$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in .= " analysis_report_satisfaction_statistics_group_title = 'Y 절편', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre_2 = "select idx from wise_analysis_report_satisfaction_statistics_group where 1 order by idx desc limit 0,1"; 
	$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
	$mem_row_2 = mysqli_fetch_array($result_pre_2);
	$satisfaction_statistics_group_idx = $mem_row_2[idx];

	$query_in2 = "insert wise_analysis_report_satisfaction_statistics_group_detail set"; 
	$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in2 .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in2 .= " satisfaction_statistics_group_idx = '".$satisfaction_statistics_group_idx."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_no = '".$analysis_report_satisfaction_statistics_group2_no."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_title = '".$analysis_report_satisfaction_statistics_group2_title."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_data = '".$analysis_report_satisfaction_statistics_ipa_data."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stder = '".$analysis_report_satisfaction_statistics_ipa_stder."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_t = '".$analysis_report_satisfaction_statistics_ipa_t."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_pval = '".$analysis_report_satisfaction_statistics_ipa_pval."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_min95 = '".$analysis_report_satisfaction_statistics_ipa_min95."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_max95 = '".$analysis_report_satisfaction_statistics_ipa_max95."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_tabval = '".$analysis_report_satisfaction_statistics_ipa_tabval."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_ratio = '".$analysis_report_satisfaction_statistics_ipa_ratio."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stf = '".$analysis_report_satisfaction_statistics_ipa_stf."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_imt = '".$analysis_report_satisfaction_statistics_ipa_imt."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_1 = '".$analysis_report_satisfaction_statistics_frequency_1."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_2 = '".$analysis_report_satisfaction_statistics_frequency_2."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_3 = '".$analysis_report_satisfaction_statistics_frequency_3."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_4 = '".$analysis_report_satisfaction_statistics_frequency_4."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_total = '".$analysis_report_satisfaction_statistics_frequency_total."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_1 = '".$analysis_report_satisfaction_statistics_ratio_1."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_2 = '".$analysis_report_satisfaction_statistics_ratio_2."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_3 = '".$analysis_report_satisfaction_statistics_ratio_3."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_4 = '".$analysis_report_satisfaction_statistics_ratio_4."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_total = '".$analysis_report_satisfaction_statistics_ratio_total."', ";
	$query_in2 .= " wdate = now() ";
	$result_in2 = mysqli_query($gconnet,$query_in2); // Y 절편 

	################## 독립변수만 따로 추출 시작 ################
	$file_1_idx = "";
	$file_1_title = "";

	$sql_file_1 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_title .= $row_file_1['analysis_report_satisfaction_option_variable_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_title .= $row_file_1['analysis_report_satisfaction_option_variable_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);
	################## 독립변수만 따로 추출 종료 ################

	$data_ipa_x_val = get_ipa_x_val($satisfaction_option_idx,$analysis_report_idx);
	$data_ipa_y_val = get_ipa_y_val($satisfaction_option_idx,$analysis_report_idx);
	include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_ipa_data.php"; // IPA 데이터 추출 인클루드
	//exit;

	$ipa_total_t = 0;
	for($ipa_t_i=0; $ipa_t_i<sizeof($getTStats); $ipa_t_i++){ // T 계수 배열수만큼 루프 시작  
		if($getTStats[$ipa_t_i] < 0){
			$ipa_t = $getTStats[$ipa_t_i]*-1;
		} else {
			$ipa_t = $getTStats[$ipa_t_i];
		}
		$ipa_total_t = $ipa_total_t + $ipa_t; // t 통계량 합계
	} // T 계수 배열수만큼 루프 종료 
	
	//$ipa_total_t = round($ipa_total_t,14);
	$ipa_total_t = round($ipa_total_t,$satisfaction_option_scorepoint);
	
	$ipa_total_ratio = 0; // 전체합 1로 변환 합계
	$ipa_total_stf = 0; // 만족도 합계
	$ipa_total_imt = 0; // 중요도 합계
	for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 독립변수 루프 시작 
		$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
		$file_1_title2 = trim($file_1_title_arr[$opt3_i]);

		$query_in = "insert into wise_analysis_report_satisfaction_statistics_group set"; 
		$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_in .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
		$query_in .= " analysis_report_satisfaction_statistics_group_no = '".$file_1_idx2."', ";
		$query_in .= " analysis_report_satisfaction_statistics_group_title = '".$file_1_title2."', ";
		$query_in .= " wdate = now() ";
		$result_in = mysqli_query($gconnet,$query_in);

		$sql_pre_2 = "select idx from wise_analysis_report_satisfaction_statistics_group where 1 order by idx desc limit 0,1"; 
		$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
		$mem_row_2 = mysqli_fetch_array($result_pre_2);
		$satisfaction_statistics_group_idx = $mem_row_2[idx];
		
		$analysis_report_satisfaction_statistics_ipa_t = round($getTStats[$opt3_i],$satisfaction_option_scorepoint);
		if($analysis_report_satisfaction_statistics_ipa_t < 0){
			$analysis_report_satisfaction_statistics_ipa_t = $analysis_report_satisfaction_statistics_ipa_t*-1;
		}
		$analysis_report_satisfaction_statistics_ipa_tabval = round($getTStats[$opt3_i],$satisfaction_option_scorepoint);
		if($analysis_report_satisfaction_statistics_ipa_tabval < 0){
			$analysis_report_satisfaction_statistics_ipa_tabval = $analysis_report_satisfaction_statistics_ipa_tabval*-1;
		}
		$analysis_report_satisfaction_statistics_ipa_ratio = round($analysis_report_satisfaction_statistics_ipa_t/$ipa_total_t,$satisfaction_option_scorepoint);
		$analysis_report_satisfaction_statistics_ipa_stf = get_perq_ipa_avg($satisfaction_option_idx,$file_1_idx2,$file_1_title2); // 문항별 평균 만족도(?) - 확인필요  
		$analysis_report_satisfaction_statistics_ipa_imt = $analysis_report_satisfaction_statistics_ipa_ratio; // 중요도 

		$query_in2 = "insert wise_analysis_report_satisfaction_statistics_group_detail set"; 
		$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_in2 .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
		$query_in2 .= " satisfaction_statistics_group_idx = '".$satisfaction_statistics_group_idx."', ";
		//$query_in2 .= " analysis_report_satisfaction_statistics_group2_no = '".$analysis_report_satisfaction_statistics_group2_no."', ";
		//$query_in2 .= " analysis_report_satisfaction_statistics_group2_title = '".$analysis_report_satisfaction_statistics_group2_title."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_data = '".$analysis_report_satisfaction_statistics_ipa_data."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stder = '".$analysis_report_satisfaction_statistics_ipa_stder."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_t = '".$analysis_report_satisfaction_statistics_ipa_t."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_pval = '".$analysis_report_satisfaction_statistics_ipa_pval."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_min95 = '".$analysis_report_satisfaction_statistics_ipa_min95."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_max95 = '".$analysis_report_satisfaction_statistics_ipa_max95."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_tabval = '".$analysis_report_satisfaction_statistics_ipa_tabval."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_ratio = '".$analysis_report_satisfaction_statistics_ipa_ratio."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stf = '".$analysis_report_satisfaction_statistics_ipa_stf."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ipa_imt = '".$analysis_report_satisfaction_statistics_ipa_imt."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_frequency_1 = '".$analysis_report_satisfaction_statistics_frequency_1."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_frequency_2 = '".$analysis_report_satisfaction_statistics_frequency_2."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_frequency_3 = '".$analysis_report_satisfaction_statistics_frequency_3."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_frequency_4 = '".$analysis_report_satisfaction_statistics_frequency_4."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_frequency_total = '".$analysis_report_satisfaction_statistics_frequency_total."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ratio_1 = '".$analysis_report_satisfaction_statistics_ratio_1."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ratio_2 = '".$analysis_report_satisfaction_statistics_ratio_2."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ratio_3 = '".$analysis_report_satisfaction_statistics_ratio_3."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ratio_4 = '".$analysis_report_satisfaction_statistics_ratio_4."', ";
		$query_in2 .= " analysis_report_satisfaction_statistics_ratio_total = '".$analysis_report_satisfaction_statistics_ratio_total."', ";
		$query_in2 .= " wdate = now() ";
		//echo $query_in2."<br>";
		$result_in2 = mysqli_query($gconnet,$query_in2); 
		
		$ipa_total_ratio = $ipa_total_ratio+$analysis_report_satisfaction_statistics_ipa_ratio;
		$ipa_total_stf = $ipa_total_stf+$analysis_report_satisfaction_statistics_ipa_stf;
		$ipa_total_imt = $ipa_total_imt+$analysis_report_satisfaction_statistics_ipa_imt;
	
	} // 독립변수 루프 종료 

	$query_in = "insert into wise_analysis_report_satisfaction_statistics_group set"; 
	$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in .= " analysis_report_satisfaction_statistics_group_title = '합계', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre_2 = "select idx from wise_analysis_report_satisfaction_statistics_group where 1 order by idx desc limit 0,1"; 
	$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
	$mem_row_2 = mysqli_fetch_array($result_pre_2);
	$satisfaction_statistics_group_idx = $mem_row_2[idx];

	$query_in2 = "insert wise_analysis_report_satisfaction_statistics_group_detail set"; 
	$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in2 .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in2 .= " satisfaction_statistics_group_idx = '".$satisfaction_statistics_group_idx."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_no = '".$analysis_report_satisfaction_statistics_group2_no."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_title = '".$analysis_report_satisfaction_statistics_group2_title."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_t = '".$ipa_total_t."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_tabval = '".$ipa_total_t."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_ratio = '".$ipa_total_ratio."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stf = '".$ipa_total_stf."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_imt = '".$ipa_total_imt."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_frequency_total = '".$analysis_report_satisfaction_statistics_frequency_total."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ratio_total = '".$analysis_report_satisfaction_statistics_ratio_total."', ";
	$query_in2 .= " wdate = now() ";
	$result_in2 = mysqli_query($gconnet,$query_in2); // 합계

	$query_in = "insert into wise_analysis_report_satisfaction_statistics_group set"; 
	$query_in .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in .= " analysis_report_satisfaction_statistics_group_title = '평균', ";
	$query_in .= " wdate = now() ";
	$result_in = mysqli_query($gconnet,$query_in);

	$sql_pre_2 = "select idx from wise_analysis_report_satisfaction_statistics_group where 1 order by idx desc limit 0,1"; 
	$result_pre_2  = mysqli_query($gconnet,$sql_pre_2);
	$mem_row_2 = mysqli_fetch_array($result_pre_2);
	$satisfaction_statistics_group_idx = $mem_row_2[idx];

	$ipa_avg_stf = round($ipa_total_stf/sizeof($file_1_idx_arr),$satisfaction_option_scorepoint); 
	$ipa_avg_imt = round($ipa_total_imt/sizeof($file_1_idx_arr),$satisfaction_option_scorepoint); 

	$query_in2 = "insert wise_analysis_report_satisfaction_statistics_group_detail set"; 
	$query_in2 .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
	$query_in2 .= " satisfaction_statistics_idx = '".$satisfaction_statistics_idx."', ";
	$query_in2 .= " satisfaction_statistics_group_idx = '".$satisfaction_statistics_group_idx."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_no = '".$analysis_report_satisfaction_statistics_group2_no."', ";
	//$query_in2 .= " analysis_report_satisfaction_statistics_group2_title = '".$analysis_report_satisfaction_statistics_group2_title."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_stf = '".$ipa_avg_stf."', ";
	$query_in2 .= " analysis_report_satisfaction_statistics_ipa_imt = '".$ipa_avg_imt."', ";
	$query_in2 .= " wdate = now() ";
	$result_in2 = mysqli_query($gconnet,$query_in2); // 평균
	
	######## IPA 입력 종료 ###########

	$inc_report_query_2 = "update wise_analysis_myreport set report_status='com',report_edate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	$inc_report_result_2 = mysqli_query($gconnet,$inc_report_query_2);

	$from_email = "cs@surveyin.kr";
	$from_name = "데이터인";
	$to_email = $inc_report_row['report_email'];

	$subject = "[데이터인] 만족도모델 보고서가 생성 되었습니다.";
		
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
                    <td style=\"text-align:center;font-weight:bold;font-size:16px;font-family:'돋움','Dotum';color:#333333;line-height:23px;background-color:#f7f7f7;\">설정하신 옵션에 따른 만족도모델 보고서 생성이 완료 되었습니다.</td>
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

		mail_utf($from_email,$from_name,$to_email,$subject,$content);

} // 보고서 추출대상 루프 종료 
?>