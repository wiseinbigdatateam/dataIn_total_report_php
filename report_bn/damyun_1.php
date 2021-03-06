<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$damyun_option_idx = trim(sqlfilter($_REQUEST['damyun_option_idx']));
	$chapter = trim(sqlfilter($_REQUEST['chapter']));

	if($damyun_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_damyun_option where 1 and idx='".$damyun_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		//echo $compet_info_sql."<br>";
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			$damyun_option_idx = "";
		}

		$row = mysqli_fetch_array($compet_info_query);
	}

	$sql_file_1 = "select * from wise_analysis_report_damyun_option_group where 1 and damyun_option_idx='".$damyun_option_idx."' and type='P' order by idx asc"; // 집단구분 항목 
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 1;
	}

	$sql_file_2 = "select * from wise_analysis_report_damyun_option_group where 1 and damyun_option_idx='".$damyun_option_idx."' and type='G' order by idx asc";
	// 평가대상 구분 
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
        <div class="body_w s1">
           <form name="frm" action="damyun_1_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" id="damyun_option_idx" name="damyun_option_idx" value="<?=$damyun_option_idx?>">
			<input type="hidden" id="chapter" name="chapter" value="<?=$chapter?>">
			<input type="hidden" name="damyun_option_status" id="damyun_option_status" value=""/>
			<input type="hidden" id="analysis_report_option_idx" name="analysis_report_option_idx" value="3"> <!-- 다면 평가모델 보고서 -->
			<input type="hidden" id="analysis_report_option_title" name="analysis_report_option_title" value="다면 평가모델 보고서">
			<input type="hidden" name="attach_count_1" id="attach_count_1" value="<?=$query_file_1_cnt?>"/> <!-- 집단구분 항목 -->
			<input type="hidden" name="attach_count_2" id="attach_count_2" value="<?=$query_file_2_cnt?>"/> <!-- 평가대상 구분 -->
			<input type="hidden" id="factor_no_x_g" name="factor_no_x_g"> <!-- 평가대상 구분 -->     
			<input type="hidden" id="factor_no_x_p" name="factor_no_x_p"> <!-- 집단구분 항목 -->     
			<div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro">
                <? include "./inc/gnb.php"; ?>
			   <div class="m_paging">
                    <div class="page_wrap">
                        <ul>
                            <li>
                                <p class="numbering"><span class="on_num">1</span></p>
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
                            <span>조사명을 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>모집단을 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>표본크기를 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>표본 추출 방법을 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>조사 방법을 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab6">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>조사 기간을 입력하세요.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab7">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측 문항을 선택 후 " + " 버튼을 클릭시 문항이 추가됩니다.  (문항 1개씩만 가능)</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>리셋 버튼을 클릭시 추가된 문항들이 삭제됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>하단의 " + " 버튼 클릭시 항목 입력란이 추가됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab8">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>보고서에 사용될 로고를 등록해주세요.</span>
                        </div>
                    </div>
                </div>
                <div class="main_flow main_dam1 content-rd">
                    <div class="mf_wrap">
                         <div class="form_wrap">
                                <div class="p1_wrap tabb1">
                                    <span class="title_1p">조사명</span>
                                    <input type="text" class="input" placeholder="20XX년 와이즈인컴퍼니 다면평가" id="damyun_option_name" name="damyun_option_name" value="<?=$row['analysis_report_damyun_option_name']?>" required="no" message="조사명">
									<?//=zero_point_set_16("3.0","16")?>
                                </div>
                                <div class="p1_wrap tabb2">
                                    <span class="title_1p">모집단</span>
                                    <input type="text" class="input" placeholder="2020년 현재 와이즈인컴퍼니 전직원 (00명)" id="damyun_option_population" name="damyun_option_population" value="<?=$row['analysis_report_damyun_option_population']?>" required="no" message="모집단">
                                </div>
                                <div class="p1_wrap tabb3">
                                    <span class="title_1p">표본크기</span>
                                    <input type="text" class="input" placeholder="총 00명, (A팀 : 0명, B팀 : 0명, C팀 : 0명,)" id="damyun_option_sampling" name="damyun_option_sampling" value="<?=$row['analysis_report_damyun_option_sampling']?>" required="no" message="표본크기">
                                </div>
                                <div class="p1_wrap tabb4">
                                    <span class="title_1p">표본추출방법</span>
                                    <input type="text" class="input" placeholder="전수조사" id="damyun_option_samplingmethod" name="damyun_option_samplingmethod" value="<?=$row['analysis_report_damyun_option_samplingmethod']?>" required="no" message="표본추출방법">
                                </div>
                                <div class="p1_wrap tabb5">
                                    <span class="title_1p">조사방법</span>
                                    <input type="text" class="input" placeholder="온라인/모바일 조사" id="damyun_option_surveymethod" name="damyun_option_surveymethod" value="<?=$row['analysis_report_damyun_option_surveymethod']?>" required="no" message="조사방법">
                                </div>
                                 <div class="p1_wrap tabb6">
                                    <span class="title_1p">조사기간</span>
                                    <input type="text" class="input " placeholder="20XX년 XX월 XX일 ~ 20XX년 XX월 XX일" id="damyun_option_data" name="damyun_option_data" value="<?=$row['analysis_report_damyun_option_data']?>" required="no" message="조사기간">
                                </div>
							<?
								for($opt_i=0; $opt_i<$query_file_2_cnt; $opt_i++){
									$row_file_2 = mysqli_fetch_array($query_file_2);
							?>
                            <!-- -------------- 수정필요 --------------- -->
                                <div class="p1_wrap tabb7">
                                    <div class="ser_wrap pyung">
                                        <span class="title_1p">평가자</span>
                                        <div class="icon_box ">
                                            <div class="ser_btn" id="select_type_x_g<?=($opt_i+1)?>">
                                                <div class="ser_add">
                                                    <button class="ser_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                                </div>
												<?if($row_file_2['analysis_report_damyun_option_group_no']){?>
													<li id="ql_<?=$row_file_2['analysis_report_damyun_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_2['analysis_report_damyun_option_group_no']?>;" class="ui-selectee"><?=$row_file_2['analysis_report_damyun_option_group_title']?></a></li>
												<?}?>
                                            </div>
                                            <div class="ser_box">
                                                <ul>
												</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p1_wrap tabb7">
                                    <div class="ser_wrap pyung">
                                        <span class="title_1p">피평가자</span>
                                        <div class="icon_box ">
                                            <div class="ser_btn" id="select_type_x_g<?=($opt_i+1)?>">
                                                <div class="ser_add">
                                                    <button class="ser_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                                </div>
												<?if($row_file_2['analysis_report_damyun_option_group_no']){?>
													<li id="ql_<?=$row_file_2['analysis_report_damyun_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_2['analysis_report_damyun_option_group_no']?>;" class="ui-selectee"><?=$row_file_2['analysis_report_damyun_option_group_title']?></a></li>
												<?}?>
                                            </div>
                                            <div class="ser_box">
                                                <ul>
												</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- --------------수정필요 END------------ -->
                                 <div class="p1_wrap tabb7">
                                    <div class="ser_wrap pyung">
                                        <span class="title_1p">평가대상구분</span>
                                        <div class="icon_box ">
                                            <div class="ser_btn" id="select_type_x_g<?=($opt_i+1)?>">
                                                <div class="ser_add">
                                                    <button class="ser_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                                </div>
												<?if($row_file_2['analysis_report_damyun_option_group_no']){?>
													<li id="ql_<?=$row_file_2['analysis_report_damyun_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_2['analysis_report_damyun_option_group_no']?>;" class="ui-selectee"><?=$row_file_2['analysis_report_damyun_option_group_title']?></a></li>
												<?}?>
                                            </div>
                                            <div class="ser_box">
                                                <ul>
												</ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?}?>
							
							<?
								for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
									$row_file_1 = mysqli_fetch_array($query_file_1);
							?>
								 <div class="p1_wrap tabb7">
                                    <div class="ser_wrap ser">
                                        <div class="ser_del">
                                            <button type="button"><img src="./img/minus_sq.png" alt=""></button>
                                        </div>
                                        <span class="title_1p">집단구분항목</span>
                                        <div class="icon_box  ">
                                            <div class="ser_btn" id="select_type_x_p<?=($opt_i+1)?>">
                                                <div class="ser_add">
                                                    <button class="ser_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                                </div>
												<?if($row_file_1['analysis_report_damyun_option_group_no']){?>
													<li id="ql_<?=$row_file_1['analysis_report_damyun_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_1['analysis_report_damyun_option_group_no']?>;" class="ui-selectee"><?=$row_file_1['analysis_report_damyun_option_group_title']?></a></li>
												<?}?>
                                            </div>
                                            <div class="ser_box">
                                                <ul>
												 </ul>
                                            </div>
                                        </div>
									<div class="jib_bot" id="jib_bot<?=($opt_i+1)?>" style="display:<?if($opt_i < ($query_file_1_cnt-1)){?>none<?}else{?>block<?}?>;">
                                        <div class="jibb_add">
                                            <button type="button">
                                                <img src="./img/plus_sq.png" alt="">
                                            </button>
                                            <div class="jib_line">
                                                <div class="line"></div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
							 <?}?>    

							 <input type="hidden" name="dfile_old_name" id="dfile_old_name" value="<?=$row['analysis_report_damyun_option_logo_c']?>"/>
							<input type="hidden" name="dfile_old_org" id="dfile_old_org" value="<?=$row['analysis_report_damyun_option_logo_o']?>"/>

                                 <div class="p1_wrap tabb8">
                                    <label for="name" class="title_1p">로고등록</label>
                                    <div class="file-input">
                                        <input type="file" required="no" message="기타 첨부자료" name="file_1" id="file_1">
                                        <span class="button">파일선택</span>
                                        <span class="label" data-js-label="">선택된 파일 없음</span>
                                    </div>
                                </div>

								<?if($row['analysis_report_damyun_option_logo_o']){?>	
								 <div class="delete_check">
                                    <span class="dc-name">현재파일 : <a href="/report/pro_inc/download_file.php?nm=<?=$row['analysis_report_damyun_option_logo_c']?>&on=<?=$row['analysis_report_damyun_option_logo_o']?>&dir=damyun"><?=$row['analysis_report_damyun_option_logo_o']?></a></span>
                                    <label for="del-check">
										<input type="checkbox" name="ddel_org" id="ddel_org" value="Y"> 삭제
                                    </label>
                                </div>
							   <?}?>

                            </div>
                       </div>
                </div>
            </div>
			</form>

            <div class="btn_all p1">
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
		$("#damyun_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {

			var attach_count_1 = Number($("#attach_count_1").val()); 
			var attach_count_2 = Number($("#attach_count_2").val()); 
			var str_type_x_g = '';
			var str_type_x_p = '';
			
			for(i=1; i<=attach_count_2; i++){
				if (i == attach_count_2){
					str_type_x_g = str_type_x_g+$("#select_type_x_g"+i+"").html();
				} else {
					str_type_x_g = str_type_x_g+$("#select_type_x_g"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_g").val(str_type_x_g);

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
		$("#damyun_option_status").val("tmp"); // 임시저장
			
			var attach_count_1 = Number($("#attach_count_1").val()); 
			var attach_count_2 = Number($("#attach_count_2").val()); 
			var str_type_x_g = '';
			var str_type_x_p = '';
			
			for(i=1; i<=attach_count_2; i++){
				if (i == attach_count_2){
					str_type_x_g = str_type_x_g+$("#select_type_x_g"+i+"").html();
				} else {
					str_type_x_g = str_type_x_g+$("#select_type_x_g"+i+"").html()+"||";
				}
			}
			$("#factor_no_x_g").val(str_type_x_g);

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
    
</script>
    
	<? include "./inc/common_pop.php"; ?>

</body>
</html>
