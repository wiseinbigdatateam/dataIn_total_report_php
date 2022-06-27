<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$idx = trim(sqlfilter($_REQUEST['idx']));

	$query = "select * from wise_analysis_option where 1 and idx='".$idx."'";
	//echo $query."<br>";
	$result = mysqli_query($gconnet,$query);

	if(mysqli_num_rows($result) == 0){
		error_frmae("삭제할 데이터가 없습니다.");
	}

	$row = mysqli_fetch_array($result);

	/*if($row['report_type'] == "manjok"){
		$del_1 = "delete from ";
	} elseif($row['report_type'] == "service"){

	} elseif($row['report_type'] == "damyun"){

	} elseif($row['report_type'] == "decision"){

	}*/

	$del_1_sql = "delete from wise_analysis_myreport where 1 and report_type='".$row['report_type']."' and report_idx='".$row['report_idx']."'";
	//echo $del_1_sql."<br>";
	$del_1_result = mysqli_query($gconnet,$del_1_sql);

	$del_2_sql = "delete from wise_analysis_option where 1 and idx='".$row['idx']."'";
	//echo $del_2_sql."<br>";
	$del_2_result = mysqli_query($gconnet,$del_2_sql);
	
	//exit;

	error_frame_go("삭제 되었습니다.","/report/my-report.php");
?>