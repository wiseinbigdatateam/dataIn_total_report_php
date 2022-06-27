<?
	if(trim($gnb_current_page_arr[0]) == "manjok"){
		$base_idx = "satisfaction_option_idx";
		$sql_file_1 = "select idx,analysis_report_satisfaction_option_name as opt_title from wise_analysis_report_satisfaction_option where 1 and satisfaction_option_status='com' and analysis_report_satisfaction_option_name != '' and analysis_report_satisfaction_option_name is not null order by idx desc limit 0,5";
	} elseif(trim($gnb_current_page_arr[0]) == "service"){
		$base_idx = "service_option_idx";
		$sql_file_1 = "select idx,analysis_report_service_option_name as opt_title from wise_analysis_report_service_option where 1 and service_option_status='com' and analysis_report_service_option_name != '' and analysis_report_service_option_name is not null order by idx desc limit 0,5";
	} elseif(trim($gnb_current_page_arr[0]) == "damyun"){
		$base_idx = "damyun_option_idx";
		$sql_file_1 = "select idx,analysis_report_damyun_option_name as opt_title from wise_analysis_report_damyun_option where 1 and damyun_option_status='com' and analysis_report_damyun_option_name != '' and analysis_report_damyun_option_name is not null order by idx desc limit 0,5";
	} elseif(trim($gnb_current_page_arr[0]) == "decision"){
		$base_idx = "decision_option_idx";
		$sql_file_1 = "select idx,analysis_report_decision_option_name as opt_title from wise_analysis_report_decision_option where 1 and decision_option_status='com' and analysis_report_decision_option_name != '' and analysis_report_decision_option_name is not null order by idx desc limit 0,5";
	}

	$base_url = trim($gnb_current_page_arr[0])."_1.php";
?>
 <div class="common_pop">
        <form action="#">
		<input type="hidden" name="common_pop_idx" id="common_pop_idx" value=""/>
            <div class="pop_wrap">
                <div class="cp_title">
                    <span>이전 설정을 불러오시겠습니까?</span>
                    <span class="pj_close"><img src="./img/close.png" alt=""></span>
                </div>
            </div>
            <div class="pj_list">
                <ul class="content-rd pro_ul">
                    <li><a href="javascript:set_common_pop('new');">새로 시작하기</a></li>
				<?
					//echo $sql_file_1."<br>";
					$query_file_1 = mysqli_query($gconnet,$sql_file_1);
					$query_file_1_cnt = mysqli_num_rows($query_file_1);
					//echo "cnt = ".$query_file_1_cnt."<br>";
					for($opt_i=0; $opt_i<$query_file_1_cnt; $opt_i++){ 
						$row_file_1 = mysqli_fetch_array($query_file_1);
				?>
					<li><a href="javascript:set_common_pop('<?=$row_file_1['idx']?>');"><?=$row_file_1['opt_title']?></a></li>
				<?}?>
                </ul>
            </div>
            <div class="pj_ok">
                <button type="button" class="pj_close" onclick="go_common_pop();">확인</button>
            </div>
        </form>
    </div>

<script>

	function set_common_pop(idx){
		$("#common_pop_idx").val(idx);
	}

	function go_common_pop(){
		var idx = $("#common_pop_idx").val();
		var view_analysis_report_idx = $("#view_analysis_report_idx").val();

		if(idx == "new"){
			if(view_analysis_report_idx){
				location.href="<?=$base_url?>?analysis_report_idx="+view_analysis_report_idx+"";
			} else {
				location.href="<?=$base_url?>";
			}
		} else {
			location.href="<?=$base_url?>?<?=$base_idx?>="+idx+"&chapter=new";
		}
	}
</script>

<?
	mysqli_close($gconnet);
?>