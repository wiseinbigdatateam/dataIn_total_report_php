<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;
	
	/*for($i=0; $i<$attach_count_1; $i++){
		$factor_no_x_p_arr2 = explode('<div id="mCSB_4" class="mCustomScrollBox mCS-light-3 mCSB_vertical mCSB_inside ui-selectee" tabindex="0" style="max-height: none;">',$factor_no_x_p_arr[$i]);
		echo "라인 = ".$i."<br>";
		
		$factor_no_x_p_arr3 = explode('<a href="javascript:',$factor_no_x_p_arr2[1]);
		for($k=1; $k<sizeof($factor_no_x_p_arr3); $k++){
			//echo "순차 ".$k." = ".$factor_no_x_p_arr3[$k]."<br><br><br>";
			$factor_no_x_p_arr4 = explode(';"',$factor_no_x_p_arr3[$k]);
			echo "독립변수 ".$k." = ".trim($factor_no_x_p_arr4[0])."<br>";
		}
		
		//echo $factor_no_x_c_arr[$i];
		$factor_no_x_c_arr2 = explode('<a href="javascript:',$factor_no_x_c_arr[$i]);
		$factor_no_x_c_arr3 = explode(';"',$factor_no_x_c_arr2[1]);
		echo "<br>종속변수 ".$i." = ".trim($factor_no_x_c_arr3[0])."<br><br>";

	}*/
	
	$satisfaction_option_model_status = trim(sqlfilter($_REQUEST['satisfaction_option_model_status']));
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$attach_count_1 = trim(sqlfilter($_REQUEST['attach_count_1'])); // 독립변수 갯수
	$attach_count_2 = trim(sqlfilter($_REQUEST['attach_count_2'])); // 종속변수 갯수

	if(!$satisfaction_option_idx){  
		error_frame_go("다시 진행해주세요.","manjok_1.php");
	}

	$factor_no_x_p = $_REQUEST['factor_no_x_p'];
	$factor_no_x_p_arr = explode('||',$factor_no_x_p);
	$factor_no_x_c = $_REQUEST['factor_no_x_c'];
	$factor_no_x_c_arr = explode('||',$factor_no_x_c);
	/*$factor_no_m_p = $_REQUEST['factor_no_m_p'];
	$factor_no_m_p_arr = explode('||',$factor_no_m_p);
	$factor_no_m_c = $_REQUEST['factor_no_m_c'];
	$factor_no_m_c_arr = explode('||',$factor_no_m_c);*/
	$factor_no_y_p = $_REQUEST['factor_no_y_p'];
	$factor_no_y_p_arr = explode('||',$factor_no_y_p);
	$factor_no_y_c = $_REQUEST['factor_no_y_c'];
	$factor_no_y_c_arr = explode('||',$factor_no_y_c);

	//echo "요소변수 : ".$factor_no_x_c."<br>";
	//exit;

	$option_variable_x_title = $_REQUEST['option_variable_x_title'];
	$variable_x_elementweight = $_REQUEST['variable_x_elementweight'];
	$variable_x_weight = $_REQUEST['variable_x_weight'];
	$option_variable_m_title = trim(sqlfilter($_REQUEST['option_variable_m_title']));
	$variable_m_weight = trim(sqlfilter($_REQUEST['variable_m_weight']));
	$factor_no_m_p = trim($_REQUEST['factor_no_m_p']);
	$option_variable_y_title = $_REQUEST['option_variable_y_title'];

	if($option_variable_m_title){
		$factor_no_m_p_arr2 = explode('<li id="',$factor_no_m_p);
		if(!$factor_no_m_p_arr2[1]){
			error_frame("세부 항목 변수를 입력해 주세요.");
		}
	} else {
		$factor_no_m_p_arr2 = explode('<li id="',$factor_no_m_p);
		if($factor_no_m_p_arr2[1]){
			if(!$option_variable_m_title){
				error_frame("세부항목 변수가 설정된 변수명을 입력해 주세요.");
			}
		}
	}
	
	//echo "option_variable_y_title = ".$option_variable_y_title[0]."<br>"; exit;
	for($i=0; $i<$attach_count_2; $i++){
		$option_variable_y_title_arr = $option_variable_y_title[$i];
		$factor_no_y_p = $factor_no_y_p_arr[$i];

		if($option_variable_y_title_arr){
			$factor_no_y_p_arr2 = explode('<li id="',$factor_no_y_p);
			if(!$factor_no_y_p_arr2[1]){
				error_frame("세부 항목 변수를 입력해 주세요.");
			}
		} else {
			$factor_no_y_p_arr2 = explode('<li id="',$factor_no_y_p_arr[0]);
			if($factor_no_y_p_arr2[1]){
				if(!$option_variable_y_title_arr){
					error_frame("세부항목 변수가 설정된 변수명을 입력해 주세요.");
				}
			}
		}
	}

	$variable_weight_cnt = 0;
	for($i=0; $i<$attach_count_1; $i++){
		$satisfaction_option_variable_weight = $variable_x_weight[$i];
		if($satisfaction_option_variable_weight){
			$factor_no_x_p_arr2 = explode('<li id="',$factor_no_x_p_arr[$i]);
			//echo "factor_no_x_p_arr = ".$factor_no_x_p_arr2[1]."<br>";
			$variable_weight_cnt = $variable_weight_cnt+1;
			if(!$factor_no_x_p_arr2[1]){
				error_frame("가중치가 설정된 변수를 설정해주세요.");
			}
		}
	}

	if($variable_m_weight){
		$factor_no_m_p_arr2 = explode('<li id="',$factor_no_m_p);
		if(!$factor_no_m_p_arr2[1]){
			error_frame("가중치가 설정된 변수를 설정해주세요.");
		}
	}

	//exit;

	for($i=0; $i<$attach_count_1; $i++){
		$satisfaction_option_variable_title = $option_variable_x_title[$i];
		$satisfaction_option_variable_weight = $variable_x_weight[$i];
		$factor_no_x_c_arr2 = explode('<a href="javascript:',$factor_no_x_c_arr[$i]);
		$factor_no_x_c_arr3 = explode(';"',$factor_no_x_c_arr2[1]);
		if($factor_no_x_c_arr3[0]  && ($variable_weight_cnt > 0)){ // 요소변수가 있을때 시작 
			$satisfaction_option_variable_element = "Y";
			$satisfaction_option_variable_elementweight = $variable_x_elementweight[$i];
			// if(!$satisfaction_option_variable_elementweight){
			// 	error_frame("요소만족도의 가중치를 모두 입력해 주세요.");
			// }
		} else {
			// if($variable_x_elementweight[$i]){
			// 	error_frame("요소만족도를 입력해 주세요.");
			// }
		}

		if(!$satisfaction_option_variable_weight && ($variable_weight_cnt > 0)){
			error_frame("가중치를 모두 입력해 주세요.");
		}

		if($satisfaction_option_variable_title){
			$factor_no_x_p_arr2 = explode('<a href="javascript:',$factor_no_x_p_arr[$i]);
			$factor_no_x_p_arr3 = explode(';"',$factor_no_x_p_arr2[1]);
			if(!$factor_no_x_p_arr2[1]){
				error_frame("세부 항목 변수를 입력해 주세요.");
			}
		} else {
			$factor_no_x_p_arr2 = explode('<a href="javascript:',$factor_no_x_p_arr[$i]);
			$factor_no_x_p_arr3 = explode(';"',$factor_no_x_p_arr2[1]);
			if($factor_no_x_p_arr2[1]){
				if(!$satisfaction_option_variable_title){
					error_frame("세부 항목 변수가 설정된 변수명을 입력해주세요.");
				}
			} else {
				error_frame("만족도 모델을 입력해 주세요.");
			}
		}
		
	}

	if($option_variable_m_title){
		if(!$variable_m_weight){
			//error_frame("중간변수의 가중치를 입력해 주세요.");
		}
	}

	/*$prev_sql = "select idx from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."'";
	$prev_query = mysqli_query($gconnet,$prev_sql);
	if(mysqli_num_rows($prev_query) == 0){ // 최초 등록일때만 시작 */

	$sql_group_del = "delete from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group_del = mysqli_query($gconnet,$sql_group_del);

	$sql_group2_del = "delete from wise_analysis_report_satisfaction_option_model_quiz where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."'";
	$result_group2_del = mysqli_query($gconnet,$sql_group2_del);
		
		######### 독립변수 저장 시작 ############
			$satisfaction_option_variable_type = "X";
		
			for($i=0; $i<$attach_count_1; $i++){
				$satisfaction_option_variable_title = $option_variable_x_title[$i];
				$satisfaction_option_variable_weight = $variable_x_weight[$i];
				$factor_no_x_c_arr2 = explode('<a href="javascript:',$factor_no_x_c_arr[$i]);
				$factor_no_x_c_arr3 = explode(';"',$factor_no_x_c_arr2[1]);
				//echo "요소변수 : ".$factor_no_x_c_arr[$i]."<br>";
				//exit;
				if($factor_no_x_c_arr3[0]){
					$satisfaction_option_variable_element = "Y";
				} else {
					$satisfaction_option_variable_element = "N";
				}
				$satisfaction_option_variable_elementweight = $variable_x_elementweight[$i];

				$query = "insert into wise_analysis_report_satisfaction_option_model set"; 
				$query .= " satisfaction_option_model_status = '".$satisfaction_option_model_status."', ";
				$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query .= " analysis_report_satisfaction_option_variable_type = '".$satisfaction_option_variable_type."', ";
				$query .= " analysis_report_satisfaction_option_variable_title = '".$satisfaction_option_variable_title."', ";
				$query .= " analysis_report_satisfaction_option_variable_weight = '".$satisfaction_option_variable_weight."', ";
				$query .= " analysis_report_satisfaction_option_variable_element = '".$satisfaction_option_variable_element."', ";
				$query .= " analysis_report_satisfaction_option_variable_elementweight = '".$satisfaction_option_variable_elementweight."', ";
				$query .= " wdate = now() ";
				$result = mysqli_query($gconnet,$query);

				//echo "독립변수 저장 쿼리 = ".$query."<br>";

				if(!$result){
					//echo "쿼리오류 발생: " . mysqli_error($gconnet)."<br><Br>";
				}

				$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option_model where 1 order by idx desc limit 0,1"; 
				$result_pre2  = mysqli_query($gconnet,$sql_pre2);
				$mem_row2 = mysqli_fetch_array($result_pre2);
				$satisfaction_option_model_idx = $mem_row2[idx]; 
				
				if($i == 3){
					//echo "자체변수 = ".$factor_no_x_p_arr[$i]."<br>";
					//exit;
				}
				// 자체변수 문항시작 

				//$factor_no_x_p_arr2 = explode('style="position:relative; top:0; left:0;" dir="ltr">',$factor_no_x_p_arr[$i]);
				$factor_no_x_p_arr2 = explode('<li id="',$factor_no_x_p_arr[$i]);
				if($i == 3){
					//echo "자체카운트 1 = ".sizeof($factor_no_x_p_arr2)."<br>";
				}

				if(sizeof($factor_no_x_p_arr2) == 1 && !$factor_no_x_c_arr3[0]){
					$sql_group_del = "delete from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."' and idx = '".$satisfaction_option_model_idx."'";
					$result_group_del = mysqli_query($gconnet,$sql_group_del);
				}
				
				for($k=1; $k<sizeof($factor_no_x_p_arr2); $k++){
					
					$factor_no_x_p_arr3 = explode('<a href="javascript:',$factor_no_x_p_arr2[$k]);
					/*if($i == 3){
						echo "자체카운트 2 = ".sizeof($factor_no_x_p_arr3)."<br>";
					}*/
					$factor_no_x_p_arr4 = explode(';"',$factor_no_x_p_arr3[1]);
					$satisfaction_option_factor_no = $factor_no_x_p_arr4[0];
					$satisfaction_option_factor_type = "P";
					$satisfaction_option_factor_type2 = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_type","");
					$satisfaction_option_factor_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_title","");
				
					$query_quiz = "insert into wise_analysis_report_satisfaction_option_model_quiz set"; 
					$query_quiz .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
					$query_quiz .= " satisfaction_option_model_idx = '".$satisfaction_option_model_idx."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_no = '".$satisfaction_option_factor_no."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type = '".$satisfaction_option_factor_type."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type2 = '".$satisfaction_option_factor_type2."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_title = '".$satisfaction_option_factor_title."', ";
					$query_quiz .= " wdate = now() ";
					$result_quiz = mysqli_query($gconnet,$query_quiz);
					//echo "query_quiz = ".$query_quiz."<br>";
				}

				//exit;

				// 요소변수 문항시작 
				if($factor_no_x_c_arr3[0]){
					$satisfaction_option_factor_no = $factor_no_x_c_arr3[0];
					$satisfaction_option_factor_type = "C";
					$satisfaction_option_factor_type2 = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_type","");
					$satisfaction_option_factor_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_title","");

					$query_quiz = "insert into wise_analysis_report_satisfaction_option_model_quiz set"; 
					$query_quiz .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
					$query_quiz .= " satisfaction_option_model_idx = '".$satisfaction_option_model_idx."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_no = '".$satisfaction_option_factor_no."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type = '".$satisfaction_option_factor_type."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type2 = '".$satisfaction_option_factor_type2."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_title = '".$satisfaction_option_factor_title."', ";
					$query_quiz .= " wdate = now() ";
					$result_quiz = mysqli_query($gconnet,$query_quiz);
				}

			}
		######### 독립변수 저장 종료 ############

		######### 중간변수 저장 시작 ############
			$satisfaction_option_variable_type = "M";
			$satisfaction_option_variable_title = $option_variable_m_title;
			$satisfaction_option_variable_weight = $variable_m_weight;
			$satisfaction_option_variable_element = "N";
			
			$query = "insert into wise_analysis_report_satisfaction_option_model set"; 
			$query .= " satisfaction_option_model_status = '".$satisfaction_option_model_status."', ";
			$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
			$query .= " analysis_report_satisfaction_option_variable_type = '".$satisfaction_option_variable_type."', ";
			$query .= " analysis_report_satisfaction_option_variable_title = '".$satisfaction_option_variable_title."', ";
			$query .= " analysis_report_satisfaction_option_variable_weight = '".$satisfaction_option_variable_weight."', ";
			$query .= " analysis_report_satisfaction_option_variable_element = '".$satisfaction_option_variable_element."', ";
			$query .= " wdate = now() ";
			$result = mysqli_query($gconnet,$query);

			$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option_model where 1 order by idx desc limit 0,1"; 
			$result_pre2  = mysqli_query($gconnet,$sql_pre2);
			$mem_row2 = mysqli_fetch_array($result_pre2);
			$satisfaction_option_model_idx = $mem_row2[idx]; 

			// 자체변수 문항시작
			$factor_no_m_p_arr2 = explode('<li id="',$factor_no_m_p);

			if(sizeof($factor_no_m_p_arr2) == 1){
				$sql_group_del = "delete from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."' and idx = '".$satisfaction_option_model_idx."'";
				$result_group_del = mysqli_query($gconnet,$sql_group_del);
			}

			for($k=1; $k<sizeof($factor_no_m_p_arr2); $k++){
				$factor_no_m_p_arr3 = explode('<a href="javascript:',$factor_no_m_p_arr2[$k]);
				$factor_no_m_p_arr4 = explode(';"',$factor_no_m_p_arr3[1]);
				$satisfaction_option_factor_no = $factor_no_m_p_arr4[0];
				$satisfaction_option_factor_type = "P";
				$satisfaction_option_factor_type2 = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_type","");
				$satisfaction_option_factor_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_title","");
				
				$query_quiz = "insert into wise_analysis_report_satisfaction_option_model_quiz set"; 
				$query_quiz .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query_quiz .= " satisfaction_option_model_idx = '".$satisfaction_option_model_idx."', ";
				$query_quiz .= " analysis_report_satisfaction_option_factor_no = '".$satisfaction_option_factor_no."', ";
				$query_quiz .= " analysis_report_satisfaction_option_factor_type = '".$satisfaction_option_factor_type."', ";
				$query_quiz .= " analysis_report_satisfaction_option_factor_type2 = '".$satisfaction_option_factor_type2."', ";
				$query_quiz .= " analysis_report_satisfaction_option_factor_title = '".$satisfaction_option_factor_title."', ";
				$query_quiz .= " wdate = now() ";
				$result_quiz = mysqli_query($gconnet,$query_quiz);
			}
			// 자체변수 문항종료 

		######### 중간변수 저장 종료 ############

		######### 종속변수 저장 시작 ############
			$satisfaction_option_variable_type = "Y";

			for($i=0; $i<$attach_count_2; $i++){
				$satisfaction_option_variable_title = $option_variable_y_title[$i];
				$satisfaction_option_variable_element = "N";
				
				$query = "insert into wise_analysis_report_satisfaction_option_model set"; 
				$query .= " satisfaction_option_model_status = '".$satisfaction_option_model_status."', ";
				$query .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
				$query .= " analysis_report_satisfaction_option_variable_type = '".$satisfaction_option_variable_type."', ";
				$query .= " analysis_report_satisfaction_option_variable_title = '".$satisfaction_option_variable_title."', ";
				$query .= " wdate = now() ";
				$result = mysqli_query($gconnet,$query);

				$sql_pre2 = "select idx from wise_analysis_report_satisfaction_option_model where 1 order by idx desc limit 0,1"; 
				$result_pre2  = mysqli_query($gconnet,$sql_pre2);
				$mem_row2 = mysqli_fetch_array($result_pre2);
				$satisfaction_option_model_idx = $mem_row2[idx]; 

				// 자체변수 문항시작 
				$factor_no_y_p_arr2 = explode('<li id="',$factor_no_y_p_arr[$i]);

				//echo "y cnt = ".sizeof($factor_no_y_p_arr2)."<br>";

				if(sizeof($factor_no_y_p_arr2) == 1){
					$sql_group_del = "delete from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx = '".$satisfaction_option_idx."' and idx = '".$satisfaction_option_model_idx."'";
					//echo "Y = ".$sql_group_del."<br>";
					$result_group_del = mysqli_query($gconnet,$sql_group_del);
				}

				for($k=1; $k<sizeof($factor_no_y_p_arr2); $k++){

					$factor_no_y_p_arr3 = explode('<a href="javascript:',$factor_no_y_p_arr2[$k]);
					$factor_no_y_p_arr4 = explode(';"',$factor_no_y_p_arr3[1]);
					$satisfaction_option_factor_no = $factor_no_y_p_arr4[0];
					$satisfaction_option_factor_type = "P";
					$satisfaction_option_factor_type2 = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_type","");
					$satisfaction_option_factor_title = get_data_colname("wise_analysis_quiz","idx",$satisfaction_option_factor_no,"quiz_title","");
				
					$query_quiz = "insert into wise_analysis_report_satisfaction_option_model_quiz set"; 
					$query_quiz .= " satisfaction_option_idx = '".$satisfaction_option_idx."', ";
					$query_quiz .= " satisfaction_option_model_idx = '".$satisfaction_option_model_idx."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_no = '".$satisfaction_option_factor_no."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type = '".$satisfaction_option_factor_type."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_type2 = '".$satisfaction_option_factor_type2."', ";
					$query_quiz .= " analysis_report_satisfaction_option_factor_title = '".$satisfaction_option_factor_title."', ";
					$query_quiz .= " wdate = now() ";
					$result_quiz = mysqli_query($gconnet,$query_quiz);
				}

			}

		######### 종속변수 저장 종료 ############

	//} // 최초 등록일때만 종료
	
	if($_REQUEST['satisfaction_option_model_status'] == "com"){
		frame_go("manjok_3.php?satisfaction_option_idx=".$satisfaction_option_idx."");
	} else {
		error_frame("저장되었습니다.");
	}
?>