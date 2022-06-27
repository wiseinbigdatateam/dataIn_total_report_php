<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "service";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";
	
	//echo('<pre>'); print_r($_REQUEST); echo('</pre>'); //exit;
	
	$service_option_idx = trim(sqlfilter($_REQUEST['service_option_idx']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$service_option_status = trim(sqlfilter($_REQUEST['service_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];

	$attach_count_1 = trim(sqlfilter($_REQUEST['attach_count_1'])); // 동일배점 갯수
	$attach_count_2 = trim(sqlfilter($_REQUEST['attach_count_2'])); // 등급기준 갯수

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$service_option_idx){  
		error_frame_go("다시 진행해주세요.","service_1.php");
	}

	$factor_no_x_p = $_REQUEST['factor_no_x_p'];
	$factor_no_x_p_arr = explode('||',$factor_no_x_p);

	$jongs_check = $_REQUEST['jongs_check'];
	//echo "jcheck = ".$jongs_check."<br>";
	$jongs_check_arr = explode('|',$jongs_check);
	echo "jongs_check_cnt = ".sizeof($jongs_check_arr)."<br>";
	
	$jongs_check_cnt = 0;
	for($joi=0; $joi<sizeof($jongs_check_arr); $joi++){
		echo $joi." : ".$jongs_check_arr[$joi]."<br>";
		if($jongs_check_arr[$joi] == "Y"){
			$jongs_check_cnt = $jongs_check_cnt+1;
		}
	}
	
	if($jongs_check_cnt == 0){
		//error_frame("종속변수를 선택해 주세요.");
	}
	if($jongs_check_cnt >= 2){
		error_frame("종속변수는 하나만 체크해 주셔야 합니다.");
	}

	$service_option_samescyn_title_arr = $_REQUEST['service_option_samescyn_title'];

	for($i=0; $i<$attach_count_1; $i++){
		$analysis_report_service_option_samescyn_title = $service_option_samescyn_title_arr[$i];
		if($analysis_report_service_option_samescyn_title){
			echo "same_scn_title = ".$analysis_report_service_option_samescyn_title."<br>";
			$factor_no_x_p_arr2 = explode('<a href="javascript:',$factor_no_x_p_arr[$i]);
			$factor_no_x_p_arr3 = explode(';"',$factor_no_x_p_arr2[1]);
			if(!$factor_no_x_p_arr2[1]){
				error_frame("변수 문항을 입력해 주세요.");
			}
		}
	}

	$analysis_report_service_option_samescyn = trim(sqlfilter($_REQUEST['service_option_samescyn']));
	$analysis_report_service_option_samept = trim(sqlfilter($_REQUEST['service_option_samept']));
	$analysis_report_service_option_levelyn = trim(sqlfilter($_REQUEST['service_option_levelyn']));

	$query = "update wise_analysis_report_service_option set"; 
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " analysis_report_service_option_samescyn = '".$analysis_report_service_option_samescyn."', ";
	$query .= " analysis_report_service_option_samept = '".$analysis_report_service_option_samept."', ";
	$query .= " analysis_report_service_option_levelyn = '".$analysis_report_service_option_levelyn."' ";
	$query .= " where 1 and idx='".$service_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	//echo "main sql = ".$query."<br>";
	//exit;
	$result = mysqli_query($gconnet,$query);
	
	$sql_group_del = "delete from wise_analysis_report_service_option_samescyn where 1 and service_option_idx = '".$service_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	$sql_group2_del = "delete from wise_analysis_report_service_option_samescyn_quiz where 1 and service_option_idx = '".$service_option_idx."'";
	$result_group2_del = mysqli_query($gconnet,$sql_group2_del);

	$sql_group3_del = "delete from wise_analysis_report_service_option_levelyn where 1 and service_option_idx = '".$service_option_idx."'";
	$result_group3_del = mysqli_query($gconnet,$sql_group3_del);

	######### 동일배점 시작 ############
	$service_option_samescyn_jongs_arr = $_REQUEST['service_option_samescyn_jongs'];
	$service_option_samescyn_title_arr = $_REQUEST['service_option_samescyn_title'];

	//echo "attach_count_1 = ".$attach_count_1."<br>";

	for($i=0; $i<$attach_count_1; $i++){
		//$analysis_report_service_option_samescyn_jongs = $service_option_samescyn_jongs_arr[$i];
		$analysis_report_service_option_samescyn_jongs = $jongs_check_arr[$i];
		$analysis_report_service_option_samescyn_title = $service_option_samescyn_title_arr[$i];

		$query = "insert into wise_analysis_report_service_option_samescyn set"; 
		$query .= " service_option_idx = '".$service_option_idx."', ";
		$query .= " analysis_report_service_option_samescyn_jongs = '".$analysis_report_service_option_samescyn_jongs."', ";
		$query .= " analysis_report_service_option_samescyn_title = '".$analysis_report_service_option_samescyn_title."', ";
		$query .= " wdate = now() ";
		//echo "sub1 sql = ".$query."<br>";
		$result = mysqli_query($gconnet,$query);

		$sql_pre2 = "select idx from wise_analysis_report_service_option_samescyn where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$service_option_samescyn_idx = $mem_row2[idx]; 

		$factor_no_x_p_arr2 = explode('<li id="',$factor_no_x_p_arr[$i]);

		//echo "arr = ".$factor_no_x_p_arr[$i]."<br>";

		for($k=1; $k<sizeof($factor_no_x_p_arr2); $k++){
					
			$factor_no_x_p_arr3 = explode('<a href="javascript:',$factor_no_x_p_arr2[$k]);
			$factor_no_x_p_arr4 = explode(';"',$factor_no_x_p_arr3[1]);
			$analysis_report_service_option_samescyn_quiz_no = $factor_no_x_p_arr4[0];
			$analysis_report_service_option_samescyn_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_service_option_samescyn_quiz_no,"quiz_type","");
			$analysis_report_service_option_samescyn_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_service_option_samescyn_quiz_no,"quiz_title","");
			//echo "analysis_report_service_option_samescyn_quiz_title = ".$analysis_report_service_option_samescyn_quiz_title."<br>";

			$samescyn_quiz_prev_sql = "select idx from wise_analysis_report_service_option_samescyn_quiz where 1 and service_option_idx = '".$service_option_idx."' and analysis_report_service_option_samescyn_quiz_no = '".$analysis_report_service_option_samescyn_quiz_no."'";
			$samescyn_quiz_prev_query = mysqli_query($gconnet,$samescyn_quiz_prev_sql);
			$samescyn_quiz_prev_cnt1 = mysqli_num_rows($samescyn_quiz_prev_query);
			$samescyn_quiz_prev_cnt2 = $samescyn_quiz_prev_cnt1+1;

			$analysis_report_service_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score_'.$analysis_report_service_option_samescyn_quiz_no.''][$samescyn_quiz_prev_cnt2]);
			$analysis_report_service_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn_'.$analysis_report_service_option_samescyn_quiz_no.''][$samescyn_quiz_prev_cnt1]);
				
			$query_quiz = "insert into wise_analysis_report_service_option_samescyn_quiz set"; 
			$query_quiz .= " service_option_idx = '".$service_option_idx."', ";
			$query_quiz .= " service_option_samescyn_idx = '".$service_option_samescyn_idx."', ";
			$query_quiz .= " analysis_report_service_option_samescyn_quiz_no = '".$analysis_report_service_option_samescyn_quiz_no."', ";
			$query_quiz .= " analysis_report_service_option_samescyn_quiz_type = '".$analysis_report_service_option_samescyn_quiz_type."', ";
			$query_quiz .= " analysis_report_service_option_samescyn_quiz_title = '".$analysis_report_service_option_samescyn_quiz_title."', ";
			$query_quiz .= " analysis_report_service_option_samescyn_quiz_score = '".$analysis_report_service_option_samescyn_quiz_score."', ";
			$query_quiz .= " analysis_report_service_option_samescyn_quiz_tscyn = '".$analysis_report_service_option_samescyn_quiz_tscyn."', ";
			$query_quiz .= " wdate = now() ";
			//echo "sub2 sql = ".$query_quiz."<br>";
			//exit;
			$result_quiz = mysqli_query($gconnet,$query_quiz);
			//echo "query_quiz = ".$query_quiz."<br>";
		}
	}
	######### 동일배점 종료 ############

	######### 등급기준 시작 ############
	for($i=0; $i<$attach_count_2; $i++){
		$service_option_levelyn_title_arr = $_REQUEST['service_option_levelyn_title'];
		$service_option_levelyn_spoint_arr = $_REQUEST['service_option_levelyn_spoint'];
		$service_option_levelyn_epoint_arr = $_REQUEST['service_option_levelyn_epoint'];

		$analysis_report_service_option_levelyn_title = trim($service_option_levelyn_title_arr[$i]);
		$analysis_report_service_option_levelyn_spoint = trim($service_option_levelyn_spoint_arr[$i]);
		$analysis_report_service_option_levelyn_epoint = trim($service_option_levelyn_epoint_arr[$i]);

		$query_level = "insert into wise_analysis_report_service_option_levelyn set"; 
		$query_level .= " service_option_idx = '".$service_option_idx."', ";
		$query_level .= " analysis_report_service_option_levelyn_title = '".$analysis_report_service_option_levelyn_title."', ";
		$query_level .= " analysis_report_service_option_levelyn_spoint = '".$analysis_report_service_option_levelyn_spoint."', ";
		$query_level .= " analysis_report_service_option_levelyn_epoint = '".$analysis_report_service_option_levelyn_epoint."', ";
		$query_level .= " wdate = now() ";
		//echo "sub level sql = ".$query_level."<br>";
		$result_level = mysqli_query($gconnet,$query_level);
	}
	######### 등급기준 종료 ############

	//exit;

	if($_REQUEST['service_option_status'] == "com"){
		frame_go("service_3.php?service_option_idx=".$service_option_idx."");
	} else {
		//error_frame_reload("저장되었습니다.");
		error_frame("저장되었습니다.");
	}

?>