<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "만족도조사_정리3_충성집단별분석";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";
	
	if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"  || $_SERVER['REMOTE_ADDR'] == "211.227.88.137"){
		Header( "Content-type: application/vnd.ms-excel" ); 
		Header( "Content-Disposition: attachment; filename=".$filename ); 
		Header( "Content-Description: PHP4 Generated Data" );
	} else {
		Header( "Content-type: application/vnd.ms-excel" ); 
		Header( "Content-Disposition: attachment; filename=".$filename ); 
		Header( "Content-Description: PHP4 Generated Data" );
	}

	//$sql_file_0 = "select satisfaction_option_idx,analysis_report_idx from wise_analysis_report_satisfaction_100data where 1 order by idx desc limit 0,1"; 
	
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$sql_file_0 = "select satisfaction_option_idx,analysis_report_idx from wise_analysis_report_satisfaction_100data where 1 ";
	if($satisfaction_option_idx){
		$sql_file_0 .= " and satisfaction_option_idx='".$satisfaction_option_idx."'";
	}
	$sql_file_0 .= " order by idx desc limit 0,1"; 

	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	$row_file_0 = mysqli_fetch_array($query_file_0);
	$satisfaction_option_idx = $row_file_0['satisfaction_option_idx']; 
	$analysis_report_idx = $row_file_0['analysis_report_idx'];  

	$compet_info_sql = "select analysis_report_satisfaction_option_scorepoint from wise_analysis_report_satisfaction_option where 1 and idx='".$satisfaction_option_idx."'";
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	$row = mysqli_fetch_array($compet_info_query);
	$satisfaction_option_scorepoint = $row['analysis_report_satisfaction_option_scorepoint'];

	$sql_file_2 = "select satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title from wise_analysis_report_satisfaction_data_group_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' group by satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title order by satisfaction_data_group_idx asc,CONVERT(analysis_report_satisfaction_data_group2_no, UNSIGNED) asc"; // 그룹 데이터 
	//echo "sql_file_2 = ".$sql_file_2."<br>";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	$sql_file_2_1 = "select satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title from wise_analysis_report_satisfaction_data_group_detail where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' group by satisfaction_data_group_idx,analysis_report_satisfaction_data_group2_no,analysis_report_satisfaction_data_group2_title order by satisfaction_data_group_idx asc,CONVERT(analysis_report_satisfaction_data_group2_no, UNSIGNED) asc"; // 그룹 데이터 
	$query_file_2_1 = mysqli_query($gconnet,$sql_file_2_1);
	$query_file_2_1_cnt = mysqli_num_rows($query_file_2_1);
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
				<td bgcolor=#CCCCCC colspan="7" style="text-align:center"><?=iconv("UTF-8","EUC-KR","빈도")?></td>
			</tr>
			<tr align="center">
				<td bgcolor=#CCCCCC></td>
				<td bgcolor=#CCCCCC></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","1(비충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","2(타성적충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","3(잠재적충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","4(우량충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","총합계")?></strong></font></td>
			</tr>
				<?
					$data_raw_1 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","1(비충성집단)");
					$data_raw_2 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","2(타성적충성집단)");
					$data_raw_3 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","3(잠재적충성집단)");
					$data_raw_4 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","4(우량충성집단)");
					$data_raw_t = $data_raw_1+$data_raw_2+$data_raw_3+$data_raw_4;
				?>
				<tr bgcolor=#ffffff align="center" height="22">
					<td></td>
					<td><?=iconv("UTF-8","EUC-KR","전체")?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_1)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_2)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_3)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_4)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_t)?></td>
				</tr>

			<?
				for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
					$row_file_2 = mysqli_fetch_array($query_file_2);

					$sql_file_3 = "select analysis_report_satisfaction_data_group_no,analysis_report_satisfaction_data_group_title from wise_analysis_report_satisfaction_data_group where 1 and idx='".$row_file_2['satisfaction_data_group_idx']."' and satisfaction_option_idx='".$satisfaction_option_idx."'"; 
					$query_file_3 = mysqli_query($gconnet,$sql_file_3);
					$row_file_3 = mysqli_fetch_array($query_file_3);
				
					$data_quiz_no = $row_file_3['analysis_report_satisfaction_data_group_no'];
					$data_quiz_ans = $row_file_2['analysis_report_satisfaction_data_group2_no'];

					//$data_quiz_ans = zero_point_set($data_quiz_ans,$satisfaction_option_scorepoint);

					$data_raw_1 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"1(비충성집단)");
					$data_raw_2 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"2(타성적충성집단)");
					$data_raw_3 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"3(잠재적충성집단)");
					$data_raw_4 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"4(우량충성집단)");
					$data_raw_t = $data_raw_1+$data_raw_2+$data_raw_3+$data_raw_4;
			
			?>
				<tr bgcolor=#ffffff align="center" height="22">
					<td>
					<?if($group_title != $row_file_3['analysis_report_satisfaction_data_group_title']){?>
						<?=iconv("UTF-8","EUC-KR",$row_file_3['analysis_report_satisfaction_data_group_title'])?>
					<?}?>
					</td>
					<td><?=$row_file_2['analysis_report_satisfaction_data_group2_no']?>=<?=iconv("UTF-8","EUC-KR",$row_file_2['analysis_report_satisfaction_data_group2_title'])?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_1)?>
						<!--<br>
						응답값 = <?//=$data_quiz_ans?>
						<br>
						<?//=get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"1(비충성집단)")?>-->
					</td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_2)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_3)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_4)?></td>
					<td style="mso-number-format:'\@'"><?=number_format($data_raw_t)?></td>
				</tr>
			<?
				$group_title = $row_file_3['analysis_report_satisfaction_data_group_title'];
				}
			?>
			</table>
		</td>

		<td></tD>
		<?$group_title = "";?>
		<td>
			<table border>
			<tr align="center">
				<td bgcolor=#CCCCCC colspan="7" style="text-align:center"><?=iconv("UTF-8","EUC-KR","비율")?></td>
			</tr>
			<tr align="center">
				<td bgcolor=#CCCCCC></td>
				<td bgcolor=#CCCCCC></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","1(비충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","2(타성적충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","3(잠재적충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","4(우량충성집단)")?></strong></font></td>
				<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR","총합계")?></strong></font></td>
			</tr>
				<?
					$data_raw_t1 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","1(비충성집단)");
					$data_raw_t2 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","2(타성적충성집단)");
					$data_raw_t3 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","3(잠재적충성집단)");
					$data_raw_t4 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,"","","4(우량충성집단)");
					$data_raw_tt = $data_raw_t1+$data_raw_t2+$data_raw_t3+$data_raw_t4;
				?>
				<tr bgcolor=#ffffff align="center" height="22">
					<td></td>
					<td><?=iconv("UTF-8","EUC-KR","전체")?></td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_t1/$data_raw_tt*100,1)?> %</td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_t2/$data_raw_tt*100,1)?> %</td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_t3/$data_raw_tt*100,1)?> %</td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_t4/$data_raw_tt*100,1)?> %</td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_tt/$data_raw_tt*100,1)?> %</td>
				</tr>

			<?
				for($opt_i=0; $opt_i<$query_file_2_1_cnt; $opt_i++){
					$row_file_2_1 = mysqli_fetch_array($query_file_2_1);

					$sql_file_3 = "select analysis_report_satisfaction_data_group_no,analysis_report_satisfaction_data_group_title from wise_analysis_report_satisfaction_data_group where 1 and idx='".$row_file_2_1['satisfaction_data_group_idx']."' and satisfaction_option_idx='".$satisfaction_option_idx."'"; 
					$query_file_3 = mysqli_query($gconnet,$sql_file_3);
					$row_file_3 = mysqli_fetch_array($query_file_3);
				
					$data_quiz_no = $row_file_3['analysis_report_satisfaction_data_group_no'];
					$data_quiz_ans = $row_file_2_1['analysis_report_satisfaction_data_group2_no'];
					//$data_quiz_ans = zero_point_set($data_quiz_ans,$satisfaction_option_scorepoint);

					$data_raw_1 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"1(비충성집단)");
					$data_raw_2 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"2(타성적충성집단)");
					$data_raw_3 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"3(잠재적충성집단)");
					$data_raw_4 = get_satisf_loyalty_val($satisfaction_option_idx,$analysis_report_idx,$data_quiz_no,$data_quiz_ans,"4(우량충성집단)");
					$data_raw_t = $data_raw_1+$data_raw_2+$data_raw_3+$data_raw_4;
			
			?>
				<tr bgcolor=#ffffff align="center" height="22">
					<td>
					<?if($group_title != $row_file_3['analysis_report_satisfaction_data_group_title']){?>
						<?=iconv("UTF-8","EUC-KR",$row_file_3['analysis_report_satisfaction_data_group_title'])?>
					<?}?>
					</td>
					<td><?=$row_file_2_1['analysis_report_satisfaction_data_group2_no']?>=<?=iconv("UTF-8","EUC-KR",$row_file_2_1['analysis_report_satisfaction_data_group2_title'])?></td>
					<td style="mso-number-format:'\@'"><?if($data_raw_t1){?><?=round($data_raw_1/$data_raw_t1*100,1)?><?}else{?>0<?}?> %</td>
					<td style="mso-number-format:'\@'"><?if($data_raw_t2){?><?=round($data_raw_2/$data_raw_t2*100,1)?><?}else{?>0<?}?> %</td>
					<td style="mso-number-format:'\@'"><?if($data_raw_t3){?><?=round($data_raw_3/$data_raw_t3*100,1)?><?}else{?>0<?}?> %</td>
					<td style="mso-number-format:'\@'"><?if($data_raw_t4){?><?=round($data_raw_4/$data_raw_t4*100,1)?><?}else{?>0<?}?> %</td>
					<td style="mso-number-format:'\@'"><?=round($data_raw_t/$data_raw_tt*100,1)?> %</td>
				</tr>
			<?
				$group_title = $row_file_3['analysis_report_satisfaction_data_group_title'];
				}
			?>
			</table>
		</td>
		</tr>
		</table>