<? include "./inc/header_my.php"; ?>
<style>
.loading {
	  width: 400px;
    /*height: 185px;*/
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    border: 1px solid #e9e9e9;
    background-color: #e9e9e9;
    border-radius: 10px;
    display: none;
    font-size:24px;
    text-align:center;
    padding:7%;
}
</style>
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
                            <span class="red_exc">프로젝트 등록 : [가져오기] 버튼 클릭 시 데이터인에 등록된 분석 프로젝트 데이터를 가져옵니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>프로젝트 관리 : 프로젝트 데이터를 삭제할 수 있습니다.</span>
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
																		<div class="report-title title-btn" style="background-position: 120px center">
                                        프로젝트 관리
                                        <div class="additionalText">
                                            <p>※ 분석 데이터를 가져오는데 걸리는 시간은 데이터양에 따라 다릅니다.</p>
                                            <p>※ 분석 데이터 가져오기가 시작되고 보고서 작성까지 최대 1시간 정도 걸릴 수 있습니다.</p>
                                            <p>※ 케이스 10,000건 이상(64MB 이상) 분석하실 경우 오랜시간이 걸릴 수 있습니다. 개별 문의 남겨주시면 감사하겠습니다.</p>
                                        </div>
                                    </div>
                                    <div class="report-list" id="myproject_report_area">
                                        <!-- inner_myproject_report.php 에서 불러옴 -->
                                    </div>
																<!-- 보고서 관리 리스트 종료 -->
                                </div>

                                <div class="rep-opt rep-wrap  rep-sel">
																<!-- 옵션 설정 리스트 시작 -->
                                    <div class="option-title title-btn" style="background-position: 120px center">
                                        프로젝트 등록
                                        <!--div class="additionalText">
                                            <p>※ 케이스 10,000건 이상(64MB 이상) 분석하실 경우 오랜시간이 걸릴 수 있습니다. 개별 문의 남겨주시면 감사하겠습니다.</p>
                                        </div-->
                                    </div>
                                    <div class="option-list" id="myproject_analysis_area">
                                         <!-- inner_myproject_analysis.php 에서 불러옴 -->
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

    <div class="loading">데이터를 가져오는 중입니다.</div>

<script>
$(document).ready(function() {
	get_data("inner_myproject_report.php","myproject_report_area","target_id=myproject_report_area&<?=$total_param?>"); // 프로젝트 리스트 불러오기 (통합리포팅 프로젝트)
	get_data("inner_myproject_analysis.php","myproject_analysis_area","target_id=myproject_analysis_area&<?=$total_param?>"); // 프로젝트 리스트 불러오기 (분석 프로젝트)
});

function go_project_delete(idx){
	if(confirm('프로젝트를 삭제하는 경우 모든 데이터 및 보고서가 삭제되며 \n\n삭제하신 데이터는 복구할수 없도록 영구 삭제 됩니다. \n\n그래도 삭제 하시겠습니까?')){
		$.post("my-project-act.php", "mode=datadelete&idx=" + idx, function(data) {
			var result = data.split("|");
			if(result[0] == "OK") {
				alert("삭제하였습니다.");
				get_data("inner_myproject_report.php","myproject_report_area","target_id=myproject_report_area&<?=$total_param?>"); // 프로젝트 리스트 불러오기 (통합리포팅 프로젝트)
			} else if(result[0] == "ERR") {
				alert(result[1]);
			} else {
				alert(data);
			}

		});
	}
}
function go_analysis_move(idx) {
    <?php
	// 2022-01-17 : 로그인 데이터 권한 확인 ----- kky
	//$permit_chk = check_payment_permit($memid, "project");
	//if($permit_chk['chk'] == false) {
    ?>
    //    alert("<?=$permit_chk['msg']?>");
    <?php
	//} else {
    ?>
        $(".loading").show();
        $.post("my-project-act.php", "mode=datacopy&idx="+idx, function(data) {
            var result = data.split("|");
            if(result[0] == "OK") {
                alert("데이터 가져오기 완료");
                get_data("inner_myproject_report.php","myproject_report_area","target_id=myproject_report_area&<?=$total_param?>"); // 프로젝트 리스트 불러오기 (통합리포팅 프로젝트)
                $(".title-btn:eq(0)").click();

                var aidx = result[1];
                var atitle = result[2];
                $("#mCSB_1_container").prepend('<input type="radio" name="analysis_report_idx" id="analysis_report_idx_'+aidx+'" value="'+aidx+'" style="display:none;">');
                $("#mCSB_1_container").prepend('</li>');
                $("#mCSB_1_container").prepend('<a href="javascript:view_analysis_quiz(\''+aidx+'\');">'+atitle+'<!-- / '+aidx+'--></a>');
                $("#mCSB_1_container").prepend('<li id="analysis_main_'+aidx+'" class="analy_main">');

            } else if(result[0] == "ERR") {
                alert(result[1]);
            } else {
                alert(data);
            }
            $(".loading").hide();
        });
    <?php   
    //}
    ?>
}
</script>

	<? include "./inc/footer.php"; ?>

   <?// include "./inc/common_pop.php"; ?>

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
