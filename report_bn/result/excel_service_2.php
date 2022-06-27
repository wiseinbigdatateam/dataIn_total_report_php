<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "서비스평가모델_집단별점수&순위정리";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";

	if($_SERVER['REMOTE_ADDR'] == "59.5.188.xx"){
		/*Header( "Content-type: application/vnd.ms-excel" ); 
		Header( "Content-Disposition: attachment; filename=".$filename ); 
		Header( "Content-Description: PHP4 Generated Data" );*/
	} else {
		Header( "Content-type: application/vnd.ms-excel" ); 
		Header( "Content-Disposition: attachment; filename=".$filename ); 
		Header( "Content-Description: PHP4 Generated Data" );
	}

	//$sql_file_0 = "select service_option_idx,analysis_report_idx from wise_analysis_report_service_100data where 1 order by idx desc limit 0,1"; // 문항 
	
	$service_option_idx = trim(sqlfilter($_REQUEST['service_option_idx']));
	$sql_file_0 = "select service_option_idx,analysis_report_idx from wise_analysis_report_service_100data where 1 ";
	if($service_option_idx){
		$sql_file_0 .= " and service_option_idx='".$service_option_idx."'";
	}
	$sql_file_0 .= " order by idx desc limit 0,1"; 

	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	$service_option_idx = $row_file_0['service_option_idx']; 
	$analysis_report_idx = $row_file_0['analysis_report_idx'];
	
	$sql_file_1 = "select idx,analysis_report_service_option_percent,analysis_report_service_option_data_no,analysis_report_service_option_data_title from wise_analysis_report_service_data where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_option_data_title not like '%집단구분 -%'"; // 일반문항 

	//echo "sql_file_1 = ".$sql_file_1."<br>";

	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
		$row_file_1 = mysqli_fetch_array($query_file_1);
	
		if($opt_i == $query_file_1_cnt-1){
			//$file_1_idx .= $row_file_1['analysis_report_service_option_data_no'];
			$file_1_idx .= $row_file_1['idx'];
			$file_1_title .= $row_file_1['analysis_report_service_option_data_title'];
		} else {
			//$file_1_idx .= $row_file_1['analysis_report_service_option_data_no'].",";
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_title .= $row_file_1['analysis_report_service_option_data_title'].",";
		}
	}

	//echo "file_1_title = ".$file_1_title."<br>";
	//exit;

	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_title_arr = explode(",",$file_1_title);

	$sql_file_2 = "select idx,analysis_report_service_option_percent,analysis_report_service_option_data_no,analysis_report_service_option_data_title from wise_analysis_report_service_data where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_option_data_title like '%집단구분 -%'"; // 집단문항 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
		$row_file_2 = mysqli_fetch_array($query_file_2);
	
		if($opt_i == $query_file_2_cnt-1){
			//$file_2_idx .= $row_file_2['analysis_report_service_option_data_no'];
			$file_2_idx .= $row_file_2['idx'];
			$file_2_quizno .= $row_file_2['analysis_report_service_option_data_no'];
			$file_2_title .= $row_file_2['analysis_report_service_option_data_title'];
		} else {
			//$file_2_idx .= $row_file_2['analysis_report_service_option_data_no'].",";
			$file_2_idx .= $row_file_2['idx'].",";
			$file_2_quizno .= $row_file_2['analysis_report_service_option_data_no'].",";
			$file_2_title .= $row_file_2['analysis_report_service_option_data_title'].",";
		}
	}

	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);

	$compet_info_sql = "select analysis_report_service_option_scorepoint from wise_analysis_report_service_option where 1 and idx='".$service_option_idx."'";
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	$compet_info_row = mysqli_fetch_array($compet_info_query);
	$service_option_scorepoint = $compet_info_row['analysis_report_service_option_scorepoint'];

	$serv_tlc_sql = "select sum(analysis_report_service_100data_total) as totsco from wise_analysis_report_service_100data_tlc where service_option_idx='".$service_option_idx."'";
	$serv_tlc_query = mysqli_query($gconnet,$serv_tlc_sql);
	$serv_tlc_row = mysqli_fetch_array($serv_tlc_query);
	$serv_tlc_sco = $serv_tlc_row['totsco'];

	$serv_tlc_sql2 = "select idx from wise_analysis_report_service_100data_tlc where service_option_idx='".$service_option_idx."'";
	$serv_tlc_query2 = mysqli_query($gconnet,$serv_tlc_sql2);
	$serv_tlc_cnt = mysqli_num_rows($serv_tlc_query2);
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
		<?
			for($opt_i=0; $opt_i<sizeof($file_2_title_arr); $opt_i++){
				$file_2_title2 = trim($file_2_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_2_title2)?><?//=$file_2_title2?></strong></font></td>
		<?}?>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_1_title2?></strong></font></td>
		<?}?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","총점")?></strong></font></td>
	<?if($query_file_2_cnt > 0){?>	
		<?
			for($opt_i=0; $opt_i<sizeof($file_2_title_arr); $opt_i++){
				$file_2_title2 = trim($file_2_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_2_title2." 의 순위")?></strong></font></td>
		<?}?>
	<?}?>
		</tr>

		<tr bgcolor=#ffffff align="center" height="22">
			<td><?=iconv("UTF-8","EUC-KR","전체")?></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_2_title_arr)-1; $opt_i++){
				$file_2_idx = trim($file_2_idx_arr[$opt_i]);
		?>
			<td></td>
		<?}?>

		<?
			$data_tot_1 = 0;
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_idx = trim($file_1_idx_arr[$opt_i]);
				$data_1 = get_report_service_data_quiz_val($service_option_idx,$file_1_idx,$where=" and analysis_report_service_data_quiz_title='전체'");
		?>
				<td style="mso-number-format:'\@'"><?=$data_1?></td>
		<?
				$data_tot_1 = $data_tot_1+$data_1;
			}
		?>
		
			<td style="mso-number-format:'\@'"><?=round($serv_tlc_sco/$serv_tlc_cnt,$service_option_scorepoint)?></td>
	<?if($query_file_2_cnt > 0){?>		
		<?
			for($opt_i=0; $opt_i<sizeof($file_2_title_arr); $opt_i++){
				$file_2_idx = trim($file_2_idx_arr[$opt_i]);
		?>
			<td></td>
		<?}?>
	<?}?>
		</tr>

		<?
			//$sql_file_4 = "select distinct(analysis_report_service_data_quiz_title) as analysis_report_service_data_quiz_title from wise_analysis_report_service_data_quiz where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_data_quiz_no='".$file_2_quizno2."' and analysis_report_service_data_quiz_title != '전체'";

			$sql_file_4 = "select analysis_report_service_data_quiz_no,analysis_report_service_data_quiz_title as analysis_report_service_data_quiz_title from wise_analysis_report_service_data_quiz where 1 and service_option_idx='".$service_option_idx."' and analysis_report_service_data_quiz_title != '전체' and service_data_idx='".$file_1_idx_arr[0]."'";
			if($_SERVER['REMOTE_ADDR'] == "59.5.188.xx"){
				echo $sql_file_4."<br>";
			}
			$query_file_4 = mysqli_query($gconnet,$sql_file_4);
			$query_file_4_cnt = mysqli_num_rows($query_file_4);
			for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ // 집단구분 보기 시작 
				$row_file_4 = mysqli_fetch_array($query_file_4);
		?>
				<tr bgcolor=#ffffff align="center" height="22">
				
				<?
					for($opt_i=0; $opt_i<sizeof($file_2_quizno_arr); $opt_i++){ // 집단문항루프 시작 
						$file_2_quizno = trim($file_2_quizno_arr[$opt_i]);
				?>
						<td>
						<?if($row_file_4['analysis_report_service_data_quiz_no'] == $file_2_quizno){?>
							<?=iconv("UTF-8","EUC-KR",$row_file_4['analysis_report_service_data_quiz_title'])?>
						<?}?>
						</td>
				<?} // 집단문항루프 종료 ?>

				<?
					$data_tot_1 = 0;
					for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){ // 문항타이틀 루프 시작 
						$file_1_idx = trim($file_1_idx_arr[$opt_i]);
						$data_1 = get_report_service_data_quiz_val($service_option_idx,$file_1_idx,$where=" and analysis_report_service_data_quiz_no='".$row_file_4['analysis_report_service_data_quiz_no']."' and analysis_report_service_data_quiz_title='".$row_file_4['analysis_report_service_data_quiz_title']."'");
				?>
						<td style="mso-number-format:'\@'">
							<?=$data_1?>
						</td>
				<?
					$data_tot_1 = $data_tot_1+$data_1;
					} // 문항타이틀 루프 종료 
				?>
				<? 
					//$row_tot_avg = round($data_tot_1/sizeof($file_1_title_arr),$service_option_scorepoint);
					//$row_tot_avg = $data_tot_1;
					$row_tot_avg = get_report_service_data_quiz_tot($service_option_idx,$file_1_idx,$where=" and analysis_report_service_data_quiz_no='".$row_file_4['analysis_report_service_data_quiz_no']."' and analysis_report_service_data_quiz_title='".$row_file_4['analysis_report_service_data_quiz_title']."'");
				?>
					<td style="mso-number-format:'\@'">
						<?=$row_tot_avg?>
						<?if($_SERVER['REMOTE_ADDR'] == "59.5.188.xx"){?>
								avg??
						<?}?>
					</td>
			
			<?if($query_file_2_cnt > 0){?>	
				<?
					for($opt_i=0; $opt_i<sizeof($file_2_quizno_arr); $opt_i++){ // 집단문항루프 시작 
						$file_2_quizno = trim($file_2_quizno_arr[$opt_i]);
				?>
						<td style="mso-number-format:'\@'">
						<?if($row_file_4['analysis_report_service_data_quiz_no'] == $file_2_quizno){?>
							<?
								$sql_file_1 = "select idx from wise_analysis_report_service_data_quiz where 1 and service_option_idx = '".$service_option_idx."' and analysis_report_service_data_quiz_no = '".$row_file_4['analysis_report_service_data_quiz_no']."' and service_data_idx='".$file_1_idx."' and analysis_report_service_data_quiz_tot > '".$row_tot_avg."'";
								
								if($_SERVER['REMOTE_ADDR'] == "59.5.188.xx"){
									echo $sql_file_1."<br>";
								}

								$query_file_1 = mysqli_query($gconnet,$sql_file_1);
								$query_file_1_cnt = mysqli_num_rows($query_file_1);

								if($query_file_1_cnt == 0){
									$row_align = 1;
									//echo "1 등 <br>";
								} else {
									$row_align = $query_file_1_cnt+1;
									//$row_align = ($opt_i+1);
								}
							?>
								<?//=($query_file_1_cnt+1)?> <?=$row_align?>
								<?//=get_report_service_data_quiz_align($service_option_idx,$file_1_idx,$where=" and analysis_report_service_data_quiz_no='".$row_file_4['analysis_report_service_data_quiz_no']."' and analysis_report_service_data_quiz_title='".$row_file_4['analysis_report_service_data_quiz_title']."'")?>
						<?}?>
						</td>
				<?} // 집단문항루프 종료 ?>
			<?}?>

				</tr>
		<?} // 집단구분 보기 종료 ?>
			</table>
		</td>
		</tr>
		
		<tr><td></td></tr>
		
		<tr>
		<td>
			
		</td>
		</tr>
	</table>
