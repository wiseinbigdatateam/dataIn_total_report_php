<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$chapter = trim(sqlfilter($_REQUEST['chapter']));

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
	<form name="frm" action="manjok_1_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="satisfaction_option_status" id="satisfaction_option_status" value=""/>
		<input type="hidden" id="satisfaction_option_data_v" name="satisfaction_option_data_v">
		<input type="hidden" id="analysis_report_option_idx" name="analysis_report_option_idx" value="1"> <!-- 만족도모델 보고서 -->
		<input type="hidden" id="analysis_report_option_title" name="analysis_report_option_title" value="만족도모델 보고서">
		<input type="hidden" id="satisfaction_option_idx" name="satisfaction_option_idx" value="<?=$satisfaction_option_idx?>">
		<input type="hidden" id="chapter" name="chapter" value="<?=$chapter?>">

        <div class="body_w s1">
           <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro">
                 <? include "./inc/gnb.php"; ?>
                <div class="m_paging man">
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
                <div class="main_flow main_pyo content-rd">
                    <div class="mf_wrap">
                        <div class="form_wrap">
                                <div class="form tabb1">
                                    <label for="name" class="label_name">조사명</label>
                                    <input type="text" class="input" placeholder="20XX년 고객만족도 조사 결과 보고서" id="satisfaction_option_name" name="satisfaction_option_name" value="<?=$row['analysis_report_satisfaction_option_name']?>" required="no" message="조사명">
                                </div>
                                <div class="form tabb2">
                                    <label for="name" class="label_name">모집단</label>
                                    <input type="text" class="input" placeholder="OOOO 서비스 이용 고객" id="satisfaction_option_population" name="satisfaction_option_population" value="<?=$row['analysis_report_satisfaction_option_population']?>" required="no" message="모집단">
                                </div>
                                <div class="form tabb3">
                                    <label for="name" class="label_name">조사대상</label>
                                    <input type="text" class="input" placeholder="최근 1년 이내에 OOOO 서비스를 받은 경험이 있는 고객" id="satisfaction_option_sampling" name="satisfaction_option_sampling" value="<?=$row['analysis_report_satisfaction_option_sampling']?>" required="no" message="조사대상">
                                </div>
                                <div class="form tabb4">
                                    <label for="name" class="label_name">표본추출방법</label>
                                    <input type="text" class="input" placeholder="모집단 고객유형에 따른 임의할당 표본추출(Quota Sampling)" id="satisfaction_option_samplingmethod" name="satisfaction_option_samplingmethod" value="<?=$row['analysis_report_satisfaction_option_samplingmethod']?>" required="no" message="표본추출방법">
                                </div>
                                <div class="form tabb5">
                                    <label for="name" class="label_name">조사방법</label>
                                    <input type="text" class="input" placeholder="일대일 개별면접조사(Face to Face interview)" id="satisfaction_option_surveymethod" name="satisfaction_option_surveymethod" value="<?=$row['analysis_report_satisfaction_option_surveymethod']?>" required="no" message="조사방법">
                                </div>
                                 <div class="form tabb6">
                                    <label for="name" class="label_name">조사기간</label>
                                    <input type="text" class="input" placeholder="20XX년 XX월 XX일 ~ 20XX년 XX월 XX일" id="satisfaction_option_data" name="satisfaction_option_data" value="<?=$row['analysis_report_satisfaction_option_data']?>" required="no" message="조사기간">
                                </div>
                                 <div class="form sample_munhang tabb7">
                                    <label for="name" class="label_name ">표본특성문항</label>
                                    <div class="icon_box ">
                                        <div class="pyo_btn">
                                            <div class="pyo_add">
                                                <button class="pyo_bbd" type="button"><img src="./img/plus_sq.png" alt=""></button>
                                            </div>
                                            <div class="pyo_re">
                                                <button type="button"><img src="./img/return_sq.png" alt=""></button>
                                            </div>
                                        </div>
                                        <div class="pyo_box">
                                            <ul id="satisfaction_option_group_type_area">
									<?
									$opt_sql = "select idx,analysis_report_satisfaction_option_group_no,analysis_report_satisfaction_option_group_title from wise_analysis_report_satisfaction_option_group where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' order by idx asc";
									$opt_query = mysqli_query($gconnet,$opt_sql);
									$opt_cnt = mysqli_num_rows($opt_query);

									for($opt_i=0; $opt_i<$opt_cnt; $opt_i++){
										$opt_k = $opt_i+1;
										$opt_row = mysqli_fetch_array($opt_query);
									?>
										<li id="ql_<?=$opt_row['analysis_report_satisfaction_option_group_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="ui-selectee"></button></span><a href="javascript:<?=$opt_row['analysis_report_satisfaction_option_group_no']?>;" class="ui-selectee ui-selected selected-flag" title="<?=$opt_row['analysis_report_satisfaction_option_group_title']?>"><?=$opt_row['analysis_report_satisfaction_option_group_title']?></a></li>
									<?}?>
											</ul>
                                        </div>
                                    </div>
                                </div>
                                    <p class="pyo_info">※ 표본특성문항은 만족도 결과를 집단별로 분석하는 기준변수입니다. <br>
                                    ※ 하위 집단의 수가 최소 30표본 이상이 되도록 구성하시기 바랍니다. (예: 20대: 30명, 30대: 50명 O / 20대: 4명, 30대: 15명 X)</p>

							<input type="hidden" name="dfile_old_name" id="dfile_old_name" value="<?=$row['analysis_report_satisfaction_option_logo_c']?>"/>
							<input type="hidden" name="dfile_old_org" id="dfile_old_org" value="<?=$row['analysis_report_satisfaction_option_logo_o']?>"/>

								<div class="form logobutton tabb8">
                                    <label for="name" class="label_name">로고등록</label>
                                    <div class="file-input">
                                        <input type="file" required="no" message="기타 첨부자료" name="file_1" id="file_1">
                                        <span class="button">파일선택</span>
                                        <span class="label" data-js-label="">선택된 파일 없음</span>
                                    </div>
                                </div>
                            <?if($row['analysis_report_satisfaction_option_logo_o']){?>
								 <div class="delete_check">
                                    <span class="dc-name">현재파일 : <a href="/report/pro_inc/download_file.php?nm=<?=$row['analysis_report_satisfaction_option_logo_c']?>&on=<?=$row['analysis_report_satisfaction_option_logo_o']?>&dir=contentment"><?=$row['analysis_report_satisfaction_option_logo_o']?></a></span>
                                    <label for="del-check">
										<input type="checkbox" name="ddel_org" id="ddel_org" value="Y"> 삭제
                                    </label>
                                </div>
							<?}?>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="btn_all">
                <!--<div class="left_btn">
                    <button>이전 단계</button>
                </div>-->
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

	// 2021-07-31 : 임시 데이터 필터링 ----- wisein
  function formDataFilter(str) {

		str = str.replace(/ /g, "");
		str = str.replace(/-/g, "");
		str = str.replace(/"/g, "");
		str = str.replace(/:/g, "");

		return str;
  }

	function go_submit() {
		// 2021-07-31 : 임시 데이터 필터링 ----- wisein
		var data_v = formDataFilter($("#satisfaction_option_group_type_area").html());

		console.log(data_v);

		/*
		var data_v = "";
		$("#satisfaction_option_group_type_area").find("li").each(function() {
			if(data_v != "") data_v += ",";
			var id_arr = $(this).attr("id").split("_");
			data_v += id_arr[1];
		});
		*/

		//$("#satisfaction_option_data_v").val($("#satisfaction_option_group_type_area").html());
		$("#satisfaction_option_data_v").val(data_v);
		$("#satisfaction_option_status").val("com"); // 저장완료
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#satisfaction_option_data_v").val($("#satisfaction_option_group_type_area").html());
		$("#satisfaction_option_status").val("tmp"); // 임시저장
		frm.submit();
	}

	function del_uploaded_photo(num){
		 //$("#docu_"+num+"").val("");
		 $("#ddel_org_"+num+"").prop("checked", true);
		 $("#docu_area_name_"+num+"").html("");
		 $("#docu_area_"+num+"").hide();
		 var fcnt = Number($("#attach_count_1").val());
		 fcnt = fcnt -1;
		 $("#attach_count_1").val(fcnt);
	}

</script>

   <? include "./inc/common_pop.php"; ?>

</body>
</html>
