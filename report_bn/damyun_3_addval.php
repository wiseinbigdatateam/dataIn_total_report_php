<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$analysis_idx = trim(sqlfilter($_REQUEST['analysis_idx']));
	$quiz_no = trim(sqlfilter($_REQUEST['quiz_no']));
	/*$analysis_report_damyun_option_weight_quiz_value = get_data_colname("wise_analysis_quiz","idx",$quiz_no,"quiz_value","");
	
	echo "add val = ".$analysis_report_damyun_option_weight_quiz_value."<br>";
	$display_addval_arr = explode("^",$analysis_report_damyun_option_weight_quiz_value);
	$display_addval_arr_cnt = sizeof($display_addval_arr);*/
	
	$org_quiz_no = get_data_colname("wise_analysis_quiz","idx",$quiz_no,"quiz_no","");
	$sub_sql_1 = "select distinct(data_val) from wise_analysis_data where analysis_idx='".$analysis_idx."' and quiz_no='".$org_quiz_no."' order by data_val asc";
	//echo $sub_sql_1."<br>";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);
?>
	<script>
		$("#query_file_3_cnt").val("<?=$sub_cnt_1?>");
	</script>
<?
	if($sub_cnt_1 > 0){ // 하위집단이 있을때 시작 
?>
										<p>※표본특성문항은 만족도 결과를 집단별로 분석하는 기준변수입니다.</p>
                                        <p>※하위 집단의 수가 최소 30표본 이상이 되도록 구성하시기 바랍니다. ( 예:  20대: 30명, 30대: 50명 O  / 20대 : 4명, 30대: 15명 X)</p>
                                        <div class="da3t_wrap">
                                            <table>
                                                <tr>
                                                    <th><!--직위-->구분</th>
													<th>번호</th>
                                                    <th><!--<input class="auto_title" type="text" value="상향" disabled>-->
                                                    <span>상향평가</span></th>
                                                    <th><!--<input class="auto_title" type="text" value="동료" disabled>-->
                                                    <span>동료평가</span></th>
                                                    <th><!--<input class="auto_title" type="text" value="하향" disabled>-->
                                                    <span>하향평가</span></th>
                                                    <th><span>합계</span></th>
                                                </tr>
									<?
										for($opt_i=0; $opt_i<$sub_cnt_1; $opt_i++){
											$sub_row_1 = mysqli_fetch_array($sub_query_1);
									?>
												<input type="hidden" id="option_weight_estimate_title" name="option_weight_estimate_title_<?=$opt_i?>" value="<?=$sub_row_1['data_val']?>">
                                                <tr class="score_line">
                                                    <th><?//=$sub_row_1['data_val']?></th>
													<td><?=($opt_i+1)?></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pa_1" name="option_weight_estimate_val1_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val1']?>" class="score_da"></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pb_1" name="option_weight_estimate_val2_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val2']?>" class="score_da"></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pc_1" name="option_weight_estimate_val3_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val3']?>" class="score_da"></td>
                                                    <td class="score_sum">
														
													</td>
                                                </tr>
									<?}?>
                                            </table>
                                        </div>
	<?} // 하위집단이 있을때 종료 ?>