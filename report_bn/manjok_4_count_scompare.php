<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?
	$score_compare = $_REQUEST['score_compare'];
	$score_vench = $_REQUEST['score_vench'];

	$tot_weight_1 = 0;
	for($i=0; $i<sizeof($score_compare); $i++){
		if($score_compare[$i]){
			$tot_weight_1 = $tot_weight_1 + 1;
		}
	}

	$tot_weight_2 = 0;
	//echo "cnt = ".sizeof($score_vench)."<br>";
	for($i=0; $i<sizeof($score_vench); $i++){
		if($score_vench[$i]){
			$tot_weight_2 = $tot_weight_2 + 1;
		}
	}
	
?>
<script>
	$("#count_scompare_area", parent.document).html("<?=$tot_weight_1?>");
	$("#count_vtot_area", parent.document).html("<?=$tot_weight_2?>");
</script>