<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));

	if($damyun_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_damyun_option where 1 and idx='".$damyun_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			error_go("다시 진행해주세요.","damyun_1.php");
		}

		$row = mysqli_fetch_array($compet_info_query);
	} else {
		error_go("다시 진행해주세요.","damyun_1.php");
	}

	$sql_file_1 = "select * from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx='".$damyun_option_idx."' and analysis_report_damyun_option_samescyn_type = 'C1' order by idx asc"; // 상사
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 1;
	}

	$sql_file_2 = "select * from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx='".$damyun_option_idx."' and analysis_report_damyun_option_samescyn_type = 'C2' order by idx asc"; // 부하
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
	if($query_file_2_cnt == 0){
		$query_file_2_cnt = 1;
	}

	$sql_file_3 = "select * from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx='".$damyun_option_idx."' and analysis_report_damyun_option_samescyn_type = 'C3' order by idx asc"; // 동료
	$query_file_3 = mysqli_query($gconnet,$sql_file_3);
	$query_file_3_cnt = mysqli_num_rows($query_file_3);
	if($query_file_3_cnt == 0){
		$query_file_3_cnt = 1;
	}

	$sql_file_4 = "select * from wise_analysis_report_damyun_option_samescyn where 1 and damyun_option_idx='".$damyun_option_idx."' and analysis_report_damyun_option_samescyn_type = 'C4' order by idx asc"; // 본인
	$query_file_4 = mysqli_query($gconnet,$sql_file_4);
	$query_file_4_cnt = mysqli_num_rows($query_file_4);
	if($query_file_4_cnt == 0){
		$query_file_4_cnt = 1;
	}

	if($row['analysis_report_damyun_option_samescyn_1']){
		$damyun_option_samescyn_1 = $row['analysis_report_damyun_option_samescyn_1'];
	} else {
		$damyun_option_samescyn_1 = "N";
	}
	if($row['analysis_report_damyun_option_samescyn_2']){
		$damyun_option_samescyn_2 = $row['analysis_report_damyun_option_samescyn_2'];
	} else {
		$damyun_option_samescyn_2 = "N";
	}
	if($row['analysis_report_damyun_option_samescyn_3']){
		$damyun_option_samescyn_3 = $row['analysis_report_damyun_option_samescyn_3'];
	} else {
		$damyun_option_samescyn_3 = "N";
	}
	if($row['analysis_report_damyun_option_samescyn_4']){
		$damyun_option_samescyn_4 = $row['analysis_report_damyun_option_samescyn_4'];
	} else {
		$damyun_option_samescyn_4 = "N";
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
		 <form name="frm" action="damyun_2_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="damyun_option_status" id="damyun_option_status" value=""/>
			<input type="hidden" id="damyun_option_idx" name="damyun_option_idx" value="<?=$damyun_option_idx?>">
			<input type="hidden" name="attach_count_1" id="attach_count_1" value="<?=$query_file_1_cnt?>"/> <!-- 상사 입력갯수 -->
			<input type="hidden" name="attach_count_2" id="attach_count_2" value="<?=$query_file_2_cnt?>"/> <!-- 부하 입력갯수 -->
			<input type="hidden" name="attach_count_3" id="attach_count_3" value="<?=$query_file_3_cnt?>"/> <!-- 동료 입력갯수 -->
			<input type="hidden" name="attach_count_4" id="attach_count_4" value="<?=$query_file_4_cnt?>"/> <!-- 본인 입력갯수 -->
			<input type="hidden" id="factor_no_x_p" name="factor_no_x_p"> <!-- 상사 퀴즈배열 -->
			<input type="hidden" id="factor_no_x_p2" name="factor_no_x_p2"> <!-- 부하 퀴즈배열 -->
			<input type="hidden" id="factor_no_x_p3" name="factor_no_x_p3"> <!-- 동료 퀴즈배열 -->
			<input type="hidden" id="factor_no_x_p4" name="factor_no_x_p4"> <!-- 본인 퀴즈배열 -->

			<input type="hidden" id="jongs_check" name="jongs_check"> 
			<input type="hidden" id="jongs_check2" name="jongs_check2"> 
			<input type="hidden" id="jongs_check3" name="jongs_check3"> 
			<input type="hidden" id="jongs_check4" name="jongs_check4"> 

           <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro">
                <? include "./inc/gnb.php"; ?>
			   <div class="m_paging">
                    <div class="page_wrap">
                        <ul>
                            <li>
                                <p class="numbering"><span>1</span></p>
                                <p>조사정보입력</p>
                            </li>
                            <li>
                                <p class="numbering"><span class="on_num">2</span></p>
                                <p>분석모델설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span>3</span></p>
                                <p>분석옵션설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span>4</span></p>
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
                            <span>동일배점 적용여부를 선택해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력 후 추가한 값은 적용되지않습니다. 입력시 해당 탭의 입력값만 적용됩니다. (문항 추가시 재입력)</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>적용안함 선택시, 해당 탭의 입력값만 초기화됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측 문항을 선택 후 " + " 버튼을 클릭시 문항이 추가됩니다. (문항 1개씩만 가능)</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력된 문항의 좌측 " X " 버튼을 클릭시 문항이 삭제됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>하단의 " + " 버튼 클릭시 항목 입력 박스가 추가됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>종속변수 적용 여부를 확인해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 박스 내의 총점 반영이 적용되지않습니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>제목을 입력하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>우측의 “ – “ 버튼을 클릭시 해당 문항입력박스가 삭제됩니다.</span>
                        </div>

                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 항목입력 박스가 추가됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab6">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 해당 줄의 박스가 삭제됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_flow main_dam">
                    <div class="mf_wrap">
                         <div id="tab-menu">
                                <div id="tab-btn">
                                <ul>
                                    <li class="tabbt active" onclick="select_left_quiz('1');"><a>상사</a></li>
                                    <li class="tabbt" onclick="select_left_quiz('3');"><a>동료</a></li>
									<li class="tabbt" onclick="select_left_quiz('2');"><a>부하</a></li>
                                    <li class="tabbt" onclick="select_left_quiz('4');"><a>본인</a></li>
                                </ul>
                                </div>

                                <div id="tab-cont">
                               <!-- 상사 시작 -->     
                                    <div class="s2_l">
                                        <div class="radio_2lt tabb1">
                                            <span>동일배점</span>
                                            <span>
                                                <label for="r2l_no">
                                                    <input type="radio" id="r2l_no" name="damyun_option_samescyn_1" value="N" <?=$damyun_option_samescyn_1=="N"?"checked":""?>>
                                                    적용안함
                                                </label>
                                            </span>
                                            <span>
                                                <label for="r2l_yes">
                                                    <input type="radio" id="r2l_yes" class="r2l_yes" name="damyun_option_samescyn_1" value="Y" <?=$damyun_option_samescyn_1=="Y"?"checked":""?>>
                                                    적용
                                                    <input type="text" class="dis_toggle2" name="damyun_option_samept_1" id="damyun_option_samept_1" value="<?=$row['analysis_report_damyun_option_samept_1']?>" onblur="set_left_score('1');">
                                                </label>
                                            </span>
                                        </div>
                                            <div class="rw_title">
                                                <span>문항선택</span>
                                                <span>배점입력</span>
                                                <span>총점반영</span>
                                                <!-- <span>종속변수</span> -->
                                                <span style="margin-left:44px;">이름입력</span>
                                            </div>
                                        <div class="r2l_wrap  content-rd">
								<?
								for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
									$row_file_1 = mysqli_fetch_array($query_file_1);
								?>
								 <!-- 상사 파트 시작 -->
                                            <div class="rwb_wrap">
                                                <div class="rwb_l tabb2">
                                                    <div class="rbl_boxt">
													<!-- 문항 리스트 시작 -->	
                                                <ul class="box_big ser_big content-rd" id="select_type_x1_p<?=($opt_i+1)?>">
											<?
													$opt_sql = "select * from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_samescyn_idx='".$row_file_1['idx']."' order by idx asc";
													//echo $opt_sql."<br>";
													$opt_query = mysqli_query($gconnet,$opt_sql);
													$opt_cnt = mysqli_num_rows($opt_query);
	
													for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
														$opt_row = mysqli_fetch_array($opt_query);
											?>
													<li id="ql_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag">
														<div class="node ui-selectee ui-selected selected-flag">
															<span class="close ui-selectee" style="">
																<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee mCS_img_loaded"></button>
															</span>
															<a href="javascript:<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="고객만족도2"><?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?></a>
															<input class="dec_in ui-selectee" type="text" style="" placeholder="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>" title="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>">
															<div class="score_div ui-selectee ui-selected selected-flag">
																<input type="text"  name="inc_left_quiz_score_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_score_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" style="" value="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_score']?>" class="left_input_score" onblur="set_calc_quiz_score();">
															</div>
															<!--<span class="jong_div ui-selectee" style="pointer-events: none;">-->
															<span class="jong_div">
																<input type="checkbox" name="inc_left_quiz_tscyn_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_tscyn_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" value="Y" <?=trim($opt_row['analysis_report_damyun_option_samescyn_quiz_tscyn'])=="Y"?"checked":""?> class="ui-selectee" style="">
															</span>
															<?if(trim($opt_row['analysis_report_damyun_option_samescyn_quiz_tscyn']) == "Y"){?>
																<script>$("#inc_left_quiz_tscyn_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>").trigger("click");</script>
															<?}?>
															<div class="dec_bwrap ui-selectee" style="">
																<div class="dec_add dec_add1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
																<div class="dec_min dec_min1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
															</div>
														</div>
													</li>
												<?}?>
												</ul>
											<!-- 문항 리스트 종료 -->		
                                                    </div>
                                                    <div class="rbl_boxb">
                                                        <div class="rbl_btn">
                                                            <div class="rbl_add">
                                                                <button type="button" id="bb_add<?=($opt_i+1)?>">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="rbl_count" id="select_quiz1_cnt<?=($opt_i+1)?>">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rwb_c tabb3" style="display: none;">
                                                    <span class="r_jong">
                                                       	<input type="checkbox" name="damyun_option_samescyn_jongs" id="damyun_option_samescyn_jongs_<?=($opt_i+1)?>" value="Y" <?=trim($row_file_1['analysis_report_damyun_option_samescyn_jongs'])=="Y"?"checked":""?>>
                                                    </span>
													<?if($row_file_1['analysis_report_damyun_option_samescyn_jongs'] == "Y"){?>
														<script>$("#damyun_option_samescyn_jongs_<?=($opt_i+1)?>").trigger("click");</script>
													<?}?>
                                                </div>
                                                <div class="rwb_r" style="
    margin-left: 10px;
">
                                                    <div class="title_wrap">
                                                        <textarea class=" tabb4" name="damyun_option_samescyn_title[]" id="damyun_option_samescyn_title_<?=($opt_i+1)?>" cols="30" rows="10" placeholder="제목"><?=$row_file_1['analysis_report_damyun_option_samescyn_title']?></textarea>
                                                    </div>
                                                    <div class="rwb_minus tabb6">
                                                        <button type="button">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="rwb_bot1" id="rwb_bot1<?=($opt_i+1)?>" <?if(($opt_i+1) == $query_file_1_cnt){}else{?>style="display:none;"<?}?>>
                                                    <button type="button">
                                                        <img src="./img/plus_sq.png" alt="">
                                                    </button>
                                                    <div class="jib_line">
                                                        <div class="line"></div>
                                                    </div>
                                                </div>
                                            </div>
										<?}?>
										 <!-- 상사 파트 종료 -->
                                        </div>
                                        <div class="sum_line">
                                            <!--<div class="by_sum">
                                                <span>변수총계 </span>
                                                <span>:</span>
                                                <span class="gas_num">0</span>
                                            </div>-->
                                            <div class="ga_sum">
                                                <span>배점합계</span>
                                                <span>:</span>
                                                <span class="gas_num">0</span>
                                            </div>
                                        </div>
                                    </div>

								 <!-- 동료 시작 -->     
                                    <div class="s2_l">
                                        <div class="radio_2lt tabb1">
                                            <span>동일배점</span>
                                            <span>
                                                <label for="r2l_no3">
                                                    <input type="radio" id="r2l_no3" name="damyun_option_samescyn_3" value="N" <?=$damyun_option_samescyn_3=="N"?"checked":""?>>
                                                    적용안함
                                                </label>
                                            </span>
                                            <span>
                                                <label for="r2l_yes3">
                                                    <input type="radio" id="r2l_yes3" class="r2l_yes" name="damyun_option_samescyn_3" value="Y" <?=$damyun_option_samescyn_3=="Y"?"checked":""?>>
                                                    적용
                                                    <input type="text" class="dis_toggle2" name="damyun_option_samept_3" id="damyun_option_samept_3" value="<?=$row['analysis_report_damyun_option_samept_3']?>" onblur="set_left_score('3');">
                                                </label>
                                            </span>
                                        </div>
                                            <div class="rw_title">
                                                <span>문항선택</span>
                                                <span>배점입력</span>
                                                <span>총점반영</span>
                                                <!-- <span>종속변수</span> -->
                                                <span style="margin-left:44px;">이름입력</span>
                                            </div>
                                        <div class="r2l_wrap  content-rd">
                                   <?
										for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){
											$row_file_3 = mysqli_fetch_array($query_file_3);
									?>
										<!-- 동료 파트 시작 -->
                                            <div class="rwb_wrap">
                                                <div class="rwb_l tabb2">
                                                    <div class="rbl_boxt">
													<!-- 문항 리스트 시작 -->	
                                                <ul class="box_big ser_big content-rd" id="select_type_x3_p<?=($opt_i+1)?>">
											<?
													$opt_sql = "select * from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_samescyn_idx='".$row_file_3['idx']."' order by idx asc";
													$opt_query = mysqli_query($gconnet,$opt_sql);
													$opt_cnt = mysqli_num_rows($opt_query);
	
													for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
														$opt_row = mysqli_fetch_array($opt_query);
											?>
													<li id="ql_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag">
														<div class="node ui-selectee ui-selected selected-flag">
															<span class="close ui-selectee" style="">
																<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee mCS_img_loaded"></button>
															</span>
															<a href="javascript:<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="고객만족도2"><?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?></a>
															<input class="dec_in ui-selectee" type="text" style="" placeholder="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>" title="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>">
															<div class="score_div ui-selectee ui-selected selected-flag">
																<input type="text"  name="inc_left_quiz_score3_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_score3_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>"  style="" value="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_score']?>" class="left_input_score3" onblur="set_calc_quiz_score3();">
															</div>
															<!--<span class="jong_div ui-selectee" style="pointer-events: none;">-->
															<span class="jong_div">
																<input type="checkbox" name="inc_left_quiz_tscyn3_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_tscyn3_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" value="Y" class="ui-selectee" style="">
															</span>
															<?if($opt_row['analysis_report_damyun_option_samescyn_quiz_tscyn'] == "Y"){?>
																<script>$("#inc_left_quiz_tscyn3_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>").trigger("click");</script>
															<?}?>
															<div class="dec_bwrap ui-selectee" style="">
																<div class="dec_add dec_add1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
																<div class="dec_min dec_min1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
															</div>
														</div>
													</li>
												<?}?>
												</ul>
											<!-- 문항 리스트 종료 -->		
                                                    </div>
                                                    <div class="rbl_boxb">
                                                        <div class="rbl_btn">
                                                            <div class="rbl_add">
                                                                <button type="button" id="bb_add3<?=($opt_i+1)?>">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="rbl_count" id="select_quiz3_cnt<?=($opt_i+1)?>">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rwb_c tabb3" style="display: none;">
                                                   <span class="r_jong">
                                                       	<input type="checkbox" name="damyun_option_samescyn_jongs3" id="damyun_option_samescyn_jongs3_<?=($opt_i+1)?>" value="Y" <?=trim($row_file_3['analysis_report_damyun_option_samescyn_jongs'])=="Y"?"checked":""?>>
                                                    </span>
													<?if($row_file_3['analysis_report_damyun_option_samescyn_jongs'] == "Y"){?>
														<script>$("#damyun_option_samescyn_jongs3_<?=($opt_i+1)?>").trigger("click");</script>
													<?}?>
                                                </div>
                                                <div class="rwb_r" style="
    margin-left: 10px;
">
                                                    <div class="title_wrap">
                                                        <textarea class=" tabb4" name="damyun_option_samescyn_title3[]" id="damyun_option_samescyn_title3_<?=($opt_i+1)?>" cols="30" rows="10" placeholder="제목"><?=$row_file_3['analysis_report_damyun_option_samescyn_title']?></textarea>
                                                    </div>
                                                    <div class="rwb_minus3 tabb6">
                                                        <button type="button">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="rwb_bot3" id="rwb_bot3<?=($opt_i+1)?>" <?if(($opt_i+1) == $query_file_3_cnt){}else{?>style="display:none;"<?}?>>
                                                    <button type="button">
                                                        <img src="./img/plus_sq.png" alt="">
                                                    </button>
                                                    <div class="jib_line">
                                                        <div class="line"></div>
                                                    </div>
                                                </div>
                                            </div>
										<?}?>
										 <!-- 동료 파트 종료 -->     
                                        </div>
                                        <div class="sum_line">
                                            <!--<div class="by_sum">
                                                <span>변수총계 </span>
                                                <span>:</span>
                                                <span class="gas_num">0</span>
                                            </div>-->
                                            <div class="ga_sum">
                                                <span>배점합계</span>
                                                <span>:</span>
                                                <span class="gas_num3">0</span>
                                            </div>
                                        </div>
                                    </div>

                                <!-- 부하 시작 -->    
                                    <div class="s2_l">
                                        <div class="radio_2lt tabb1">
                                            <span>동일배점</span>
                                            <span>
                                                <label for="r2l_no2">
                                                    <input type="radio" id="r2l_no2" name="damyun_option_samescyn_2" value="N" <?=$damyun_option_samescyn_2=="N"?"checked":""?>>
                                                    적용안함
                                                </label>
                                            </span>
                                            <span>
                                                <label for="r2l_yes2">
                                                    <input type="radio" id="r2l_yes2" class="r2l_yes" name="damyun_option_samescyn_2" value="Y" <?=$damyun_option_samescyn_2=="Y"?"checked":""?>>
                                                    적용
                                                    <input type="text" class="dis_toggle2" name="damyun_option_samept_2" id="damyun_option_samept_2" value="<?=$row['analysis_report_damyun_option_samept_2']?>" onblur="set_left_score('2');">
                                                </label>
                                            </span>
                                        </div>
                                            <div class="rw_title">
                                                <span>문항선택</span>
                                                <span>배점입력</span>
                                                <span>총점반영</span>
                                                <!-- <span>종속변수</span> -->
                                                <span style="margin-left:44px;">이름입력</span>
                                            </div>
                                        <div class="r2l_wrap  content-rd">
									<?
										for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
											$row_file_2 = mysqli_fetch_array($query_file_2);
									?>
										<!-- 부하 파트 시작 -->
                                            <div class="rwb_wrap">
                                                <div class="rwb_l tabb2">
                                                    <div class="rbl_boxt">
													<!-- 문항 리스트 시작 -->	
                                                <ul class="box_big ser_big content-rd" id="select_type_x2_p<?=($opt_i+1)?>">
											<?
													$opt_sql = "select * from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_samescyn_idx='".$row_file_2['idx']."' order by idx asc";
													$opt_query = mysqli_query($gconnet,$opt_sql);
													$opt_cnt = mysqli_num_rows($opt_query);
	
													for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
														$opt_row = mysqli_fetch_array($opt_query);
											?>
													<li id="ql_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag">
														<div class="node ui-selectee ui-selected selected-flag">
															<span class="close ui-selectee" style="">
																<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee mCS_img_loaded"></button>
															</span>
															<a href="javascript:<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="고객만족도2"><?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?></a>
															<input class="dec_in ui-selectee" type="text" style="" placeholder="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>" title="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>">
															<div class="score_div ui-selectee ui-selected selected-flag">
																<input type="text"  name="inc_left_quiz_score2_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_score2_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>"  style="" value="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_score']?>" class="left_input_score2" onblur="set_calc_quiz_score2();">
															</div>
															<!--<span class="jong_div ui-selectee" style="pointer-events: none;">-->
															<span class="jong_div">
																<input type="checkbox" name="inc_left_quiz_tscyn2_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_tscyn2_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" value="Y" class="ui-selectee" style="">
															</span>
															<?if($opt_row['analysis_report_damyun_option_samescyn_quiz_tscyn'] == "Y"){?>
																<script>$("#inc_left_quiz_tscyn2_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>").trigger("click");</script>
															<?}?>
															<div class="dec_bwrap ui-selectee" style="">
																<div class="dec_add dec_add1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
																<div class="dec_min dec_min1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
															</div>
														</div>
													</li>
												<?}?>
												</ul>
											<!-- 문항 리스트 종료 -->		
                                                    </div>
                                                    <div class="rbl_boxb">
                                                        <div class="rbl_btn">
                                                            <div class="rbl_add">
                                                                <button type="button" id="bb_add2<?=($opt_i+1)?>">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="rbl_count" id="select_quiz2_cnt<?=($opt_i+1)?>">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rwb_c tabb3" style="display: none;">
                                                   	<span class="r_jong">
                                                       	<input type="checkbox" name="damyun_option_samescyn_jongs2" id="damyun_option_samescyn_jongs2_<?=($opt_i+1)?>" value="Y" <?=trim($row_file_2['analysis_report_damyun_option_samescyn_jongs'])=="Y"?"checked":""?>>
                                                    </span>
													<?if($row_file_2['analysis_report_damyun_option_samescyn_jongs'] == "Y"){?>
														<script>$("#damyun_option_samescyn_jongs2_<?=($opt_i+1)?>").trigger("click");</script>
													<?}?>
                                                </div>
                                                <div class="rwb_r" style="
    margin-left: 10px;
">
                                                    <div class="title_wrap">
                                                        <textarea class=" tabb4" name="damyun_option_samescyn_title2[]" id="damyun_option_samescyn_title2_<?=($opt_i+1)?>" cols="30" rows="10" placeholder="제목"><?=$row_file_2['analysis_report_damyun_option_samescyn_title']?></textarea>
                                                    </div>
                                                    <div class="rwb_minus2 tabb6">
                                                        <button type="button">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="rwb_bot2" id="rwb_bot2<?=($opt_i+1)?>" <?if(($opt_i+1) == $query_file_2_cnt){}else{?>style="display:none;"<?}?>>
                                                    <button type="button">
                                                        <img src="./img/plus_sq.png" alt="">
                                                    </button>
                                                    <div class="jib_line">
                                                        <div class="line"></div>
                                                    </div>
                                                </div>
                                            </div>
										<?}?>
										 <!-- 부하 파트 종료 -->     
										</div>
                                        <div class="sum_line">
                                            <!--<div class="by_sum">
                                                <span>변수총계 </span>
                                                <span>:</span>
                                                <span class="gas_num">0</span>
                                            </div>-->
                                            <div class="ga_sum">
                                                <span>배점합계</span>
                                                <span>:</span>
                                                <span class="gas_num2">0</span>
                                            </div>
                                        </div>
                                    </div>
                              
                               <!-- 본인 시작 -->     
                                    <div class="s2_l">
                                        <div class="radio_2lt tabb1">
                                            <span>동일배점</span>
                                            <span>
                                                <label for="r2l_no4">
                                                    <input type="radio" id="r2l_no4" name="damyun_option_samescyn_4" value="N" <?=$damyun_option_samescyn_4=="N"?"checked":""?>>
                                                    적용안함
                                                </label>
                                            </span>
                                            <span>
                                                <label for="r2l_yes4">
                                                    <input type="radio" id="r2l_yes4" class="r2l_yes" name="damyun_option_samescyn_4" value="Y" <?=$damyun_option_samescyn_4=="Y"?"checked":""?>>
                                                    적용
                                                    <input type="text" class="dis_toggle2" name="damyun_option_samept_4" id="damyun_option_samept_4" value="<?=$row['analysis_report_damyun_option_samept_4']?>" onblur="set_left_score('4');">
                                                </label>
                                            </span>
                                        </div>
                                            <div class="rw_title">
                                                <span>문항선택</span>
                                                <span>배점입력</span>
                                                <span>총점반영</span>
                                                <!-- <span>종속변수</span> -->
                                                <span style="margin-left:44px;">이름입력</span>
                                            </div>
                                        <div class="r2l_wrap  content-rd">
                                    <?
										for($opt_i=0; $opt_i<$query_file_4_cnt; $opt_i++){
											$row_file_4 = mysqli_fetch_array($query_file_4);
									?>
										<!-- 본인 파트 시작 -->
                                            <div class="rwb_wrap">
                                                <div class="rwb_l tabb2">
                                                    <div class="rbl_boxt">
													<!-- 문항 리스트 시작 -->	
                                                <ul class="box_big ser_big content-rd" id="select_type_x4_p<?=($opt_i+1)?>">
											<?
													$opt_sql = "select * from wise_analysis_report_damyun_option_samescyn_quiz where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_samescyn_idx='".$row_file_4['idx']."' order by idx asc";
													$opt_query = mysqli_query($gconnet,$opt_sql);
													$opt_cnt = mysqli_num_rows($opt_query);
	
													for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
														$opt_row = mysqli_fetch_array($opt_query);
											?>
													<li id="ql_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag">
														<div class="node ui-selectee ui-selected selected-flag">
															<span class="close ui-selectee" style="">
																<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee mCS_img_loaded"></button>
															</span>
															<a href="javascript:<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="고객만족도2"><?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?></a>
															<input class="dec_in ui-selectee" type="text" style="" placeholder="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>" title="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_title']?>">
															<div class="score_div ui-selectee ui-selected selected-flag">
																<input type="text"  name="inc_left_quiz_score4_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_score4_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" style="" value="<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_score']?>" class="left_input_score4" onblur="set_calc_quiz_score4();">
															</div>
															<!--<span class="jong_div ui-selectee" style="pointer-events: none;">-->
															<span class="jong_div">
																<input type="checkbox" name="inc_left_quiz_tscyn4_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" id="inc_left_quiz_tscyn4_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>" value="Y" class="ui-selectee" style="">
															</span>
															<?if($opt_row['analysis_report_damyun_option_samescyn_quiz_tscyn'] == "Y"){?>
																<script>$("#inc_left_quiz_tscyn4_<?=$opt_row['analysis_report_damyun_option_samescyn_quiz_no']?>").trigger("click");</script>
															<?}?>
															<div class="dec_bwrap ui-selectee" style="">
																<div class="dec_add dec_add1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
																<div class="dec_min dec_min1 ui-selectee">
																	<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" class="ui-selectee mCS_img_loaded"></button>
																</div>
															</div>
														</div>
													</li>
												<?}?>
												</ul>
											<!-- 문항 리스트 종료 -->		
                                                    </div>
                                                    <div class="rbl_boxb">
                                                        <div class="rbl_btn">
                                                            <div class="rbl_add">
                                                                <button type="button" id="bb_add4<?=($opt_i+1)?>">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="rbl_count" id="select_quiz4_cnt<?=($opt_i+1)?>">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="rwb_c tabb3" style="display: none;">
                                                   	<span class="r_jong">
                                                       	<input type="checkbox" name="damyun_option_samescyn_jongs4" id="damyun_option_samescyn_jongs4_<?=($opt_i+1)?>" value="Y" <?=trim($row_file_4['analysis_report_damyun_option_samescyn_jongs'])=="Y"?"checked":""?>>
                                                    </span>
													<?if($row_file_4['analysis_report_damyun_option_samescyn_jongs'] == "Y"){?>
														<script>$("#damyun_option_samescyn_jongs4_<?=($opt_i+1)?>").trigger("click");</script>
													<?}?>
                                                </div>
                                                <div class="rwb_r" style="
    margin-left: 10px;
">
                                                    <div class="title_wrap">
                                                        <textarea class=" tabb4" name="damyun_option_samescyn_title4[]" id="damyun_option_samescyn_title4_<?=($opt_i+1)?>" cols="30" rows="10" placeholder="제목"><?=$row_file_4['analysis_report_damyun_option_samescyn_title']?></textarea>
                                                    </div>
                                                    <div class="rwb_minus4 tabb6">
                                                        <button type="button">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="rwb_bot4" id="rwb_bot4<?=($opt_i+1)?>" <?if(($opt_i+1) == $query_file_4_cnt){}else{?>style="display:none;"<?}?>>
                                                    <button type="button">
                                                        <img src="./img/plus_sq.png" alt="">
                                                    </button>
                                                    <div class="jib_line">
                                                        <div class="line"></div>
                                                    </div>
                                                </div>
                                            </div>
										<?}?>
									<!-- 본인 파트 종료 -->        
                                        </div>
                                        <div class="sum_line">
                                            <!--<div class="by_sum">
                                                <span>변수총계 </span>
                                                <span>:</span>
                                                <span class="gas_num">0</span>
                                            </div>-->
                                            <div class="ga_sum">
                                                <span>점수총합</span>
                                                <span>:</span>
                                                <span class="gas_num4">0</span>
                                            </div>
                                        </div>
                                    </div>
							<!-- 본인 종료 -->

                                </div>
                            </div>
                     </div>
                </div>
            </div>
            </form>

			<div class="btn_all">
                <div class="left_btn" onclick="location.href='damyun_1.php?damyun_option_idx=<?=$damyun_option_idx?>';">
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

	set_calc_quiz_score();
	set_calc_quiz_score2();
	set_calc_quiz_score3();
	set_calc_quiz_score4();
});

	function set_calc_quiz_score(){
		var sum = 0;
		$('.left_input_score').each(function() {
			var price = Number($(this).val());
			sum = sum+price;
		});
        $('.gas_num').html(sum);
	}

	function set_calc_quiz_score2(){
		var sum = 0;
		$('.left_input_score2').each(function() {
			var price = Number($(this).val());
			sum = sum+price;
		});
        $('.gas_num2').html(sum);
	}

	function set_calc_quiz_score3(){
		var sum = 0;
		$('.left_input_score3').each(function() {
			var price = Number($(this).val());
			sum = sum+price;
		});
        $('.gas_num3').html(sum);
	}

	function set_calc_quiz_score4(){
		var sum = 0;
		$('.left_input_score4').each(function() {
			var price = Number($(this).val());
			sum = sum+price;
		});
        $('.gas_num4').html(sum);
	}

$( function() {
  $(".selectable").bind("mousedown", function(e) {
    e.metaKey = true;
  }).selectable();
  $( ".selectable" ).selectable({
    selected: function(event, ui) {
      if (!$(ui.selected).hasClass('selected-flag')) {
        $(ui.selected).addClass('selected-flag');
        $(ui.selected).removeClass('selectable-disabled');
        $(".side_list li a.on").removeClass('on');
      } else {
        $(ui.selected).removeClass("ui-selected selected-flag");
      }
    }
  });
  
});
</script>

<script>
    $(document).ready(function(){
        // Also see: https://www.quirksmode.org/dom/inputfile.html

        var inputs = document.querySelectorAll('.file-input')

        for (var i = 0, len = inputs.length; i < len; i++) {
        customInput(inputs[i])
        }

        function customInput (el) {
            const fileInput = el.querySelector('[type="file"]')
            const label = el.querySelector('[data-js-label]')

            fileInput.onchange =
            fileInput.onmouseout = function () {
                if (!fileInput.value) return

                var value = fileInput.value.replace(/^.*[\\\/]/, '')
                el.className += ' -chosen'
                label.innerText = value
            }
        }
    });
    
</script>
   
   <script>
    var tabBtn = $("#tab-btn > ul > li");     //각각의 버튼을 변수에 저장
var tabCont = $("#tab-cont > div");       //각각의 콘텐츠를 변수에 저장

//컨텐츠 내용을 숨겨주세요!
tabCont.hide().eq(0).show();

tabBtn.click(function(){
    var target = $(this);         //버튼의 타겟(순서)을 변수에 저장
    var index = target.index();   //버튼의 순서를 변수에 저장
    //alert(index);
    tabBtn.removeClass("active");    //버튼의 클래스를 삭제
    target.addClass("active");    //타겟의 클래스를 추가
    tabCont.css("display","none");
    tabCont.eq(index).css("display", "block");
});

	function select_left_quiz(num){
		if(num == "1"){
			get_data("/report/inner_analysis_quiz2.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		} else if(num == "2"){
			get_data("/report/inner_analysis_quiz2_1.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		} else if(num == "3"){
			get_data("/report/inner_analysis_quiz2_2.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		} else if(num == "4"){
			get_data("/report/inner_analysis_quiz2_3.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		}
	}
    
	function go_submit() {

		// 2021-07-28 추가된 코드

		const tabs = document.querySelectorAll('.s2_l');
		const tabName = ['상사','동료','부하','본인']
		console.log(tabs);
		for(let i = 0; i < tabs.length; i++){
			let vari = tabs[i].querySelectorAll('.rbl_boxt .mCSB_container');
			let variTitle = tabs[i].querySelectorAll('.title_wrap textarea');
			
			for(let j = 0; j < vari.length; j++){
				if(vari[j].innerHTML.length < 100 && variTitle[j].value !== ''){
					alert(tabName[i]+'탭의 세부 항목 변수를 설정해주세요.');
					return false;
				} else if (vari[j].innerHTML.length > 100 && variTitle[j].value == '') {
					alert(tabName[i]+'탭의 세부 항목 변수가 설정된 변수명을 입력해주세요.');
					return false;
					
				} else if (vari[j].innerHTML.length < 100 && variTitle[j].value == '') {
					// alert(tabName[i]+'탭의 세부 항목 변수 및 변수명을 입력해 주세요.');
					// return false;
				}
			}

			let flag = 0;
			let score = tabs[i].querySelectorAll('.item_serv.ui-selectee.ui-selected.selected-flag .score_div.ui-selectee input');

			for(let j = 0; j < score.length; j++){
				if(score[j].value == '' && flag == 0){

				} else if(score[j].value == '' && flag > 0){
					alert(tabName[i]+'탭의 모든 배점을 입력해주세요.');
					return false;
				} else if(score[j].value !== '') {
					flag = 1;
				}
			}
		}


		$("#damyun_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			
			scyn_jongs_check();
			scyn_jongs_check2();
			scyn_jongs_check3();
			scyn_jongs_check4();

			/*var chk = document.getElementsByName("damyun_option_samescyn_jongs");
			var chkcnt = 0;
			for(i=0; i<chk.length;i++){      
				if (chk[i].checked == true){
					chkcnt = chkcnt+1;		
				}
			}
			if(chkcnt > 1){
				alert("상사 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk2 = document.getElementsByName("damyun_option_samescyn_jongs2");
			var chkcnt2 = 0;
			for(i2=0; i2<chk2.length;i2++){      
				if (chk2[i].checked == true){
					chkcnt2 = chkcnt2+1;		
				}
			}
			if(chkcnt2 > 1){
				alert("부하 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk3 = document.getElementsByName("damyun_option_samescyn_jongs3");
			var chkcnt3 = 0;
			for(i3=0; i3<chk3.length;i3++){      
				if (chk3[i].checked == true){
					chkcnt3 = chkcnt3+1;		
				}
			}
			if(chkcnt3 > 1){
				alert("동료 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk4 = document.getElementsByName("damyun_option_samescyn_jongs4");
			var chkcnt4 = 0;
			for(i4=0; i4<chk4.length;i4++){      
				if (chk4[i].checked == true){
					chkcnt4 = chkcnt4+1;		
				}
			}
			if(chkcnt4 > 1){
				alert("본인 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}*/

			var attach_count_1 = Number($("#attach_count_1").val());
			var attach_count_2 = Number($("#attach_count_2").val()); 
			var attach_count_3 = Number($("#attach_count_3").val()); 
			var attach_count_4 = Number($("#attach_count_4").val()); 
							
			var str_type_x_p = "";
			var str_type_x_p2 = "";
			var str_type_x_p3 = "";
			var str_type_x_p4 = "";
			
			$("#factor_no_x_p").val("");
			for(i=1; i<=attach_count_1; i++){
				if (i == attach_count_1){
					str_type_x_p = str_type_x_p+$("#select_type_x1_p"+i+"").html();
				} else {
					str_type_x_p = str_type_x_p+$("#select_type_x1_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p").val(str_type_x_p);
			
			$("#factor_no_x_p2").val("");
			for(i=1; i<=attach_count_2; i++){
				if (i == attach_count_2){
					str_type_x_p2 = str_type_x_p2+$("#select_type_x2_p"+i+"").html();
				} else {
					str_type_x_p2 = str_type_x_p2+$("#select_type_x2_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p2").val(str_type_x_p2);
			
			$("#factor_no_x_p3").val("");
			for(i=1; i<=attach_count_3; i++){
				if (i == attach_count_3){
					str_type_x_p3 = str_type_x_p3+$("#select_type_x3_p"+i+"").html();
				} else {
					str_type_x_p3 = str_type_x_p3+$("#select_type_x3_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p3").val(str_type_x_p3);
			
			$("#factor_no_x_p4").val("");
			for(i=1; i<=attach_count_4; i++){
				if (i == attach_count_4){
					str_type_x_p4 = str_type_x_p4+$("#select_type_x4_p"+i+"").html();
				} else {
					str_type_x_p4 = str_type_x_p4+$("#select_type_x4_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p4").val(str_type_x_p4);
			
			frm.submit();
		
		} else {
			false;
		}
	}

	function go_tmp_submit() {
			$("#damyun_option_status").val("tmp"); // 임시저장

			scyn_jongs_check();
			scyn_jongs_check2();
			scyn_jongs_check3();
			scyn_jongs_check4();

			/*var chk = document.getElementsByName("damyun_option_samescyn_jongs");
			var chkcnt = 0;
			for(i=0; i<chk.length;i++){      
				if (chk[i].checked == true){
					chkcnt = chkcnt+1;		
				}
			}
			if(chkcnt > 1){
				alert("상사 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk2 = document.getElementsByName("damyun_option_samescyn_jongs2");
			var chkcnt2 = 0;
			for(i2=0; i2<chk2.length;i2++){      
				if (chk2[i].checked == true){
					chkcnt2 = chkcnt2+1;		
				}
			}
			if(chkcnt2 > 1){
				alert("부하 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk3 = document.getElementsByName("damyun_option_samescyn_jongs3");
			var chkcnt3 = 0;
			for(i3=0; i3<chk3.length;i3++){      
				if (chk3[i].checked == true){
					chkcnt3 = chkcnt3+1;		
				}
			}
			if(chkcnt3 > 1){
				alert("동료 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}

			var chk4 = document.getElementsByName("damyun_option_samescyn_jongs4");
			var chkcnt4 = 0;
			for(i4=0; i4<chk4.length;i4++){      
				if (chk4[i].checked == true){
					chkcnt4 = chkcnt4+1;		
				}
			}
			if(chkcnt4 > 1){
				alert("본인 종속변수는 하나만 선택하셔야 합니다.");
				return;
			}*/

			var attach_count_1 = Number($("#attach_count_1").val());
			var attach_count_2 = Number($("#attach_count_2").val()); 
			var attach_count_3 = Number($("#attach_count_3").val()); 
			var attach_count_4 = Number($("#attach_count_4").val()); 
							
			var str_type_x_p = "";
			var str_type_x_p2 = "";
			var str_type_x_p3 = "";
			var str_type_x_p4 = "";
			
			$("#factor_no_x_p").val("");
			for(i=1; i<=attach_count_1; i++){
				if (i == attach_count_1){
					str_type_x_p = str_type_x_p+$("#select_type_x1_p"+i+"").html();
				} else {
					str_type_x_p = str_type_x_p+$("#select_type_x1_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p").val(str_type_x_p);
			
			$("#factor_no_x_p2").val("");
			for(i=1; i<=attach_count_2; i++){
				if (i == attach_count_2){
					str_type_x_p2 = str_type_x_p2+$("#select_type_x2_p"+i+"").html();
				} else {
					str_type_x_p2 = str_type_x_p2+$("#select_type_x2_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p2").val(str_type_x_p2);
			
			$("#factor_no_x_p3").val("");
			for(i=1; i<=attach_count_3; i++){
				if (i == attach_count_3){
					str_type_x_p3 = str_type_x_p3+$("#select_type_x3_p"+i+"").html();
				} else {
					str_type_x_p3 = str_type_x_p3+$("#select_type_x3_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p3").val(str_type_x_p3);
			
			$("#factor_no_x_p4").val("");
			for(i=1; i<=attach_count_4; i++){
				if (i == attach_count_4){
					str_type_x_p4 = str_type_x_p4+$("#select_type_x4_p"+i+"").html();
				} else {
					str_type_x_p4 = str_type_x_p4+$("#select_type_x4_p"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_p4").val(str_type_x_p4);
		
			frm.submit();
	}

	function set_left_score(num){
		var tscore = $("#damyun_option_samept_"+num+"").val();
		//alert(tscore);
		if(num == 1){
			$(".left_input_score").val(tscore);
		} else if(num == 2){
			$(".left_input_score2").val(tscore);
		} else if(num == 3){
			$(".left_input_score3").val(tscore);	
		} else if(num == 4){
			$(".left_input_score4").val(tscore);
		}
	}

	function scyn_jongs_check() {
		var chk = document.getElementsByName("damyun_option_samescyn_jongs");   
		var vars = "";
		for(i=0; i<chk.length;i++){      
			vars += (chk[i].checked == true) ? "Y" : "N";
			if(i < (chk.length-1)){
				vars += "|";
			}
		}
		$("#jongs_check").val(vars);
	}

	function scyn_jongs_check2() {
		var chk = document.getElementsByName("damyun_option_samescyn_jongs2");   
		var vars = "";
		for(i=0; i<chk.length;i++){      
			vars += (chk[i].checked == true) ? "Y" : "N";
			if(i < (chk.length-1)){
				vars += "|";
			}
		}
		$("#jongs_check2").val(vars);
	}

	function scyn_jongs_check3() {
		var chk = document.getElementsByName("damyun_option_samescyn_jongs3");   
		var vars = "";
		for(i=0; i<chk.length;i++){      
			vars += (chk[i].checked == true) ? "Y" : "N";
			if(i < (chk.length-1)){
				vars += "|";
			}
		}
		$("#jongs_check3").val(vars);
	}

	function scyn_jongs_check4() {
		var chk = document.getElementsByName("damyun_option_samescyn_jongs4");   
		var vars = "";
		for(i=0; i<chk.length;i++){      
			vars += (chk[i].checked == true) ? "Y" : "N";
			if(i < (chk.length-1)){
				vars += "|";
			}
		}
		$("#jongs_check4").val(vars);
	}

    </script>
   
   <? include "./inc/common_pop.php"; ?>

    <div class="ser-pop">
        <div class="m2p_wrap">
            <p class="ga_ment">집단구분은 4개까지 가능합니다.</p>
            <p class="ga_ment">변수명에 공란이 있습니다.</p>
            <div class="ok_btn">
                <button type="button">확인</button>
            </div>
        </div>
    </div>
</body>
</html>
