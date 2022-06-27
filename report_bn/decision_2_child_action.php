<? include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="/report_bn/js/common_js.js"></script>

<?
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));
	$child_pknum = trim(sqlfilter($_REQUEST['child_pknum']));
	$child_mode = trim(sqlfilter($_REQUEST['child_mode']));
	$child_level = trim(sqlfilter($_REQUEST['child_level']));
	
	echo "child_pknum = ".$child_pknum."<br>";
	echo "child_mode = ".$child_mode."<br>";

	//echo('<pre>'); print_r($_REQUEST); echo('</pre>'); exit;

	$factor_no_x_g = $_REQUEST['factor_no_x_g']; // 표본특성문항
	$factor_no_x_g_arr = explode('<li id="',$factor_no_x_g);

	echo "<pre>";
	//print_r($_REQUEST);
	print_r($factor_no_x_g_arr);
	echo "</pre>";

	if($child_pknum == "P"){ // 모델명일때 
		
		####### option_model 시작 ##########
		$analysis_report_decision_option_model_title = trim(sqlfilter($_REQUEST['decision_option_model_title_p']));
		$sql_pre = "select idx from wise_analysis_report_decision_option_model where 1 and decision_option_idx='".$decision_option_idx."'"; 
		$result_pre  = mysqli_query($gconnet,$sql_pre);
		if(mysqli_num_rows($result_pre) == 0){
			$query = "insert into wise_analysis_report_decision_option_model set"; 
			$query .= " decision_option_idx = '".$decision_option_idx."', ";
			$query .= " analysis_report_decision_option_model_title = '".$analysis_report_decision_option_model_title."', ";
			$query .= " wdate = now() ";
			$result = mysqli_query($gconnet,$query);
		} else {
			$query = "update wise_analysis_report_decision_option_model set"; 
			$query .= " analysis_report_decision_option_model_title = '".$analysis_report_decision_option_model_title."'";
			$query .= " where 1 and decision_option_idx='".$decision_option_idx."'";
			$result = mysqli_query($gconnet,$query);
		}
		####### option_model 종료 ##########
		
	echo "<pre>";
	print_r($query);
	echo "</pre>";

		$sql_pre2 = "select idx from wise_analysis_report_decision_option_model where 1 and decision_option_idx='".$decision_option_idx."' order by idx desc limit 0,1"; 
		$result_pre2  = mysqli_query($gconnet,$sql_pre2);
		$mem_row2 = mysqli_fetch_array($result_pre2);
		$decision_option_model_idx = $mem_row2[idx]; 

		####### option_model_quiz 시작 ##########
		
		if($child_mode != "mod"){ // 삭제시작
			$sql_group_del = "delete from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx = '".$decision_option_idx."'";
			$result_group_del = mysqli_query($gconnet,$sql_group_del);

			$sql_group_del = "delete from wise_analysis_report_decision_option_model_quiz_view where 1 and decision_option_idx = '".$decision_option_idx."'";
			$result_group_del = mysqli_query($gconnet,$sql_group_del);
		}	
		echo "cnt = ".sizeof($factor_no_x_g_arr)."<br>";

		if($child_mode == "minus"){ // 삭제시작
			
			/*$query_sub = "delete from wise_analysis_report_decision_option_model_quiz where 1"; 
			$query_sub .= " and decision_option_model_idx='".$decision_option_model_idx."'";*/
			
			$query_sub = "delete from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx = '".$decision_option_idx."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

			$query_sub = "delete from wise_analysis_report_decision_option_model_quiz_view where 1 and decision_option_idx = '".$decision_option_idx."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

		} elseif($child_mode == "add"){ // 추가시작 

			for($i=1; $i<sizeof($factor_no_x_g_arr); $i++){
				$desicion_option_data_arr2 = explode('<a href="javascript:',$factor_no_x_g_arr[$i]);
				$desicion_option_data_arr3 = explode(';"',$desicion_option_data_arr2[1]);

				$desicion_option_data2_arr2 = explode('style="display:',$factor_no_x_g_arr[$i]);
				$desicion_option_data2_arr3 = explode(';"',$desicion_option_data2_arr2[1]);

				$desicion_option_data3_arr2 = explode('placeholder="',$factor_no_x_g_arr[$i]);
				$desicion_option_data3_arr3 = explode('"',$desicion_option_data3_arr2[1]);
				
				$analysis_report_decision_option_model_quiz_no = trim($desicion_option_data_arr3[0]);
				$analysis_report_decision_option_model_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_model_quiz_no,"quiz_type","");

				if($_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.'']){
					$analysis_report_decision_option_model_quiz_title = $_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.''];
				} else {
					$analysis_report_decision_option_model_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_model_quiz_no,"quiz_title","");
				}
				
				$view_yn = (trim($desicion_option_data2_arr3[0]) == "none") ? trim($desicion_option_data2_arr3[0]) : "";
				$view_title = trim($desicion_option_data3_arr3[0]);

					echo "quiz_title = ".$analysis_report_decision_option_model_quiz_title."<br>";
					
					$sql_pre4 = "select idx from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx = '".$decision_option_model_idx."' and analysis_report_decision_option_model_quiz_no='".$analysis_report_decision_option_model_quiz_no."'"; 

					echo "sql_pre4 => ".$sql_pre4."<br>";
					$result_pre4  = mysqli_query($gconnet,$sql_pre4);
					if(mysqli_num_rows($result_pre4) == 0){
						$query_sub = "insert into wise_analysis_report_decision_option_model_quiz set"; 
						$query_sub .= " decision_option_idx = '".$decision_option_idx."', ";
						$query_sub .= " decision_option_model_idx = '".$decision_option_model_idx."', ";
						$query_sub .= " analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."', ";
						$query_sub .= " decision_option_model_quiz_level = '1', ";
						$query_sub .= " decision_option_model_quiz_group = '1', ";
						$query_sub .= " analysis_report_decision_option_model_quiz_type = '".$analysis_report_decision_option_model_quiz_type."', ";
						$query_sub .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."', ";
						$query_sub .= " view_yn = '".$view_yn."', ";
						$query_sub .= " view_title = '".$view_title."', ";
						$query_sub .= " wdate = now()";
						echo $query_sub."<br>";
						$result_sub = mysqli_query($gconnet,$query_sub);
					}

						$query_sub2 = "insert into wise_analysis_report_decision_option_model_quiz_view set"; 
						$query_sub2 .= " decision_option_idx = '".$decision_option_idx."', ";
						$query_sub2 .= " decision_option_model_idx = '".$decision_option_model_idx."', ";
						$query_sub2 .= " analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."', ";
						$query_sub2 .= " decision_option_model_quiz_level = '1', ";
						$query_sub2 .= " decision_option_model_quiz_group = '1', ";
						$query_sub2 .= " analysis_report_decision_option_model_quiz_type = '".$analysis_report_decision_option_model_quiz_type."', ";
						$query_sub2 .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."', ";
						$query_sub2 .= " view_yn = '".$view_yn."', ";
						$query_sub2 .= " view_title = '".$view_title."', ";
						$query_sub2 .= " wdate = now()";
						$result_sub = mysqli_query($gconnet,$query_sub2);
			}

		} // 추가종료 
		####### option_model_quiz 종료 ##########
		
	} else { // 퀴즈일때
		
		//echo "child_mode = ".$child_mode."<br>";

		if($child_mode == "mod"){ // 옵션이름 수정시작  

			$analysis_report_decision_option_model_quiz_title = $_REQUEST['decision_option_model_title_'.$child_pknum.''];
			$analysis_report_decision_option_model_quiz_no = $child_pknum;

			$query_sub = "update wise_analysis_report_decision_option_model_quiz set"; 
			$query_sub .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."' ";
			$query_sub .= " where 1 and decision_option_idx = '".$decision_option_idx."' and analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."' and decision_option_model_quiz_level='".$child_level."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

			$query_sub = "update wise_analysis_report_decision_option_model_quiz_view set"; 
			$query_sub .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."' ";
			$query_sub .= " where 1 and decision_option_idx = '".$decision_option_idx."' and analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."' and decision_option_model_quiz_level='".$child_level."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

		} elseif($child_mode == "minus"){ // 옵션이름 수정끝. 삭제시작
			
			$child_del_level = $child_level+1;

			$query_sub = "delete from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx = '".$decision_option_idx."'"; 
			$query_sub .= " and decision_option_model_quiz_parent='".$child_pknum."' and decision_option_model_quiz_level > '".$child_level."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

			$query_sub = "delete from wise_analysis_report_decision_option_model_quiz_view where 1 and decision_option_idx = '".$decision_option_idx."'"; 
			$query_sub .= " and decision_option_model_quiz_parent='".$child_pknum."' and decision_option_model_quiz_level > '".$child_level."'";
			$result_sub = mysqli_query($gconnet,$query_sub);

			/*$sql_min = "select decision_option_model_quiz_level as min_lev from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_quiz_parent='".$child_pknum."'"; 
			//echo "sql_min = ".$sql_min."<br>";
			$result_min  = mysqli_query($gconnet,$sql_min);
			$row_min = mysqli_fetch_array($result_min);

			$sql_max = "select max(decision_option_model_quiz_level) as max_lev from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."'"; 
			//echo "sql_max = ".$sql_max."<br>";
			$result_max  = mysqli_query($gconnet,$sql_max);
			$row_max = mysqli_fetch_array($result_max);

			for($i_pre=$row_min['min_lev']; $i_pre<=$row_max['max_lev']; $i_pre++){
				$sql_pre2 = "select idx,analysis_report_decision_option_model_quiz_no from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_quiz_level='".$i_pre."'";
				$result_pre2  = mysqli_query($gconnet,$sql_pre2);

				for($i_pre2=0; $i_pre2<mysqli_num_rows($result_pre2); $i_pre2++){
					$result_row2 = mysqli_fetch_array($result_pre2);

					$query_sub = "delete from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx = '".$decision_option_idx."'"; 
					$query_sub .= " and decision_option_model_quiz_parent='".$result_row2['analysis_report_decision_option_model_quiz_no']."'";
					//echo "query_sub = ".$query_sub."<br>";
					$result_sub  = mysqli_query($gconnet,$query_sub);
					
				}

				$query_sub2 = "delete from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_quiz_level='".$i_pre."'"; 
				//echo "query_sub2 = ".$query_sub2."<br><br>";
				$result_sub2  = mysqli_query($gconnet,$query_sub2);
				
			}*/

		} else { // 추가시작 
			
			echo "factor_no_x_g_arr = ".$factor_no_x_g_arr."<br>";

			$sql_pre2 = "select idx from wise_analysis_report_decision_option_model where 1 and decision_option_idx='".$decision_option_idx."' order by idx desc limit 0,1"; 
			$result_pre2  = mysqli_query($gconnet,$sql_pre2);
			$mem_row2 = mysqli_fetch_array($result_pre2);
			$decision_option_model_idx = $mem_row2[idx]; 

			$sql_pre3 = "select decision_option_model_quiz_level from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx = '".$decision_option_model_idx."' and analysis_report_decision_option_model_quiz_no='".$child_pknum."' order by idx desc limit 0,1"; 
			echo $sql_pre3."<br>";
			$result_pre3  = mysqli_query($gconnet,$sql_pre3);
			$mem_row3 = mysqli_fetch_array($result_pre3);
			$option_model_quiz_level = $mem_row3['decision_option_model_quiz_level']; 
			$option_model_quiz_level_next = $mem_row3['decision_option_model_quiz_level']+1; 
			echo $option_model_quiz_level."<br>";

			$sql_pre4 = "select decision_option_model_quiz_group from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' order by idx desc limit 0,1"; 
			$result_pre4  = mysqli_query($gconnet,$sql_pre4);
			$mem_row4 = mysqli_fetch_array($result_pre4);
			$option_model_quiz_group = $mem_row4['decision_option_model_quiz_group']; 
			$option_model_quiz_group_next = $mem_row4['decision_option_model_quiz_group']+1; 

			####### option_model_quiz 시작 ##########

			for($i=1; $i<sizeof($factor_no_x_g_arr); $i++){
				$desicion_option_data_arr2 = explode('<a href="javascript:',$factor_no_x_g_arr[$i]);
				$desicion_option_data_arr3 = explode(';"',$desicion_option_data_arr2[1]);

				$desicion_option_data2_arr2 = explode('style="display:',$factor_no_x_g_arr[$i]);
				$desicion_option_data2_arr3 = explode(';"',$desicion_option_data2_arr2[1]);

				$desicion_option_data3_arr2 = explode('placeholder="',$factor_no_x_g_arr[$i]);
				$desicion_option_data3_arr3 = explode('"',$desicion_option_data3_arr2[1]);
		
				$analysis_report_decision_option_model_quiz_no = trim($desicion_option_data_arr3[0]);
				$view_yn = (trim($desicion_option_data2_arr3[0]) == "none") ? trim($desicion_option_data2_arr3[0]) : "";
				$view_title = trim($desicion_option_data3_arr3[0]);

				$analysis_report_decision_option_model_quiz_type = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_model_quiz_no,"quiz_type","");
				
				if($_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.'']){
					$analysis_report_decision_option_model_quiz_title = $_REQUEST['decision_option_model_title_'.$analysis_report_decision_option_model_quiz_no.''];
				} else {
					$analysis_report_decision_option_model_quiz_title = get_data_colname("wise_analysis_quiz","idx",$analysis_report_decision_option_model_quiz_no,"quiz_title","");
				}

				echo "level = ".$option_model_quiz_level." / title = ".$analysis_report_decision_option_model_quiz_title."<br>"; 
				
				//$sql_pre4 = "select idx from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx = '".$decision_option_model_idx."' and analysis_report_decision_option_model_quiz_no='".$analysis_report_decision_option_model_quiz_no."' and decision_option_model_quiz_level = '".$option_model_quiz_level."'"; 

				$sql_pre4 = "select idx from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx = '".$decision_option_model_idx."' and analysis_report_decision_option_model_quiz_no='".$analysis_report_decision_option_model_quiz_no."'"; 

				echo $sql_pre4."<br>";
				$result_pre4  = mysqli_query($gconnet,$sql_pre4);
				
				if(mysqli_num_rows($result_pre4) == 0){
					$query_sub = "insert into wise_analysis_report_decision_option_model_quiz set"; 
					$query_sub .= " decision_option_idx = '".$decision_option_idx."', ";
					$query_sub .= " decision_option_model_idx = '".$decision_option_model_idx."', ";
					$query_sub .= " decision_option_model_quiz_parent = '".$child_pknum."', ";
					$query_sub .= " decision_option_model_quiz_level = '".$option_model_quiz_level_next."', ";
					$query_sub .= " decision_option_model_quiz_group = '".$option_model_quiz_group_next."', ";
					$query_sub .= " analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."', ";
					$query_sub .= " analysis_report_decision_option_model_quiz_type = '".$analysis_report_decision_option_model_quiz_type."', ";
					$query_sub .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."', ";
					$query_sub .= " view_yn = '".$view_yn."', ";
					$query_sub .= " view_title = '".$view_title."', ";
					$query_sub .= " wdate = now()";
					echo $query_sub."<br>";
					$result_sub = mysqli_query($gconnet,$query_sub);
				}

					$query_sub2 = "insert into wise_analysis_report_decision_option_model_quiz_view set"; 
					$query_sub2 .= " decision_option_idx = '".$decision_option_idx."', ";
					$query_sub2 .= " decision_option_model_idx = '".$decision_option_model_idx."', ";
					$query_sub2 .= " decision_option_model_quiz_parent = '".$child_pknum."', ";
					$query_sub2 .= " decision_option_model_quiz_level = '".$option_model_quiz_level_next."', ";
					$query_sub2 .= " decision_option_model_quiz_group = '".$option_model_quiz_group_next."', ";
					$query_sub2 .= " analysis_report_decision_option_model_quiz_no = '".$analysis_report_decision_option_model_quiz_no."', ";
					$query_sub2 .= " analysis_report_decision_option_model_quiz_type = '".$analysis_report_decision_option_model_quiz_type."', ";
					$query_sub2 .= " analysis_report_decision_option_model_quiz_title = '".$analysis_report_decision_option_model_quiz_title."', ";
					$query_sub2 .= " view_yn = '".$view_yn."', ";
					$query_sub2 .= " view_title = '".$view_title."', ";
					$query_sub2 .= " wdate = now()";
					echo $query_sub2."<br>";
					$result_sub2 = mysqli_query($gconnet,$query_sub2);
			}
			####### option_model_quiz 종료 ##########

		} // 추가종료
		
	} // 모델명, 퀴즈 모두 종료 
?>
	<script>
		//$("#factor_no_x_g", parent.document).val("");
	</script>