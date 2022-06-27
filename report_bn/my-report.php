<? include "./inc/header_my.php"; ?>
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
            <div class="side_men">
                <? include "./inc/inc_left_quiz.php"; ?>
            </div>

            <div class="main_pro">
                <? include "./inc/gnb.php"; ?>
                <div class="guide_c" style="margin-top: 25px;">
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
                <div class="main_flow">
                    <div class="mf_wrap">

                        <form action="#">
                            <div class="report-manage">
                                <div class="rep-man on rep-sel">
                                <!-- 보고서 관리 리스트 시작 -->
									<div class="report-title title-btn">
                                        보고서 관리
                                        <div class="additionalText">
                                            <p>※ 본 분석을 사용하여 보고서를 작성하는데 걸리는 시간은 데이터양에 따라 다릅니다.</p> 
                                            <p>※ 분석이 시작되고 보고서 작성까지 최대 2시간 정도 걸릴 수 있습니다.</p>
                                        </div>
                                    </div>
                                    <div class="report-list" id="myreport_report_area">
                                        <!-- inner_myreport_report.php 에서 불러옴 -->
                                    </div>
								<!-- 보고서 관리 리스트 종료 -->
                                </div>

                                <div class="rep-opt rep-wrap  rep-sel">
									<!-- 옵션 설정 리스트 시작 -->
                                    <div class="option-title title-btn">
                                        옵션 설정
                                    </div>
                                    <div class="option-list" id="myreport_option_area">
                                         <!-- inner_myreport_option.php 에서 불러옴 -->
                                    </div>
									<!-- 옵션 설정 리스트 종료 -->
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--<div class="btn_all last">
                <div class="left_btn">
                    <button>이전 단계</button>
                </div>
                <div class="right_btn end">
                    <button>종료</button>
                </div>
            </div>-->
        </div>
    </section>

<script>
$(document).ready(function() {
	get_data("inner_myreport_report.php","myreport_report_area","target_id=myreport_report_area&<?=$total_param?>"); // 리포트 리스트 불러오기
	get_data("inner_myreport_option.php","myreport_option_area","target_id=myreport_option_area&<?=$total_param?>"); // 옵션 리스트 불러오기
});

function go_option_delete(idx){
	if(confirm('삭제하신 데이터는 복구할수 없도록 영구 삭제 됩니다. 그래도 삭제 하시겠습니까?')){
		_fra_admin.location.href = "delete_myreport_option.php?idx="+idx+"";
	}
}

function go_report_delete(idx){
	if(confirm('삭제하신 데이터는 복구할수 없도록 영구 삭제 됩니다. 그래도 삭제 하시겠습니까?')){
		_fra_admin.location.href = "delete_myreport_report.php?idx="+idx+"";
	}
}

function go_myreport_getreport(type,idx){
	if(type == "manjok"){ // 만족도 보고서 시작
		_fra_admin.location.href = "/report/result/excel_manjok_1.php?satisfaction_option_idx="+idx+"";

		setTimeout(function() {
			go_getreport_satisfaction_2(idx);
		}, 3000);

	} else if(type == "service"){ // 서비스 보고서 시작
		_fra_admin.location.href = "/report/result/excel_service_1.php?service_option_idx="+idx+"";

		setTimeout(function() {
			go_getreport_service_2(idx);
		}, 3000);
	} else if(type == "damyun"){ // 다면평가 보고서 시작
		_fra_admin.location.href = "/report/result/excel_damyun_1.php?damyun_option_idx="+idx+"";

		setTimeout(function() {
			go_getreport_damyun_2(idx);
		}, 3000);
	} else if(type == "decision"){ // 의사결정모델 보고서 시작
		_fra_admin4.location.href = "/report/result/excel_decision_1.php?decision_option_idx="+idx+"";

		setTimeout(function() {
			go_getreport_decision_2(idx);
		}, 3000);
	}
}

function open_myreport_viewer(mode,type,idx) {
    var report_path = "";
	if(type == "manjok"){ // 만족도 보고서 시작
		report_path = "satisfaction";
	} else if(type == "service"){ // 서비스 보고서 시작
		report_path = "service";
	} else if(type == "damyun"){ // 다면평가 보고서 시작
		report_path = "multi";
	} else if(type == "decision"){ // 의사결정모델 보고서 시작
		report_path = "ahp";
	}

    if(mode != "") report_path += "_" + mode;

    if(report_path != "") {
        var report_url = "http://datain.co.kr/report/" + report_path + ".html?ridx=" + idx;
        window.open(report_url, "", "", "");
    }

}

function go_myreport_make(type,idx){
	if(type == "manjok"){ // 만족도 보고서 시작
		_fra_admin5.location.href = "/report/cron_satisfaction_report.php?idx="+idx+"";
	} else if(type == "service"){ // 서비스 보고서 시작
		_fra_admin5.location.href = "/report/cron_service_report.php?idx="+idx+"";
	} else if(type == "damyun"){ // 다면평가 보고서 시작
		_fra_admin5.location.href = "/report/cron_damyun_report.php?idx="+idx+"";
	} else if(type == "decision"){ // 의사결정모델 보고서 시작
	    _fra_admin5.location.href = "/report/cron_decision_report.php?idx="+idx+"";
	}
}

function go_getreport_satisfaction_2(idx){
	_fra_admin2.location.href = "/report/result/excel_manjok_2.php?satisfaction_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_satisfaction_3(idx);
	}, 3000);
}

function go_getreport_satisfaction_3(idx){
	_fra_admin3.location.href = "/report/result/excel_manjok_3.php?satisfaction_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_satisfaction_4(idx);
	}, 3000);
}

function go_getreport_satisfaction_4(idx){
	_fra_admin4.location.href = "/report/result/excel_manjok_4.php?satisfaction_option_idx="+idx+"";
	//alert("다운로드가 완료 되었습니다.");
}

function go_getreport_service_2(idx){
	_fra_admin2.location.href = "/report/result/excel_service_2.php?service_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_service_3(idx);
	}, 3000);
}

function go_getreport_service_3(idx){
	_fra_admin3.location.href = "/report/result/excel_service_3.php?service_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_service_4(idx);
	}, 3000);
}

function go_getreport_service_4(idx){
	_fra_admin4.location.href = "/report/result/excel_service_4.php?service_option_idx="+idx+"";
	//alert("다운로드가 완료 되었습니다.");
}

function go_getreport_damyun_2(idx){
	_fra_admin2.location.href = "/report/result/excel_damyun_2.php?damyun_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_damyun_3(idx);
	}, 3000);
}

function go_getreport_damyun_3(idx){
	_fra_admin3.location.href = "/report/result/excel_damyun_3.php?damyun_option_idx="+idx+"";
	//alert("다운로드가 완료 되었습니다.");
}

function go_getreport_decision_2(idx){
	_fra_admin2.location.href = "/report/result/excel_decision_2.php?decision_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_decision_3(idx);
	}, 3000);
}

function go_getreport_decision_3(idx){
	_fra_admin3.location.href = "/report/result/excel_decision_3.php?decision_option_idx="+idx+"";

	setTimeout(function() {
		go_getreport_decision_4(idx);
	}, 3000);
}

function go_getreport_decision_4(idx){
	_fra_admin4.location.href = "/report/result/excel_decision_4.php?decision_option_idx="+idx+"";
	//alert("다운로드가 완료 되었습니다.");
}
</script>

<? include "./inc/footer.php"; ?>


//    <? include "./inc/common_pop.php"; ?>


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
        $('.title-btn').on('click',function(){
            $('.rep-sel').removeClass('on');
            $(this).parents('.rep-sel').addClass('on');
        });
    });
</script>




</body>
</html>