<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$service_option_idx = trim(sqlfilter($_REQUEST['service_option_idx']));

	if($service_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_service_option where 1 and idx='".$service_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			error_go("다시 진행해주세요.","service_1.php");
		}

		$row = mysqli_fetch_array($compet_info_query);
	} else {
		error_go("다시 진행해주세요.","service_1.php");
	}

	if($row['analysis_report_service_option_samescyn']){
		$service_option_samescyn = $row['analysis_report_service_option_samescyn'];
	} else {
		$service_option_samescyn = "N";
	}

	//echo "row level yn = ".$row['analysis_report_service_option_levelyn']."<br>";

	if($row['analysis_report_service_option_levelyn']){
		$service_option_levelyn = $row['analysis_report_service_option_levelyn'];
	} else {
		$service_option_levelyn = "N";
	}

	$sql_file_1 = "select * from wise_analysis_report_service_option_samescyn where 1 and service_option_idx='".$service_option_idx."' order by idx asc"; // 동일배점 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 1;
	}

	$sql_file_2 = "select * from wise_analysis_report_service_option_levelyn where 1 and service_option_idx='".$service_option_idx."' order by idx asc"; // 등급기준
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
          <form name="frm" action="service_2_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="service_option_status" id="service_option_status" value=""/>
			<input type="hidden" id="service_option_idx" name="service_option_idx" value="<?=$service_option_idx?>">
			<input type="hidden" name="attach_count_1" id="attach_count_1" value="<?=$query_file_1_cnt?>"/> <!-- 동일배점 입력갯수 -->
			<input type="hidden" name="attach_count_2" id="attach_count_2" value="<?=$query_file_2_cnt?>"/> <!-- 등급기준 입력갯수 -->
			<input type="hidden" id="factor_no_x_p" name="factor_no_x_p"> 
			<input type="hidden" id="jongs_check" name="jongs_check"> 
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
                            <span>동일배점 적용 여부를 선택해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력시 추가된 문항의 총점 반영에만 적용됩니다. (문항 추가시 재입력)
</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>적용안함 선택시, 입력값이 초기화됩니다.
</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측 문항을 선택 후 " + " 버튼을 클릭시 문항이 추가됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>추가된 문항의 " X " 버튼을 클릭시 문항이 삭제됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>하단의 " + " 버튼을 클릭시 문항입력박스가 추가됩니다.</span>
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
                            <span>제목을 입력해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>우측의 " - " 버튼 클릭시 해당 문항입력박스가 삭제됩니다. </span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>등급기준 사용여부를 체크해주세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab6">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>리셋 버튼을 클릭시 해당 줄의 모든 입력값이 초기화됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>우측의 " - " 버튼을 클릭시 해당 입력박스가 삭제됩니다. 하단의 " + " 버튼을 클릭시 등급입력박스가 추가생성됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>등급설정시, 누락 또는 겹치는 구간이 생기지 않도록 설정하여 주십시오.</span>
                        </div>
                    </div>
                </div>
                <div class="main_ser content-xd">
                    <div class="ser2_wrap">
                           <div class="s2_l">
                                <div class="radio_2lt tabb1">
                                    <span>동일배점</span>
                                    <span>
                                        <label for="r2l_no">
                                            <input type="radio" name="service_option_samescyn" value="N" id="r2l_no" <?=$service_option_samescyn=="N"?"checked":""?>>
                                            적용안함
                                        </label>
                                    </span>
                                    <span>
                                        <label for="r2l_yes">
                                            <input type="radio" name="service_option_samescyn" value="Y" id="r2l_yes" <?=$service_option_samescyn=="Y"?"checked":""?> class="r2l_yes">
                                            적용
                                            <input type="text" class="dis_toggle" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="service_option_samept" id="service_option_samept" value="<?=$row['analysis_report_service_option_samept']?>" onblur="set_calc_quiz_score();">
                                        </label>
                                    </span>
                                </div>
								    <div class="rw_title">
                                        <span>문항선택</span>
                                        <span>배점입력</span>
                                        <span>총점반영</span>
                                        <span>종속변수</span>
                                        <span>이름입력</span>
                                    </div>
                                <div class="r2l_wrap  content-rd">
							<?
								$set_calc_quiz_score = 0;
								for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
									$row_file_1 = mysqli_fetch_array($query_file_1);
							?>
								 <!-- 동일배점 파트 시작 -->
                                    <div class="rwb_wrap">
                                        <div class="rwb_l tabb2">
                                            <div class="rbl_boxt">
											<!-- 문항 리스트 시작 -->	
                                                <ul class="box_big ser_big content-rd" id="select_type_x_p<?=($opt_i+1)?>">
											<?
													$opt_sql = "select * from wise_analysis_report_service_option_samescyn_quiz where 1 and service_option_idx='".$service_option_idx."' and service_option_samescyn_idx='".$row_file_1['idx']."' order by idx asc";
													//echo $opt_sql."<br>";
													$opt_query = mysqli_query($gconnet,$opt_sql);
													$opt_cnt = mysqli_num_rows($opt_query);
																										
													for($opt_i2=0; $opt_i2<$opt_cnt; $opt_i2++){
														$opt_row = mysqli_fetch_array($opt_query);

														$set_calc_quiz_score = $set_calc_quiz_score+$opt_row['analysis_report_service_option_samescyn_quiz_score'];
											?>
												<li id="ql_<?=$opt_row['analysis_report_service_option_samescyn_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag">
														<div class="node ui-selectee ui-selected selected-flag">
															<span class="close ui-selectee" style="">
																<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee mCS_img_loaded"></button>
															</span>
															<a href="javascript:<?=$opt_row['analysis_report_service_option_samescyn_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="고객만족도2"><?=$opt_row['analysis_report_service_option_samescyn_quiz_title']?></a>
															<input class="dec_in ui-selectee" type="text" style="" placeholder="<?=$opt_row['analysis_report_service_option_samescyn_quiz_title']?>" title="<?=$opt_row['analysis_report_service_option_samescyn_quiz_title']?>">
															<div class="score_div ui-selectee ui-selected selected-flag">
																<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="inc_left_quiz_score_<?=$opt_row['analysis_report_service_option_samescyn_quiz_no']?>[]" id="inc_left_quiz_score_<?=$opt_row['analysis_report_service_option_samescyn_quiz_no']?>" class="left_input_score" style="" value="<?=$opt_row['analysis_report_service_option_samescyn_quiz_score']?>" onblur="set_calc_quiz_score();">
															</div>
															<!--<span class="jong_div ui-selectee" style="pointer-events: none;">-->
															<span class="jong_div">
																<input type="checkbox" name="inc_left_quiz_tscyn_<?=$opt_row['analysis_report_service_option_samescyn_quiz_no']?>[]" id="inc_left_quiz_tscyn_<?=$opt_row['idx']?>" value="Y" <?=trim($opt_row['analysis_report_service_option_samescyn_quiz_tscyn'])=="Y"?"checked":""?>>
															</span>
															<?if(trim($opt_row['analysis_report_service_option_samescyn_quiz_tscyn']) == "Y"){?>
																<script>$("#inc_left_quiz_tscyn_<?=$opt_row['idx']?>").trigger("click");</script>
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
                                                <div class="rbl_count" id="select_quiz_cnt<?=($opt_i+1)?>">
                                                    <span></span>
                                                </div>
                                            </div>
                                        </div>
										<div class="rwb_c tabb3">
                                            <span class="r_jong">
												<input type="checkbox" name="service_option_samescyn_jongs" id="service_option_samescyn_jongs_<?=($opt_i+1)?>" value="Y" <?=trim($row_file_1['analysis_report_service_option_samescyn_jongs'])=="Y"?"checked":""?> class="jongs_chk">
											</span>
											<?if($row_file_1['analysis_report_service_option_samescyn_jongs'] == "Y"){?>
												<script>$("#service_option_samescyn_jongs_<?=($opt_i+1)?>").trigger("click");</script>
											<?}?>
                                        </div>
                                        <div class="rwb_r tabb4">
                                            <div class="title_wrap">
                                                <textarea name="service_option_samescyn_title[]" id="service_option_samescyn_title_<?=($opt_i+1)?>" cols="30" rows="10" placeholder="제목" required="yes" message="서비스 평가모델"><?=$row_file_1['analysis_report_service_option_samescyn_title']?></textarea>
                                            </div>
                                            <div class="rwb_minus">
                                                <button type="button">
                                                    <img src="./img/minus_sq.png" alt="">
                                                </button>
                                            </div>
                                        </div>
                                        <div class="rwb_bot" id="rwb_bot<?=($opt_i+1)?>" <?if(($opt_i+1) == $query_file_1_cnt){}else{?>style="display:none;"<?}?>>
                                            <button type="button">
                                                <img src="./img/plus_sq.png" alt="">
                                            </button>
                                            <div class="jib_line">
                                                <div class="line"></div>
                                            </div>
                                        </div>
									</div>
									<!-- 동일배점 파트 종료 -->
							   <?}?>
                                </div>
                            </div>
                            <div class="s2_r">
                                <div class="radio_2rt tabb5">
                                    <span class="yes_no">
                                            등급기준 사용여부
                                            <input type="checkbox" name="service_option_levelyn" id="service_option_levelyn" value="Y" <?=$service_option_levelyn=="Y"?"checked":""?> class="grade_yes">
                                    </span>
                                </div>
                                    <div class="rwr_title">
                                        <span>등급분류</span>
                                        <span>최하</span>
                                        <span>~</span>
                                        <span>최대</span>
                                    </div>
                                <div class="r2r_wrap content-rd tabb6">
							       <div class="rwbr_wrap">
                            <?
								for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
									$row_file_2 = mysqli_fetch_array($query_file_2);
							?>
									<!-- 등급기준 파트 시작 -->
										<div class="rwg_wrap">
                                            <div class="rwg_input">
                                                <div class="rwg_grade">
                                                    <input type="text" name="service_option_levelyn_title[]" id="service_option_levelyn_title_<?=($opt_i+1)?>" value="<?=$row_file_2['analysis_report_service_option_levelyn_title']?>">
                                                </div>
                                                <div class="rwg_down">
                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="service_option_levelyn_spoint[]" id="service_option_levelyn_spoint_<?=($opt_i+1)?>" value="<?=$row_file_2['analysis_report_service_option_levelyn_spoint']?>">
                                                </div>
                                                <div class="rwg_hypen">
                                                    <span class="hypen">~</span>
                                                </div>
                                                <div class="rwg_up">
                                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="service_option_levelyn_epoint[]" id="service_option_levelyn_epoint_<?=($opt_i+1)?>" value="<?=$row_file_2['analysis_report_service_option_levelyn_epoint']?>">
                                                </div>
                                            </div>
                                            <div class="rwg_btn">
                                                <div class="minus_rwg">
                                                    <button type="button"><img src="./img/minus_sq.png" alt=""></button>
                                                </div>
                                                <div class="minus_re">
                                                    <button type="button"><img src="./img/return_sq.png" alt=""></button>
                                                </div>
                                            </div>
                                        </div>
									<!-- 등급기준 파트 종료 -->
								<?}?>
                                        <div class="rwg_bot">
                                            <div class="rwgb_r">
                                                <button type="button"><img src="./img/plus_sq.png" alt=""></button>
                                            </div>
                                            <div class="rwgb_l"></div>
                                        </div>
                                    </div>
								</div>
							</div>
                       </div>
                </div>
                <div class="sum_line">
                    <div class="ga_sum">
                        <span>배점합계</span>
                        <span>:</span>
                        <span class="gas_num">0</span>
                    </div>
                </div>
            </div>
			</form>

            <div class="btn_all">
                <div class="left_btn" onclick="location.href='service_1.php?service_option_idx=<?=$service_option_idx?>';">
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
	
	<input type="hidden" id="calc_quiz_score_tot" value="<?=$set_calc_quiz_score?>">

<script>
    $(document).ready(function(){

        $(".content-xd").mCustomScrollbar({
                axis:"yx",
                theme:"light-3",
                scrollInertia:550,
                scrollbarPosition:"outside"
                    });


		set_calc_quiz_score();

    });

	function set_calc_quiz_score(){
		var sum = 0;
		$('.left_input_score').each(function() {
			var price = Number($(this).val());
			sum = sum+price;
		});
        $('.gas_num').html(sum);
	}

</script> 
<script>

$(function(){
	$('.mindmap').mindmap();
});

$(document).ready(function(){

    $(".content-rd").mCustomScrollbar({
                    theme:"light-3",
                });

	<?if($service_option_levelyn=="Y"){?>
		 $("#service_option_levelyn").trigger("click");
	<?}?>
});


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

	function go_submit() {
        // 2021-08-05 추가
        let flag = 0;
        const score = document.querySelectorAll('.item_serv.ui-selectee.ui-selected.selected-flag .score_div.ui-selectee input');

        for(let i = 0; i < score.length; i++){
            if(score[i].value == '' && flag == 0){

            } else if(score[i].value == '' && flag > 0){
                alert('모든 배점을 입력해주세요.');
                return false;
            } else if(score[i].value !== '') {
                flag = 1;
            }
        }
        // ---------------------------

		$("#service_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			scyn_jongs_check();
			var attach_count_1 = Number($("#attach_count_1").val()); 
			var attach_count_2 = Number($("#attach_count_2").val()); 
				
			var str_type_x_p = '';

			/*var chk = document.getElementsByName("service_option_samescyn_jongs");
			var chkcnt = 0;
			for(i=0; i<chk.length;i++){      
				if (chk[i].checked == true){
					chkcnt = chkcnt+1;		
				}
			}
			if(chkcnt > 1){
				//alert(chkcnt);
				alert("종속변수는 하나만 선택하셔야 합니다.");
				return;
			}*/
		
			for(i=1; i<=attach_count_1; i++){
				if (i == attach_count_1){
					str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html();
				} else {
					str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html()+"||";
				}
			}
		
			$("#factor_no_x_p").val(str_type_x_p);
						
			frm.submit();
		
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#service_option_status").val("tmp"); // 임시저장
		scyn_jongs_check();
		var attach_count_1 = Number($("#attach_count_1").val()); 
		var attach_count_2 = Number($("#attach_count_2").val()); 
				
		var str_type_x_p = '';

		/*var chk = document.getElementsByName("service_option_samescyn_jongs");
		var chkcnt = 0;
		for(i=0; i<chk.length;i++){      
			if (chk[i].checked == true){
				chkcnt = chkcnt+1;		
			}
		}
		if(chkcnt > 1){
			alert("종속변수는 하나만 선택하셔야 합니다.");
			return;
		}*/
		
		for(i=1; i<=attach_count_1; i++){
			if (i == attach_count_1){
				str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html();
			} else {
				str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html()+"||";
			}
		}
		
		$("#factor_no_x_p").val(str_type_x_p);

		frm.submit();
	}

	function scyn_jongs_check() {
		var chk = document.getElementsByName("service_option_samescyn_jongs");   
		var vars = "";
		for(i=0; i<chk.length;i++){      
			vars += (chk[i].checked == true) ? "Y" : "N";
			if(i < (chk.length-1)){
				vars += "|";
			}
		}
		//alert(vars);
		$("#jongs_check").val(vars);
	}

	/*function samescyn_jongs_check(){
		var chk = document.getElementsByName("service_option_samescyn_jongs");
		var chkcnt = 0;
		for(i=0; i<chk.length;i++){      
			if (chk[i].checked == true){
				chkcnt = chkcnt+1;		
			}
		}
		
		if(chkcnt > 0){
			alert("no");
			$(".jongs_chk").removeClass('checked');
		} else {
			alert("yes");
		}
	}*/
</script>
    
	<? include "./inc/common_pop.php"; ?>

    <div class="ser2-pop">
        <div class="m2p_wrap">
            <p class="gr_ment">등급기준에 공란이 있습니다.</p>
            <p class="moon_ment">문항이 전부 설정되지 않았습니다.</p>
            <p class="byunsu_ment">변수명에 공란이 있습니다.</p>
            <div class="ok_btn">
                <button type="button">확인</button>
            </div>
        </div>
    </div>
</body>
</html>
