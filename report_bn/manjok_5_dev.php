<? include "./inc/header.php"; ?>
<?
	$memid = $_SESSION['wiz_session']['id'];
	$subid = $_SESSION['wiz_session']['subid'];
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));

	$compet_info_sql = "select * from wise_analysis_report_satisfaction_option where 1 and idx='".$satisfaction_option_idx."' and memid='".$memid."' and subid='".$subid."'";
	//echo $compet_info_sql;
	$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
	if(mysqli_num_rows($compet_info_query) == 0){
		error_go("다시 진행해주세요.","manjok_1.php");
	}

	$row = mysqli_fetch_array($compet_info_query);
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

	<form name="frm" action="manjok_5_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="satisfaction_option_model_status" id="satisfaction_option_model_status" value=""/>
		<input type="hidden" id="satisfaction_option_idx" name="satisfaction_option_idx" value="<?=$satisfaction_option_idx?>"> 

        <div class="body_w">
            <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>
            <div class="main_pro">
                <div class="main_cmenu">
                    <ul>
                        <li class="selected"><a href="javascript:;">만족도모델 보고서</a></li>
                        <li><a href="javascript:;">서비스평가모델 보고서</a></li>
                        <li><a href="javascript:;">다면평가모델 보고서</a></li>
                        <li><a href="javascript:;">의사결정모델 보고서</a></li>
                    </ul>
                </div>
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
                                <p class="numbering"><span>4</span></p>
                                <p>비교점수입력</p>
                            </li>
                            <li>
                                <p class="numbering"><span class="on_num">5</span></p>
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
                <div class="main_flow main_save content-rd">
                    <div class="mf_wrap">
                        
                        <form action="">
                            <div class="form_wrap">
                                <div class="form">
                                    <label for="name" class="label_name">조사명</label>
                                    <span class="jo_name"><?=$row['analysis_report_satisfaction_option_name']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">모집단</label>
                                    <span class="peo_name"><?=$row['analysis_report_satisfaction_option_population']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">조사대상</label>
                                    <span class="cus_name"><?=$row['analysis_report_satisfaction_option_sampling']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">표본추출방법</label>
                                    <span class="way_name"><?=$row['analysis_report_satisfaction_option_samplingmethod']?></span>
                                </div>
                                <div class="form">
                                    <label for="name" class="label_name">조사방법</label>
                                    
                                    <span class="sur_name"><?=$row['analysis_report_satisfaction_option_surveymethod']?></span>
                                </div>
                                 <div class="form">
                                    <label for="name" class="label_name">조사기간</label>
                                    <span class="date_name"><?=$row['analysis_report_satisfaction_option_data']?></span>
                                </div>
                                <div class="m5_logo">
                                    <img src="<?=$_P_DIR_WEB_FILE?>contentment/<?=$row['analysis_report_satisfaction_option_logo_c']?>" style="max-width:80%;">
                                </div>
                                <div class="down_btn  tabb1">
                                    <button type="button"> 보고서 다운로드</button>
                                </div>
                                <div class="save_info">
                                    <p>현재 설정을 저장하시겠습니까?</p>
                                    <p>파일명 지정</p>
                                    <input type="text" placeholder="<?=$row['analysis_report_satisfaction_option_logo_o']?>">
                                    <div class="save_btn">
                                        <button class="save_on tabb2" type="button">예</button>
                                        <button class="save_none tabb3" type="button">아니오</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="btn_all">
                <div class="left_btn">
                    <button type="button" onclick="location.href='manjok_4.php?satisfaction_option_idx=<?=$satisfaction_option_idx?>';">이전 단계</button>
                </div>
                <div class="right_btn end">
                    <button type="button" onclick="go_submit();">종료</button>
                </div>
            </div>
        </div>
    </section>

	<? include "./inc/footer.php"; ?>
    
    
    <? include "./inc/common_pop.php"; ?>   
         
        <div class="m5_1pop m2_pop">
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

<script>

$(function(){
	$('.mindmap').mindmap();
});

$(document).ready(function(){

    $(".content-rd").mCustomScrollbar({
                    theme:"light-3",
                });
});


	function go_submit() {
		$("#satisfaction_option_model_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}
</script>


 

</body>
</html>
