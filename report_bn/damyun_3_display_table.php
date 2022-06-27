<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?
	//echo('<pre>'); print_r($_POST); echo('</pre>'); exit;

	$damyun_point_weight_v = $_REQUEST['damyun_point_weight_v'];
	$damyun_point_weight_v_arr = explode('<li id="',$damyun_point_weight_v);
	$damyun_point_weight_v_arr2 = explode('<a href="javascript:',$damyun_point_weight_v_arr[1]);
	$damyun_point_weight_v_arr3 = explode(';"',$damyun_point_weight_v_arr2[1]);

	$analysis_report_damyun_option_weight_quiz_no = trim($damyun_point_weight_v_arr3[0]);
	/*$analysis_report_damyun_option_weight_quiz_value = get_data_colname("wise_analysis_quiz","idx",$analysis_report_damyun_option_weight_quiz_no,"quiz_value","");
	
	$display_addval_arr = explode("^",$analysis_report_damyun_option_weight_quiz_value);
	//echo "cnt = ".sizeof($display_addval_arr)."<br>";

	$weight_quiz_value2 = "";
	for($opt_i=0; $opt_i<sizeof($display_addval_arr); $opt_i++){
		//echo $opt_i." 번째 = ".$display_addval_arr[$opt_i]."<br>";
		if($opt_i == sizeof($display_addval_arr)-1){
			$weight_quiz_value2 .= $display_addval_arr[$opt_i];
		} else {
			$weight_quiz_value2 .= $display_addval_arr[$opt_i]."-";
		}
	}

	echo "quiz_value = ".$weight_quiz_value2."<br>";
	//$analysis_report_damyun_option_weight_quiz_value = "1|1급-2|2급-3|3급-4|4급";
	*/
?>
	<script>
		parent.go_display_view("<?=$analysis_report_damyun_option_weight_quiz_no?>");
	</script>