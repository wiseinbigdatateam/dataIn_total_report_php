<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "damyun";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));
	$chapter = trim(sqlfilter($_REQUEST['chapter']));
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));

	$damyun_option_status = trim(sqlfilter($_REQUEST['damyun_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$analysis_report_option_idx = trim(sqlfilter($_REQUEST['analysis_report_option_idx']));
	$analysis_report_option_title = trim(sqlfilter($_REQUEST['analysis_report_option_title']));
	$attach_count_1 = trim(sqlfilter($_REQUEST['attach_count_1'])); // 집단구분항목 갯수
	$attach_count_2 = trim(sqlfilter($_REQUEST['attach_count_2'])); // 평가대상 구분

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}

	$analysis_report_damyun_option_name = trim(sqlfilter($_REQUEST['damyun_option_name']));
	$analysis_report_damyun_option_population = trim(sqlfilter($_REQUEST['damyun_option_population']));
	$analysis_report_damyun_option_sampling = trim(sqlfilter($_REQUEST['damyun_option_sampling']));
	$analysis_report_damyun_option_samplingmethod = trim(sqlfilter($_REQUEST['damyun_option_samplingmethod']));
	$analysis_report_damyun_option_surveymethod = trim(sqlfilter($_REQUEST['damyun_option_surveymethod']));
	$analysis_report_damyun_option_data = trim(sqlfilter($_REQUEST['damyun_option_data']));

	$file_old_name = trim(sqlfilter($_REQUEST['dfile_old_name'])); // 원본 서버파일 이름
	$file_old_org = trim(sqlfilter($_REQUEST['dfile_old_org']));	// 원본 오리지널 파일 이름
	$del_org = trim(sqlfilter($_REQUEST['ddel_org']));	// 원본 파일 삭제여부

	$factor_no_x_g = $_REQUEST['factor_no_x_g']; // 평가대상
	$factor_no_x_g_arr = explode('||',$factor_no_x_g);
	$factor_no_x_p = $_REQUEST['factor_no_x_p']; // 집단구분
	$factor_no_x_p_arr = explode('||',$factor_no_x_p);

if(!$damyun_option_idx || $chapter == "new"){ // 신규 등록일때 

	if ($_FILES['file_1']['size'] > 0){ // 파일이 있다면 업로드한다 시작
		$analysis_report_damyun_option_logo_o = $_FILES['file_1']['name'];
		$analysis_report_damyun_option_logo_c = uploadFile($_FILES, "file_1", $_FILES['docu_1'], $_P_DIR_FILE); 
	}

	$query = "insert into wise_analysis_report_damyun_option set"; 
	$query .= " damyun_option_status = '".$damyun_option_status."', ";
	$query .= " memid = '".$memid."', ";
	$query .= " subid = '".$subid."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " analysis_report_option_idx = '".$analysis_report_option_idx."', ";
	$query .= " analysis_report_option_title = '".$analysis_report_option_title."', ";

	$query .= " analysis_report_damyun_option_name = '".$analysis_report_damyun_option_name."', ";
	$query .= " analysis_report_damyun_option_population = '".$analysis_report_damyun_option_population."', ";
	$query .= " analysis_report_damyun_option_sampling = '".$analysis_report_damyun_option_sampling."', ";
	$query .= " analysis_report_damyun_option_samplingmethod = '".$analysis_report_damyun_option_samplingmethod."', ";
	$query .= " analysis_report_damyun_option_surveymethod = '".$analysis_report_damyun_option_surveymethod."', ";
	$query .= " analysis_report_damyun_option_data = '".$analysis_report_damyun_option_data."', ";
	$query .= " analysis_report_damyun_option_logo_o = '".$analysis_report_damyun_option_logo_o."', ";
	$query .= " analysis_report_damyun_option_logo_c = '".$analysis_report_damyun_option_logo_c."', ";
	$query .= " wdate = now() ";
	//echo $query."<br>"; 
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_damyun_option where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$damyun_option_idx = $mem_row2[idx]; 

	######### 집단구분항목 시작 ############
	for($i=0; $i<$attach_count_1; $i++){

		$damyun_option_group = $factor_no_x_p_arr[$i];
		$damyun_option_group_arr = explode('<li id="',$damyun_option_group);
		$damyun_option_group_arr2 = explode('<a href="javascript:',$damyun_option_group_arr[1]);
		$damyun_option_group_arr3 = explode(';"',$damyun_option_group_arr2[1]);
		
		$analysis_report_damyun_option_group_no = trim($damyun_option_group_arr3[0]);
		$analysis_report_damyun_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_type","");
		$analysis_report_damyun_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_title","");
		$type = "P"; // 집단구분

		if($analysis_report_damyun_option_group_no){
			$query_sub = "insert into wise_analysis_report_damyun_option_group set"; 
			$query_sub .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_sub .= " type = '".$type."', ";
			$query_sub .= " analysis_report_damyun_option_group_no = '".$analysis_report_damyun_option_group_no."', ";
			$query_sub .= " analysis_report_damyun_option_group_type = '".$analysis_report_damyun_option_group_type."', ";
			$query_sub .= " analysis_report_damyun_option_group_title = '".$analysis_report_damyun_option_group_title."', ";
			$query_sub .= " wdate = now()";
			//echo $query_sub."<br>"; 
			$result_sub = mysqli_query($gconnet,$query_sub);
		}
	
	}
	######### 집단구분항목 종료 ############

	######### 평가대상항목 시작 ############
	for($i=0; $i<$attach_count_2; $i++){

		$damyun_option_group = $factor_no_x_g_arr[$i];
		$damyun_option_group_arr = explode('<li id="',$damyun_option_group);
		$damyun_option_group_arr2 = explode('<a href="javascript:',$damyun_option_group_arr[1]);
		$damyun_option_group_arr3 = explode(';"',$damyun_option_group_arr2[1]);
		
		$analysis_report_damyun_option_group_no = trim($damyun_option_group_arr3[0]);
		$analysis_report_damyun_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_type","");
		$analysis_report_damyun_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_title","");
		$type = "G"; // 평가대상

		if($analysis_report_damyun_option_group_no){
			$query_sub = "insert into wise_analysis_report_damyun_option_group set"; 
			$query_sub .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_sub .= " type = '".$type."', ";
			$query_sub .= " analysis_report_damyun_option_group_no = '".$analysis_report_damyun_option_group_no."', ";
			$query_sub .= " analysis_report_damyun_option_group_type = '".$analysis_report_damyun_option_group_type."', ";
			$query_sub .= " analysis_report_damyun_option_group_title = '".$analysis_report_damyun_option_group_title."', ";
			$query_sub .= " wdate = now()";
			//echo $query_sub."<br><br>"; 
			$result_sub = mysqli_query($gconnet,$query_sub);
		}
	
	}
	######### 평가대상항목 종료 ############
	
} else { // 기존 데이터 수정일때 
	
	if ($_FILES['file_1']['size'] > 0){ // 파일이 있다면 업로드한다 시작
		if($file_old_name){
			unlink($_P_DIR_FILE.$file_old_name); // 원본파일 삭제
		}
		$analysis_report_damyun_option_logo_o = $_FILES['file_1']['name'];
		$analysis_report_damyun_option_logo_c = uploadFile($_FILES, "file_1", $_FILES['docu_1'], $_P_DIR_FILE); 
	} else { // 파일이 없을때 시작 
		if($file_old_name && $file_old_org){
			$analysis_report_damyun_option_logo_c = $file_old_name;
			$analysis_report_damyun_option_logo_o = $file_old_org;
		} else {
			$analysis_report_damyun_option_logo_c = "";
			$analysis_report_damyun_option_logo_o = "";
		}

		if($del_org == "Y"){
			if($file_old_name){
				unlink($_P_DIR_FILE.$file_old_name); // 원본파일 삭제
			}
			$analysis_report_damyun_option_logo_c = "";
			$analysis_report_damyun_option_logo_o = "";
		}
	} // 파일이 없을때 종료 

	//echo "analysis_report_damyun_option_logo_o = ".$analysis_report_damyun_option_logo_o."<br>";
	//echo "analysis_report_damyun_option_logo_c = ".$analysis_report_damyun_option_logo_c."<br>";
	//exit;

	$query = "update wise_analysis_report_damyun_option set"; 
	$query .= " analysis_report_damyun_option_name = '".$analysis_report_damyun_option_name."', ";
	$query .= " analysis_report_damyun_option_population = '".$analysis_report_damyun_option_population."', ";
	$query .= " analysis_report_damyun_option_sampling = '".$analysis_report_damyun_option_sampling."', ";
	$query .= " analysis_report_damyun_option_samplingmethod = '".$analysis_report_damyun_option_samplingmethod."', ";
	$query .= " analysis_report_damyun_option_surveymethod = '".$analysis_report_damyun_option_surveymethod."', ";
	$query .= " analysis_report_damyun_option_data = '".$analysis_report_damyun_option_data."', ";
	$query .= " analysis_report_damyun_option_logo_o = '".$analysis_report_damyun_option_logo_o."', ";
	$query .= " analysis_report_damyun_option_logo_c = '".$analysis_report_damyun_option_logo_c."' ";
	$query .= " where 1 and idx='".$damyun_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	//echo $query;
	//exit;
	$result = mysqli_query($gconnet,$query);

	$sql_group_del = "delete from wise_analysis_report_damyun_option_group where 1 and damyun_option_idx = '".$damyun_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	######### 집단구분항목 시작 ############
	for($i=0; $i<$attach_count_1; $i++){

		$damyun_option_group = $factor_no_x_p_arr[$i];
		$damyun_option_group_arr = explode('<li id="',$damyun_option_group);
		$damyun_option_group_arr2 = explode('<a href="javascript:',$damyun_option_group_arr[1]);
		$damyun_option_group_arr3 = explode(';"',$damyun_option_group_arr2[1]);
		
		$analysis_report_damyun_option_group_no = trim($damyun_option_group_arr3[0]);
		$analysis_report_damyun_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_type","");
		$analysis_report_damyun_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_title","");
		$type = "P"; // 집단구분

		if($analysis_report_damyun_option_group_no){
			$query_sub = "insert into wise_analysis_report_damyun_option_group set"; 
			$query_sub .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_sub .= " type = '".$type."', ";
			$query_sub .= " analysis_report_damyun_option_group_no = '".$analysis_report_damyun_option_group_no."', ";
			$query_sub .= " analysis_report_damyun_option_group_type = '".$analysis_report_damyun_option_group_type."', ";
			$query_sub .= " analysis_report_damyun_option_group_title = '".$analysis_report_damyun_option_group_title."', ";
			$query_sub .= " wdate = now()";
			//echo $query_sub."<br><br>"; 
			$result_sub = mysqli_query($gconnet,$query_sub);
		}
	
	}
	######### 집단구분항목 종료 ############

	######### 평가대상항목 시작 ############
	for($i=0; $i<$attach_count_2; $i++){

		$damyun_option_group = $factor_no_x_g_arr[$i];
		$damyun_option_group_arr = explode('<li id="',$damyun_option_group);
		$damyun_option_group_arr2 = explode('<a href="javascript:',$damyun_option_group_arr[1]);
		$damyun_option_group_arr3 = explode(';"',$damyun_option_group_arr2[1]);
		
		$analysis_report_damyun_option_group_no = trim($damyun_option_group_arr3[0]);
		$analysis_report_damyun_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_type","");
		$analysis_report_damyun_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_group_no,"quiz_title","");
		$type = "G"; // 평가대상

		if($analysis_report_damyun_option_group_no){
			$query_sub = "insert into wise_analysis_report_damyun_option_group set"; 
			$query_sub .= " damyun_option_idx = '".$damyun_option_idx."', ";
			$query_sub .= " type = '".$type."', ";
			$query_sub .= " analysis_report_damyun_option_group_no = '".$analysis_report_damyun_option_group_no."', ";
			$query_sub .= " analysis_report_damyun_option_group_type = '".$analysis_report_damyun_option_group_type."', ";
			$query_sub .= " analysis_report_damyun_option_group_title = '".$analysis_report_damyun_option_group_title."', ";
			$query_sub .= " wdate = now()";
			//echo $query_sub."<br><br>"; 
			$result_sub = mysqli_query($gconnet,$query_sub);
		}
	
	}
	######### 평가대상항목 종료 ############

} // 기존 데이터 수정일때 종료 

	$option_prev_sql = "select idx from wise_analysis_option where 1 and report_type = 'damyun' and report_idx = '".$damyun_option_idx."'"; 
	$option_prev_query = mysqli_query($gconnet,$option_prev_sql);
	if(mysqli_num_rows($option_prev_query) == 0){
		$query_option = "insert into wise_analysis_option set"; 
		$query_option .= " report_status = '".$_REQUEST['damyun_option_status']."', ";
		$query_option .= " memid = '".$memid."', ";
		$query_option .= " subid = '".$subid."', ";
		$query_option .= " report_type = 'damyun', ";
		$query_option .= " report_idx = '".$damyun_option_idx."', ";
		$query_option .= " report_name = '".$analysis_report_damyun_option_name."', ";
		$query_option .= " report_sdate = now() ";
		$result_option = mysqli_query($gconnet,$query_option);
	} else {
		$query_option = "update wise_analysis_option set"; 
		$query_option .= " report_status = '".$_REQUEST['damyun_option_status']."', ";
		$query_option .= " memid = '".$memid."', ";
		$query_option .= " subid = '".$subid."', ";
		$query_option .= " report_name = '".$analysis_report_damyun_option_name."', ";
		$query_option .= " report_edate = now() ";
		$query_option .= " where 1 and report_type = 'damyun' and report_idx = '".$damyun_option_idx."'";
		$result_option = mysqli_query($gconnet,$query_option);
	}

	if($_REQUEST['damyun_option_status'] == "com"){
		frame_go("damyun_2.php?damyun_option_idx=".$damyun_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}

?>