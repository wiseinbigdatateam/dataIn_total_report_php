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

	$sql_file_1 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='X' order by idx asc";
	$query_file_1 = mysqli_query($gconnet,$sql_file_1);

	$sql_file_2 = "select * from wise_analysis_report_satisfaction_option_model where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and analysis_report_satisfaction_option_variable_type='Y' order by idx asc";
	$query_file_2 = mysqli_query($gconnet,$sql_file_2);
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

	<form name="frm" action="manjok_2_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
		<input type="hidden" name="satisfaction_option_model_status" id="satisfaction_option_model_status" value=""/>
		<input type="hidden" id="satisfaction_option_idx" name="satisfaction_option_idx" value="<?=$satisfaction_option_idx?>"> 
		
		<?if(mysqli_num_rows($query_file_1) == 0){?>
			<input type="hidden" name="attach_count_1" value="1"/> <!-- 독립변수 입력갯수 -->
		<?}else{?>
			<input type="hidden" name="attach_count_1" value="<?=mysqli_num_rows($query_file_1)?>"/> <!-- 독립변수 입력갯수 -->
		<?}?>
		
		<?if(mysqli_num_rows($query_file_2) == 0){?>
			<input type="hidden" name="attach_count_2" value="1"/> <!-- 종속변수 입력갯수 -->
		<?}else{?>
			<input type="hidden" name="attach_count_2" value="<?=mysqli_num_rows($query_file_2)?>"/> <!-- 종속변수 입력갯수 -->
		<?}?>

        <div class="body_w">
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
                    <div class="cover_gc">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>문항명, 요인명은 보고서에 그대로 반영됩니다. 이름을 변경하고 싶다면 '문항속성'에서 수정한 후 분석모델을 설정하세요.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>설정된 문항 순서대로 분석 보고서가 작성됩니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>요소만족도의 문항은 필수는 아닙니다. 미설정시 IPA분석의 종속변수는 전반만족도가 됩니다..</span>
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
                                    <li class="children__item">
                                        <div class="node lbox_n">
                                           <div class="box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_l">
                                                            <ul class="box_big content-rd selectable" id="option_model_quiz_0"></ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                                </div>
                                                                <div class="count" id="option_quiz_cnt_0"></div>
                                                            </div>
                                                        </div>
                                                        <div class="bwt_r">
															<textarea name="option_variable_title_0" id="option_variable_title_0" cols="30" rows="10" placeholder="제목"></textarea>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="chi_del"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="box_mid">
                                                        <div class="bwm_l">
                                                            <div class="ym_wrap">
                                                                <span class="ym_title">요소만족도</span>
                                                                <span>:</span>
                                                                <button type="button" class="ym_add"><img src="./img/plus_sq.png" alt=""></button>
                                                                <div class="y_wrap" id="option_model_ele_quiz_0"></div>
                                                                <input type="text" class="yo_num" placeholder="요소 가중치%" name="variable_elementweight_0" id="variable_elementweight_0">
                                                            </div>
                                                        </div>
                                                        <div class="bwm_r">
                                                            <input type="text" placeholder="가중치%" name="variable_weight_0" id="variable_weight_0">
                                                        </div>
                                                    </div>
                                                    <div class="box_bot2">
                                                        <div class="bwb_l" onclick="addForm_1();">
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
                              <!-- 독립변수 파트 종료 --> 
							<?
							for($i_file=0; $i_file<mysqli_num_rows($query_file_1); $i_file++){
								$row_file = mysqli_fetch_array($query_file_1);
							?>
									<li class="children__item">
                                        <div class="node lbox_n">
                                           <div class="box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_l">
                                                            <ul class="box_big content-rd selectable" id="option_model_quiz_<?=$i_file?>"></ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                                </div>
                                                                <div class="count" id="option_quiz_cnt_<?=$i_file?>"></div>
                                                            </div>
                                                        </div>
                                                        <div class="bwt_r">
															<textarea name="option_variable_title_<?=$i_file?>" id="option_variable_title_<?=$i_file?>" cols="30" rows="10" placeholder="제목"></textarea>
                                                        </div>
                                                        <div>
                                                            <button type="button" class="chi_del"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="box_mid">
                                                        <div class="bwm_l">
                                                            <div class="ym_wrap">
                                                                <span class="ym_title">요소만족도</span>
                                                                <span>:</span>
                                                                <button type="button" class="ym_add"><img src="./img/plus_sq.png" alt=""></button>
                                                                <div class="y_wrap" id="option_model_ele_quiz_<?=$i_file?>"></div>
                                                                <input type="text" class="yo_num" placeholder="요소 가중치%" name="variable_elementweight_<?=$i_file?>" id="variable_elementweight_<?=$i_file?>">
                                                            </div>
                                                        </div>
                                                        <div class="bwm_r">
                                                            <input type="text" placeholder="가중치%" name="variable_weight_<?=$i_file?>" id="variable_weight_<?=$i_file?>">
                                                        </div>
                                                    </div>
                                                    <div class="box_bot2">
                                                        <div class="bwb_l" onclick="addForm_1();">
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
									<div id="addedFormDiv_1"></div>

                                </ol>
                                <div class="node node_root cw_mw">
                                   
                                            <div class="box_wrap center_wrap">
                                                <div class="bw_top">
                                                    <div class="bwt_r">
                                                        <textarea name="title" id="" cols="30" rows="10" placeholder="제목"></textarea>
                                                    </div>
                                                    <div class="bwt_l">
                                                        <ul class="box_big content-rd selectable">
                                                        </ul>
                                                        <div class="bb_btn">
                                                            <div>
                                                                <button type="button" class="bb_add"><img src="./img/plus_sq.png" alt=""></button>
                                                            </div>
                                                            <div>
                                                                <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                            </div>
                                                            <div class="count">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="center_ga">
                                                    <input type="number" placeholder="가중치%">
                                                    </div>
                                                </div>
                                            </div>
                                   
                                </div>
                                    <ol class="children children_rightbranch">
                                        <li class="children__item">
                                           
                                                <div class="node rbox_n">
                                                    <div class="rbox_wrap box_wrap">
                                                    <div class="bw_top">
                                                        <div class="bwt_r">
                                                            <textarea name="title" id="" cols="30" rows="10" placeholder="제목"></textarea>
                                                        </div>
                                                        <div class="bwt_l">
                                                            <ul class="box_big content-rd selectable">
                                                            </ul>
                                                            <div class="bb_btn">
                                                                <div>
                                                                    <button type="button" class="bb_add"><img src="./img/plus_sq.png" alt=""></button>
                                                                </div>
                                                                <div>
                                                                    <button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button>
                                                                </div>
                                                                <div class="count">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="chi_wel">
                                                            <button type="button" class="chi_del"><img src="./img/minus_sq.png" alt=""></button>
                                                        </div>
                                                    </div>
                                                    <div class="rbox_bot">
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
                                    </ol>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="sum_line">
                    <div class="ga_sum">
                        <span>가중치 총합</span>
                        <span>:</span>
                        <span class="gas_num">0</span>
                    </div>
                    <div class="by_sum">
                        <span>변수 총계</span>
                        <span>:</span>
                        <span class="bys_num">0</span>
                    </div>
                    <div class="iy_sum">
                        <span>변수 총계</span>
                        <span>:</span>
                        <span class="iys_num">0</span>
                    </div>
                </div>
            </div>

			</form>

            <div class="btn_all">
                <div class="left_btn">
                    <button type="button">이전 단계</button>
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

    <div class="m2_pop">
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
    
    
    <div class="common_pop">
        <form action="#">
            <div class="pop_wrap">
                <div class="cp_title">
                    <span>이전 설정을 불러오시겠습니까?</span>
                    <span class="pj_close"><img src="./img/close.png" alt=""></span>
                </div>
            </div>
            <div class="pj_list">
                <ul class="content-rd pro_ul">
                    <li><a href="javascript:;">새로 시작하기</a></li>
                    <li><a href="javascript:;">공원만족도조사_만족모델보고서_20200920_03:04:15</a></li>
                    <li><a href="javascript:;">공원만족도조사_만족모델보고서_20200920_03:04:15</a></li>
                    <li><a href="javascript:;">공원만족도조사_만족모델보고서_20200920_03:04:15</a></li>
                    <li><a href="javascript:;">공원만족도조사_만족모델보고서_20200920_03:04:15</a></li>
                </ul>
            </div>
            <div class="pj_ok">
                <button type="button" class="pj_close">확인</button>
            </div>
        </form>
    </div>

    

<script>
        $(document).ready(function(){

            $(".content-xd").mCustomScrollbar({
					axis:"yx",
					theme:"3d",
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



    
  $(function() {
  $(".selectable").bind("mousedown", function(e) {
    e.metaKey = true;
      
      return false;
  }).selectable();
  $(".selectable").selectable({
    selected: function(event, ui) {
      if (!$(ui.selected).hasClass('selected-flag')) {
        $(ui.selected).addClass('selected-flag');
      } else {
        $(ui.selected).removeClass("ui-selected selected-flag");
      }
    }
  });
});
    
    

    
	function go_submit() {
		$("#satisfaction_option_data_v").val($("#satisfaction_option_group_type_area").html());
		$("#satisfaction_option_model_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#satisfaction_option_data_v").val($("#satisfaction_option_group_type_area").html());
		$("#satisfaction_option_model_status").val("tmp"); // 임시저장
		frm.submit();
	}    
    
    
</script>

<script>

<?if(mysqli_num_rows($query_file_1) == 0){?>
	var count_1 = 1;   
<?}else{?>
	var count_1 = <?=mysqli_num_rows($query_file_1)?>;          
<?}?>

function addForm_1(){
	var addedFormDiv = document.getElementById("addedFormDiv_1");
	var str = "";
	
	str+='<li class="children__item"><div class="node lbox_n"><div class="box_wrap"><div class="bw_top"><div class="bwt_l"><ul class="box_big content-rd selectable" id="option_model_quiz_0"></ul><div class="bb_btn"><div><button type="button" class="bb_add"><img src="./img/plus_sq.png" alt=""></button></div><div><button type="button" class="bb_re"><img src="./img/return_sq.png" alt=""></button></div><div class="count" id="option_quiz_cnt_0"></div></div></div><div class="bwt_r"><textarea name="option_variable_title_0" id="option_variable_title_0" cols="30" rows="10" placeholder="제목"></textarea></div><div><button type="button" class="chi_del"><img src="./img/minus_sq.png" alt=""></button></div></div><div class="box_mid"><div class="bwm_l"><div class="ym_wrap"><span class="ym_title">요소만족도</span><span>:</span><button type="button" class="ym_add"><img src="./img/plus_sq.png" alt=""></button><div class="y_wrap" id="option_model_ele_quiz_0"></div><input type="text" class="yo_num" placeholder="요소 가중치%" name="variable_elementweight_0" id="variable_elementweight_0"></div></div><div class="bwm_r"><input type="text" placeholder="가중치%" name="variable_weight_0" id="variable_weight_0"></div></div><div class="box_bot2"><div class="bwb_l"><img src="./img/plus_sq.png" alt=""></div><div class="bwb_r"><div class="bw_line"></div></div></div></div></div></li>'; // 추가할 폼(에 들어갈 HTML)

	var addedDiv = document.createElement("div"); // 폼 생성
    addedDiv.id = "added_1_"+count_1; // 폼 Div에 ID 부 여 (삭제를 위해)
    addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
    addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입
    count_1++;
	frm.attach_count_1.value = count_1;
}

function delForm_1(didx){
	//alert(didx);
	var addedFormDiv = document.getElementById("addedFormDiv_1");
	if(count_1 >1){ // 현재 폼이 두개 이상이면
		var addedDiv = document.getElementById("added_1_"+(didx));
        // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
        addedFormDiv.removeChild(addedDiv); // 폼 삭제
		count_1 = count_1-1;
		frm.attach_count_1.value = count_1;
     }else{ // 마 지막 폼만 남아있다면
      //  document.baseForm.reset(); // 폼 내용 삭제
     }
}

var count_2 = <?=mysql_num_rows($query_file_key)?>;          
function addForm_2(){
	var addedFormDiv = document.getElementById("addedFormDiv_2");
	var str = "";
	
	str+='<span style="display: inline-block; width: 250px;"><input type="text" name="keyword_'+count_2+'" id="keyword_'+count_2+'" class="form-control" style="width:150px;" value="" placeholder="키워드_'+count_2+'"></span><button type="button" id="" class="btn btn-danger btn-sm margin_right5" onclick="delForm_2('+count_2+');">취소</button><div class="space0"></div>'; // 추가할 폼(에 들어갈 HTML)

	var addedDiv = document.createElement("div"); // 폼 생성
    addedDiv.id = "added_2_"+count_2; // 폼 Div에 ID 부 여 (삭제를 위해)
    addedDiv.innerHTML  = str; // 폼 Div안에 HTML삽입
    addedFormDiv.appendChild(addedDiv); // 삽입할 DIV에 생성한 폼 삽입
    count_2++;
	frm.attach_count_3.value = count_2;
}

function delForm_2(didx){
//alert(didx);
  var addedFormDiv = document.getElementById("addedFormDiv_2");
   //if(count_2 >1){ // 현재 폼이 두개 이상이면
      var addedDiv = document.getElementById("added_2_"+(didx));
       // 마지막으로 생성된 폼의 ID를 통해 Div객체를 가져옴
        addedFormDiv.removeChild(addedDiv); // 폼 삭제 
		 //frm.attach_count_2.value = count_2;
    /*}else{ // 마 지막 폼만 남아있다면
      //  document.baseForm.reset(); // 폼 내용 삭제
     }*/
}    

</script>
 

</body>
</html>
