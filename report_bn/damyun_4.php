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
		 <form name="frm" action="myreport_save_ing.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
		 <!--<form name="frm" action="damyun_4_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">-->
			<input type="hidden" name="damyun_option_status" id="damyun_option_status" value=""/>
			<input type="hidden" id="damyun_option_idx" name="damyun_option_idx" value="<?=$damyun_option_idx?>"> 
			
			<input type="hidden" name="report_type" id="report_type" value="damyun"/>
			<input type="hidden" id="report_idx" name="report_idx" value="<?=$damyun_option_idx?>"> 
			<input type="hidden" id="report_name" name="report_name" value="<?=$row['analysis_report_damyun_option_name']?>"> 

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
                                <p class="numbering"><span>3</span></p>
                                <p>분석옵션설정</p>
                            </li>
                            <li>
                                <p class="numbering"><span class="on_num">4</span></p>
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
                            <span>보고서를 다운로드합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력값이 저장되고, 분석이 종료됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>입력값이 초기화되고, 분석이 종료됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_flow serv_save content-rd">
                    <div class="mf_wrap">
                          <div class="form_wrap">
                                <div class="form">
                                    <label for="name" class="label_name">조사명</label>
                                    <span class="jo_name"><?=$row['analysis_report_damyun_option_name']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">모집단</label>
                                    <span class="peo_name"><?=$row['analysis_report_damyun_option_population']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">표본크기</label>
                                    <span class="cus_name"><?=$row['analysis_report_damyun_option_sampling']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">표본추출방법</label>
                                    <span class="way_name"><?=$row['analysis_report_damyun_option_samplingmethod']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">조사방법</label>
                                    
                                    <span class="sur_name"><?=$row['analysis_report_damyun_option_surveymethod']?></span>
                                </div>
                                 <div class="form">
                                    <label for="name" class="label_name">조사기간</label>
                                    <span class="date_name"><?=$row['analysis_report_damyun_option_data']?></span>
                                </div>
                                <!-- <div class="m5_logo">
                                    <img src="<?=$_P_DIR_WEB_FILE?>damyun/<?=$row['analysis_report_damyun_option_logo_c']?>" style="max-width:80%;">
                                </div> -->
                                <div class="down_btn  tabb1">
                                   <div class="input-email">
										<input type="text" placeholder="입력한 이메일" name="email" id="email" required="no" message="이메일" is_email="yes">
									</div>
                                    <!-- <button type="button"> 보고서 다운로드</button> -->
                                </div>
                                <div class="save_info">
                                    <p>현재 설정을 저장하시겠습니까?</p>
                                    <p>파일명 지정</p>
                                    <input type="text" placeholder="<?=$row['analysis_report_damyun_option_logo_o']?>" id="damyun_option_report_title" name="damyun_option_report_title" required="yes" message="보고서 파일명">
                                    <div class="save_btn">
                                       	<button class="save_on tabb2" type="button" onclick="go_submit();">예</button>
                                        <button class="save_none tabb3" type="button" onclick="go_delete();">아니오</button>
                                    </div>
										<div class="saved-name">
											<span class="sn-title">설정 파일명 :</span>
											<span class="sn-name"></span>
										</div>
                                </div>
                            </div>  
                       </div>
                </div>
            </div>
            </form>
            
			<div class="btn_all last">
                <div class="left_btn">
                    <button type="button" onclick="location.href='damyun_3.php?damyun_option_idx=<?=$damyun_option_idx?>';">이전 단계</button>
                </div>
                <div class="right_btn end">
                    <button type="button">종료</button>
                </div>
            </div>

        </div>
    </section>
    
    <? include "./inc/footer.php"; ?>

    <div class="common_pop ser4_1-pop">
        <form action="#">
            <div class="m2p_wrap">
                <p class="option_ment">분석이 진행되었습니다.<br /> 종료 후 다시 진행해 주세요.</p>
            </div>
            <div class="pj_ok">
                <button type="button">확인</button>
            </div>
        </form>
    </div>

         
        <div class="ser4-pop">
            <div class="m2p_wrap">
                <p class="option_ment">현재까지의 설정을 저장하지 않고 종료됩니다.</p>
                <div class="ok_btn">
                    <button type="button">확인</button>
                </div>
                <div class="no_btn">
                    <button type="button">아니오</button>
                </div>
            </div>
        </div>
<!--
        <div class="m5_2pop m2_pop">
            <div class="m2p_wrap">
                <p class="option_ment">분석이 진행되었습니다.<br /> 종료 후 다시 진행해 주세요.</p>
                <div class="ok_btn">
                    <button type="button">확인</button>
                </div>
            </div>
        </div>
-->
    
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
		$("#damyun_option_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#damyun_option_status").val("tmp"); // 임시저장
		frm.submit();
	}
</script>

</body>
</html>
