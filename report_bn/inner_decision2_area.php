<? include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	//echo('<pre>'); print_r($_REQUEST); echo('</pre>');

	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));
	$decision_option_model_idx = trim(sqlfilter($_REQUEST['decision_option_model_idx']));
	$analysis_report_decision_option_model_quiz_no = trim(sqlfilter($_REQUEST['decision_option_model_quiz_parent']));
	$next_quiz_level = trim(sqlfilter($_REQUEST['next_quiz_level']));
	/*
	echo "<pre>";
	print_r($_REQUEST);
	echo "</pre>";
	*/
	
	if($analysis_report_decision_option_model_quiz_no){
		$sql_file_2 = "select * from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx='".$decision_option_model_idx."' and decision_option_model_quiz_parent = '".$analysis_report_decision_option_model_quiz_no."' and decision_option_model_quiz_level='".$next_quiz_level."' order by idx asc";
	} else {
		$sql_file_2 = "select * from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx='".$decision_option_model_idx."' and (decision_option_model_quiz_parent = '' or decision_option_model_quiz_parent is null) and decision_option_model_quiz_level='".$next_quiz_level."' order by idx asc";
	}
	//echo $sql_file_2."<br>";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);

	$next_quiz_level = $next_quiz_level+1;

	//echo "inner decision model <br>";
?>
								<?
									for($opt_i2=0; $opt_i2<$query_file_2_cnt; $opt_i2++){ // 하위 카운트 루프 시작 
										$row_file_2 = mysqli_fetch_array($query_file_2);

										$sql_file_3 = "select idx from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx='".$decision_option_model_idx."' and decision_option_model_quiz_parent = '".$row_file_2['analysis_report_decision_option_model_quiz_no']."' and decision_option_model_quiz_level='".$next_quiz_level."' order by idx asc";
										$query_file_3 = mysqli_query($gconnet,$sql_file_3);
										$query_file_3_cnt = mysqli_num_rows($query_file_3);
										//echo $query_file_3_cnt. " : ". $sql_file_3."<br>";
										
										if($row_file_2['view_yn'] == "none" && $row_file_2['view_title'] != "") {
											$row_file_2['view_yn'] = "";
										}
									?>
										<li id="ql_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag children__item" <?if($row_file_2['view_yn'] == "none"){?>style="display: none;"<?}?>>
											<div class="node ui-selectee ui-selected selected-flag">
												<span class="close ui-selectee" style="">
													<button type="button" class="ui-selectee"><img src="../report_bn/img/remove.png" alt="" class="ui-selectee"></button>
												</span>
									            
												<a href="javascript:<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="<?=$row_file_2['analysis_report_decision_option_model_quiz_title']?>"></a>

												<input class="dec_in ui-selectee" type="text" placeholder="<?=$row_file_2['view_title']?>" title="<?=$row_file_2['analysis_report_decision_option_model_quiz_title']?>" style="" name="decision_option_model_title_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" value="<?=$row_file_2['view_title']?>" onblur="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','mod','<?=$row_file_2['decision_option_model_quiz_level']?>');" readonly>
												
												<div class="score_div ui-selectee ui-selected selected-flag">
													<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="decision_option_model_title_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" class="left_input_score ui-selectee" style="" onblur="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','mod','<?=$row_file_2['decision_option_model_quiz_level']?>');">
												</div>
												<?php
												if($row_file_2['decision_option_model_quiz_level'] < 4) {	// 최대 4단계까지 
												?>
												<div class="dec_bwrap ui-selectee" style="">
												<?if($query_file_3_cnt > 0){ // 하위 카운트 있을때 시작 ?>
													<div class="dec_add dec_add1 ui-selectee displayNone">
														<button type="button" class="ui-selectee btn-secondary btn-plus" level="<?=$row_file_2['decision_option_model_quiz_level']?>" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','add','<?=$row_file_2['decision_option_model_quiz_level']?>');">+</button>
													</div>
													<div class="dec_min dec_min1 ui-selectee">
														<button type="button" class="ui-selectee btn-outline-secondary btn-minus" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','minus','<?=$row_file_2['decision_option_model_quiz_level']?>');">-</button>
													</div>
												<?}else{?>
													<div class="dec_add dec_add1 ui-selectee">
														<button type="button" class="ui-selectee btn-secondary btn-plus" level="<?=$row_file_2['decision_option_model_quiz_level']?>" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','add','<?=$row_file_2['decision_option_model_quiz_level']?>');">+</button>
													</div>
													<div class="dec_min dec_min1 ui-selectee displayNone">
														<button type="button" class="ui-selectee btn-outline-secondary btn-minus" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','minus','<?=$row_file_2['decision_option_model_quiz_level']?>');">-</button>
													</div>
												<?}?>
												</div>
												<?php
												}
												?>
											</div>
												
											<script src="/report_bn/js/common_js.js"></script>
											<?if($query_file_3_cnt > 0){ // 하위 카운트 있을때 시작 ?>
												<ol class="children confirmed" id="decision2_area_<?=$next_quiz_level?>_<?=$row_file_2['idx']?>" level="<?=$next_quiz_level?>">
													<!-- inner_decision2_area.php 에서 불러옴 -->
												</ol>
												<script>
													get_data("/report_bn/inner_decision2_area.php","decision2_area_<?=$next_quiz_level?>_<?=$row_file_2['idx']?>","decision_option_idx=<?=$decision_option_idx?>&decision_option_model_idx=<?=$decision_option_model_idx?>&decision_option_model_quiz_parent=<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>&next_quiz_level=<?=$next_quiz_level?>");
												</script>
											<?} // 하위 카운트 있을때 종료 ?>
										</li>
									 <?} // 하위 카운트 루프 종료 ?>