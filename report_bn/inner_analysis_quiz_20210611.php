<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$analysis_idx = trim(sqlfilter($_REQUEST['analysis_idx']));

	$sub_sql_1 = "select * from wise_analysis_quiz where analysis_idx = '".$analysis_idx."' and quiz_delete='N' order by quiz_title asc";
	//echo $sub_sql_1."<br>";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);
?>
				<ul class="selectable que_l pro_ul">
				<?
				for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
					$sub_row_1 = mysqli_fetch_array($sub_query_1);
				?>
                      <li id="ql_<?=$sub_row_1['idx']?>" class="ui-widget-content item_serv" ><span class="close"><button><img src="./img/remove.png" alt=""></button></span><a href="javascript:<?=$sub_row_1['idx']?>;"><?=$sub_row_1['quiz_title']?></a></li>

				<?}?>
                </ul>

<script>

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