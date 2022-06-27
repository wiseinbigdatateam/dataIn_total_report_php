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
		$compet_info_query = mysqli_query($gconnet,$compet_info_sql);
		if(mysqli_num_rows($compet_info_query) == 0){
			error_go("다시 진행해주세요.","manjok_1.php");
		}

		$row = mysqli_fetch_array($compet_info_query);
	} else {
		error_go("다시 진행해주세요.","manjok_1.php");
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

	<form name="frm" action="manjok_4_action.php" target="_fra_admin" method="post"  enctype="multipart/form-data">
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
                                <p class="numbering"><span class="on_num">4</span></p>
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
                            <span>년도 입력창에는 숫자만 입력가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>엑셀에서 한 행씩 복사 & 붙여넣기가 가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>데이터 붙여넣기는 숫자만 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab2">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 해당 줄의 입력값이 초기화됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab3">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 새로운 테이블이 한 줄 추가됩니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab4">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>이름 입력창에는 벤치마킹집단의 이름이 입력되어야합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>엑셀에서 한 행씩 복사 & 붙여넣기가 가능합니다.</span>
                        </div>
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>데이터 붙여넣기는 숫자만 가능합니다.</span>
                        </div>
                    </div>
                    <div class="cover_gc tab5">
                        <div class="gc_wrap">
                            <span class="red_exc">!</span>
                            <span>클릭시 해당 테이블이 삭제됩니다.</span>
                        </div>
                    </div>
                </div>
                <div class="main_table">
                    <div class="table_wrap">
                        <div class="table_r">
                            <div class="tr_title">
                                <h1>
                                     추세점수 비교입력
                                </h1>
                            </div>
                            <div class="tr_wrap  content-rd">
                                
                                    <div class="tr_th">
                                        <table  class="tabb1">
                                            <tr>
                                                <th>문항명</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트1</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트2</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트3</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트4</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트5</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트6</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트7</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트8</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트6</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트7</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트8</th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tr_width ">
                                        <div class="tr_tr content-xd">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="number" placeholder="(년도입력) 년도">
                                                        <button type="button" class="table_del tabb5">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                        <button type="button" class="table_re tabb2">
                                                            <img src="./img/return_sq.png" alt="">
                                                        </button>
                                                        <div class="table_add tabb3">
                                                                <button type="button">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_compare[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                
                            </div>
                        </div><div class="table_r2">
                            <div class="tr2_title">
                                <h1>
                                     벤치마킹 집단 점수입력
                                </h1>
                            </div>
                            <div class="tr2_wrap  content-rd">
                                
                                    <div class="tr2_th">
                                        <table class="tabb4">
                                            <tr>
                                                <th>문항명</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트1</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트2</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트3</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트4</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트5</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트6</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트7</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트8</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트6</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트7</th>
                                            </tr>
                                            <tr>
                                                <th>문항리스트8</th>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="tr2_width ">
                                        <div class="tr2_tr content-xd">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <input type="text" placeholder="(이름입력)">
                                                        <button type="button" class="table_del tabb5">
                                                            <img src="./img/minus_sq.png" alt="">
                                                        </button>
                                                        <button type="button" class="table_re tabb2">
                                                            <img src="./img/return_sq.png" alt="">
                                                        </button>
                                                        <div class="table_addr tabb3">
                                                                <button type="button">
                                                                    <img src="./img/plus_sq.png" alt="">
                                                                </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input class="susik" name="score_vench[]" onblur="set_count_scompare();" type="number">
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sumt_w">
                    
                            <div class="sum_tl">
                                <span>변수총계</span>
                                <span>:</span>
                                <span id="count_scompare_area">0</span>
                            </div>
                            <div class="sum_tr">
                                <span>변수총계</span>
                                <span>:</span>
                                <span id="count_vtot_area">0</span>
                            </div>
                </div>
            </div>

			 </form>

            <div class="btn_all">
                <div class="left_btn">
                   <button type="button" onclick="location.href='manjok_3.php?satisfaction_option_idx=<?=$satisfaction_option_idx?>';">이전 단계</button>
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
                
        <!--<div class="m4_pop m2_pop">
            <div class="m2p_wrap">
                <p class="bun_ment">분석을 시작합니다<br/>분석이 시작된 이후엔 설정변경이 안됩니다.<br> 분석을 진행하시겠습니까?</p>
                <div class="ok_btn">
                    <button type="button">확인</button>
                </div>
            </div>
        </div>-->

    <? include "./inc/common_pop.php"; ?>   

    </section>
    
	<? include "./inc/footer.php"; ?>

	<script>
		    $(document).ready(function(){
    
        $(".content-xd").mCustomScrollbar({
					axis:"x",
					advanced:{autoExpandHorizontalScroll:true}
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


	function go_submit() {
		$("#satisfaction_option_model_status").val("com"); // 저장완료 
		var check = chkFrm('frm');
		if(check) {
			frm.submit();
		} else {
			false;
		}
	}

	function go_tmp_submit() {
		$("#satisfaction_option_model_status").val("tmp"); // 임시저장
		frm.submit();
	}  
	
	function set_count_scompare(){
		//alert("aa");
		frm.action = "manjok_4_count_scompare.php";
		frm.submit();
	}
</script>


</body>
</html>
