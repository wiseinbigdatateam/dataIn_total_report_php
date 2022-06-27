<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "damyun";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;

	$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$damyun_option_status = trim(sqlfilter($_REQUEST['damyun_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];

	$attach_count_1 = trim(sqlfilter($_REQUEST['attach_count_1'])); // 상사 갯수
	$attach_count_2 = trim(sqlfilter($_REQUEST['attach_count_2'])); // 부하 갯수
	$attach_count_3 = trim(sqlfilter($_REQUEST['attach_count_3'])); // 동료 갯수
	$attach_count_4 = trim(sqlfilter($_REQUEST['attach_count_4'])); // 본인 갯수

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	if(!$damyun_option_idx){  
		error_frame_go("다시 진행해주세요.","damyun_1.php");
	}

	$factor_no_x_p = $_REQUEST['factor_no_x_p'];
	$factor_no_x_p_arr = explode('||',$factor_no_x_p);
	$factor_no_x_p2 = $_REQUEST['factor_no_x_p2'];
	$factor_no_x_p2_arr = explode('||',$factor_no_x_p2);
	$factor_no_x_p3 = $_REQUEST['factor_no_x_p3'];
	$factor_no_x_p3_arr = explode('||',$factor_no_x_p3);
	$factor_no_x_p4 = $_REQUEST['factor_no_x_p4'];
	$factor_no_x_p4_arr = explode('||',$factor_no_x_p4);

	/*echo "상사 = ".$factor_no_x_p."<br><br>";
	echo "부하 = ".$factor_no_x_p2."<br><br>";
	echo "동료 = ".$factor_no_x_p3."<br><br>";
	echo "본인 = ".$factor_no_x_p4."<br><br>";
	exit;*/

	$jongs_check = $_REQUEST['jongs_check'];
	$jongs_check_arr = explode('|',$jongs_check);
	$jongs_check2 = $_REQUEST['jongs_check2'];
	$jongs_check2_arr = explode('|',$jongs_check2);
	$jongs_check3 = $_REQUEST['jongs_check3'];
	$jongs_check3_arr = explode('|',$jongs_check3);
	$jongs_check4 = $_REQUEST['jongs_check4'];
	$jongs_check4_arr = explode('|',$jongs_check4);

	$analysis_report_damyun_option_samescyn_1 = trim(sqlfilter($_REQUEST['damyun_option_samescyn_1']));
	$analysis_report_damyun_option_samept_1 = trim(sqlfilter($_REQUEST['damyun_option_samept_1']));
	$analysis_report_damyun_option_samescyn_2 = trim(sqlfilter($_REQUEST['damyun_option_samescyn_2']));
	$analysis_report_damyun_option_samept_2 = trim(sqlfilter($_REQUEST['damyun_option_samept_2']));
	$analysis_report_damyun_option_samescyn_3 = trim(sqlfilter($_REQUEST['damyun_option_samescyn_3']));
	$analysis_report_damyun_option_samept_3 = trim(sqlfilter($_REQUEST['damyun_option_samept_3']));
	$analysis_report_damyun_option_samescyn_4 = trim(sqlfilter($_REQUEST['damyun_option_samescyn_4']));
	$analysis_report_damyun_option_samept_4 = trim(sqlfilter($_REQUEST['damyun_option_samept_4']));

	$query = "update wise_analysis_report_damyun_option set"; 
	$query .= " analysis_report_damyun_option_samescyn_1 = '".$analysis_report_damyun_option_samescyn_1."', ";
	$query .= " analysis_report_damyun_option_samept_1 = '".$analysis_report_damyun_option_samept_1."', ";
	$query .= " analysis_report_damyun_option_samescyn_2 = '".$analysis_report_damyun_option_samescyn_2."', ";
	$query .= " analysis_report_damyun_option_samept_2 = '".$analysis_report_damyun_option_samept_2."', ";
	$query .= " analysis_report_damyun_option_samescyn_3 = '".$analysis_report_damyun_option_samescyn_3."', ";
	$query .= " analysis_report_damyun_option_samept_3 = '".$analysis_report_damyun_option_samept_3."', ";
	$query .= " analysis_report_damyun_option_samescyn_4 = '".$analysis_report_damyun_option_samescyn_4."', ";
	$query .= " analysis_report_damyun_option_samept_4 = '".$analysis_report_damyun_option_samept_4."' ";
	$query .= " where 1 and idx='".$damyun_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	//echo "main sql = ".$query."<br>";
	//exit;
	$result = mysqli_query($gconnet,$query);
	
	$sql_group_del = "delete from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	$sql_group2_del = "delete from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group2_del = mysqli_query($gconnet,$sql_group2_del);

	######### 상사 시작 ############
	$damyun_option_samescyn_jongs_arr = $_REQUEST['damyun_option_samescyn_jongs'];
	$damyun_option_samescyn_title_arr = $_REQUEST['damyun_option_samescyn_title'];
	
	/*echo "jongs = ".$_REQUEST['damyun_option_samescyn_jongs']."<br>";
	for($i=0; $i<$attach_count_1; $i++){
		echo "jongs line = ".$damyun_option_samescyn_jongs_arr[$i]."<br>";
	}
	exit;*/

	for($i=0; $i<$attach_count_1; $i++){
		$analysis_report_damyun_option_samescyn_type = "C1";
		//$analysis_report_damyun_option_samescyn_jongs = $damyun_option_samescyn_jongs_arr[$i];
		$analysis_report_damyun_option_samescyn_jongs = $jongs_check_arr[$i];
		$analysis_report_damyun_option_samescyn_title = $damyun_option_samescyn_title_arr[$i];
		
		$query = "insert into wise_analysis_report_damyun_option_samescyn set"; 
		$query .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query .= " analysis_report_damyun_option_samescyn_type = '".$analysis_report_damyun_option_samescyn_type."', ";
		$query .= " analysis_report_damyun_option_samescyn_jongs = '".$analysis_report_damyun_option_samescyn_jongs."', ";
		$query .= " analysis_report_damyun_option_samescyn_title = '".$analysis_report_damyun_option_samescyn_title."', ";
		$query .= " wdate = now() ";
		//echo "sub1 sql = ".$query."<br>";
		$result = mysqli_query($gconnet,$query);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_option_samescyn where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_option_samescyn_idx = $mem_row2[idx]; 

		$factor_no_x_p_arr2 = explode('<li id="',$factor_no_x_p_arr[$i]);
		for($k=1; $k<sizeof($factor_no_x_p_arr2); $k++){
					
			$factor_no_x_p_arr3 = explode('<a href="javascript:',$factor_no_x_p_arr2[$k]);
			$factor_no_x_p_arr4 = explode(';"',$factor_no_x_p_arr3[1]);
			$analysis_report_damyun_option_samescyn_quiz_no = $factor_no_x_p_arr4[0];
			$analysis_report_damyun_option_samescyn_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_type","");
			$analysis_report_damyun_option_samescyn_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_title","");
			//echo "analysis_report_damyun_option_samescyn_quiz_title = ".$analysis_report_damyun_option_samescyn_quiz_title."<br>";

			$samescyn_quiz_prev_sql = "select idx from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx = '".$damyun_option_idx."' and analysis_report_damyun_option_samescyn_quiz_no = '".$analysis_report_damyun_option_samescyn_quiz_no."'";
			$samescyn_quiz_prev_query = mysqli_query($gconnet,$samescyn_quiz_prev_sql);
			$samescyn_quiz_prev_cnt1 = mysqli_num_rows($samescyn_quiz_prev_query);
			$samescyn_quiz_prev_cnt2 = $samescyn_quiz_prev_cnt1+1;

			/*$analysis_report_damyun_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score_'.$analysis_report_damyun_option_samescyn_quiz_no.''][$samescyn_quiz_prev_cnt2]);
			$analysis_report_damyun_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn_'.$analysis_report_damyun_option_samescyn_quiz_no.''][$samescyn_quiz_prev_cnt1]);*/

			$analysis_report_damyun_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
			$analysis_report_damyun_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
				
			$query_quiz = "insert into wise_analysis_report_damyun_option_samescyn_quiz set"; 
			$query_quiz .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_quiz .= " damyun_option_samescyn_idx = '".$damyun_option_samescyn_idx."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_no = '".$analysis_report_damyun_option_samescyn_quiz_no."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_type = '".$analysis_report_damyun_option_samescyn_quiz_type."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_title = '".$analysis_report_damyun_option_samescyn_quiz_title."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_score = '".$analysis_report_damyun_option_samescyn_quiz_score."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_tscyn = '".$analysis_report_damyun_option_samescyn_quiz_tscyn."', ";
			$query_quiz .= " wdate = now() ";
			echo "sub2 sql = ".$query_quiz."<br>";
			//exit;
			$result_quiz = mysqli_query($gconnet,$query_quiz);
			//echo "query_quiz = ".$query_quiz."<br>";
		}
	}
	######### 상사 종료 ############

	######### 부하 시작 ############
	$damyun_option_samescyn_jongs_arr = $_REQUEST['damyun_option_samescyn_jongs2'];
	$damyun_option_samescyn_title_arr = $_REQUEST['damyun_option_samescyn_title2'];

	for($i=0; $i<$attach_count_2; $i++){
		$analysis_report_damyun_option_samescyn_type = "C2";
		//$analysis_report_damyun_option_samescyn_jongs = $damyun_option_samescyn_jongs_arr[$i];
		$analysis_report_damyun_option_samescyn_jongs = $jongs_check2_arr[$i];
		$analysis_report_damyun_option_samescyn_title = $damyun_option_samescyn_title_arr[$i];
		
		$query = "insert into wise_analysis_report_damyun_option_samescyn set"; 
		$query .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query .= " analysis_report_damyun_option_samescyn_type = '".$analysis_report_damyun_option_samescyn_type."', ";
		$query .= " analysis_report_damyun_option_samescyn_jongs = '".$analysis_report_damyun_option_samescyn_jongs."', ";
		$query .= " analysis_report_damyun_option_samescyn_title = '".$analysis_report_damyun_option_samescyn_title."', ";
		$query .= " wdate = now() ";
		//echo "sub1 sql = ".$query."<br>";
		$result = mysqli_query($gconnet,$query);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_option_samescyn where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_option_samescyn_idx = $mem_row2[idx]; 

		$factor_no_x_p2_arr2 = explode('<li id="',$factor_no_x_p2_arr[$i]);
		for($k=1; $k<sizeof($factor_no_x_p2_arr2); $k++){
					
			$factor_no_x_p2_arr3 = explode('<a href="javascript:',$factor_no_x_p2_arr2[$k]);
			$factor_no_x_p2_arr4 = explode(';"',$factor_no_x_p2_arr3[1]);
			$analysis_report_damyun_option_samescyn_quiz_no = $factor_no_x_p2_arr4[0];
			$analysis_report_damyun_option_samescyn_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_type","");
			$analysis_report_damyun_option_samescyn_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_title","");
			//echo "analysis_report_damyun_option_samescyn_quiz_title = ".$analysis_report_damyun_option_samescyn_quiz_title."<br>";
			$analysis_report_damyun_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score2_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
			$analysis_report_damyun_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn2_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
				
			$query_quiz = "insert into wise_analysis_report_damyun_option_samescyn_quiz set"; 
			$query_quiz .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_quiz .= " damyun_option_samescyn_idx = '".$damyun_option_samescyn_idx."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_no = '".$analysis_report_damyun_option_samescyn_quiz_no."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_type = '".$analysis_report_damyun_option_samescyn_quiz_type."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_title = '".$analysis_report_damyun_option_samescyn_quiz_title."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_score = '".$analysis_report_damyun_option_samescyn_quiz_score."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_tscyn = '".$analysis_report_damyun_option_samescyn_quiz_tscyn."', ";
			$query_quiz .= " wdate = now() ";
			//echo "sub2 sql = ".$query_quiz."<br>";
			//exit;
			$result_quiz = mysqli_query($gconnet,$query_quiz);
			//echo "query_quiz = ".$query_quiz."<br>";
		}
	}
	######### 부하 종료 ############

	######### 동료 시작 ############
	$damyun_option_samescyn_jongs_arr = $_REQUEST['damyun_option_samescyn_jongs3'];
	$damyun_option_samescyn_title_arr = $_REQUEST['damyun_option_samescyn_title3'];

	for($i=0; $i<$attach_count_3; $i++){
		$analysis_report_damyun_option_samescyn_type = "C3";
		//$analysis_report_damyun_option_samescyn_jongs = $damyun_option_samescyn_jongs_arr[$i];
		$analysis_report_damyun_option_samescyn_jongs = $jongs_check3_arr[$i];
		$analysis_report_damyun_option_samescyn_title = $damyun_option_samescyn_title_arr[$i];
		
		$query = "insert into wise_analysis_report_damyun_option_samescyn set"; 
		$query .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query .= " analysis_report_damyun_option_samescyn_type = '".$analysis_report_damyun_option_samescyn_type."', ";
		$query .= " analysis_report_damyun_option_samescyn_jongs = '".$analysis_report_damyun_option_samescyn_jongs."', ";
		$query .= " analysis_report_damyun_option_samescyn_title = '".$analysis_report_damyun_option_samescyn_title."', ";
		$query .= " wdate = now() ";
		//echo "sub1 sql = ".$query."<br>";
		$result = mysqli_query($gconnet,$query);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_option_samescyn where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_option_samescyn_idx = $mem_row2[idx]; 

		$factor_no_x_p3_arr2 = explode('<li id="',$factor_no_x_p3_arr[$i]);
		for($k=1; $k<sizeof($factor_no_x_p3_arr2); $k++){
					
			$factor_no_x_p3_arr3 = explode('<a href="javascript:',$factor_no_x_p3_arr2[$k]);
			$factor_no_x_p3_arr4 = explode(';"',$factor_no_x_p3_arr3[1]);
			$analysis_report_damyun_option_samescyn_quiz_no = $factor_no_x_p3_arr4[0];
			$analysis_report_damyun_option_samescyn_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_type","");
			$analysis_report_damyun_option_samescyn_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_title","");
			//echo "analysis_report_damyun_option_samescyn_quiz_title = ".$analysis_report_damyun_option_samescyn_quiz_title."<br>";
			$analysis_report_damyun_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score3_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
			$analysis_report_damyun_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn3_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
				
			$query_quiz = "insert into wise_analysis_report_damyun_option_samescyn_quiz set"; 
			$query_quiz .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_quiz .= " damyun_option_samescyn_idx = '".$damyun_option_samescyn_idx."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_no = '".$analysis_report_damyun_option_samescyn_quiz_no."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_type = '".$analysis_report_damyun_option_samescyn_quiz_type."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_title = '".$analysis_report_damyun_option_samescyn_quiz_title."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_score = '".$analysis_report_damyun_option_samescyn_quiz_score."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_tscyn = '".$analysis_report_damyun_option_samescyn_quiz_tscyn."', ";
			$query_quiz .= " wdate = now() ";
			//echo "sub2 sql = ".$query_quiz."<br>";
			//exit;
			$result_quiz = mysqli_query($gconnet,$query_quiz);
			//echo "query_quiz = ".$query_quiz."<br>";
		}
	}
	######### 동료 종료 ############

	######### 본인 시작 ############
	$damyun_option_samescyn_jongs_arr = $_REQUEST['damyun_option_samescyn_jongs4'];
	$damyun_option_samescyn_title_arr = $_REQUEST['damyun_option_samescyn_title4'];

	for($i=0; $i<$attach_count_4; $i++){
		$analysis_report_damyun_option_samescyn_type = "C4";
		//$analysis_report_damyun_option_samescyn_jongs = $damyun_option_samescyn_jongs_arr[$i];
		$analysis_report_damyun_option_samescyn_jongs = $jongs_check4_arr[$i];
		$analysis_report_damyun_option_samescyn_title = $damyun_option_samescyn_title_arr[$i];
		
		$query = "insert into wise_analysis_report_damyun_option_samescyn set"; 
		$query .= " damyun_option_idx = '".$damyun_option_idx."', ";
		$query .= " analysis_report_damyun_option_samescyn_type = '".$analysis_report_damyun_option_samescyn_type."', ";
		$query .= " analysis_report_damyun_option_samescyn_jongs = '".$analysis_report_damyun_option_samescyn_jongs."', ";
		$query .= " analysis_report_damyun_option_samescyn_title = '".$analysis_report_damyun_option_samescyn_title."', ";
		$query .= " wdate = now() ";
		//echo "sub1 sql = ".$query."<br>";
		$result = mysqli_query($gconnet,$query);

		$sql_pre2 = "select idx from wise_analysis_report_damyun_option_samescyn where 1 order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$damyun_option_samescyn_idx = $mem_row2[idx]; 

		$factor_no_x_p4_arr2 = explode('<li id="',$factor_no_x_p4_arr[$i]);
		for($k=1; $k<sizeof($factor_no_x_p4_arr2); $k++){
					
			$factor_no_x_p4_arr3 = explode('<a href="javascript:',$factor_no_x_p4_arr2[$k]);
			$factor_no_x_p4_arr4 = explode(';"',$factor_no_x_p4_arr3[1]);
			$analysis_report_damyun_option_samescyn_quiz_no = $factor_no_x_p4_arr4[0];
			$analysis_report_damyun_option_samescyn_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_type","");
			$analysis_report_damyun_option_samescyn_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_samescyn_quiz_no,"quiz_title","");
			//echo "analysis_report_damyun_option_samescyn_quiz_title = ".$analysis_report_damyun_option_samescyn_quiz_title."<br>";
			$analysis_report_damyun_option_samescyn_quiz_score = trim($_REQUEST['inc_left_quiz_score4_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
			$analysis_report_damyun_option_samescyn_quiz_tscyn = trim($_REQUEST['inc_left_quiz_tscyn4_'.$analysis_report_damyun_option_samescyn_quiz_no.'']);
				
			$query_quiz = "insert into wise_analysis_report_damyun_option_samescyn_quiz set"; 
			$query_quiz .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_quiz .= " damyun_option_samescyn_idx = '".$damyun_option_samescyn_idx."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_no = '".$analysis_report_damyun_option_samescyn_quiz_no."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_type = '".$analysis_report_damyun_option_samescyn_quiz_type."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_title = '".$analysis_report_damyun_option_samescyn_quiz_title."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_score = '".$analysis_report_damyun_option_samescyn_quiz_score."', ";
			$query_quiz .= " analysis_report_damyun_option_samescyn_quiz_tscyn = '".$analysis_report_damyun_option_samescyn_quiz_tscyn."', ";
			$query_quiz .= " wdate = now() ";
			//echo "sub2 sql = ".$query_quiz."<br>";
			//exit;
			$result_quiz = mysqli_query($gconnet,$query_quiz);
			//echo "query_quiz = ".$query_quiz."<br>";
		}
	}
	######### 본인 종료 ############

	//exit;

	if($_REQUEST['damyun_option_status'] == "com"){
		frame_go("damyun_3.php?damyun_option_idx=".$damyun_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}

?>