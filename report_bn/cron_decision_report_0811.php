<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
//exit;
// http://surveyin.kr/report/cron_decision_report.php
$bbs_code = "decision";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";

//$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_status='tmp' and report_type='decision' and report_sdate is null order by idx desc limit 0,1";

$idx = trim(sqlfilter($_REQUEST['idx']));
if($idx){
	$top_where = " and idx='".$idx."'";
}

if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){
	$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_type='decision' ".$top_where." order by idx desc limit 0,1";
} else {
	$inc_report_sql = "select * from wise_analysis_myreport where 1 and report_status='tmp' and report_type='decision' ".$top_where." order by idx desc limit 0,1";
}

$inc_report_query = mysqli_query($gconnet,$inc_report_sql);
for ($inc_report_i=0; $inc_report_i<mysqli_num_rows($inc_report_query); $inc_report_i++){ // 보고서 추출대상 루프 시작 
	$inc_report_row = mysqli_fetch_array($inc_report_query);
	
	$decision_option_idx = trim($inc_report_row['report_idx']);
	$decision_option_report_title = trim($inc_report_row['report_title']);
	$memid = trim($inc_report_row['memid']);
	$subid = trim($inc_report_row['subid']);

	$inc_report_query_1 = "update wise_analysis_myreport set report_sdate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	$inc_report_result_1 = mysqli_query($gconnet,$inc_report_query_1);
	
	$sql_file_0 = "select decision_option_idx from wise_analysis_report_decision_100data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
	$query_file_0 = mysqli_query($gconnet,$sql_file_0);
	if(mysqli_num_rows($query_file_0) > 0){
		$sql_del_0 = "delete from wise_analysis_report_decision_100data where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_0 = mysqli_query($gconnet,$sql_del_0);
		$sql_del_1 = "delete from wise_analysis_report_decision_100data_detail where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_1 = mysqli_query($gconnet,$sql_del_1);
		$sql_del_2 = "delete from wise_analysis_report_decision_100data_detail2 where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_2 = mysqli_query($gconnet,$sql_del_2);
		$sql_del_3 = "delete from wise_analysis_report_decision_100data_detail3 where 1 and decision_option_idx = '".$decision_option_idx."'"; 
		$query_del_3 = mysqli_query($gconnet,$sql_del_3);
	}

	$compet_info_sql = "select idx,analysis_report_idx,analysis_report_decision_option_scorepoint,analysis_report_decision_option_scorepoint2,analysis_report_decision_option_calpath,analysis_report_decision_option_calpath2,analysis_report_decision_option_case,analysis_report_decision_option_case_no from wise_analysis_report_decision_option where 1 and idx='".$decision_option_idx."'";
	//echo $compet_info_sql."<br>";
	/*if($memid){
		$compet_info_sql .= " and memid='".$memid."'";
	}
	if($subid){
		$compet_info_sql .= " and subid='".$subid."'";
	}*/
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_frame_go("다시 진행해주세요.","decision_1.php");
	}
	$compet_info_row = mysqli_fetch_array($compet_info_query);
	$analysis_report_idx = trim($compet_info_row['analysis_report_idx']);
	$ilk_option_case = trim($compet_info_row['analysis_report_decision_option_case']);
	$ilk_option_case_no = trim($compet_info_row['analysis_report_decision_option_case_no']);
	
	$query = "insert into wise_analysis_report_decision_100data set"; 
	$query .= " decision_option_idx = '".$decision_option_idx."', ";
	$query .= " analysis_report_idx = '".$analysis_report_idx."', ";
	$query .= " decision_option_report_title = '".$decision_option_report_title."', ";
	$query .= " wdate = now() ";

	//echo $query."<br>";
	$result = mysqli_query($gconnet,$query);

	$sql_pre2 = "select idx from wise_analysis_report_decision_100data where 1 order by idx desc limit 0,1"; 
	$result_pre2  = mysqli_query($gconnet,$sql_pre2);
	$mem_row2 = mysqli_fetch_array($result_pre2);
	$decision_option_100data_idx = $mem_row2[idx]; 

	//exit;
	
	// 표본특성문항 
	$sql_file_1 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_group.analysis_report_decision_option_group_no) as quiz_no from wise_analysis_report_decision_option_group where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);

	for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_file_1);
		if($opt_i == $query_file_1_cnt-1){
			$file_1_idx .= $row_file_1['idx'];
			$file_1_quizno .= $row_file_1['quiz_no'];
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'];
		} else {
			$file_1_idx .= $row_file_1['idx'].",";
			$file_1_quizno .= $row_file_1['quiz_no'].",";
			$file_1_title .= $row_file_1['analysis_report_decision_option_group_title'].",";
		}
	}
	$file_1_idx_arr = explode(",",$file_1_idx);
	$file_1_quizno_arr = explode(",",$file_1_quizno);
	$file_1_title_arr = explode(",",$file_1_title);

	//분석모델설정 테이블
	$sql_file_2 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_model_quiz.analysis_report_decision_option_model_quiz_no) as quiz_no from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
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
	$file_2_title_arr = explode(",",$file_2_title);

		$sql_file_3 = "select idx,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_point_case.analysis_report_decision_option_case_no) as quiz_no,analysis_report_decision_option_case_answer as quiz_answ from wise_analysis_report_decision_option_point_case where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc";
		$query_file_3 = mysqli_query($gconnet,$sql_file_3);
		$query_file_3_cnt = mysqli_num_rows($query_file_3);
		
		if($query_file_3_cnt == 0){
			$case_where = "";
		} else {
			for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){ // 케이스 설정 루프 시작 
				$row_file_3 = mysqli_fetch_array($query_file_3);
			
				if($opt_i == 0){
					$sql_file_3_sub = "select distinct(data_no) as data_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$row_file_3['quiz_no']."' and data_val='".$row_file_3['quiz_answ']."' order by data_no asc";
				} else {
					$sql_file_3_sub = "select distinct(data_no) as data_no from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and quiz_no='".$row_file_3['quiz_no']."' and data_val='".$row_file_3['quiz_answ']."' and data_no in (".$case_data.") order by data_no asc";
				}
				//echo "케이스 쿼리 = ".$sql_file_3_sub."<br>";
				$query_file_3_sub = mysqli_query($gconnet,$sql_file_3_sub);
				$query_file_3_sub_cnt = mysqli_num_rows($query_file_3_sub);
			
				$case_data = "";
				for($opt_i_sub=0; $opt_i_sub<$query_file_3_sub_cnt; $opt_i_sub++){
					$row_file_3_sub = mysqli_fetch_array($query_file_3_sub);
					//echo "문항번호 ".$row_file_3['quiz_no']." 가 ".$row_file_3['quiz_answ']." 인 조건 ".$opt_i_sub." = ".$row_file_3_sub['data_no']."<br>"; 
					if($opt_i_sub == $query_file_3_sub_cnt-1){
						$case_data .= $row_file_3_sub['data_no'];
					} else {
						$case_data .= $row_file_3_sub['data_no'].",";
					}
				}
			
				//echo "case_data = ".$case_data."<br>";
			} // 케이스 설정 루프 종료
			
			$case_where = " and data_no in (".$case_data.")";
		}

	/*$sql_data_model = "select max(decision_option_model_quiz_level) as mlevel from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."'";
	//echo "sql_data_model = ".$sql_data_model."<br>"; //exit;
	$query_data_model = mysqli_query($gconnet,$sql_data_model);
	$row_data_model = mysqli_fetch_array($query_data_model);
	$model_max = $row_data_model['mlevel'];*/
	//echo "model_max = ".$model_max."<br>";

	$sql_data_model = "select distinct(decision_option_model_quiz_parent) as quiz_parent from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."'";
	echo "sql_data_model = ".$sql_data_model."<br>";
	$query_data_model = mysqli_query($gconnet,$sql_data_model);
	$model_max = mysqli_num_rows($query_data_model);

	for($opt_i=0; $opt_i<$model_max; $opt_i++){ 
		$row_file_1 = mysqli_fetch_array($query_data_model);
		if($opt_i == $model_max-1){
			$quiz_parent .= $row_file_1['quiz_parent'];
		} else {
			$quiz_parent .= $row_file_1['quiz_parent'].",";
		}
	}
	$quiz_parent_arr = explode(",",$quiz_parent);
	echo "model_max = ".$model_max."<br>";
		
	$sql_data_1 = "select distinct(data_no) from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' ".$case_where." order by data_no asc";
	$query_data_1 = mysqli_query($gconnet,$sql_data_1);
	$query_data_1_cnt = mysqli_num_rows($query_data_1);

	for($opt_i=0; $opt_i<$query_data_1_cnt; $opt_i++){ // 응답자 루프 시작 
		$row_data_1 = mysqli_fetch_array($query_data_1);
		$decision_100data_no = $row_data_1['data_no'];

			//if($opt_i > 0){exit;}
		
			######## raw data 시작 ############
			
			for($opt2_i=0; $opt2_i<$model_max; $opt2_i++){ // 최고 레벨까지 루프 시작  
				$opt2_k = $opt2_i+1;
				
				$decision_100data_quiz_no = $row_data_2['quiz_no'];

				echo "opt2 = ".$quiz_parent_arr[$opt2_i]."<br>";
				
				if($opt2_i == 0){
					$sql_data_3 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_model_quiz.analysis_report_decision_option_model_quiz_no) as quiz_no from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_quiz_parent is null";
				} else {
					$sql_data_3 = "select *,(select quiz_no from wise_analysis_quiz where 1 and idx=wise_analysis_report_decision_option_model_quiz.analysis_report_decision_option_model_quiz_no) as quiz_no from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_quiz_parent='".$quiz_parent_arr[$opt2_i]."'";
				}
				
				echo "sql_data_3 = ".$sql_data_3."<br>"; //exit;
				
				$query_data_3 = mysqli_query($gconnet,$sql_data_3);
				$query_data_3_cnt = mysqli_num_rows($query_data_3);
				
				$file_1_title = "";
				$file_1_quizno = "";
				$inputNumber = "";
				$inputNumber = array();

				for($opt_i3=0; $opt_i3<$query_data_3_cnt; $opt_i3++){ 
					$row_file_3 = mysqli_fetch_array($query_data_3);

					$sql_data_4 = "select data_val from wise_analysis_data where 1 and analysis_idx='".$analysis_report_idx."' and data_no='".$decision_100data_no."' and quiz_no='".$row_file_3['quiz_no']."'";
					//echo $sql_data_4."<br>";
					$query_data_4 = mysqli_query($GLOBALS['gconnet'],$sql_data_4);
					$row_data_4 = mysqli_fetch_array($query_data_4);
					$quiz_sco = $row_data_4['data_val'];

					if($opt_i3 == $query_data_3_cnt-1){
						$file_1_title .= $row_file_3['analysis_report_decision_option_model_quiz_title'];
						$file_1_quizno .= $quiz_sco;
						$inputNumber[$opt_i3] = $quiz_sco;
					} else {
						$file_1_title .= $row_file_3['analysis_report_decision_option_model_quiz_title']."_";
						$file_1_quizno .= $quiz_sco.",";
						$inputNumber[$opt_i3] = $quiz_sco;
					}
				}

				//echo "file_1_title = ".$file_1_title."<br>";
				echo "file_1_quizno = ".$file_1_quizno."<br>";

				$title_arr2 = explode("_",$file_1_title);
				$title_arr3 = array_unique($title_arr2);
				
				$title_last_arr = array();
				$k = 0;
				for($i=0; $i<sizeof($title_arr2); $i++){
					if($title_arr3[$i]){
						$title_last_arr[$k] .= $title_arr3[$i];
						$k = $k+1;
					}
				}
				
					//echo "title_last size = ".sizeof($title_last_arr)."<br>"; //exit;
				
				// 고유치 공식 시작 
					//echo "시작값 = ".$file_1_quizno."<br>";
					//$inputNumber = array($file_1_quizno); // 시작값
					//$inputNumber = array(1,1,1,1,1,1);

					//주어진 시작값들의 개수가 삼각수인지 확인
					$sizeOfArray = 0;
					$maxSizeValue = 100;
					for($i=0;$i<$maxSizeValue;$i++){
						$sizeTemp = $i*($i+1)/2;
						if(sizeof($inputNumber) == $sizeTemp){
							$sizeOfArray= $i+1;
							$i = $maxSizeValue+1;
						}
					}
					
					echo $sizeOfArray.'개 짜리 행렬<br/>'; // sizeOfArray 가 0인 경우는 에러처리.
					
					$inputMatrix="";
					$inputMatrix=array(); // 주어진 시작값을 통해 배열을 생성함.
					$k = 0;
					for($i=0;$i<$sizeOfArray;$i++){
						for($j=0;$j<$sizeOfArray;$j++){
							if($i == $j){
								$inputMatrix[$i][$j] = 1;
							}else if($i<$j){
								$inputMatrix[$i][$j] = $inputNumber[$k];
								$k++;
							}else{
								$inputMatrix[$i][$j] = 1/$inputMatrix[$j][$i];
							}
							if($j==$sizeOfArray-1)echo '<br />';
						}
					}

					//print_r($inputMatrix); // 행렬을 보여줌
					
					$weight = "";
					$weightAfter = "";
					$weight = array();
					$weightAfter = array();
					$weightSum = 0;
					for($i=0;$i<$sizeOfArray;$i++){
						$weight[$i] = $inputMatrix[$i][0];
					}
					/*echo "<br />";
					print_r($weight);
					echo "<br />";*/

					$weightLoop = $sizeOfArray+1;
					$weightPre0 = [0];
					$weightPre1 = [1];
					$weightPreAll0 = [0];
					$weightPreAll1 = [1];
					for($k=0;$k<1000;$k++){
	
						$weightPreAll1 = $weightPreAll0;
						$weightPreAll0 = $weight;
	
						for($i=0;$i<$sizeOfArray;$i++)$weightPre1[$i] = $weightPre0[$i];
						for($i=0;$i<$sizeOfArray;$i++)$weightPre0[$i] = round($weight[$i],3);
	
						/*print_r($weightPre0);
						echo "0<br />";
						print_r($weightPre1);
						echo "1<br />";
						print_r($weightPreAll0);
						echo "0<br />";
						print_r($weightPreAll1);*/
						if($weightPre0 == $weightPre1){
							//echo $k."번째 부터 같음";
							$k = 10000;
						}
						//echo "1<br />";
						//echo "-------------------------------<br />";
		
						for($i=0;$i<$sizeOfArray;$i++){
							$weightTempValue = 0;
							$weightTempValuePre = 0;
							for($j=0;$j<$sizeOfArray;$j++){
								$weightTempValue += $weight[$j] * $inputMatrix[$i][$j];
								//$weightTempValuePre += $weightPreAll0[$j] * $inputMatrix[$i][$j];
								$weightTempValuePre += $weightPreAll1[$j] * $inputMatrix[$i][$j];
							}
							$weightAfter[$i] = $weightTempValue;
							$weightAfterPre[$i] = $weightTempValuePre;
						}
						$weightSum = array_sum($weightAfter);
						$weightSumPre = array_sum($weightAfterPre);
							for($i=0;$i<$sizeOfArray;$i++){
								$weight[$i] = $weightAfter[$i]/$weightSum;
							}
						}

						//print_r($weightAfter);
						//echo "<br />";

						//print_r(substr($weight[0],0,5));
						//print_r($weightPreAll0);
						//echo "<== 고유치법 가중치 최종 결과값<br />";

					//$eigenValue = ($weightSumPre-$sizeOfArray)/($sizeOfArray-1); // 고유치법 값 계산

					//$eigenValue = ($weightSum-$sizeOfArray)/($sizeOfArray-1);
					$eigenValue = ($weightSumPre-$sizeOfArray)/($sizeOfArray-1);
					
					echo "고유치법 최종 값 (CI): ".$eigenValue."<br>";
					//echo "<br />";
					
					$eigenValue = round($eigenValue,11);

					$weightMatrix = array();
					for($i=0;$i<$sizeOfArray;$i++){
						for($j=0;$j<$sizeOfArray;$j++){
							$sumColumn = 0;
							for($k=0;$k<$sizeOfArray;$k++){
								$sumColumn += $inputMatrix[$k][$j];
							}
							$weightMatrix[$i][$j] = $inputMatrix[$i][$j]/$sumColumn;
						}
					}
					//print_r($weightMatrix);
					//echo "<== 가중치 매트릭스<br />";

					$confidenceIntervalMatrix = array();
					for($i=0;$i<$sizeOfArray;$i++){
						for($j=0;$j<$sizeOfArray;$j++){
							$confidenceIntervalMatrix[$i][$j] = $inputMatrix[$i][$j]*array_sum($weightMatrix[$j])/$sizeOfArray;
						}
					}

					//print_r($confidenceIntervalMatrix);
					//echo "<== CI 매트릭스<br />";

					$CIweights = array();
					for($i=0;$i<$sizeOfArray;$i++){
						$CIweights[$i] = array_sum($weightMatrix[$i])/$sizeOfArray;
					}

					//print_r($CIweights);
					//echo "<== CI 매트릭스 최종 가중치 (평균법 문항 값) <br />";

					$lamdaMax = 0;
					for($i=0;$i<$sizeOfArray;$i++){
						$lamdaMax += array_sum($confidenceIntervalMatrix[$i])/array_sum($weightMatrix[$i]);
					}

					//print_r($lamdaMax);
					//echo "<== 람다_max<br />";

					$averageMethodValue = ($lamdaMax-$sizeOfArray)/($sizeOfArray-1);

					//echo '평균법 최종 값 (평균법 CI) : '.$averageMethodValue;
					//echo "<br />";
					$averageMethodValue = round($averageMethodValue,11);

					$geometricWeight = array();
					$geometricPowSum = 0;
					for($i=0;$i<$sizeOfArray;$i++){
						$geometricPowSum += pow(array_product($inputMatrix[$i]),1/$sizeOfArray);
					}

					//print_r($geometricPowSum);
					//echo "<== 기하평균 제곱합<br />";

					$importance = array();

					for($i=0;$i<$sizeOfArray;$i++){
						$importance[$i] = pow(array_product($inputMatrix[$i]),1/$sizeOfArray)/$geometricPowSum;
					}

					//print_r($importance);
					//echo "<== 비중 (기하평균 문항 값)<br />";

					$finalWeight = array();
					$weightTempValue = array();

					for($i=0;$i<$sizeOfArray;$i++){
						$weightTempValue[$i] = 0;
						for($j=0;$j<$sizeOfArray;$j++){
							$weightTempValue[$i] += $importance[$j] * $inputMatrix[$i][$j];
						}
						$finalWeight[$i] = $weightTempValue[$i]/$importance[$i];
					}

					/*print_r($finalWeight);
					echo "<== 최종 계산<br />";

					print_r($weightTempValue);
					echo "<== 최종 가중치<br />";*/

					$geometricMeanValue = (array_sum($finalWeight)/$sizeOfArray-$sizeOfArray)/($sizeOfArray-1);

					//echo '기하평균법 최종 값 (기하평균 CI): '.$geometricMeanValue;
					//echo "<br />";
					$geometricMeanValue = round($geometricMeanValue,11);

				// 고유치 공식 종료 

				//exit;

				for($ik=0; $ik<sizeof($title_last_arr); $ik++){
					$quiz_val = $weightPreAll0[$ik]; 
					if($quiz_val <= 0){
						$quiz_val = 0;
					}
					######## 고유치 시작 ############
					$query_in = "insert into wise_analysis_report_decision_100data_detail set"; 
					$query_in .= " decision_option_idx = '".$decision_option_idx."', ";
					$query_in .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query_in .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query_in .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query_in .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[$ik]."', ";
					$query_in .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					$query_in .= " wdate = now() ";
					//echo $query_in."<br>";
					$result_in = mysqli_query($gconnet,$query_in);
					######## 고유치 종료 ############
				}	
					
					$quiz_val = $eigenValue;
					if($quiz_val <= 0){
						$quiz_val = 0;
					}
					
					######## 일관성지수 체크 시작 ############
					if($opt2_i == 0){ // 첫번째 뭉텅이 시작 
						if($ilk_option_case_no){
							if($quiz_val >= $ilk_option_case_no){
								$ilk_yn = "N";
							} else {
								$ilk_yn = "Y";
							}
						} else {
							$ilk_yn = "";
						}
					} else { // 첫번째 뭉텅이 종료
						$ilk_yn = "";
					}
					######## 일관성지수 체크 종료 ############

					$query_in2 = "insert into wise_analysis_report_decision_100data_detail set"; 
					$query_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
					$query_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query_in2 .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query_in2 .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[0]."_CI', ";
					$query_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					if($ilk_yn){
						$query_in2 .= " analysis_report_decision_100data_ilk_yn = '".$ilk_yn."', ";
					}
					$query_in2 .= " wdate = now() ";
					//echo $query_in2."<br>";
					$result_in = mysqli_query($gconnet,$query_in2);
					

				for($ik=0; $ik<sizeof($title_last_arr); $ik++){	
					$quiz_val = $CIweights[$ik];
					if($quiz_val <= 0){
						$quiz_val = 0;
					}
					######## 평균 시작 ############
					$query2_in = "insert into wise_analysis_report_decision_100data_detail2 set"; 
					$query2_in .= " decision_option_idx = '".$decision_option_idx."', ";
					$query2_in .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query2_in .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[$ik]."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					$query2_in .= " wdate = now() ";
					//echo $query2_in."<br>";
					$result_in = mysqli_query($gconnet,$query2_in);
					######## 평균 종료 ############
				}
					
					$quiz_val = $averageMethodValue;
					if($quiz_val <= 0){
						$quiz_val = 0;
					}

					//echo "detail2 opt2_i = ".$opt2_i."<br>";
					//echo "detail2 ilk_option_case_no = ".$ilk_option_case_no."<br>";	
					//echo "detail2 quiz_val = ".$quiz_val."<br>";	
					######## 일관성지수 체크 시작 ############
					if($opt2_i == 0){ // 첫번째 뭉텅이 시작 
						if($ilk_option_case_no){
							if($quiz_val >= $ilk_option_case_no){
								$ilk_yn = "N";
							} else {
								$ilk_yn = "Y";
							}
						} else {
							$ilk_yn = "";
						}
					} else { // 첫번째 뭉텅이 종료
						$ilk_yn = "";
					}
					//echo "detail2 ilk_yn = ".$ilk_yn."<br>";	
					######## 일관성지수 체크 종료 ############

					$query2_in2 = "insert into wise_analysis_report_decision_100data_detail2 set"; 
					$query2_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
					$query2_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query2_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[0]."_CI', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					if($ilk_yn){
						$query2_in2 .= " analysis_report_decision_100data_ilk_yn = '".$ilk_yn."', ";
					}
					$query2_in2 .= " wdate = now() ";
					//echo $query2_in2."<br>";
					$result_in = mysqli_query($gconnet,$query2_in2);

				for($ik=0; $ik<sizeof($title_last_arr); $ik++){	
					$quiz_val = $importance[$ik];
					if($quiz_val <= 0){
						$quiz_val = 0;
					}
					######## 기하평균 시작 ############
					$query2_in = "insert into wise_analysis_report_decision_100data_detail3 set"; 
					$query2_in .= " decision_option_idx = '".$decision_option_idx."', ";
					$query2_in .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query2_in .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[$ik]."', ";
					$query2_in .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					$query2_in .= " wdate = now() ";
					//echo $query2_in."<br>";
					$result_in = mysqli_query($gconnet,$query2_in);
					######## 기하평균 종료 ############
				}
					
					$quiz_val = $geometricMeanValue;
					if($quiz_val <= 0){
						$quiz_val = 0;
					}

					######## 일관성지수 체크 시작 ############
					if($opt2_i == 0){ // 첫번째 뭉텅이 시작 
						if($ilk_option_case_no){
							if($quiz_val >= $ilk_option_case_no){
								$ilk_yn = "N";
							} else {
								$ilk_yn = "Y";
							}
						} else {
							$ilk_yn = "";
						}
					} else { // 첫번째 뭉텅이 종료
						$ilk_yn = "";
					}
					######## 일관성지수 체크 종료 ############

					$query2_in2 = "insert into wise_analysis_report_decision_100data_detail3 set"; 
					$query2_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
					$query2_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
					$query2_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_no = '".$decision_100data_quiz_no."', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_title = '".$title_last_arr[0]."_CI', ";
					$query2_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val."', ";
					if($ilk_yn){
						$query2_in2 .= " analysis_report_decision_100data_ilk_yn = '".$ilk_yn."', ";
					}
					$query2_in2 .= " wdate = now() ";
					//echo $query2_in2."<br>";
					$result_in = mysqli_query($gconnet,$query2_in2);

					//exit;
				
			} // 최고 레벨까지 루프 종료   
			
	} // 웅답자 루프 종료 

	##################### 전체 AHP 데이터 인서트 시작 ###############
	$file_1_quizno = "";
	$file_1_title = "";

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
	
	// 고유치법 토탈 
	for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
		$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		
		$data_100_model_no = "1";
		$quiz_val_1 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg",$ilk_option_case_no); // 평균값
		$quiz_val_2 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg2",$ilk_option_case_no); // 기하평균값
		
		$query2_in2 = "insert into wise_analysis_report_decision_100data_detail_total set"; 
		$query2_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query2_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
		$query2_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_model_no = '".$data_100_model_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_title = '".$file_1_title2."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val_1."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val2 = '".$quiz_val_2."', ";
		$query2_in2 .= " wdate = now() ";
		//echo $query2_in2."<br>";
		$result_in = mysqli_query($gconnet,$query2_in2);
	}

	// 평균 토탈 
	for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
		$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		
		$data_100_model_no = "2";
		$quiz_val_1 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg",$ilk_option_case_no); // 평균값
		$quiz_val_2 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg2",$ilk_option_case_no); // 기하평균값
		
		$query2_in2 = "insert into wise_analysis_report_decision_100data_detail_total set"; 
		$query2_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query2_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
		$query2_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_model_no = '".$data_100_model_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_title = '".$file_1_title2."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val_1."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val2 = '".$quiz_val_2."', ";
		$query2_in2 .= " wdate = now() ";
		//echo $query2_in2."<br>";
		$result_in = mysqli_query($gconnet,$query2_in2);
	}

	// 기하평균 토탈 
	for($opt_i=0; $opt_i<sizeof($file_1_title_arr); $opt_i++){
		$file_1_title2 = trim($file_1_title_arr[$opt_i]);
		
		$data_100_model_no = "3";
		$quiz_val_1 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg",$ilk_option_case_no); // 평균값
		$quiz_val_2 = get_calcurate_decision_avg($data_100_model_no,$decision_option_idx,$file_1_title2,"avg2",$ilk_option_case_no); // 기하평균값
		
		$query2_in2 = "insert into wise_analysis_report_decision_100data_detail_total set"; 
		$query2_in2 .= " decision_option_idx = '".$decision_option_idx."', ";
		$query2_in2 .= " decision_option_100data_idx = '".$decision_option_100data_idx."', ";
		$query2_in2 .= " analysis_report_decision_100data_no = '".$decision_100data_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_model_no = '".$data_100_model_no."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_title = '".$file_1_title2."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val = '".$quiz_val_1."', ";
		$query2_in2 .= " analysis_report_decision_100data_quiz_val2 = '".$quiz_val_2."', ";
		$query2_in2 .= " wdate = now() ";
		//echo $query2_in2."<br>";
		$result_in = mysqli_query($gconnet,$query2_in2);
	}
	##################### 전체 AHP 데이터 인서트 종료 ###############
	
	//exit;

	$inc_report_query_2 = "update wise_analysis_myreport set report_status='com',report_edate=now() where 1 and idx='".trim($inc_report_row['idx'])."'"; 
	//echo $inc_report_query_2."<br>";
	$inc_report_result_2 = mysqli_query($gconnet,$inc_report_query_2);

	$from_email = "cs@surveyin.kr";
	$from_name = "데이터인";
	$to_email = $inc_report_row['report_email'];

	$subject = "[데이터인] 의사결정모델 보고서가 생성 되었습니다.";
		
	$content = "
		<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:646px;border:1px solid #dddddd;border-top:3px solid #3e4348;\">
       <tr>
        <td colspan=\"3\" style=\"height:23px;\"></td>
    </tr>
    <tr>
        <td style=\"width:56px;\"></td>
        <td style=\"width:533px;\">
            <table cellpadding=\"0\" cellspacing=\"0\" style=\"width:533px;height:209px;\">
                <tr>
                    <td style=\"height:43px;border-bottom:2px solid #333;font-weight:bold;font-size:20px;font-family:'맑은 고딕','Malgun Gothic';color:#333333;\">안녕하세요, 데이터 인 입니다.</td>
                </tr>
                <tr>
                    <td style=\"height:70px;background-color:#f7f7f7;\"></td>
                </tr>
                <tr>
                    <td style=\"text-align:center;font-weight:bold;font-size:16px;font-family:'돋움','Dotum';color:#333333;line-height:23px;background-color:#f7f7f7;\">설정하신 옵션에 따른 의사결정모델 보고서 생성이 완료 되었습니다.</td>
                </tr>
                <tr>
                    <td style=\"height:12px;background-color:#f7f7f7;\"></td>
                </tr>
                 <tr>
                    <td style=\"text-align:center;font-weight:bold;font-size:16px;font-family:'돋움','Dotum';color:#333333;line-height:23px;background-color:#f7f7f7;\">'나의 보고서 관리' 메뉴를 통해서 보고서를 다운로드 하실 수 있습니다.</td>
                </tr>
				<tr>
                    <td style=\"height:12px;background-color:#f7f7f7;\"></td>
                </tr>
                <tr>
                    <td style=\"text-align:center;font-size:13px;font-family:'돋움','Dotum';color:#666666;line-height:16px;background-color:#f7f7f7;\"><font style=\"font-size:16px;color:#e03f4e;font-weight:bold;\"><a href='http://surveyin.kr/report/my-report.php' target='_blank'>http://surveyin.kr/report/my-report.php</a></td>
                </tr>
                <tr>
                    <td style=\"height:70px;border-bottom:1px solid #ddd;background-color:#f7f7f7;\"></td>
                </tr>
             </table>
        </td>
        <td style=\"width:55px;\"></td>
    </tr>
    <tr>
        <td colspan=\"3\" style=\"height:45px;\"></td>
    </tr>
   </table>
		";
	
	mail_utf($from_email,$from_name,$to_email,$subject,$content);

} // 보고서 추출대상 루프 종료 

	error_frame("보고서 생성이 완료 되었습니다.");
?>