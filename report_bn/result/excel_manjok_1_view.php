<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "만족도조사_100점변환_영역별점수계산";
	$pay_str =  iconv("UTF-8","UTF-8",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";
	
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$sql_file_0 = "select satisfaction_option_idx,analysis_report_idx from wise_analysis_report_satisfaction_100data where 1 ";
	if($satisfaction_option_idx){
		$sql_file_0 .= " and satisfaction_option_idx='".$satisfaction_option_idx."'";
	}
	$sql_file_0 .= " order by idx desc limit 0,1"; 

	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	$satisfaction_option_idx = $row_file_0['satisfaction_option_idx'];  

	$sql_file_1 = "select analysis_report_satisfaction_100data_no from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by analysis_report_satisfaction_100data_no asc limit 0,1"; 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$row_file_1 = mysqli_fetch_array($query_file_1);
	
	$sql_file_1 = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_model_no,analysis_report_satisfaction_100data_quiz_title from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_no='".$row_file_1['analysis_report_satisfaction_100data_no']."'"; // 문항 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'];
			$file_2_idx .= $row_file_1['analysis_report_satisfaction_100data_model_no'];
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'];
		} else {
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'].",";
			$file_2_idx .= $row_file_1['analysis_report_satisfaction_100data_model_no'].",";
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_1_title_arr = explode(",",$file_1_title);

	$sql_file_2 = "select distinct analysis_report_satisfaction_100data_no from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by CONVERT(analysis_report_satisfaction_100data_no, UNSIGNED) asc"; // 응답 데이터 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
?>
	<head>
			<meta http-equiv=Content-Type content="text/html; charset=ks_c_5601-1987">
			<style>
			<!--
				br{mso-data-placement:same-cell;}
			-->
			</style>
		</head>
			
		<table border width="100%">
		<tr align="center">
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","UTF-8","NO")?></strong></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","UTF-8",$file_1_title2)?></strong></font></td>
		<?}?>
		</tr>
		<?
			for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
				$row_file_2 = mysqli_fetch_array($query_file_2);
				$data_no = $row_file_2['analysis_report_satisfaction_100data_no'];
		?>
			<tr bgcolor=#ffffff align="center" height="22">
				<td><?=$row_file_2['analysis_report_satisfaction_100data_no']?></td>
				<?
				for($opt2_i=0; $opt2_i<sizeof($file_1_title_arr); $opt2_i++){
					$file_1_idx2 = trim($file_1_idx_arr[$opt2_i]);
					$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
					$file_1_title2 = trim($file_1_title_arr[$opt2_i]);
				?>	
					<td style="mso-number-format:'\@'"><?=iconv("UTF-8","UTF-8",get_satisfaction_100data_no_val_16($satisfaction_option_idx,$data_no,$file_1_idx2,$file_2_idx2,$file_1_title2))?></td>
				<?}?>
			</tr>
		<?}?>
		</table>
