<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$pay_str = "의사결정모델_전체AHP값";
	$pay_str =  iconv("UTF-8","EUC-KR",$pay_str);
	$filename = $pay_str."_".date("Y-m-d").".xls";

	Header( "Content-type: application/vnd.ms-excel" ); 
	Header( "Content-Disposition: attachment; filename=".$filename ); 
	Header( "Content-Description: PHP4 Generated Data" );
	
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));

	$compet_info_sql = "select analysis_report_idx,analysis_report_decision_option_scorepoint,analysis_report_decision_option_case,analysis_report_decision_option_case_no from wise_analysis_report_decision_option where 1 and idx='".$decision_option_idx."'";
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	$compet_info_row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($compet_info_row['analysis_report_idx']);
	$analysis_score_point = trim($compet_info_row['analysis_report_decision_option_scorepoint']);
	$ilk_option_case = trim($compet_info_row['analysis_report_decision_option_case']);
	$ilk_option_case_no = trim($compet_info_row['analysis_report_decision_option_case_no']);

	$sql_file_1 = "select analysis_report_decision_100data_no from wise_analysis_report_decision_100data_detail where 1 and decision_option_idx='".$decision_option_idx."' order by analysis_report_decision_100data_no asc limit 0,1"; 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$row_file_1 = mysqli_fetch_array($query_file_1);

	$sql_file_1 = "select analysis_report_decision_100data_quiz_no as quiz_no,analysis_report_decision_100data_quiz_title as quiz_title from wise_analysis_report_decision_100data_detail where 1 and decision_option_idx='".$decision_option_idx."' and analysis_report_decision_100data_no='".$row_file_1['analysis_report_decision_100data_no']."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['quiz_title'];
		} else {
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['quiz_title'].",";
		}
	}
	$file_1_quizno_arr = explode(",",$file_1_quizno);
	$file_1_title_arr = explode(",",$file_1_title);

	//분석모델설정 테이블
	/*$sql_file_2 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_model_quiz.analysis_report_decision_option_model_quiz_no) as quiz_no from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){ 
		$row_file_2 = mysqli_fetch_array($query_file_2);
		if($opt_i == $query_file_2_cnt-1){
			$file_2_idx .= $row_file_2['idx'];
			$file_2_quizno .= $row_file_2['quiz_no'];
			$file_2_title .= $row_file_2['analysis_report_decision_option_model_quiz_title'];
		} else {
			$file_2_idx .= $row_file_2['idx'].",";
			$file_2_quizno .= $row_file_2['quiz_no'].",";
			$file_2_title .= $row_file_2['analysis_report_decision_option_model_quiz_title'].",";
		}
	}
	$file_2_idx_arr = explode(",",$file_2_idx);
	$file_2_quizno_arr = explode(",",$file_2_quizno);
	$file_2_title_arr = explode(",",$file_2_title);*/

	$sql_file_4 = "select analysis_report_decision_option_action_quiz_no,analysis_report_decision_option_action_quiz_title,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_point_quiz.analysis_report_decision_option_action_quiz_no) as quiz_no from wise_analysis_report_decision_option_point_quiz where decision_option_idx='".$decision_option_idx."'";
	$query_file_4 = mysqli_query($gconnet,$sql_file_4);
	$query_file_4_cnt = mysqli_num_rows($query_file_4);
	for($opt4_i=0; $opt4_i<$query_file_4_cnt; $opt4_i++){ // 집단별 분석보기 시작 
		$row_file_4 = mysqli_fetch_array($query_file_4);
		
		if($opt4_i == $query_file_4_cnt-1){
			$file_4_idx .= $row_file_4['analysis_report_decision_option_action_quiz_no'];
			$file_4_quizno .= $row_file_4['quiz_no'];
			$file_4_title .= $row_file_4['analysis_report_decision_option_action_quiz_title'];
		} else {
			$file_4_idx .= $row_file_4['analysis_report_decision_option_action_quiz_no'].",";
			$file_4_quizno .= $row_file_4['quiz_no'].",";
			$file_4_title .= $row_file_4['analysis_report_decision_option_action_quiz_title'].",";
		}
	} // 집단별 분석보기 종료

	$file_4_idx_arr = explode(",",$file_4_idx);
	$file_4_quizno_arr = explode(",",$file_4_quizno);
	$file_4_title_arr = explode(",",$file_4_title);

	//echo "quiz_no_array = ".$file_4_quizno."<br>";
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
			<td bgcolor=#CCCCCC><font color="#669900"><strong></strong></font></td>
			<td bgcolor=#CCCCCC><font color="#669900"><strong></strong></font></td>
			<td bgcolor=#CCCCCC><font color="#669900"><strong></strong></font></td>
			<td bgcolor=#CCCCCC><font color="#669900"><strong></strong></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#CCCCCC><font color="#669900"><strong><?=iconv("UTF-8","EUC-KR",$file_1_title2)?><?//=$file_1_title2?></strong></font></td>
		<?}?>
		</tr>
		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","기하평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","고유치법")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"1",$file_1_title2,"analysis_report_decision_100data_quiz_val2")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);
							
							$data_100_model_no = "1"; // 고유치법 
							$type = "avg2"; // 기하평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"2",$file_1_title2,"analysis_report_decision_100data_quiz_val2")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);

							$data_100_model_no = "2"; // 평균 
							$type = "avg2"; // 기하평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font ><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","기하평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"3",$file_1_title2,"analysis_report_decision_100data_quiz_val2")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);

							$data_100_model_no = "3"; // 기하평균 
							$type = "avg2"; // 기하평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font ><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","고유치법")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"1",$file_1_title2,"analysis_report_decision_100data_quiz_val")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);

							$data_100_model_no = "1"; // 고유치법 
							$type = "avg"; // 평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font ><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"2",$file_1_title2,"analysis_report_decision_100data_quiz_val")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);

							$data_100_model_no = "2"; // 평균 
							$type = "avg"; // 평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font ><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		<tr align="center">
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
			<td bgcolor=#FFFFFF><font ><strong><?=iconv("UTF-8","EUC-KR","기하평균")?></strong></font></td>
			<td bgcolor=#FFFFFF><font ></font></td>
		<?
			for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
				$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		?>
			<td bgcolor=#FFFFFF><font ><?=get_decision_100data_total_val($decision_option_idx,"3",$file_1_title2,"analysis_report_decision_100data_quiz_val")?></font></td>
		<?}?>
		</tr>

		<?
			for($opt_i4=0; $opt_i4<sizeof($file_4_idx_arr); $opt_i4++){ // 집단별 분석 루프 시작 
				$file_4_idx = trim($file_4_idx_arr[$opt_i4]);
				$file_4_quizno = trim($file_4_quizno_arr[$opt_i4]);
				$file_4_title = trim($file_4_title_arr[$opt_i4]);

				$any_data_sql = "select distinct(data_val) as data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$file_4_quizno."' order by data_val asc";
				//echo "any_data_sql = ".$any_data_sql."<br>";
				$any_data_query = mysqli_query($gconnet,$any_data_sql);
				$any_data_cnt = mysqli_num_rows($any_data_query);

				for($opt_i5=0; $opt_i5<$any_data_cnt; $opt_i5++){ // 집단별 응답값 루프 시작  
					$any_data_row = mysqli_fetch_array($any_data_query);
		?>
				<tr align="center">
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font ></font></td>
					<td bgcolor=#FFFFFF><font >
					<?if($opt_i5 == 0){?>
						<?=iconv("UTF-8","EUC-KR",$file_4_title)?></font>
					<?}?>
					</td>
					<td bgcolor=#FFFFFF><font ><?=$any_data_row['data_val']?></font></td>
					<?
						for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
							$file_1_title2 = trim($file_1_title_arr[$opt_i]);

							$data_100_model_no = "3"; // 기하평균 
							$type = "avg"; // 평균
							$dan_data = get_calcurate_decision_excel_avg($data_100_model_no,$decision_option_idx,$file_1_title2,$type,$analysis_report_idx,$file_4_quizno,$any_data_row['data_val'],$ilk_option_case_no); 
					?>
						<td bgcolor=#FFFFFF><font ><?=$dan_data?></font></td>
					<?}?>
				</tr>
				<? } // 집단별 응답값 루프 종료  ?>
		<? } // 집단별 분석 루프 종료  ?>

		</table>
