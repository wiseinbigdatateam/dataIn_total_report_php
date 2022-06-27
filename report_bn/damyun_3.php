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

	$analysis_report_idx = $row['analysis_report_idx'];
	//echo "analysis_report_idx = ".$analysis_report_idx."<br>";

	$sql_file_1 = "select * from wise_analysis_report_damyun_option_point_case where 1 and damyun_option_idx='".$damyun_option_idx."' order by idx asc"; // 케이스 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 0;
	}

	$sql_file_2 = "select * from wise_analysis_report_damyun_option_point_weight where 1 and damyun_option_idx='".$damyun_option_idx."' order by idx asc"; // 케이스 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
	$query_file_2_cnt = mysqli_num_rows($query_file_2);
	if($query_file_2_cnt == 0){
		$query_file_2_cnt = 0;
	}

	if($row['analysis_report_damyun_option_score']){
		$damyun_option_score = $row['analysis_report_damyun_option_score'];	
	} else {
		$damyun_option_score = "5";
	}

	if($row['analysis_report_damyun_option_percent']){
		$damyun_option_percent = $row['analysis_report_damyun_option_percent'];	
	} else {
		$damyun_option_percent = "1";
	}

	if($row['analysis_report_damyun_option_case']){
		$damyun_option_case = $row['analysis_report_damyun_option_case'];	
	} else {
		$damyun_option_case = "N";
	}

	//echo $row['analysis_report_damyun_option_case']."<br>";
	//echo $damyun_option_case."<br>";
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
          <form name="frm" id="frm" action="damyun_3_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="damyun_option_status" id="damyun_option_status" value=""/>
			<input type="hidden" id="damyun_option_idx" name="damyun_option_idx" value="<?=$damyun_option_idx?>"> 
			<input type="hidden" id="damyun_point_case_v" name="damyun_point_case_v">   
			<input type="hidden" id="damyun_point_weight_v" name="damyun_point_weight_v">   

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
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>가중치 반영여부를 선택해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>가중치는 1개의 문항만 입력 가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력 후 미반영 선택시 입력값이 초기화됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="damy_mop content-rd">
                    <div class="mop_wrap">
                           <div class="mop_l1">
                                <div class="title">
                                    <p>점수변환방식</p>
                                </div>
                                <div class="mop_option tabb1">
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
                                                        <input type="radio" name="damyun_option_score" id="option_score_five" value="5" <?=$damyun_option_score=="5"?"checked":""?>><span>5점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="seven">
                                                        <input type="radio" name="damyun_option_score" id="option_score_seven" value="7" <?=$damyun_option_score=="7"?"checked":""?>><span>7점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="nine">
                                                        <input type="radio" name="damyun_option_score" id="option_score_nine" value="9" <?=$damyun_option_score=="9"?"checked":""?>><span>9점</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="ten">
                                                        <input type="radio" name="damyun_option_score" id="option_score_ten" value="10" <?=$damyun_option_score=="10"?"checked":""?>><span>10점</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="l2_right">
                                            <ul>
                                                <li>
                                                    <label for="not_cha">
                                                        <input type="radio" name="damyun_option_percent" id="not_cha" value="1" <?=$damyun_option_percent=="1"?"checked":""?>><span>원 점수 그대로</span>
                                                    </label>
                                                </li>
                                                <li>
                                                    <label for="sco_cha">
                                                        <input type="radio" name="damyun_option_percent" id="sco_cha" value="2" <?=$damyun_option_percent=="2"?"checked":""?>><span>100점으로 변환</span>
                                                    </label>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mop_l2">
                                <div class="title">
                                    <p>숫자 자리수</p>
                                </div>
                                <div class="mop_sosu tabb2">
                                    <div class="sosu_1">
                                        <span>점수의 소수점</span>
                                     	 <input type="number" maxlength="1" onkeypress="return lengthCheckofExp(this)" placeholder="1" name="damyun_option_scorepoint" id="damyun_option_scorepoint" required="no" message="점수의 소수점" value="<?=$row['analysis_report_damyun_option_scorepoint']?>">
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
                                         <input type="number" maxlength="1" onkeypress="return lengthCheckofExp(this)" placeholder="1" name="damyun_option_scorepoint2" id="damyun_option_scorepoint2" required="no" message="빈도의 소수점" value="<?=$row['analysis_report_damyun_option_scorepoint2']?>">
                                        <span>째 자리</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mop_l3">
                                <div class="title">
                                    <p>케이스 선택</p>
                                </div>
                                <div class="mop_case  tabb3">
                                    <div class="case_1">
                                        <div class="case_add">
                                            <button type="button"><img src="./img/plus_sq.png" alt=""></button>
                                        </div>
                                        <span>케이스 추가</span>
                                    </div>
                                   <div class="case_box" id="damyun_point_case_area">
								<?
									for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
										$row_file_1 = mysqli_fetch_array($query_file_1);

										$quiz_no = get_data_colname("wise_analysis_quiz","idx",$row_file_1['analysis_report_damyun_option_case_no'],"quiz_no","");
								?>
										<li class="ui-widget-content item_serv pop_li pop_t on"><span class="pop_close" id="quiz_no_<?=$row_file_1['analysis_report_damyun_option_case_no']?>"><button><img src="./img/remove.png" alt=""></button></span><a href="javascript:view_analysis_quiz_ans('<?=$row['analysis_report_idx']?>','<?=$quiz_no?>');" title="<?=$row_file_1['analysis_report_damyun_option_case_title']?>"><?=$row_file_1['analysis_report_damyun_option_case_title']?></a></li><li class="ui-widget-content item_serv pop_li pop_c on"><a href="javascript:<?=$row_file_1['analysis_report_damyun_option_case_answer']?>;" title="<?=$row_file_1['analysis_report_damyun_option_case_answer']?>"><?=$row_file_1['analysis_report_damyun_option_case_answer']?></a></li><span class="and">and</span>
								<?}?>
                                    </div>
                                </div>
                            </div>
                             <div class="mop_l4 tabb4">
                                <div class="da3_wrap da3">
                                    <span class="title">
                                        <p>가중치 반영</p>
                                    </span>
                                    <div class="icon_box">
                                        <div class="da3y_wrap">
                                            <label for="da3_yes">
                                               	<input type="radio" name="damyun_option_case" id="da3_yes" value="Y" <?=$damyun_option_case=="Y"?"checked":""?> onclick="add_value_yn('Y');">
                                                반영
                                            </label>
                                        </div>
                                        <div class="da3_btn on" id="damyun_point_weight_area">
                                            <div class="da3_add">
                                                <button class="ser_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                            </div>
								<?
									for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
										$row_file_2 = mysqli_fetch_array($query_file_2);
										$damyun_option_weight_idx = $row_file_2['idx'];
								?>
										<li id="ql_<?=$row_file_2['analysis_report_damyun_option_weight_quiz_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_2['analysis_report_damyun_option_weight_quiz_no']?>;" class="ui-selectee"><?=$row_file_2['analysis_report_damyun_option_weight_quiz_title']?></a></li>
								<?}?>
                                        </div>
                                        <div class="da3y_wrap2">
                                            <label for="da3_no">
												<input type="radio" name="damyun_option_case" id="da3_no" value="N" <?=$damyun_option_case=="N"?"checked":""?> onclick="add_value_yn('N');">
                                                미반영
                                            </label>
                                        </div>
                                    </div>
								<?
									$sql_file_3 = "select * from wise_analysis_report_damyun_option_point_weight_estimate where 1 and damyun_option_idx='".$damyun_option_idx."' and damyun_option_weight_idx='".$damyun_option_weight_idx."' order by idx asc"; 
									//echo $sql_file_3."<br>";
									$query_file_3 = mysqli_query($gconnet,$sql_file_3);
									$query_file_3_cnt = mysqli_num_rows($query_file_3);
								?>
									
									<input type="hidden" id="query_file_3_cnt" name="query_file_3_cnt" value="<?=$query_file_3_cnt?>">

                                    <div class="da3_table" id="add_value_area">
                                       <!-- damyun_3_addval.php 에서 불러옴 --> 
								<?if($query_file_3_cnt > 0){?>
									   <!-- 기존 데이터 있을때 시작 -->
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
										/*if($query_file_3_cnt < 4){
											$query_file_3_cnt = 4;
										}*/
										for($opt_i=0; $opt_i<$query_file_3_cnt; $opt_i++){
											$row_file_3 = mysqli_fetch_array($query_file_3);
											$option_weight_estimate_title = $row_file_3['analysis_report_damyun_option_weight_estimate_title'];
									?>
												<input type="hidden" id="option_weight_estimate_title" name="option_weight_estimate_title_<?=$opt_i?>" value="<?=$option_weight_estimate_title?>">
                                                <tr class="score_line">
                                                    <th><?=$option_weight_estimate_title?></th>
													<td><?=($opt_i+1)?></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pa_1" name="option_weight_estimate_val1_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val1']?>" class="score_da"></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pb_1" name="option_weight_estimate_val2_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val2']?>" class="score_da"></td>
                                                    <td><input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="num_pc_1" name="option_weight_estimate_val3_<?=$opt_i?>" value="<?=$row_file_3['analysis_report_damyun_option_weight_estimate_val3']?>" class="score_da"></td>
                                                    <td class="score_sum">
														<?=number_format($row_file_3['analysis_report_damyun_option_weight_estimate_val1']+$row_file_3['analysis_report_damyun_option_weight_estimate_val2']+$row_file_3['analysis_report_damyun_option_weight_estimate_val3'])?>
													</td>
                                                </tr>
									<?}?>
                                            </table>
                                        </div>
										<!-- 기존 데이터 있을때 종료 -->
								 <?}?>
                                    </div>

                                </div>
                            </div>
                       </div>
                </div>
            </div>
            </form>

			<div class="btn_all">
                <div class="left_btn" onclick="location.href='damyun_2.php?damyun_option_idx=<?=$damyun_option_idx?>';">
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
		$("#frm").attr("action","damyun_3_action.php");
		$("#damyun_point_case_v").val($("#damyun_point_case_area").html());
		$("#damyun_point_weight_v").val($("#damyun_point_weight_area").html());
		$("#damyun_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#frm").attr("action","damyun_3_action.php");
		$("#damyun_point_case_v").val($("#damyun_point_case_area").html());
		$("#damyun_point_weight_v").val($("#damyun_point_weight_area").html());
		$("#damyun_option_status").val("tmp"); // 임시저장
		frm.submit();
	}

	function go_display_table() {
		$("#frm").attr("action","damyun_3_display_table.php");
		$("#damyun_point_weight_v").val($("#damyun_point_weight_area").html());
		frm.submit();
	}

	function go_display_view(quiz_no) {
		get_data("damyun_3_addval.php","add_value_area","quiz_no="+quiz_no+"&analysis_idx=<?=$analysis_report_idx?>");
	}

	function view_analysis_quiz_ans(analysis_idx,quiz_no){
		get_data("inner_step3_answer.php","step3_answer_area","analysis_idx="+analysis_idx+"&quiz_no="+quiz_no+"");
	}

	$(document).ready(function(){
        <?if(trim($damyun_option_case) == "Y"){?>
			$("#da3_yes").trigger("click");
		<?} elseif(trim($damyun_option_case) == "N"){?>
			$("#da3_no").trigger("click");
		<?}?>
    });

	function add_value_yn(type){
		if(type == "Y"){
			//alert(type);
			$("#add_value_area").show();
		} else if(type == "N"){
			$("#add_value_area").hide();
		}
	}
</script>

</body>
</html>
