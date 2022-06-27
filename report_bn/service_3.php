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

	$sql_file_1 = "select * from wise_analysis_report_service_option_point_case where 1 and service_option_idx='".$service_option_idx."' order by idx asc"; // 케이스 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 0;
	}

	if($row['analysis_report_service_option_score']){
		$service_option_score = $row['analysis_report_service_option_score'];	
	} else {
		$service_option_score = "5";
	}

	if($row['analysis_report_service_option_percent']){
		$service_option_percent = $row['analysis_report_service_option_percent'];	
	} else {
		$service_option_percent = "1";
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
          <form name="frm" action="service_3_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="service_option_status" id="service_option_status" value=""/>
			<input type="hidden" id="service_option_idx" name="service_option_idx" value="<?=$service_option_idx?>"> 
			<input type="hidden" id="service_point_case_v" name="service_point_case_v">
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
                            <span>점수변환방식을 선택해주세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>점수의 소수점 자리를 설정해주세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
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
                </div>
                <div class="serv_mop content-rd">
                    <div class="mop_wrap">
                          <div class="mop_l1 tabb1">
                                <div class="title">
                                    <p>점수변환방식</p>
                                </div>
                                <div class="mop_option">
                                    <div class="line_1">
                                        <span>원점수</span>
                                        <span><img src="./img/arrow_right.png" alt=""></span>
                                        <span>변환점수</span>
                                    </div>
                                    <div class="line_2">
                                        <div class="l2_left">
                                            <ul>
                                                <li>
                                                    <label for="five">
                                                        <input type="radio" name="service_option_score" id="option_score_five" value="5" <?=$service_option_score=="5"?"checked":""?>><span>5점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="seven">
                                                        <input type="radio" name="service_option_score" id="option_score_seven" value="7" <?=$service_option_score=="7"?"checked":""?>><span>7점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="nine">
                                                        <input type="radio" name="service_option_score" id="option_score_nine" value="9" <?=$service_option_score=="9"?"checked":""?>><span>9점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="ten">
                                                        <input type="radio" name="service_option_score" id="option_score_ten" value="10" <?=$service_option_score=="10"?"checked":""?>><span>10점</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="l2_right">
                                            <ul>
                                                <li>
                                                    <label for="not_cha">
                                                        <input type="radio" name="service_option_percent" id="not_cha" value="1" <?=$service_option_percent=="1"?"checked":""?>><span>원 점수 그대로</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="sco_cha">
                                                        <input type="radio" name="service_option_percent" id="sco_cha" value="2" <?=$service_option_percent=="2"?"checked":""?>><span>100점으로 변환</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mop_l2 tabb2">
                                <div class="title">
                                    <p>숫자 자리수</p>
                                </div>
                                <div class="mop_sosu">
                                    <div class="sosu_1">
                                        <span>점수의 소수점</span>
                                        <input type="number" maxlength="1" onkeypress="return lengthCheckofExp(this)" placeholder="1" name="service_option_scorepoint" id="service_option_scorepoint" required="no" message="점수의 소수점" value="<?=$row['analysis_report_service_option_scorepoint']?>">
                                        <span>째 자리</span>
                                    </div>
                                    
                                    <script>
                                    function lengthCheckofExp(obj)
                                        {
                                            if(obj.value.length >= obj.maxLength) //obj.maxLength = 2
                                            {
                                                return false;
                                            }
                                        }

                                    
                                    </script>
                                    <div class="sosu_2">
                                        <span>빈도의 소수점</span>
                                        <input type="number" maxlength="1" onkeypress="return lengthCheckofExp(this)" placeholder="1" name="service_option_scorepoint2" id="service_option_scorepoint2" required="no" message="빈도의 소수점" value="<?=$row['analysis_report_service_option_scorepoint2']?>">
                                        <span>째 자리</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mop_l3 tabb3">
                                <div class="title">
                                    <p>케이스 선택</p>
                                </div>
                                <div class="mop_case ">
                                    <div class="case_1">
                                        <div class="case_add">
                                            <button type="button"><img src="./img/plus_sq.png" alt=""></button>
                                        </div>
                                        <span>케이스 추가</span>
                                    </div>
                                    <div class="case_box" id="service_point_case_area">
								<?
									for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
										$row_file_1 = mysqli_fetch_array($query_file_1);

										$quiz_no = get_data_colname("wise_analysis_quiz","idx",$row_file_1['analysis_report_service_option_case_no'],"quiz_no","");
								?>
										<li class="ui-widget-content item_serv pop_li pop_t on"><span class="pop_close" id="quiz_no_<?=$row_file_1['analysis_report_service_option_case_no']?>"><button><img src="./img/remove.png" alt=""></button></span><a href="javascript:view_analysis_quiz_ans('<?=$row['analysis_report_idx']?>','<?=$quiz_no?>');" title="<?=$row_file_1['analysis_report_service_option_case_title']?>"><?=$row_file_1['analysis_report_service_option_case_title']?></a></li><li class="ui-widget-content item_serv pop_li pop_c on"><a href="javascript:<?=$row_file_1['analysis_report_service_option_case_answer']?>;" title="<?=$row_file_1['analysis_report_service_option_case_answer']?>"><?=$row_file_1['analysis_report_service_option_case_answer']?></a></li><span class="and">and</span>
								<?}?>
                                    </div>
                                </div>
                            </div>
                      </div>
                </div>
            </div>

			</form>

            <div class="btn_all">
                <div class="left_btn" onclick="location.href='service_2.php?service_option_idx=<?=$service_option_idx?>';">
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
         
        <div class="ser3-pop">
            <div class="m2p_wrap">
                <p class="bun_ment">분석을 시작합니다<br/>분석이 시작된 이후엔 설정변경이 안됩니다.<br> 분석을 진행하시겠습니까?</p>
                <div class="ok_btn">
                    <button type="button">확인</button>
                </div>
            </div>
        </div>

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
		$("#service_point_case_v").val($("#service_point_case_area").html());
		$("#service_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#service_point_case_v").val($("#service_point_case_area").html());
		$("#service_option_status").val("tmp"); // 임시저장
		frm.submit();
	}

	function view_analysis_quiz_ans(analysis_idx,quiz_no){
		get_data("inner_step3_answer.php","step3_answer_area","analysis_idx="+analysis_idx+"&quiz_no="+quiz_no+"");
	}
</script>

</body>
</html>
