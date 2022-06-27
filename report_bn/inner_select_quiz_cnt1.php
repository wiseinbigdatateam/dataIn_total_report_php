<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$satisfaction_option_idx = trim(sqlfilter($_REQUEST['satisfaction_option_idx']));
	$satisfaction_option_model_idx = trim(sqlfilter($_REQUEST['satisfaction_option_model_idx']));

	$opt_sql = "select idx,analysis_report_satisfaction_option_factor_no,analysis_report_satisfaction_option_factor_title from wise_analysis_report_satisfaction_option_model_quiz where 1 and satisfaction_option_idx='".$satisfaction_option_idx."' and satisfaction_option_model_idx='".$satisfaction_option_model_idx."' and  analysis_report_satisfaction_option_factor_type='C' order by idx asc";

	$opt_query = mysqli_query($gconnet,$opt_sql);
	$opt_cnt = mysqli_num_rows($opt_query);
	
	for($opt_i3=0; $opt_i3<$opt_cnt; $opt_i3++){
		$opt_row = mysqli_fetch_array($opt_query);
?>
	<li id="ql_<?=$opt_row['analysis_report_satisfaction_option_factor_no']?>" class="ui-widget-content item_serv ui-selectee ui-selected selected-flag"><span class="close ui-selectee" style=""><button class="ui-selectee"><img src="./img/remove.png" alt="" class="mCS_img_loaded ui-selectee"></button></span><a href="javascript:<?=$opt_row['analysis_report_satisfaction_option_factor_no']?>;" class="ui-selectee" title="<?=$opt_row['analysis_report_satisfaction_option_factor_title']?>"><?=$opt_row['analysis_report_satisfaction_option_factor_title']?></a></li>
<?}?>