<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));

	if($satisfaction_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_satisfaction_option where 1 and idx='".$satisfaction_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			error_go("다시 진행해주세요.","manjok_1.php");
		}

		$row = mysqli_fetch_array($compet_info_query);
	} else {
		error_go("다시 진행해주세요.","manjok_1.php");
	}

	/*$sub_sql_1 = "select idx,quiz_title from wise_analysis_quiz where analysis_idx = '".$row['analysis_report_idx']."' and quiz_delete='N' and idx in (select analysis_report_satisfaction_option_factor_no from wise_analysis_report_satisfaction_option_model_quiz where 1 and analysis_report_satisfaction_option_factor_type='P' and satisfaction_option_idx='".$satisfaction_option_idx."') order by quiz_title asc";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);

	for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
		$sub_row_1 = mysqli_fetch_array($sub_query_1);

		if($sub_i_1 == ($sub_cnt_1-1)){
			$cate_code1_arr .= $sub_row_1['idx'];
			$cate_name1_arr .= $sub_row_1['quiz_title'];
		} else {
			$cate_code1_arr .= $sub_row_1['idx']."|";
			$cate_name1_arr .= $sub_row_1['quiz_title']."|";
		}
	}*/

    // 추세점수 기준년도
    $base_year = $row['analysis_report_satisfaction_option_base_year'];
	
    // 추세점수 CSI(종합만족도) 추가
    $cate_code1_arr = "csi|";
    $cate_name1_arr = "CSI(종합만족도)|";
    $cate_type1_arr = "csi|";

	$sub_sql_1 = "select idx,analysis_report_satisfaction_option_variable_title from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and idx in (select satisfaction_option_model_idx from wise_analysis_report_satisfaction_option_model_quiz where 1 and satisfaction_option_idx='".$satisfaction_option_idx."') order by idx asc";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);

	for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
		$sub_row_1 = mysqli_fetch_array($sub_query_1);

		$cate_code1_arr .= $sub_row_1['idx']."|";
		$cate_name1_arr .= $sub_row_1['analysis_report_satisfaction_option_variable_title']."|";
		$cate_type1_arr .= "model|";

		$sub_sql_2 = "select idx,quiz_title from wise_analysis_quiz where 1 and quiz_delete='N' and idx in (select analysis_report_satisfaction_option_factor_no from wise_analysis_report_satisfaction_option_model_quiz where 1 and analysis_report_satisfaction_option_factor_type='P' and satisfaction_option_idx='".$satisfaction_option_idx."' and satisfaction_option_model_idx='".$sub_row_1['idx']."') order by idx asc";
		$sub_query_2 = mysqli_query($gconnet,$sub_sql_2);
		$sub_cnt_2 = mysqli_num_rows($sub_query_2);

		for($sub_i_2=0; $sub_i_2<$sub_cnt_2; $sub_i_2++){
			$sub_row_2 = mysqli_fetch_array($sub_query_2);

			$cate_code1_arr .= $sub_row_2['idx']."|";
			$cate_name1_arr .= $sub_row_2['quiz_title']."|";
			$cate_type1_arr .= "quiz_p|";
		}

		$sub_sql_3 = "select idx,quiz_title from wise_analysis_quiz where 1 and quiz_delete='N' and idx in (select analysis_report_satisfaction_option_factor_no from wise_analysis_report_satisfaction_option_model_quiz where 1 and analysis_report_satisfaction_option_factor_type='C' and satisfaction_option_idx='".$satisfaction_option_idx."' and satisfaction_option_model_idx='".$sub_row_1['idx']."') order by idx asc";
		$sub_query_3 = mysqli_query($gconnet,$sub_sql_3);
		$sub_cnt_3 = mysqli_num_rows($sub_query_3);

		for($sub_i_3=0; $sub_i_3<$sub_cnt_3; $sub_i_3++){
			$sub_row_3 = mysqli_fetch_array($sub_query_3);

			$cate_code1_arr .= $sub_row_3['idx']."|";
			$cate_name1_arr .= $sub_row_3['quiz_title']."|";
			$cate_type1_arr .= "quiz_c|";
		}

	}
	
	//echo "cate_name1_arr = ".$cate_name1_arr."<br>";
	$cate_code1_arr2 = explode("|",$cate_code1_arr);
	$cate_name1_arr2 = explode("|",$cate_name1_arr);
	$cate_type1_arr2 = explode("|",$cate_type1_arr);

	$sql_file_1 = "select * from wise_analysis_report_satisfaction_option_compare where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_action_compare_type='C' order by idx asc"; // 추세점수 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 1;
	}

	$sql_file_2 = "select * from wise_analysis_report_satisfaction_option_compare where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_action_compare_type='V' order by idx asc"; // 벤치마킹 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
	if($query_file_2_cnt == 0){
		$query_file_2_cnt = 1;
	}
?>
<body>
    <header>
        <div class="logo">
            <img src="./img/logo.png" alt="">
        </div>
        <div class="menu">
            <ul>
                <li><a href="javascript:;">분석</a></li>
                <li><a href="javascript:;">통합리포팅</a></li>
            </ul>
        </div>
    </header>
    <section>
        <div class="body_w">
       <form name="frm" action="manjok_4_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
				<input type="hidden" name="satisfaction_option_model_status" id="satisfaction_option_model_status" value=""/>
				<input type="hidden" id="satisfaction_option_idx" name="satisfaction_option_idx" value="<?=$satisfaction_option_idx?>"> 
				<input type="hidden" id="cate_code1_arr" name="cate_code1_arr" value="<?=$cate_code1_arr?>">    
				<input type="hidden" id="cate_name1_arr" name="cate_name1_arr" value="<?=$cate_name1_arr?>">    
				<input type="hidden" id="cate_type1_arr" name="cate_type1_arr" value="<?=$cate_type1_arr?>">    
		   <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro">
               <? include "./inc/gnb.php"; ?>
			   <div class="m_paging man">
                    <div class="page_wrap">
                        <ul>
                            <li>
                                <p class="numbering"><span>1</span></p>
                                <p>조사정보입력</p>
                            </li>
                            <li>
                                <p class="numbering"><span>2</span></p>
                                <p>분석모델설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span>3</span></p>
                                <p>분석옵션설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span class="on_num">4</span></p>
                                <p>비교점수입력</p>
                            </li>
                            <li>
                                <p class="numbering"><span>5</span></p>
                                <p>분석</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="guide_c">
                    <div class="cover_gc default">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>각 부분에 대한 설명이 출력됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력창에 마우스를 올려보세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab1">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>년도 입력창에는 숫자만 입력가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>엑셀에서 한 행씩 복사 & 붙여넣기가 가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>데이터 붙여넣기는 숫자만 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 해당 줄의 입력값이 초기화됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 새로운 테이블이 한 줄 추가됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>이름 입력창에는 벤치마킹집단의 이름이 입력되어야합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>엑셀에서 한 행씩 복사 & 붙여넣기가 가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>데이터 붙여넣기는 숫자만 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 해당 테이블이 삭제됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_table">
                    <div class="table_wrap">
                        <div class="table_r">
                            <div class="tr_title trtop">
                                <h1>
                                     추세점수 비교입력
                                </h1>
                                <div class="attr-table">
                                    <div class="table1_ok">
                                        <label for="t1_ok">
                                            <input type="radio" name="table1_view" value="table_yes" id="t1_ok">
                                            <span>반영</span>
                                        </label>
                                    </div>
                                    <div class="table1_no">
                                        <label for="t1_no">
                                            <input type="radio" checked name="table1_view" value="table_not" id="t1_no">
                                            <span>미반영</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="attr-table">
                                    <div class="table1_ok">
                                        <label for="t1_ok">
                                            <span>기준년도</span>
                                            <input type="number" placeholder="(년도입력) 년도" name="score_compare_base_year" value="<?=$base_year?>">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tr_wrap tablew content-rd">
                                   <div class="tr_th">
                                        <table  class="tabb1">
                                            <tr>
                                                <th>문항명</th>
                                            </tr>
                                       <?for($sub_i=0; $sub_i<sizeof($cate_code1_arr2); $sub_i++){
										   if($cate_code1_arr2[$sub_i]){
										   ?>   
												<tr>
													<th><?=$cate_name1_arr2[$sub_i]?></th>
												</tr>
											<?}?>
										<?}?>
                                        </table>
                                    </div>
                                    <div class="tr_width ">
                                        <div class="tr_tr content-xd">
									<?
									for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
										$row_file_1 = mysqli_fetch_array($query_file_1);
									?>
										<!-- 추세점수 시작 -->
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input class="tabb1 susik-t" type="number" placeholder="(년도입력) 년도" name="score_compare_year[]" value="<?=$row_file_1['analysis_report_satisfaction_option_action_compare_year']?>">
                                                        <button type="button" class="table_del tabb5">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                        <button type="button" class="table_re tabb2">
                                                            <img src="./img/return_sq.png" alt="">
                                                        </button>
                                                        <div class="table_add tabb3">
                                                                <button type="button">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                        </div>
                                                    </td>
                                                </tr>
											<?for($sub_i=0; $sub_i<sizeof($cate_code1_arr2); $sub_i++){
												if($cate_code1_arr2[$sub_i]){
													$sc_val = get_data_colname("wise_analysis_report_satisfaction_option_compare_list","satisfaction_option_idx",$satisfaction_option_idx,"analysis_report_satisfaction_option_quiz_value"," and satisfaction_option_compare_idx='".$row_file_1['idx']."' and analysis_report_satisfaction_option_quiz_no='".$cate_code1_arr2[$sub_i]."'");
												?>   
													<tr>
														<td>
															<input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number" value="<?=$sc_val?>">
														</td>
													</tr>
												<?}?>
											<?}?>
                                           </table>
										<!-- 추세점수 종료 -->
									<?}?>
                                        </div>
                                    </div>
                              </div>
                        </div><div class="table_r2 tabb4">
                            <div class="tr2_title trtop">
                                <h1>
                                     벤치마킹 집단 점수입력
                                </h1>
                                <div class="attr-table">
                                    <div class="table2_ok">
                                        <label for="t2_ok">
                                            <input type="radio" name="table2_view" value="table_yes" id="t2_ok">
                                            <span>반영</span>
                                        </label>
                                    </div>
                                    <div class="table2_no">
                                        <label for="t2_no">
                                            <input type="radio" checked name="table2_view" value="table_not" id="t2_no">
                                            <span>미반영</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="tr2_wrap tablew  content-rd">
                                   <div class="tr2_th">
                                        <table class="">
                                            <tr>
                                                <th>문항명</th>
                                            </tr>
                                        <?for($sub_i=0; $sub_i<sizeof($cate_code1_arr2); $sub_i++){
										   if($cate_code1_arr2[$sub_i]){
										   ?>   
												<tr>
													<th><?=$cate_name1_arr2[$sub_i]?></th>
												</tr>
											<?}?>
										<?}?>
                                        </table>
                                    </div>
                                    <div class="tr2_width ">
                                        <div class="tr2_tr tr_tr content-xd">
									<?
									for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
										$row_file_2 = mysqli_fetch_array($query_file_2);
									?>
										<!-- 벤치마킹 시작 -->
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" class="susik-t" placeholder="(이름입력)" name="score_vench_year[]" value="<?=$row_file_2['analysis_report_satisfaction_option_action_compare_year']?>">
                                                        <button type="button" class="table_del tabb5">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                        <button type="button" class="table_re tabb2">
                                                            <img src="./img/return_sq.png" alt="">
                                                        </button>
                                                        <div class="table_addr tabb3">
                                                                <button type="button">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                        </div>
                                                    </td>
                                                </tr>
											<?for($sub_i=0; $sub_i<sizeof($cate_code1_arr2); $sub_i++){
												if($cate_code1_arr2[$sub_i]){
													$sc_val = get_data_colname("wise_analysis_report_satisfaction_option_compare_list","satisfaction_option_idx",$satisfaction_option_idx,"analysis_report_satisfaction_option_quiz_value"," and satisfaction_option_compare_idx='".$row_file_2['idx']."' and analysis_report_satisfaction_option_quiz_no='".$cate_code1_arr2[$sub_i]."'");
												?>   
													<tr>
														<td>
															 <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number" value="<?=$sc_val?>">
														</td>
													</tr>
												<?}?>
											<?}?>
                                            </table>
										<!-- 벤치마킹 종료 -->
									<?}?>
                                        </div>
                                    </div>
                               </div>
                        </div>
                    </div>
                </div>
				
				<div class="sumt_w">
                    <div class="sum_tl">
                        <span>변수총계</span>
                        <span>:</span>
                        <span id="count_scompare_area">0</span>
                   </div>
                   <div class="sum_tr">
                       <span>변수총계</span>
                       <span>:</span>
                       <span id="count_vtot_area">0</span>
                   </div>
                </div>

            </div>
            <div class="btn_all">
                <div class="left_btn" onclick="location.href='manjok_3.php?satisfaction_option_idx=<?=$satisfaction_option_idx?>';">
                    <button>이전 단계</button>
                </div>
               <div class="center_btn">
                    <div class="center_b1">
                        <button type="button" onclick="frm.reset();">초기화</button>
                    </div>
                    <div class="center_b2">
                        <button type="button" onclick="go_tmp_submit();">임시 저장</button>
                    </div>
                </div>
                <div class="right_btn">
                    <button type="button" onclick="go_submit();">다음 단계</button>
                </div>
            </div>
        </div>
                
        <!--<div class="m4_pop m2_pop">
            <div class="m2p_wrap">
                <p class="bun_ment">분석을 시작합니다<br/>분석이 시작된 이후엔 설정변경이 안됩니다.<br> 분석을 진행하시겠습니까?</p>
                <div class="ok_btn">
                    <button type="button">확인</button>
                </div>
            </div>
        </div>-->

    <? include "./inc/common_pop.php"; ?> 

    </section>
    
	<? include "./inc/footer.php"; ?>


<script>

$(function(){
	$('.mindmap').mindmap();
});
    
    $(document).ready(function(){
    
        $(".content-rd").mCustomScrollbar({
                        theme:"light-3",
                    });
    
        


    });

$( function() {
  $(".selectable").bind("mousedown", function(e) {
    e.metaKey = true;
  }).selectable();
  $( ".selectable" ).selectable({
    filter : 'li:not(.selectable-disabled)',
    selected: function(event, ui) {
      if (!$(ui.selected).hasClass('selected-flag')) {
        $(ui.selected).addClass('selected-flag');
      } else {
        $(ui.selected).removeClass("ui-selected selected-flag");
      }
    }
  });
  
});
    
    
	function go_submit() {
		$("#satisfaction_option_model_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.action = "manjok_4_action.php";
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#satisfaction_option_model_status").val("tmp"); // 임시저장
		frm.action = "manjok_4_action.php";
		frm.submit();
	}  
	
	function set_count_scompare(){
		//alert("aa");
		frm.action = "manjok_4_count_scompare.php";
		frm.submit();
	}   
       
</script>


</body>
</html>
