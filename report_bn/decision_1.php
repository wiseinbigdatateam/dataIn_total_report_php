<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$decision_option_idx = trim(sqlfilter($_REQUEST['decision_option_idx']));
	$chapter = trim(sqlfilter($_REQUEST['chapter']));

	if($decision_option_idx){
		$compet_info_sql = "select * from wise_analysis_report_decision_option where 1 and idx='".$decision_option_idx."'";
		if($memid){
			$compet_info_sql .= " and memid='".$memid."'";
		}
		if($subid){
			$compet_info_sql .= " and subid='".$subid."'";
		}
		//echo $compet_info_sql."<br>";
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			$decision_option_idx = "";
		}
		
		//echo $compet_info_sql."<br>";
		$row = mysqli_fetch_array($compet_info_query);
	}

	$sql_file_1 = "select * from wise_analysis_report_decision_option_group where 1 and decision_option_idx='".$decision_option_idx."' order by idx asc"; // 표본특성문항
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);
	$query_file_1_cnt = mysqli_num_rows($query_file_1);
	if($query_file_1_cnt == 0){
		$query_file_1_cnt = 0;
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
		<form name="frm" action="decision_1_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
			<input type="hidden" id="decision_option_idx" name="decision_option_idx" value="<?=$decision_option_idx?>">
			<input type="hidden" id="chapter" name="chapter" value="<?=$chapter?>">
			<input type="hidden" name="decision_option_status" id="decision_option_status" value=""/>
			<input type="hidden" id="analysis_report_option_idx" name="analysis_report_option_idx" value="4"> <!-- 의사결정모델 보고서 -->
			<input type="hidden" id="analysis_report_option_title" name="analysis_report_option_title" value="의사결정모델 보고서">
			<input type="hidden" id="factor_no_x_g" name="factor_no_x_g"> <!-- 표본특성문항 -->     
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
                            <span>조사 대상을 입력하세요.</span>
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
                            <span>표본 특성 문항을 설정하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>좌측의 문항을 클릭 또는 드래그한 후 " + " 버튼을 눌러주 .</span>
                        </div>
                    </div>
                    <div class="cover_gc tab8">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>보고서에 사용될 로고를 등록해주세요.</span>
                        </div>
                    </div>
                </div>
                <div class="main_dec1 content-rd">
                    <div class="mf_wrap">
                         <div class="form_wrap">
								<div class="form tabb2">
                                    <label for="name" class="label_name">모집단</label>
                                     <input type="text" class="input" placeholder="전문가" id="decision_option_population" name="decision_option_population" value="<?=$row['analysis_report_decision_option_population']?>" required="no" message="모집단">
                                </div>
                                <div class="form tabb3">
                                    <label for="name" class="label_name">조사대상</label>
                                   <input type="text" class="input" placeholder="OO관련 전문가" id="decision_option_sampling" name="decision_option_sampling" value="<?=$row['analysis_report_decision_option_sampling']?>" required="no" message="조사대상">
                                </div>
                                <div class="form tabb4">
                                    <label for="name" class="label_name">표본추출방법</label>
                                    <input type="text" class="input" placeholder="모집단 고객유형에 따른 임의할당 표본추출(Quota Sampling)" id="decision_option_samplingmethod" name="decision_option_samplingmethod" value="<?=$row['analysis_report_decision_option_samplingmethod']?>" required="no" message="표본추출방법">
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">조사방법</label>
                                     <input type="text" class="input tabb5" placeholder="일대일 개별면접조사(Face to Face interview)" id="decision_option_surveymethod" name="decision_option_surveymethod" value="<?=$row['analysis_report_decision_option_surveymethod']?>" required="no" message="조사방법">
                                </div>
                                 <div class="form tabb6">
                                    <label for="name" class="label_name">조사기간</label>
                                   <input type="text" class="input " placeholder="20XX년 XX월 XX일 ~ 20XX년 XX월 XX일" id="decision_option_data" name="decision_option_data" value="<?=$row['analysis_report_decision_option_data']?>" required="no" message="조사기간">
                                </div>
         				
                                 <div class="form dec tabb7 sample_munhang">
                                    <label for="name" class="label_name ">표본특성문항</label>
                                    <div class="icon_box ">
                                        <div class="dec_btn">
                                            <div class="decp_add">
                                                <button class="dec_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                            </div>
                                            <div class="decp_re">
                                                <button type="button"><img src="./img/return_sq.png" alt=""></button>
                                            </div>
										</div>
                                        <div class="dec_box">
                                            <ul id="select_type_x_g">
											<?
												for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){
													$row_file_1 = mysqli_fetch_array($query_file_1);
											?>	
													<li id="ql_<?=$row_file_1['analysis_report_decision_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$row_file_1['analysis_report_decision_option_group_no']?>;" class="ui-selectee"><?=$row_file_1['analysis_report_decision_option_group_title']?></a></li>
											<?}?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
																
							    <input type="hidden" name="dfile_old_name" id="dfile_old_name" value="<?=$row['analysis_report_decision_option_logo_c']?>"/>
								<input type="hidden" name="dfile_old_org" id="dfile_old_org" value="<?=$row['analysis_report_decision_option_logo_o']?>"/>

                                 <div class="form logobutton tabb8">
                                    <label for="name" class="label_name">로고등록</label>
                                    <div class="file-input">
                                        <input type="file" required="no" message="기타 첨부자료" name="file_1" id="file_1">
                                        <span class="button">파일선택</span>
                                        <span class="label" data-js-label="">선택된 파일 없음</span>
                                    </div>
                                </div>

								<?if($row['analysis_report_decision_option_logo_o']){?>	
								 <div class="delete_check">
                                    <span class="dc-name">현재파일 : <a href="/report/pro_inc/download_file.php?nm=<?=$row['analysis_report_decision_option_logo_c']?>&on=<?=$row['analysis_report_decision_option_logo_o']?>&dir=decision"><?=$row['analysis_report_decision_option_logo_o']?></a></span>
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
		$("#decision_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			var str_type_x_g = $("#select_type_x_g").html();
			$("#factor_no_x_g").val(str_type_x_g);

			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#decision_option_status").val("tmp"); // 임시저장

		var str_type_x_g = $("#select_type_x_g").html();
		$("#factor_no_x_g").val(str_type_x_g);

		frm.submit();
	}
    
</script>
    
	<? include "./inc/common_pop.php"; ?>

</body>
</html>
