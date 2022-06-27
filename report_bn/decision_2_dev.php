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

	$sql_file_1 = "select * from wise_analysis_report_decision_option_model where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc"; 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 1;
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
          <form name="decision_2_frm" id="decision_2_frm" action="decision_2_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="decision_option_status" id="decision_option_status" value=""/>
			<input type="hidden" id="decision_option_idx" name="decision_option_idx" value="<?=$decision_option_idx?>">
			<input type="hidden" id="factor_no_x_g" name="factor_no_x_g"> <!-- 모델 배열 -->

			<input type="hidden" id="child_pknum" name="child_pknum">
			<input type="hidden" id="child_mode" name="child_mode">

			<div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro ">
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
                            <span>제목을 입력해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측 문항리스트에서 문항을 선택 후 " + " 버튼을 클릭시 문항이 추가됩니다. </span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>문항을 추가한 후 " - " 버튼을 클릭시 모든 하위문항이 삭제됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_dec2 content-xd">
                      <div class="mf_wrap">
                            <div class="mf_all">
                                <div class="mindmap tabb1" id="select_type_x_g">
							<!-- 문항 컨텐츠 시작 -->
							<?
							for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ // 모델명 루프 시작 
								$row_file_1 = mysqli_fetch_array($query_file_1);

								$sql_file_2 = "select * from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx='".$row_file_1['idx']."' and (decision_option_model_quiz_parent = '' or decision_option_model_quiz_parent is null) order by idx asc";
								$query_file_2 = mysqli_query($gconnet,$sql_file_2);
								$query_file_2_cnt = mysqli_num_rows($query_file_2);
							?>
                                    <div class="node node_root">
                                        <div class="node__text"><input class="dec_in" type="text" placeholder="목표" title=""  name="decision_option_model_title_p" id="decision_option_model_title_<?=($opt_i+1)?>" value="<?=$row_file_1['analysis_report_decision_option_model_title']?>"></div>
                                        <div class="dec_bwrap">
										<?if($query_file_2_cnt > 0){ // 하위 카운트 있을때 시작 ?>
											<div class="dec_add dec_add1" style="display:none;">
                                                <button type="button"><img src="./img/plus_sq.png" alt="" onclick="go_tmp_child('P','add');"></button>
                                            </div>
                                            <div class="dec_min dec_min1 tabb2" style="display:block;">
                                                <button type="button"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('P','minus');"></button>
                                            </div>
                                        <?}else{?>
                                            <div class="dec_add dec_add1">
                                                <button type="button"><img src="./img/plus_sq.png" alt="" onclick="go_tmp_child('P','add');"></button>
                                            </div>
                                            <div class="dec_min dec_min1 tabb2">
                                                <button type="button"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('P','minus');"></button>
                                            </div>
										<?}?>
                                        </div>
									</div>
									
								<?if($query_file_2_cnt > 0){ // 하위 카운트 있을때 시작 ?>
									<ol class="children">
									<?
									for($opt_i2=0; $opt_i2<$query_file_2_cnt; $opt_i2++){ // 하위 카운트 루프 시작 
										$row_file_2 = mysqli_fetch_array($query_file_2);

										$sql_file_3 = "select * from wise_analysis_report_decision_option_model_quiz where 1 and decision_option_idx='".$decision_option_idx."' and decision_option_model_idx='".$row_file_1['idx']."' and decision_option_model_quiz_parent = '".$row_file_2['analysis_report_decision_option_model_quiz_no']."' order by idx asc";
										//echo $sql_file_3."<br>";
										$query_file_3 = mysqli_query($gconnet,$sql_file_3);
										$query_file_3_cnt = mysqli_num_rows($query_file_3);
									?>
										<li id="ql_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag children__item">
											<div class="node ui-selectee ui-selected selected-flag">
												<span class="close ui-selectee" style="">
													<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button>
												</span>
									            <a href="javascript:<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="<?=$row_file_2['analysis_report_decision_option_model_quiz_title']?>"><?=$row_file_2['analysis_report_decision_option_model_quiz_title']?></a>
												<input class="dec_in ui-selectee" type="text" placeholder="<?=$row_file_2['analysis_report_decision_option_model_quiz_title']?>" title="<?=$row_file_2['analysis_report_decision_option_model_quiz_title']?>" style="">
												<div class="score_div ui-selectee ui-selected selected-flag">
													<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="decision_option_model_title_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" id="decision_option_model_title_<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>" class="left_input_score ui-selectee" style="">
												</div>
												<div class="dec_bwrap ui-selectee" style="">
												<?if($query_file_3_cnt > 0){ // 하위 카운트 있을때 시작 ?>
													<div class="dec_add dec_add1 ui-selectee" style="display:none;">
														<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','add');" class="ui-selectee"></button>
													</div>
													<div class="dec_min dec_min1 ui-selectee" style="display:block;">
														<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','minus');" class="ui-selectee"></button>
													</div>
												<?}else{?>
													<div class="dec_add dec_add1 ui-selectee">
														<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt="" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','add');" class="ui-selectee"></button>
													</div>
													<div class="dec_min dec_min1 ui-selectee">
														<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('<?=$row_file_2['analysis_report_decision_option_model_quiz_no']?>','minus');" class="ui-selectee"></button>
													</div>
												<?}?>
												</div>
											</div>
											<?if($query_file_3_cnt > 0){ // 하위 카운트 있을때 시작 ?>
												<ol class="children">
												<?
												for($opt_i3=0; $opt_i3<$query_file_3_cnt; $opt_i3++){ // 하위 카운트 루프 시작 
													$row_file_3 = mysqli_fetch_array($query_file_3);
												?>
												<li id="ql_<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>" class="item_serv ui-selectee ui-selected selected-flag children__item">
													<div class="node ui-selectee ui-selected selected-flag">
														<span class="close ui-selectee" style="">
															<button type="button" class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button>
														</span>
														<a href="javascript:<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>;" class="overtext ui-selectee ui-selected selected-flag" title="<?=$row_file_3['analysis_report_decision_option_model_quiz_title']?>"><?=$row_file_3['analysis_report_decision_option_model_quiz_title']?></a>
														<input class="dec_in ui-selectee" type="text" placeholder="<?=$row_file_3['analysis_report_decision_option_model_quiz_title']?>" title="<?=$row_file_3['analysis_report_decision_option_model_quiz_title']?>" style="">
														<div class="score_div ui-selectee ui-selected selected-flag">
															<input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="decision_option_model_title_<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>" id="decision_option_model_title_<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>" class="left_input_score ui-selectee" style="">
														</div>
														<div class="dec_bwrap ui-selectee" style="">
															<div class="dec_add dec_add1 ui-selectee">
																<button type="button" class="ui-selectee"><img src="./img/plus_sq.png" alt=""	onclick="go_tmp_child('<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>','add');" class="ui-selectee"></button>
															</div>
															<div class="dec_min dec_min1 ui-selectee">
																<button type="button" class="ui-selectee"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('<?=$row_file_3['analysis_report_decision_option_model_quiz_no']?>','minus');" class="ui-selectee"></button>
															</div>
														</div>
													</div>
												</li>
												<?} // 하위 카운트 루프 종료 ?>
												</ol>
											<?} // 하위 카운트 있을때 종료 ?>
										</li>
									 <?} // 하위 카운트 루프 종료 ?>
									 </ol>
								<?}  // 하위 카운트 있을때 종료 ?>
							<?}  // 모델명 루프 종료 ?>
							<!-- 문항 컨텐츠 종료 -->
							</div>

                         </div>
                      </div>
                  </div>
            </div>
            </form>
            
			 <div class="btn_all">
                <div class="left_btn" onclick="location.href='decision_1.php?decision_option_idx=<?=$decision_option_idx?>';">
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
    
    <? include "./inc/common_pop.php"; ?>
    

<script>
        $(document).ready(function(){

            $(".content-xd").mCustomScrollbar({
					axis:"yx",
					theme:"light-3",
					scrollInertia:550,
					scrollbarPosition:"outside"
                        });




        });

</script> 
 
    
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
		$("#decision_option_status").val("com"); // 저장완료 
		var check = chkFrm('decision_2_frm');
		if(check) {
			var str_type_x_g = $("#select_type_x_g").html();
			$("#factor_no_x_g").val(str_type_x_g);

			$("#decision_2_frm").attr("action","decision_2_action.php");
			$("#decision_2_frm").submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#decision_option_status").val("tmp"); // 임시저장
		var str_type_x_g = $("#select_type_x_g").html();
		$("#factor_no_x_g").val(str_type_x_g);

		$("#decision_2_frm").attr("action","decision_2_action.php");
		$("#decision_2_frm").submit();
	}

	function go_tmp_child(pknum,mode) {
		$("#decision_option_status").val("tmp"); // 임시저장
		//var str_type_x_g = $("#select_type_x_g").html();
		//$("#factor_no_x_g").val(str_type_x_g);
		$("#child_pknum").val(pknum);
		$("#child_mode").val(mode);

		frm.action="decision_2_child_action.php";
		frm.submit();
	}
</script>


</body>
</html>
