<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "contentment";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$chapter = trim(sqlfilter($_REQUEST['chapter']));

	$satisfaction_option_status = trim(sqlfilter($_REQUEST['satisfaction_option_status']));
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$analysis_report_idx = trim(sqlfilter($_REQUEST['analysis_report_idx']));
	$analysis_report_option_idx = trim(sqlfilter($_REQUEST['analysis_report_option_idx']));

	if(!$analysis_report_idx){
		error_frame("프로젝트를 선택해 주세요.");
	}
	
	//$analysis_report_option_title = get_data_colname("wise_analysis_main","idx",$analysis_report_idx,"analysis_title","");
	$analysis_report_option_title = trim(sqlfilter($_REQUEST['analysis_report_option_title']));

	$analysis_report_satisfaction_option_name = trim(sqlfilter($_REQUEST['satisfaction_option_name']));
	$analysis_report_satisfaction_option_population = trim(sqlfilter($_REQUEST['satisfaction_option_population']));
	$analysis_report_satisfaction_option_sampling = trim(sqlfilter($_REQUEST['satisfaction_option_sampling']));
	$analysis_report_satisfaction_option_samplingmethod = trim(sqlfilter($_REQUEST['satisfaction_option_samplingmethod']));
	$analysis_report_satisfaction_option_surveymethod = trim(sqlfilter($_REQUEST['satisfaction_option_surveymethod']));
	$analysis_report_satisfaction_option_data = trim(sqlfilter($_REQUEST['satisfaction_option_data']));

	$file_old_name = trim(sqlfilter($_REQUEST['dfile_old_name'])); // 원본 서버파일 이름
	$file_old_org = trim(sqlfilter($_REQUEST['dfile_old_org']));	// 원본 오리지널 파일 이름
	$del_org = trim(sqlfilter($_REQUEST['ddel_org']));	// 원본 파일 삭제여부

if(!$satisfaction_option_idx || $chapter == "new"){ // 신규 등록일때 

	if ($_FILES['file_1']['size'] > 0){ // 파일이 있다면 업로드한다 시작
		$analysis_report_satisfaction_option_logo_o = $_FILES['file_1']['name'];
		$analysis_report_satisfaction_option_logo_c = uploadFile($_FILES, "file_1", $_FILES['docu_1'], $_P_DIR_FILE); 
	}

	$query = "insert into wise_analysis_report_satisfaction_option set"; 
	$query .= " satisfaction_option_status = '".$satisfaction_option_status."', ";
	$query .= " memid = '".$memid."', ";
	$query .= " subid = '".$subid."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " analysis_report_option_idx = '".$analysis_report_option_idx."', ";
	$query .= " analysis_report_option_title = '".$analysis_report_option_title."', ";
	$query .= " analysis_report_satisfaction_option_name = '".$analysis_report_satisfaction_option_name."', ";
	$query .= " analysis_report_satisfaction_option_population = '".$analysis_report_satisfaction_option_population."', ";
	$query .= " analysis_report_satisfaction_option_sampling = '".$analysis_report_satisfaction_option_sampling."', ";
	$query .= " analysis_report_satisfaction_option_samplingmethod = '".$analysis_report_satisfaction_option_samplingmethod."', ";
	$query .= " analysis_report_satisfaction_option_surveymethod = '".$analysis_report_satisfaction_option_surveymethod."', ";
	$query .= " analysis_report_satisfaction_option_data = '".$analysis_report_satisfaction_option_data."', ";
	$query .= " analysis_report_satisfaction_option_logo_o = '".$analysis_report_satisfaction_option_logo_o."', ";
	$query .= " analysis_report_satisfaction_option_logo_c = '".$analysis_report_satisfaction_option_logo_c."', ";
	$query .= " wdate = now() ";
	//echo $query; exit;
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$satisfaction_option_idx = $mem_row2[idx]; 

	$satisfaction_option_data_v = $_REQUEST['satisfaction_option_data_v'];
	//$satisfaction_option_data_arr = explode('<li class="ui-widget-content item_serv ui-selectee ui-selected">',$satisfaction_option_data_v);
	$satisfaction_option_data_arr = explode('<li id="',$satisfaction_option_data_v);
	
	//echo "카운트 = ".sizeof($satisfaction_option_data_arr)."<br>";

	for($i=1; $i<sizeof($satisfaction_option_data_arr); $i++){
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr[$i]."<br>";

		$satisfaction_option_data_arr2 = explode('<a href="javascript:',$satisfaction_option_data_arr[$i]);
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr2[1]."<br>";
		//$satisfaction_option_data_arr3 = explode(';" class="ui-selectee ui-selected">',$satisfaction_option_data_arr2[1]);
		$satisfaction_option_data_arr3 = explode(';"',$satisfaction_option_data_arr2[1]);
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr3[0]."<br>";

		$analysis_report_satisfaction_option_group_no = trim($satisfaction_option_data_arr3[0]);
		$analysis_report_satisfaction_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_group_no,"quiz_type","");
		$analysis_report_satisfaction_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_group_no,"quiz_title","");

		$query_sub = "insert into wise_analysis_report_satisfaction_option_group set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_no = '".$analysis_report_satisfaction_option_group_no."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_type = '".$analysis_report_satisfaction_option_group_type."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_title = '".$analysis_report_satisfaction_option_group_title."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}

} else { // 기존 데이터 수정일때 
	
	if ($_FILES['file_1']['size'] > 0){ // 파일이 있다면 업로드한다 시작
		if($file_old_name){
			unlink($_P_DIR_FILE.$file_old_name); // 원본파일 삭제
		}
		$analysis_report_satisfaction_option_logo_o = $_FILES['file_1']['name'];
		$analysis_report_satisfaction_option_logo_c = uploadFile($_FILES, "file_1", $_FILES['docu_1'], $_P_DIR_FILE); 
	} else { // 파일이 없을때 시작 
		if($file_old_name && $file_old_org){
			$analysis_report_satisfaction_option_logo_c = $file_old_name;
			$analysis_report_satisfaction_option_logo_o = $file_old_org;
		} else {
			$analysis_report_satisfaction_option_logo_c = "";
			$analysis_report_satisfaction_option_logo_o = "";
		}

		if($del_org == "Y"){
			if($file_old_name){
				unlink($_P_DIR_FILE.$file_old_name); // 원본파일 삭제
			}
			$analysis_report_satisfaction_option_logo_c = "";
			$analysis_report_satisfaction_option_logo_o = "";
		}
	} // 파일이 없을때 종료 

	$query = "update wise_analysis_report_satisfaction_option set"; 
	$query .= " analysis_report_satisfaction_option_name = '".$analysis_report_satisfaction_option_name."', ";
	$query .= " analysis_report_satisfaction_option_population = '".$analysis_report_satisfaction_option_population."', ";
	$query .= " analysis_report_satisfaction_option_sampling = '".$analysis_report_satisfaction_option_sampling."', ";
	$query .= " analysis_report_satisfaction_option_samplingmethod = '".$analysis_report_satisfaction_option_samplingmethod."', ";
	$query .= " analysis_report_satisfaction_option_surveymethod = '".$analysis_report_satisfaction_option_surveymethod."', ";
	$query .= " analysis_report_satisfaction_option_data = '".$analysis_report_satisfaction_option_data."', ";
	$query .= " analysis_report_satisfaction_option_logo_o = '".$analysis_report_satisfaction_option_logo_o."', ";
	$query .= " analysis_report_satisfaction_option_logo_c = '".$analysis_report_satisfaction_option_logo_c."' ";
	$query .= " where 1 and idx='".$satisfaction_option_idx."'";
	if($memid){
		$query .= " and memid='".$memid."'";
	}
	if($subid){
		$query .= " and subid='".$subid."'";
	}
	$result = mysqli_query($gconnet,$query);

	$satisfaction_option_data_v = trim($_REQUEST['satisfaction_option_data_v']);
	$satisfaction_option_data_arr = explode('<li id="',$satisfaction_option_data_v);
		
	//echo "문항리스트 = ".$satisfaction_option_data_v."<br>";
	//echo "카운트 = ".sizeof($satisfaction_option_data_arr)."<br>";
	
	$sql_group_del = "delete from wise_analysis_report_satisfaction_option_group where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	for($i=1; $i<sizeof($satisfaction_option_data_arr); $i++){
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr[$i]."<br>";

		$satisfaction_option_data_arr2 = explode('<a href="javascript:',$satisfaction_option_data_arr[$i]);
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr2[1]."<br>";
		//$satisfaction_option_data_arr3 = explode(';" class="ui-selectee ui-selected">',$satisfaction_option_data_arr2[1]);
		$satisfaction_option_data_arr3 = explode(';"',$satisfaction_option_data_arr2[1]);
		//echo "라인 ".$i." = ".$satisfaction_option_data_arr3[0]."<br>";

		$analysis_report_satisfaction_option_group_no = trim($satisfaction_option_data_arr3[0]);
		$analysis_report_satisfaction_option_group_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_group_no,"quiz_type","");
		$analysis_report_satisfaction_option_group_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_satisfaction_option_group_no,"quiz_title","");

		$query_sub = "insert into wise_analysis_report_satisfaction_option_group set"; 
		$query_sub .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_no = '".$analysis_report_satisfaction_option_group_no."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_type = '".$analysis_report_satisfaction_option_group_type."', ";
		$query_sub .= " analysis_report_satisfaction_option_group_title = '".$analysis_report_satisfaction_option_group_title."', ";
		$query_sub .= " wdate = now()";
		$result_sub = mysqli_query($gconnet,$query_sub);
	}

} // 기존 데이터 수정일때 종료 
	
	//echo "1 sql = ".$query."<br>";
	//echo "2 sql = ".$query_sub."<br>";
	//exit;
	
	$option_prev_sql = "select idx from wise_analysis_option where 1 and report_type = 'manjok' and report_idx = '".$satisfaction_option_idx."'"; 
	$option_prev_query = mysqli_query($gconnet,$option_prev_sql);
	if(mysqli_num_rows($option_prev_query) == 0){
		$query_option = "insert into wise_analysis_option set"; 
		$query_option .= " report_status = '".$_REQUEST['satisfaction_option_status']."', ";
		$query_option .= " memid = '".$memid."', ";
		$query_option .= " subid = '".$subid."', ";
		$query_option .= " report_type = 'manjok', ";
		$query_option .= " report_idx = '".$satisfaction_option_idx."', ";
		$query_option .= " report_name = '".$analysis_report_satisfaction_option_name."', ";
		$query_option .= " report_sdate = now() ";
		$result_option = mysqli_query($gconnet,$query_option);
	} else {
		$query_option = "update wise_analysis_option set"; 
		$query_option .= " report_status = '".$_REQUEST['satisfaction_option_status']."', ";
		$query_option .= " memid = '".$memid."', ";
		$query_option .= " subid = '".$subid."', ";
		$query_option .= " report_name = '".$analysis_report_satisfaction_option_name."', ";
		$query_option .= " report_edate = now() ";
		$query_option .= " where 1 and report_type = 'manjok' and report_idx = '".$satisfaction_option_idx."'";
		$result_option = mysqli_query($gconnet,$query_option);
	}

	if($_REQUEST['satisfaction_option_status'] == "com"){
		frame_go("manjok_2.php?satisfaction_option_idx=".$satisfaction_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}
?>