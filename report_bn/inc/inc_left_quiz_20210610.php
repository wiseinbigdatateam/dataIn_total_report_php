				<div class="side_main">
                    <h1>프로젝트선택</h1>
                    <ul class="content-rd pro_ul">
					<?
						$sub_sql_1 = "select * from wise_analysis_main where 1 order by analysis_title asc";
						$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
						$sub_cnt_1 = mysqli_num_rows($sub_query_1);
						//echo "cnt = ".$sub_cnt_1."<br>";
						for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
							$sub_row_1 = mysqli_fetch_array($sub_query_1);
					?>
                        <li id="analysis_main_<?=$sub_row_1['idx']?>" class="analy_main">
							<a href="javascript:view_analysis_quiz('<?=$sub_row_1['idx']?>');"><?=$sub_row_1['analysis_title']?><!-- / <?=$sub_row_1['idx']?>--></a>
						</li>

						<input type="radio" name="analysis_report_idx" id="analysis_report_idx_<?=$sub_row_1['idx']?>" value="<?=$sub_row_1['idx']?>" style="display:none;">
					<?}?>
                    </ul>
                </div>

				<input type="hidden" id="view_analysis_report_idx">

                <div class="side_list">
                    <h1>문항리스트</h1>
                    <div class="sub_list content-rd" id="analysis_quiz_area">
					<?if(basename($_SERVER['PHP_SELF']) == "decision_2.php"){?>
						<!-- /report/inner_analysis_quiz2.php 에서 불러옴 -->
					<?}else{?>
						 <!-- /report/inner_analysis_quiz.php 에서 불러옴 -->
					<?}?>
					</div>
                </div>

<script>

	function view_analysis_quiz(idx){
		//alert(idx);
		$(".analy_main").removeClass("selected");
		$("#analysis_main_"+idx+"").addClass("selected");
		/*if(document.getElementById("analysis_report_idx_"+idx+"").checked == true){
			document.getElementById("analysis_report_idx_"+idx+"").checked = false;
		} else {
			document.getElementById("analysis_report_idx_"+idx+"").checked = true;
		}*/

		$("#view_analysis_report_idx").val(idx);
		document.getElementById("analysis_report_idx_"+idx+"").checked = true;

		<?if(basename($_SERVER['PHP_SELF']) == "service_2.php" || basename($_SERVER['PHP_SELF']) == "damyun_2.php"){?>
			get_data("/report/inner_analysis_quiz2.php","analysis_quiz_area","analysis_idx="+idx+"");
		<?}elseif(basename($_SERVER['PHP_SELF']) == "decision_2.php"){?>
			get_data("/report/inner_analysis_quiz3.php","analysis_quiz_area","analysis_idx="+idx+"");
		<?}else{?>
			get_data("/report/inner_analysis_quiz.php","analysis_quiz_area","analysis_idx="+idx+"");
		<?}?>

		<?if(basename($_SERVER['PHP_SELF']) == "manjok_3.php" || basename($_SERVER['PHP_SELF']) == "service_3.php" || basename($_SERVER['PHP_SELF']) == "damyun_3.php" || basename($_SERVER['PHP_SELF']) == "decision_3.php"){?>
			get_data("/report/inner_step3_quiz.php","step3_quiz_area","analysis_idx="+idx+"");
		<?}?>
	}

	function select_option_group_type(idx){
		//alert(idx);
		if(document.getElementById("satisfaction_option_group_type_"+idx+"").checked == true){
			document.getElementById("satisfaction_option_group_type_"+idx+"").checked = false;
		} else {
			document.getElementById("satisfaction_option_group_type_"+idx+"").checked = true;
		}
	}

	<?if($row['analysis_report_idx']){?>
		$(".analy_main").removeClass("selected");
		$("#analysis_main_<?=$row['analysis_report_idx']?>").addClass("selected");
		document.getElementById("analysis_report_idx_<?=$row['analysis_report_idx']?>").checked = true;

		<?if(basename($_SERVER['PHP_SELF']) == "service_2.php"  || basename($_SERVER['PHP_SELF']) == "damyun_2.php"){?>
			get_data("/report/inner_analysis_quiz2.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		<?}elseif(basename($_SERVER['PHP_SELF']) == "decision_2.php"){?>
			get_data("/report/inner_analysis_quiz3.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		<?}else{?>
			get_data("/report/inner_analysis_quiz.php","analysis_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		<?}?>

		<?if(basename($_SERVER['PHP_SELF']) == "manjok_3.php" || basename($_SERVER['PHP_SELF']) == "service_3.php" || basename($_SERVER['PHP_SELF']) == "damyun_3.php" || basename($_SERVER['PHP_SELF']) == "decision_3.php"){?>
			get_data("/report/inner_step3_quiz.php","step3_quiz_area","analysis_idx=<?=$row['analysis_report_idx']?>");
		<?}?>
	<?} elseif($_REQUEST['analysis_report_idx']){?>
		$(".analy_main").removeClass("selected");
		$("#analysis_main_<?=$_REQUEST['analysis_report_idx']?>").addClass("selected");
		document.getElementById("analysis_report_idx_<?=$_REQUEST['analysis_report_idx']?>").checked = true;
		get_data("/report/inner_analysis_quiz.php","analysis_quiz_area","analysis_idx=<?=$_REQUEST['analysis_report_idx']?>");
	<?}?>
</script>