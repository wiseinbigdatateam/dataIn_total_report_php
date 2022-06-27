<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "만족도조사_정리2_IPA(개선영역도출)";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";
	
	//if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
	//} else {	
		Header( "Content-type: application/vnd.ms-excel" ); 
		Header( "Content-Disposition: attachment; filename=".$filename ); 
		Header( "Content-Description: PHP4 Generated Data" );
	//}

	//$sql_file_0 = "select satisfaction_option_idx from wise_analysis_report_satisfaction_100data where 1 order by idx desc limit 0,1"; 
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$sql_file_0 = "select satisfaction_option_idx,analysis_report_idx from wise_analysis_report_satisfaction_100data where 1 ";
	if($satisfaction_option_idx){
		$sql_file_0 .= " and satisfaction_option_idx='".$satisfaction_option_idx."'";
	}
	$sql_file_0 .= " order by idx desc limit 0,1"; 

	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	$satisfaction_option_idx = $row_file_0['satisfaction_option_idx'];  

	$sql_file_2 = "select idx,analysis_report_satisfaction_statistics_group_title from wise_analysis_report_satisfaction_statistics_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and (analysis_report_satisfaction_statistics_group_no in (select idx from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X') or analysis_report_satisfaction_statistics_group_title='합계') order by idx asc"; // 그룹 데이터 
	if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
		//echo "sql_file_2 = ".$sql_file_2."<br>";
	}
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	$sql_file_4 = "select idx,analysis_report_satisfaction_statistics_group_title from wise_analysis_report_satisfaction_statistics_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and (analysis_report_satisfaction_statistics_group_no in (select idx from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X') or analysis_report_satisfaction_statistics_group_title='평균') order by idx asc"; // 그룹 데이터 
	if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
		//echo "sql_file_4 = ".$sql_file_4."<br>";
	}
	$query_file_4 = mysqli_query($gconnet,$sql_file_4);
	$query_file_4_cnt = mysqli_num_rows($query_file_4);

?>
	<head>
			<meta http-equiv=Content-Type content="text/html; charset=ks_c_5601-1987">
			<style>
			<!--
				br{mso-data-placement:same-cell;}
			-->
			</style>
		</head>
		
		<table width="100%">
		<tr>
		<td>
			<table border>
			<tr align="center">
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","영역")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","절대값 변환 (t 통계량)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","전체합 1 로 변환")?></strong></font></td>
			</tr>
		<?
			for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
				$row_file_2 = mysqli_fetch_array($query_file_2);

				$sql_file_3 = "select * from wise_analysis_report_satisfaction_statistics_group_detail where 1 and satisfaction_statistics_group_idx='".$row_file_2['idx']."' and satisfaction_option_idx='".$satisfaction_option_idx."'"; 
				if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
					//echo "sql_file_3 = ".$sql_file_3."<br>";
				}
				$query_file_3 = mysqli_query($gconnet,$sql_file_3);
				$row_file_3 = mysqli_fetch_array($query_file_3);
		?>
			<tr bgcolor=#ffffff align="center" height="22">
				<td><?=iconv("UTF-8","EUC-KR",$row_file_2['analysis_report_satisfaction_statistics_group_title'])?></td>
				<td style="mso-number-format:'\@'"><?=iconv("UTF-8","EUC-KR",$row_file_3['analysis_report_satisfaction_statistics_ipa_tabval'])?></td>
				<td style="mso-number-format:'\@'"><?=iconv("UTF-8","EUC-KR",$row_file_3['analysis_report_satisfaction_statistics_ipa_ratio'])?></td>
			</tr>
		<?}?>
			</table>
		</td>
		<td></tD>
		<td>
			<table border>
			<tr align="center">
				<td bgcolor=#CCCCCC></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","만족도")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","중요도")?></strong></font></td>
			</tr>
		<?
			for($opt2_i=0; $opt2_i<$query_file_4_cnt; $opt2_i++){
				$row_file_4 = mysqli_fetch_array($query_file_4);

				$sql_file_5 = "select * from wise_analysis_report_satisfaction_statistics_group_detail where 1 and satisfaction_statistics_group_idx='".$row_file_4['idx']."' and satisfaction_option_idx='".$satisfaction_option_idx."'";
				if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
					//echo "sql_file_5 = ".$sql_file_5."<br>";
				}
				$query_file_5 = mysqli_query($gconnet,$sql_file_5);
				$row_file_5 = mysqli_fetch_array($query_file_5);
		?>
			<tr bgcolor=#ffffff align="center" height="22">
				<td><?=iconv("UTF-8","EUC-KR",$row_file_4['analysis_report_satisfaction_statistics_group_title'])?></td>
				<td style="mso-number-format:'\@'"><?=iconv("UTF-8","EUC-KR",$row_file_5['analysis_report_satisfaction_statistics_ipa_stf'])?></td>
				<td style="mso-number-format:'\@'"><?=iconv("UTF-8","EUC-KR",$row_file_5['analysis_report_satisfaction_statistics_ipa_imt'])?></td>
			</tr>
		<?}?>
			</table>
		</td>
		</tr>
		</table>
