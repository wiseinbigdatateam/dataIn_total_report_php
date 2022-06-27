<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "서비스평가모델_집단구분&등급분포";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";

	Header( "Content-type: application/vnd.ms-excel" ); 
	Header( "Content-Disposition: attachment; filename=".$filename ); 
	Header( "Content-Description: PHP4 Generated Data" );

	$sql_file_0 = "select service_option_idx,analysis_report_idx from wise_analysis_report_service_100data where 1 order by idx desc limit 0,1"; // 문항 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	$service_option_idx = $row_file_0['service_option_idx'];
	$analysis_report_idx = $row_file_0['analysis_report_idx']; 
	
	$compet_info_sql = "select analysis_report_service_option_score,analysis_report_service_option_percent,analysis_report_service_option_scorepoint,analysis_report_service_option_scorepoint2 from wise_analysis_report_service_option where 1 and idx='".$service_option_idx."'";
	$compet_info_query = mysqli_query($GLOBALS['gconnet'],$compet_info_sql);
	$row = mysqli_fetch_array($compet_info_query);
	$service_option_scorepoint = trim($row['analysis_report_service_option_scorepoint']);
		
	// 집단 구분 항목 
	$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_service_option_group.analysis_report_service_option_group_no) as quiz_no from wise_analysis_report_service_option_group where 1 and service_option_idx='".$service_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_service_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_service_option_group_title'].",";
		}
	}
	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_quizno_arr = explode(",",$file_1_quizno);
	$file_1_title_arr = explode(",",$file_1_title);
	
	// 등급
	$sql_file_2 = "select idx,analysis_report_service_option_levelyn_title from wise_analysis_report_service_option_levelyn where 1 and service_option_idx='".$service_option_idx."' order by idx asc"; // 등급기준
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
	for($opt_i2=0; $opt_i2<$query_file_2_cnt; $opt_i2++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i2 == $query_file_2_cnt-1){
			$file_2_idx .= $row_file_2['idx'];
			$file_2_title .= $row_file_2['analysis_report_service_option_levelyn_title'];
		} else {
			$file_2_idx .= $row_file_2['idx'].",";
			$file_2_title .= $row_file_2['analysis_report_service_option_levelyn_title'].",";
		}
	}
	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_2_title_arr = explode(",",$file_2_title);

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
			<!-- 등급없는 집단구분 시작 --> 
			<td>
			<table>
				<?
				for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
					$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
					$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
					$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
				?>
				<tr>
				<td>
						<table border>
								<tr align="center">
									<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_1_title2?></strong></font></td>
									<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","빈도")?><!--빈도--></strong></font></td>
									<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","퍼센트")?><!--퍼센트--></strong></font></td>
								</tr>
							<?
								$sql_file_1 = "select * from wise_analysis_report_service_data_ratio where service_option_idx='".$service_option_idx."' and service_data_idx='".$file_1_quizno2."' and service_data_level_idx is null order by analysis_report_service_data_frequency_no asc";
								$query_file_1 = mysqli_query($gconnet,$sql_file_1);
								$query_file_1_cnt = mysqli_num_rows($query_file_1);

								$tot_frequency_val = 0;
								$tot_ratio_val = 0;
								for($opt4_i=0; $opt4_i<$query_file_1_cnt; $opt4_i++){ 
									$row_file_1 = mysqli_fetch_array($query_file_1);
							?>
								<tr bgcolor=#ffffff align="center" height="22">
									<td><?=iconv("UTF-8","EUC-KR",$row_file_1['analysis_report_service_data_frequency_no'])?>
									<?//=$row_file_1['analysis_report_service_data_frequency_no']?></td>
									<td><?=number_format($row_file_1['analysis_report_service_data_frequency_val'])?></td>
									<td><?=$row_file_1['analysis_report_service_data_ratio_val']?></td>
								</tr>
							<?
								$tot_frequency_val = $tot_frequency_val+$row_file_1['analysis_report_service_data_frequency_val'];
								$tot_ratio_val = $tot_ratio_val+$row_file_1['analysis_report_service_data_ratio_val'];
								}
							?>
								<tr bgcolor=#ffffff align="center" height="22">
									<td><?=iconv("UTF-8","EUC-KR","합계")?><!--합계--></td>
									<td><?=number_format($tot_frequency_val)?></td>
									<td><?=$tot_ratio_val?></td>
								</tr>
						</table>
					</td>
					</tr>
					<tr><td></td></tr>
				<?}?>
			
			</table>
			</td>
			<!-- 등급없는 집단구분 종료 --> 
			<td></td>
			<!-- 등급별 집단구분 시작 --> 
			<td>
				<table>
				<tr>
					<!-- 빈도시작 -->
					<td>
						<table border>
							<tr align="center">
								<td bgcolor=#CCCCCC rowspan="3" colspan="2"></td>
								<td bgcolor=#CCCCCC colspan="<?=sizeof($file_2_idx_arr)+1?>"><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","등급")?><!--등급--></strong></font></td>
							</tr>
							<tr align="center">
						<?
							for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
								$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
								$file_2_title2 = trim($file_2_title_arr[$opt2_i]);
						?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_2_title2?></strong></font></td>	
						<?} // 등급루프 종료?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","전체")?><!--전체--></strong></font></td>
							</tr>
							<tr align="center">
						<?
							for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
								$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
								$file_2_title2 = trim($file_2_title_arr[$opt2_i]);
						?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","빈도")?><!--빈도--></strong></font></td>	
						<?} // 등급루프 종료?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","빈도")?><!--빈도--></strong></font></td>
							</tr>

							<tr bgcolor=#ffffff align="center" height="22">
								<td><?=iconv("UTF-8","EUC-KR","전체")?><!--전체--></td>
								<td></td>
								<?
								$val_tot = 0;
								for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
									$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
									$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

									$val_one = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_level_idx='".$file_2_idx2."' and service_data_idx='".$file_1_quizno_arr[0]."'");
								?>
									<td><?=number_format($val_one)?></td>
								<?
									$val_tot = $val_tot+$val_one;
									} //등급루프 종료
								?>
								<td><?=number_format($val_tot)?></td>
							</tr>

					<?
						for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
							$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
							$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
							$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
		
							$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
							$query_file_4 = mysqli_query($gconnet,$sql_file_4);
							$query_file_4_cnt = mysqli_num_rows($query_file_4);
							for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ // 문항별 보기루프 시작 
								$row_file_4 = mysqli_fetch_array($query_file_4);
					?>
							<tr bgcolor=#ffffff align="center" height="22">
								<td>
								<?if($opt4_i == 0){?>
									<?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_1_title2?>
								<?}?>
								</td>
								<td><?=iconv("UTF-8","EUC-KR",$row_file_4['data_val'])?><?//=$row_file_4['data_val']?></td>
								<?
								$val_tot = 0;
								for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
									$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
									$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

									$val_one = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_idx='".$file_1_quizno2."' and service_data_level_idx='".$file_2_idx2."' and analysis_report_service_data_frequency_no='".$row_file_4['data_val']."'");
								?>
									<td><?=number_format($val_one)?></td>
								<?
									$val_tot = $val_tot+$val_one;
									} //등급루프 종료
								?>
								<td><?=number_format($val_tot)?></td>
							</tr>
					<?
							}
						}
					?>
						</table>
					</td>
					<!-- 빈도종료 -->
					<td></td>
					<!-- 비율시작 -->
					<td>
						<table border>
							<tr align="center">
								<td bgcolor=#CCCCCC rowspan="3" colspan="2"></td>
								<td bgcolor=#CCCCCC colspan="<?=sizeof($file_2_idx_arr)+1?>"><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","등급")?><!--등급--></strong></font></td>
							</tr>
							<tr align="center">
						<?
							for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
								$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
								$file_2_title2 = trim($file_2_title_arr[$opt2_i]);
						?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_2_title2?></strong></font></td>	
						<?} // 등급루프 종료?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","전체")?><!--전체--></strong></font></td>
							</tr>
							<tr align="center">
						<?
							for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
								$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
								$file_2_title2 = trim($file_2_title_arr[$opt2_i]);
						?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","빈도")?><!--비율--></strong></font></td>	
						<?} // 등급루프 종료?>
							<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","빈도")?><!--비율--></strong></font></td>
							</tr>

							<tr bgcolor=#ffffff align="center" height="22">
								<td><?=iconv("UTF-8","EUC-KR","전체")?><!--전체--></td>
								<td></td>
								<?
								$val_tot = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_idx='".$file_1_quizno_arr[0]."' and service_data_level_idx is null");

								for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
									$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
									$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

									$val_one = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_level_idx='".$file_2_idx2."' and service_data_idx='".$file_1_quizno_arr[0]."'");
									
									if($val_tot == 0){
										$val_per = 0;
									} else {
										$val_per = round($val_one/$val_tot,$service_option_scorepoint);
										$val_per = $val_per*100;
									}
								?>
									<td><?=$val_per?></td>
								<?
									} //등급루프 종료
								?>
								<td><?=($val_tot/$val_tot)*100?></td>
							</tr>

					<?
						for($opt3_i=0; $opt3_i<sizeof($file_1_idx_arr); $opt3_i++){ // 집단구분항목 루프 시작 
							$file_1_idx2 = trim($file_1_idx_arr[$opt3_i]);
							$file_1_quizno2 = trim($file_1_quizno_arr[$opt3_i]);
							$file_1_title2 = trim($file_1_title_arr[$opt3_i]);
		
							$sql_file_4 = "select distinct(data_val) as data_val from wise_analysis_data where analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_1_quizno2."' order by data_val asc";
							$query_file_4 = mysqli_query($gconnet,$sql_file_4);
							$query_file_4_cnt = mysqli_num_rows($query_file_4);
							for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ // 문항별 보기루프 시작 
								$row_file_4 = mysqli_fetch_array($query_file_4);
					?>
							<tr bgcolor=#ffffff align="center" height="22">
								<td>
								<?if($opt4_i == 0){?>
									<?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_1_title2?>
								<?}?>
								</td>
								<td><?=iconv("UTF-8","EUC-KR",$row_file_4['data_val'])?><?//=$row_file_4['data_val']?></td>
								<?
								for($opt2_i=0; $opt2_i<sizeof($file_2_idx_arr); $opt2_i++){ // 등급루프 시작 
									$file_2_idx2 = trim($file_2_idx_arr[$opt2_i]);
									$file_2_title2 = trim($file_2_title_arr[$opt2_i]);

									$val_tot = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_idx='".$file_1_quizno2."' and analysis_report_service_data_frequency_no='".$row_file_4['data_val']."' and service_data_level_idx is not null");

									$val_one = get_data_colname("wise_analysis_report_service_data_ratio","service_option_idx",$service_option_idx,"sum(analysis_report_service_data_frequency_val)"," and service_data_idx='".$file_1_quizno2."' and service_data_level_idx='".$file_2_idx2."' and analysis_report_service_data_frequency_no='".$row_file_4['data_val']."'");
									
									if($val_tot == 0){
										$val_per = 0;
									} else {
										$val_per = round($val_one/$val_tot,$service_option_scorepoint);
										$val_per = $val_per*100;
									}
								?>
									<td><?=$val_per?></td>
								<?
									} //등급루프 종료
								?>
								<td><?=($val_tot/$val_tot)*100?></td>
							</tr>
					<?
							}
						}
					?>
						</table>
					</td>
					<!-- 비율종료 -->
				</tr>
				</table>
			</td>
			<!-- 등급별 집단구분 종료 --> 
		</tr>
		</table>