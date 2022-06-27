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
		//echo $compet_info_sql."<br>";
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			$satisfaction_option_idx = "";
		}

		$row = mysqli_fetch_array($compet_info_query);
	}

	$sql_file_1 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X' order by idx asc"; // 독립변수 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);

	$sql_file_2 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='Y' order by idx asc"; // 종속변수 
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);

	$sql_file_3 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='M' order by idx asc"; // 중간변수 
	$query_file_3 = mysqli_query($gconnet,$sql_file_3);
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

		<form name="frm" action="manjok_2_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" name="satisfaction_option_model_status" id="satisfaction_option_model_status" value=""/>
			<input type="hidden" id="satisfaction_option_idx" name="satisfaction_option_idx" value="<?=$satisfaction_option_idx?>"> 

			<?if(mysqli_num_rows($query_file_1) == 0){?>
				<input type="hidden" name="attach_count_1" id="attach_count_1" value="1"/> <!-- 독립변수 입력갯수 -->
			<?}else{?>
				<input type="hidden" name="attach_count_1" id="attach_count_1" value="<?=mysqli_num_rows($query_file_1)?>"/> <!-- 독립변수 입력갯수 -->
			<?}?>
		
			<?if(mysqli_num_rows($query_file_2) == 0){?>
				<input type="hidden" name="attach_count_2" id="attach_count_2" value="1"/> <!-- 종속변수 입력갯수 -->
			<?}else{?>
				<input type="hidden" name="attach_count_2" id="attach_count_2" value="<?=mysqli_num_rows($query_file_2)?>"/> <!-- 종속변수 입력갯수 -->
			<?}?>

			<input type="hidden" id="factor_no_x_p" name="factor_no_x_p"> 
			<input type="hidden" id="factor_no_x_c" name="factor_no_x_c"> 
			<input type="hidden" id="factor_no_m_p" name="factor_no_m_p"> 
			<input type="hidden" id="factor_no_m_c" name="factor_no_m_c"> 
			<input type="hidden" id="factor_no_y_p" name="factor_no_y_p"> 
			<input type="hidden" id="factor_no_y_c" name="factor_no_y_c"> 

			<input type="hidden" id="tot_weight_val" name="tot_weight_val" value="0">

            <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro ">
                <div class="main_cmenu">
                    <ul>
                        <li class="selected"><a href="javascript:;">만족도모델 보고서</a></li>
                        <li><a href="javascript:;">서비스평가모델 보고서</a></li>
                        <li><a href="javascript:;">다면평가모델 보고서</a></li>
                        <li><a href="javascript:;">의사결정모델 보고서</a></li>
                    </ul>
                </div>
                <div class="m_paging man">
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
                            <span>문항을 추가해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측에서 문항을 드래그 혹은 클릭으로 선택 후 " + " 버튼을 클릭하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>추가된 문항의 좌측 " X " 버튼을 누르시면 삭제됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>문항들의 제목을 입력해주세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>요소만족도를 추가해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측의 문항리스트에서 선택 후 " + " 버튼을 클릭하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>추가된 문항의 좌측 " X " 버튼을 누르시면 삭제됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>가중치를 입력해주세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>가중치의 총합은 "100"이어야합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 새로운 문항 박스가 생성됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>생성된 박스의 " - "버튼 클릭시 삭제됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab6">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>" - "버튼 클릭시 박스가 삭제됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_flow  content-xd">
                    <div class="mf_wrap">
                        <div class="mf_all">
                            <div class="mindmap">
                                <ol class="children children_leftbranch">
								 <!-- 독립변수 파트 시작 -->
							<?if(mysqli_num_rows($query_file_1) == 0){?>
                                    <li id="" class="children__item">
                                        <div class="node lbox_n">
                                             <div class="box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_l tabb1">
                                                          	<ul class="box_big content-rd selectable" id="select_type_x_p1"></ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add" id="bb_add1"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
																<!--
																	<div>
																		<button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
																	</div>
																-->
																<div class="count" id="select_quiz_cnt1"></div>
                                                            </div>
                                                        </div>
                                                        <div class="bwt_r tabb2">
                                                        	<textarea name="option_variable_x_title[]" id="" cols="30" rows="10" placeholder="제목"></textarea>
                                                        </div>
                                                        <div class="tabb6">
                                                            <button  type="button" class="chi_del"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="box_mid">
                                                        <div class="bwm_l">
                                                            <div class="ym_wrap tabb3">
                                                                <span  class="ym_title">요소만족도</span>
                                                                <span>:</span>
                                                                <button type="button" class="ym_add"><img src="./img/plus_sq.png" alt=""></button>
                                                               	<div class="y_wrap" id="select_type_x_c1"></div>
                                                                <input type="number" class="yo_num" name="variable_x_elementweight[]" placeholder="가중치%" onblur="calc_weight();" id="elementweight1">
                                                            </div>
                                                        </div>
                                                        <div class="bwm_r tabb4">
                                                            <input type="number" placeholder="가중치%" name="variable_x_weight[]" onblur="calc_weight();" id="weight1">
                                                        </div>
                                                    </div>
                                                    <div class="box_bot_1 tabb5" id="box_bot1">
                                                        <div class="bwb_l">
                                                            <img src="./img/plus_sq.png" alt="">
                                                        </div>
                                                        <div class="bwb_r">
                                                            <div class="bw_line"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                    </li>
							<?}else{?>
								<?
									for($opt_i=0; $opt_i<mysqli_num_rows($query_file_1); $opt_i++){
										$row_file_1 = mysqli_fetch_array($query_file_1);
								?>
									<li id="" class="children__item">
                                        <div class="node lbox_n">
                                             <div class="box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_l tabb1">
                                                          	<ul class="box_big content-rd selectable" id="select_type_x_p1"></ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add" id="bb_add1"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
																<!--
																	<div>
																		<button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
																	</div>
																-->
																<div class="count" id="select_quiz_cnt1"></div>
                                                            </div>
                                                        </div>
                                                        <div class="bwt_r tabb2">
                                                        	<textarea name="option_variable_x_title[]" id="" cols="30" rows="10" placeholder="제목">11</textarea>
                                                        </div>
                                                        <div class="tabb6">
                                                            <button  type="button" class="chi_del_1"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="box_mid">
                                                        <div class="bwm_l">
                                                            <div class="ym_wrap tabb3">
                                                                <span  class="ym_title">요소만족도</span>
                                                                <span>:</span>
                                                                <button type="button" class="ym_add"><img src="./img/plus_sq.png" alt=""></button>
                                                               	<div class="y_wrap" id="select_type_x_c1"></div>
                                                                <input type="number" class="yo_num" name="variable_x_elementweight[]" placeholder="가중치%" onblur="calc_weight();" id="elementweight1">
                                                            </div>
                                                        </div>
                                                        <div class="bwm_r tabb4">
                                                            <input type="number" placeholder="가중치%" name="variable_x_weight[]" onblur="calc_weight();" id="weight1">
                                                        </div>
                                                    </div>
                                                    <div class="box_bot_1 tabb5" id="box_bot<?=($opt_i+1)?>">
                                                        <div class="bwb_l">
                                                            <img src="./img/plus_sq.png" alt="">
                                                        </div>
                                                        <div class="bwb_r">
                                                            <div class="bw_line"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                    </li>
								<?}?>
							<?}?>
                                   <!-- 독립변수 파트 종료 -->  
                                </ol>
                                <div class="node node_root cw_mw">
                                   <!-- 중간변수 파트 시작 -->
                                            <div class="box_wrap center_wrap">
                                                <div class="bw_top">
                                                    <div class="bwt_r tabb2">
                                                        <textarea name="title" name="option_variable_m_title" id="option_variable_m_title" cols="30" rows="10" placeholder="제목"></textarea>
                                                    </div>
                                                    <div class="bwt_l tabb1">
                                                        <ul class="box_big content-rd selectable" id="select_type_m_p"></ul>
                                                        <div class="bb_btn">
                                                            <div>
                                                                <button type="button" class="bb_add_m"><img src="./img/plus_sq.png" alt=""></button>
                                                            </div>
<!--
                                                            <div>
                                                                <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                            </div>
-->
                                                            <div class="count" id="select_quiz_m_cnt"></div>
                                                        </div>
                                                    </div>
                                                    <div class="center_ga tabb4">
                                                    <input type="number" placeholder="가중치%" name="variable_m_weight" placeholder="가중치%" onblur="calc_weight();">
                                                    </div>
                                                </div>
                                            </div>
									 <!-- 중간변수 파트 종료 -->
                                </div>
                                    <ol class="children children_rightbranch">
                                      <!-- 종속변수 파트 시작 -->     
										<li class="children__item2">
                                            <div class="node rbox_n">
                                                    <div class="rbox_wrap box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_r tabb2">
                                                            <textarea name="title" name="option_variable_y_title[]" id="" cols="30" rows="10" placeholder="제목"></textarea>
                                                        </div>
                                                        <div class="bwt_l tabb1">
                                                           <ul class="box_big content-rd selectable" id="select_type_y_p1"></ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add_y" id="bb_add_y1"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
<!--
                                                                <div>
                                                                    <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                                </div>
-->
                                                               <div class="count" id="select_quiz_y_cnt1"></div>
                                                            </div>
                                                        </div>
                                                        <div class="chi_wel tabb6">
                                                            <button type="button" class="chi_del_1_y"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="rbox_bot_1 tabb5" id="rbox_bot1">
                                                        <div class="bwb_l">
                                                            <img src="./img/plus_sq.png" alt="">
                                                        </div>
                                                        <div class="bwb_r">
                                                            <div class="bw_line"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                          </li>
										 <!-- 종속변수 파트 종료 -->  
                                    </ol>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="sum_line">
                    <div class="ga_sum">
                        <span>가중치 총합</span>
                        <span>:</span>
                        <span class="gas_num" id="tot_weight_area">0</span>
                    </div>
                    <div class="by_sum">
                        <span>변수 총계</span>
                        <span>:</span>
                        <span class="bys_num" id="tot_var_x_area">0</span>
                    </div>
                    <div class="iy_sum">
                        <span>변수 총계</span>
                        <span>:</span>
                        <span class="iys_num" id="tot_var_y_area">0</span>
                    </div>
                </div>
            </div>

			</form>

            <div class="btn_all">
                <div class="left_btn">
                    <button type="button" onclick="location.href='manjok_1.php?satisfaction_option_idx=<?=$satisfaction_option_idx?>';">이전 단계</button>
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

    <div class="m2_pop" id="m2_pop_area">
        <div class="m2p_wrap">
            <p class="ga_ment">현재 가중치 총 합이 100%가 아닙니다.</p>
            <p class="moon_ment">문항이 전부 설정되지않았습니다.</p>
            <p class="by_ment">변수명에 공란이 있습니다.</p>
            <p class="yo_ment">요소만족도는 1개의 문항만 추가가 가능합니다.</p>
            <div class="ok_btn">
                <button type="button">확인</button>
            </div>
        </div>
    </div>
    
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

	
	function calc_weight(){
		/*var attach_count_1 = Number($("#attach_count_1").val()); 
		var attach_count_2 = Number($("#attach_count_1").val()); 
		alert(document.frm.variable_x_elementweight[0].value());

		var tot_weight = 0;
		for(i=0; i<attach_count_1; i++){
			 var weight_ele = Number($("input[name=variable_x_elementweight]:eq("+i+")").val());
			 //alert(weight_ele);
			 var weight = Number($("input[name=variable_x_weight]:eq("+i+")").val());
			 var each_weight = weight_ele+weight;
			 tot_weight = tot_weight+each_weight;
		}

		$("#tot_weight_area").html(tot_weight);*/
		
		
		frm.action = "manjok_2_calcurate_weight.php";
		frm.submit();
		
	}

    
    function go_submit() {
		$("#satisfaction_option_model_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {

			var attach_count_1 = Number($("#attach_count_1").val()); 
			var attach_count_2 = Number($("#attach_count_2").val()); 

			var tot_weight_val = Number($("#tot_weight_val").val()); 
				
			var str_type_x_p = '';
			var str_type_x_c = '';
			var str_type_m_p = '';
			var str_type_m_c = '';
			var str_type_y_p = '';
			var str_type_y_c = '';

			for(i=1; i<=attach_count_1; i++){
				if (i == attach_count_1){
					str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html();
					str_type_x_c = str_type_x_c+$("#select_type_x_c"+i+"").html();
				} else {
					str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html()+"||";
					str_type_x_c = str_type_x_c+$("#select_type_x_c"+i+"").html()+"||";
				}
			}
		
			str_type_m_p = $("#select_type_m_p").html();

			for(i=1; i<=attach_count_2; i++){
				if (i == attach_count_2){
					str_type_y_p = str_type_y_p+$("#select_type_y_p"+i+"").html();
					//str_type_y_c = str_type_y_c+$("#select_type_y_c"+i+"").html();
				} else {
					str_type_y_p = str_type_y_p+$("#select_type_y_p"+i+"").html()+"||";
					//str_type_y_c = str_type_y_c+$("#select_type_y_c"+i+"").html()+"||";
				}
			}

			$("#factor_no_x_p").val(str_type_x_p);
			$("#factor_no_x_c").val(str_type_x_c);
			$("#factor_no_m_p").val(str_type_m_p);
			$("#factor_no_y_p").val(str_type_y_p);
			
			if(tot_weight_val == 100 || tot_weight_val == 0){
				$("#m2_pop_area").hide();
				frm.action = "manjok_2_action.php";
				frm.submit();
			} else {
				$("#m2_pop_area").show();
			}

		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#satisfaction_option_model_status").val("tmp"); // 임시저장
		var attach_count_1 = Number($("#attach_count_1").val()); 
		var attach_count_2 = Number($("#attach_count_2").val()); 
				
		var str_type_x_p = '';
		var str_type_x_c = '';
		var str_type_m_p = '';
		var str_type_m_c = '';
		var str_type_y_p = '';
		var str_type_y_c = '';

		for(i=1; i<=attach_count_1; i++){
			if (i == attach_count_1){
				str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html();
				str_type_x_c = str_type_x_c+$("#select_type_x_c"+i+"").html();
			} else {
				str_type_x_p = str_type_x_p+$("#select_type_x_p"+i+"").html()+"||";
				str_type_x_c = str_type_x_c+$("#select_type_x_c"+i+"").html()+"||";
			}
		}
		
		str_type_m_p = $("#select_type_m_p").html();

		for(i=1; i<=attach_count_2; i++){
			if (i == attach_count_2){
				str_type_y_p = str_type_y_p+$("#select_type_y_p"+i+"").html();
				//str_type_y_c = str_type_y_c+$("#select_type_y_c"+i+"").html();
			} else {
				str_type_y_p = str_type_y_p+$("#select_type_y_p"+i+"").html()+"||";
				//str_type_y_c = str_type_y_c+$("#select_type_y_c"+i+"").html()+"||";
			}
		}

		$("#factor_no_x_p").val(str_type_x_p);
		$("#factor_no_x_c").val(str_type_x_c);
		$("#factor_no_m_p").val(str_type_m_p);
		$("#factor_no_y_p").val(str_type_y_p);
		
		var tot_weight_val = Number($("#tot_weight_val").val()); 
		
		if(tot_weight_val == 100 || tot_weight_val == 0){
			$("#m2_pop_area").hide();
			frm.action = "manjok_2_action.php";
			frm.submit();
		} else {
			$("#m2_pop_area").show();
		}
	}       
</script>


</body>
</html>
