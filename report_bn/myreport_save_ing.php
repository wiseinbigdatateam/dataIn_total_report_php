<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$bbs_code = "contentment";
	$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$report_type = trim(sqlfilter($_REQUEST['report_type']));
	$report_idx = trim(sqlfilter($_REQUEST['report_idx']));
	$report_name = trim(sqlfilter($_REQUEST['report_name']));
	$report_email = trim(sqlfilter($_REQUEST['email']));
	if($report_type == "manjok"){
		$report_title = trim(sqlfilter($_REQUEST['satisfaction_option_report_title']));
	} elseif($report_type == "service"){
		$report_title = trim(sqlfilter($_REQUEST['service_option_report_title']));
	} elseif($report_type == "damyun"){
		$report_title = trim(sqlfilter($_REQUEST['damyun_option_report_title']));
	} elseif($report_type == "decision"){
		$report_title = trim(sqlfilter($_REQUEST['decision_option_report_title']));
	}

	$sql_file_0 = "select idx from wise_analysis_myreport where 1 and memid='".$memid."' and report_type='".$report_type."' and report_idx='".$report_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		$query = "update wise_analysis_myreport set"; 
		$query .= " report_status = 'tmp', ";
		$query .= " report_name = '".$report_name."', ";
		$query .= " report_email = '".$report_email."', ";
		$query .= " report_title = '".$report_title."', ";
		$query .= " wdate = now() ";
		$query .= " where 1 and memid='".$memid."' and report_type='".$report_type."' and report_idx='".$report_idx."'";
	} else {
		$query = "insert into wise_analysis_myreport set"; 
		$query .= " memid = '".$memid."', ";
		$query .= " subid = '".$subid."', ";
		$query .= " report_type = '".$report_type."', ";
		$query .= " report_idx = '".$report_idx."', ";
		$query .= " report_name = '".$report_name."', ";
		$query .= " report_email = '".$report_email."', ";
		$query .= " report_title = '".$report_title."', ";
		$query .= " wdate = now() ";
	}
	$result = mysqli_query($gconnet,$query);
	
	$query_option = "update wise_analysis_option set"; 
	$query_option .= " report_name = '".$report_title."', ";
	$query_option .= " report_edate = now() ";
	$query_option .= " where 1 and report_type = '".$report_type."' and report_idx = '".$report_idx."'";
	$result_option = mysqli_query($gconnet,$query_option);

	error_frame_go("보고서 생성정보가 저장되었습니다.","my-report.php");
?>	