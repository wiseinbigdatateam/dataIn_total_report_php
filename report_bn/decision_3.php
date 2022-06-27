<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));

	if($decision_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_decision_option where 1 and idx='".$decision_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			error_go("다시 진행해주세요.","decision_1.php");
		}

		$row = mysqli_fetch_array($compet_info_query);
	} else {
		error_go("다시 진행해주세요.","decision_1.php");
	}

	$sql_file_1 = "select * from wise_analysis_report_decision_option_point_case where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc"; // 케이스 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 0;
	}

	$sql_file_2 = "select * from wise_analysis_report_decision_option_point_quiz where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc"; // 행동특성문항 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
	if($query_file_2_cnt == 0){
		$query_file_2_cnt = 0;
	}

	if($row['analysis_report_decision_option_score']){
		$decision_option_score = $row['analysis_report_decision_option_score'];	
	} else {
		$decision_option_score = "5";
	}

	if($row['analysis_report_decision_option_percent']){
		$decision_option_percent = $row['analysis_report_decision_option_percent'];	
	} else {
		$decision_option_percent = "1";
	}

	if($row['analysis_report_decision_option_calpath']){
		$decision_option_calpath = $row['analysis_report_decision_option_calpath'];
	} else {
		$decision_option_calpath = "2";
	}

	if($row['analysis_report_decision_option_calpath2']){
		$decision_option_calpath2 = $row['analysis_report_decision_option_calpath2'];
	} else {
		$decision_option_calpath2 = "1";
	}

	if($row['analysis_report_decision_option_case']){
		$decision_option_case = $row['analysis_report_decision_option_case'];	
	} else {
		$decision_option_case = "N";
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
		 <form name="frm" action="decision_3_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="decision_option_status" id="decision_option_status" value=""/>
			<input type="hidden" id="decision_option_idx" name="decision_option_idx" value="<?=$decision_option_idx?>"> 
			<input type="hidden" id="decision_point_case_v" name="decision_point_case_v">
			<input type="hidden" id="decision_point_quiz_v" name="decision_point_quiz_v">   
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
                                <p class="numbering"><span>2</span></p>
                                <p>분석모델설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span class="on_num">3</span></p>
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
                            <span>소수점 자리수를 입력하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력값이 없을 시, 자동 3자리로 사용됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>개인별 계산방식을 선택하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>전체 계산방식을 선택하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>일관성지수 적용여부를 선택하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력은 숫자만 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>케이스를 선택하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 팝업창이 나타납니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>팝업당 한 번에 1개의 요소만 선택이 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab6">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>집단별 분석 문항을 설정하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측의 문항을 클릭 또는 드래그한 후 " + " 버튼을 눌러주세요.</span>
                        </div>
                    </div>
                </div>
                <div class="main_dec3 content-rd">
                    <div class="dop_wrap">
                         <div class="dop_l1 tabb1">
                                <div class="title">
                                    <p>숫자 자리수</p>
                                </div>
                                <div class="dop_sosu">
                                    <div class="sosu_1">
                                        <span>점수의 소수점</span>
                                        <input type="number"  maxlength="1" name="decision_option_scorepoint" id="decision_option_scorepoint" required="no" message="점수의 소수점" value="<?=$row['analysis_report_decision_option_scorepoint']?>" placeholder="1">
                                        <span>째 자리</span>
                                    </div>
                                    <div class="sosu_2">
                                        <span>빈도의 소수점</span>
                                        <input type="number"  maxlength="1" name="decision_option_scorepoint2" id="decision_option_scorepoint2" required="no" message="빈도의 소수점" value="<?=$row['analysis_report_decision_option_scorepoint2']?>" placeholder="1">
                                        <span>째 자리</span>
                                    </div>
                                </div>
                            </div>
                            <div class="dop_l2 tabb2">
                                <div class="title">
                                    <p>개인별 계산방식</p>
                                </div>
                                <div class="dop2_ra">
                                    <div class="d2r_l">
                                        <label for="eig">
                                            <input type="radio" name="decision_option_calpath" id="eig" <?=$decision_option_calpath=="1"?"checked":""?> value="1">
                                            eigen(고유치)
                                        </label>
                                    </div>
                                    <div class="d2r_c">
                                        <label for="mea">
                                            <input type="radio" name="decision_option_calpath" id="mea" <?=$decision_option_calpath=="2"?"checked":""?> value="2">
                                            mean(평균)
                                        </label>
                                    </div>
                                    <div class="d2r_r">
                                        <label for="geo">
                                            <input type="radio" name="decision_option_calpath" id="geo" <?=$decision_option_calpath=="3"?"checked":""?> value="3">
                                            geom mean(기하평균)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="dop_l3 tabb3">
                                <div class="title">
                                    <p>전체 계산방식</p>
                                </div>
                                <div class="dop3_ra">
                                    <div class="d3r_l">
                                        <label for="san">
                                            <input type="radio" name="decision_option_calpath2" id="san" <?=$decision_option_calpath2=="1"?"checked":""?> value="1">
                                            산술평균
                                        </label>
                                    </div>
                                    <div class="d3r_r">
                                        <label for="giha">
                                            <input type="radio" name="decision_option_calpath2" id="giha" <?=$decision_option_calpath2=="2"?"checked":""?> value="2">
                                            기하평균
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="dop_l4 tabb4">
                                <div class="title">
                                    <p>일관성지수</p>
                                </div>
                                <div class="dop4_ra">
                                    <span>
                                        <label for="d4_no">
                                            <input type="radio" name="decision_option_case" id="d4_no" <?=$decision_option_case=="N"?"checked":""?> value="N">
                                            적용안함
                                        </label>
                                    </span>
                                    <span>
                                        <label for="d4_yes">
                                            <input type="radio" name="decision_option_case" id="d4_yes" <?=$decision_option_case=="Y"?"checked":""?> value="Y" class="r2l_yes">
                                            적용
                                            <input type="text" class="dis_toggle2"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="decision_option_case_no" id="decision_option_case_no" value="<?=$row['analysis_report_decision_option_case_no']?>">
                                            이하
                                        </label>
                                    </span>
                                </div>
                            </div>
                            <div class="dop_l5 tabb5">
                                <div class="title">
                                    <p>케이스 선택</p>
                                </div>
                                <div class="dop_case">
                                    <div class="case_1">
                                        <div class="case_add">
                                            <button type="button"><img src="./img/plus_sq.png" alt=""></button>
                                        </div>
                                        <span>케이스 추가</span>
                                    </div>
                                     <div class="case_box" id="decision_point_case_area">
								<?
									for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
										$row_file_1 = mysqli_fetch_array($query_file_1);

										$quiz_no = get_data_colname("wise_analysis_quiz","idx",$row_file_1['analysis_report_decision_option_case_no'],"quiz_no","");
								?>
										<li class="ui-widget-content item_serv pop_li pop_t on"><span class="pop_close" id="quiz_no_<?=$row_file_1['analysis_report_decision_option_case_no']?>"><button><img src="./img/remove.png" alt=""></button></span><a href="javascript:view_analysis_quiz_ans('<?=$row['analysis_report_idx']?>','<?=$quiz_no?>');" title="<?=$row_file_1['analysis_report_decision_option_case_title']?>"><?=$row_file_1['analysis_report_decision_option_case_title']?></a></li><li class="ui-widget-content item_serv pop_li pop_c on"><a href="javascript:<?=$row_file_1['analysis_report_decision_option_case_answer']?>;" title="<?=$row_file_1['analysis_report_decision_option_case_answer']?>"><?=$row_file_1['analysis_report_decision_option_case_answer']?></a></li><span class="and">and</span>
								<?}?>
									</div>
                                </div>
                            </div>
                            <div class="dop_l6  tabb6">
                                <div class="title">
                                    <p>집단별 분석</p>
                                </div>
                                <div class="icon_box ">
                                    <div class="dec_btn">
                                        <div class="dec_add dec_add3">
                                            <button  type="button"><img src="./img/plus_sq.png" alt=""></button>
                                        </div>
                                        <div class="dec_re">
                                            <button  type="button"><img src="./img/return_sq.png" alt=""></button>
                                        </div>
                                    </div>
                                    <div class="dec_box" id="decision_point_quiz_area">
                                    <ul>
									<?
									for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
										$row_file_2 = mysqli_fetch_array($query_file_2);
									?>	
										<li id="ql_<?=$row_file_2['analysis_report_decision_option_action_quiz_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="mCS_img_loaded ui-selectee"></button></span><a href="javascript:<?=$row_file_2['analysis_report_decision_option_action_quiz_no']?>;" class="ui-selectee ui-selected selected-flag"><?=$row_file_2['analysis_report_decision_option_action_quiz_title']?></a></li>
									<?}?>
									</ul>
                                    </div>
                                </div>
                            </div>
                     </div>
                </div>
            </div>
			</form>
            
			<div class="btn_all">
                <div class="left_btn" onclick="location.href='decision_2.php?decision_option_idx=<?=$decision_option_idx?>';">
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

  
	<div class="pop_case1  pop_box">
         <div class="pop_c1t">
            <span class="pop_title">
                문항리스트
            </span>
            <span class="close_pop">
                <button type="button"><img src="./img/close_btn.png" alt=""></button>
            </span>
        </div>
            <div class="pop_list content-rd" id="step3_quiz_area">
				<!-- inner_step3_quiz.php 에서 불러옴 -->
            </div>
       </div>
        
			<div class="pop_case1_2 pop_box"> 
               <div class="pop_c2t">
                    <span class="pop_title">
                        문항리스트
                    </span>
                    <span class="close_pop">
                        <button type="button"><img src="./img/close_btn.png" alt=""></button>
                    </span>
                </div>
                    <div class="pop_list content-rd" id="step3_answer_area">
						<!-- inner_step3_answer.php 에서 불러옴 -->
                    </div>
                    <div class="pop_c2btn none">
                        <button type="button">
                            저장
                        </button>
                    </div>
             </div>
        
         
    <div class="m3_pop m2_pop">
        <div class="m2p_wrap">
            <p class="man_ment">만족도 문항을 추가해 주세요.</p>
            <p class="chung_ment">충성도 문항을 추가해 주세요.</p>
            <div class="ok_btn">
                <button type="button">확인</button>
            </div>
        </div>
    </div>
    
   <? include "./inc/common_pop.php"; ?>

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

   function go_submit() {
		$("#decision_point_case_v").val($("#decision_point_case_area").html());
		$("#decision_point_quiz_v").val($("#decision_point_quiz_area").html());
		$("#decision_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.action = "decision_3_action.php";
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#decision_point_case_v").val($("#decision_point_case_area").html());
		$("#decision_point_quiz_v").val($("#decision_point_quiz_area").html());
		$("#decision_option_status").val("tmp"); // 임시저장
		frm.action = "decision_3_action.php";
		frm.submit();
	}

	function view_analysis_quiz_ans(analysis_idx,quiz_no){
		get_data("inner_step3_answer.php","step3_answer_area","analysis_idx="+analysis_idx+"&quiz_no="+quiz_no+"");
	}
</script>




</body>
</html>
