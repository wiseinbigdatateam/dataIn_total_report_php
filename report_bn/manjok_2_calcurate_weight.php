<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?
	//echo('<pre>'); print_r($_POST); echo('</pre>');
	$attach_count_1 = trim(sqlfilter($_REQUEST['attach_count_1'])); // 독립변수
	$attach_count_2 = trim(sqlfilter($_REQUEST['attach_count_2'])); // 종속변수 
	
	$variable_x_elementweight = $_REQUEST['variable_x_elementweight'];
	$variable_x_weight = $_REQUEST['variable_x_weight'];
	$variable_m_weight = $_REQUEST['variable_m_weight'];
	
	$tot_weight = 0;
	$tot_weight_x = 0;

	for($i=0; $i<$attach_count_1; $i++){
		$each_weight = $variable_x_elementweight[$i]+$variable_x_weight[$i];
		$tot_weight_x = $tot_weight_x+$each_weight;
	}

	$tot_weight = $tot_weight_x+$variable_m_weight;
?>
<script>
	$("#tot_weight_area", parent.document).html("<?=$tot_weight?>");
	$("#tot_weight_val", parent.document).val("<?=$tot_weight?>");
</script>