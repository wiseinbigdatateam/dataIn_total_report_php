<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "만족도조사_만족도지수";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";

	//Header( "Content-type: application/vnd.ms-excel" ); 
	//Header( "Content-Disposition: attachment; filename=".$filename ); 
	//Header( "Content-Description: PHP4 Generated Data" );

	$satisfaction_option_idx = "1"; // 테스트 확인용 

	$sql_file_1 = "select analysis_report_satisfaction_100data_quiz_no,analysis_report_satisfaction_100data_quiz_title from wise_analysis_report_satisfaction_100data_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_100data_no='1'"; // 문항 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'];
		} else {
			$file_1_idx .= $row_file_1['analysis_report_satisfaction_100data_quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_satisfaction_100data_quiz_title'].",";
		}
	}

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);

	$sql_file_2 = "select idx,analysis_report_satisfaction_data_group_no,analysis_report_satisfaction_data_group_title from wise_analysis_report_satisfaction_data_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by CONVERT(analysis_report_satisfaction_data_group_no, UNSIGNED) asc"; // 그룹 데이터 
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
			<td bgcolor=#CCCCCC></td>
			<td bgcolor=#CCCCCC></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?></strong></font></td>
		<?}?>
		</tr>
		<?
			for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
				$row_file_2 = mysqli_fetch_array($query_file_2);

				$sql_file_3 = "select analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title from wise_analysis_report_satisfaction_data_group_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and satisfaction_data_group_idx='".$row_file_2['idx']."' group by analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title order by CONVERT(analysis_report_satisfaction_data_group2_no, UNSIGNED) asc"; 
				//echo $sql_file_3."<br>";
				$query_file_3 = mysqli_query($gconnet,$sql_file_3);
				$query_file_3_cnt = mysqli_num_rows($query_file_3);
		?>
			<tr bgcolor=#ffffff align="center" height="22">
				<td><?=$row_file_2['analysis_report_satisfaction_data_group_title']?></td>
				<td>
				<table border width="100%">
			<?
				for($opt2_i=0; $opt2_i<$query_file_3_cnt; $opt2_i++){
					$row_file_3 = mysqli_fetch_array($query_file_3);
			?>
				<tr bgcolor=#ffffff align="center" height="22">
					<td><?=$row_file_3['analysis_report_satisfaction_data_group2_no']?>=<?=$row_file_3['analysis_report_satisfaction_data_group2_title']?></td>
					<?
					for($opt3_i=0; $opt3_i<sizeof($file_1_title_arr); $opt3_i++){
						$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
						$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
					?>	
						<td><?=get_satisfaction_100data_no_val($satisfaction_option_idx,$data_no,$file_1_idx2,$file_1_title2)?></td>
					<?}?>
				</tr>
			<?}?>
				</table>
				</td>
			</tr>
		<?}?>
		</table>