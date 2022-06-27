<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
	$analysis_idx = trim(sqlfilter($_REQUEST['analysis_idx']));

	$sub_sql_1 = "select * from wise_analysis_quiz where analysis_idx = '".$analysis_idx."' and quiz_delete='N' and answer_cnt = 1 order by quiz_no asc";
	//echo $sub_sql_1."<br>";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);
?>
				<ul class="selectable que_l pro_ul gae_ul">
				<?
				for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
					$sub_row_1 = mysqli_fetch_array($sub_query_1);
				?>
                       <li id="ql_<?=$sub_row_1['idx']?>" class=" item_serv" >
                            <div class="node">
                                <span class="close">
                                    <button type="button"><img src="./img/remove.png" alt=""></button>
                                </span>

                                <a href="javascript:<?=$sub_row_1['idx']?>;" class="overtext" title="<?=$sub_row_1['quiz_title']?>"><?=$sub_row_1['quiz_title']?></a>
                                <input class="dec_in" type="text" name="decision_option_model_title_<?=$sub_row_1['idx']?>" onblur="go_tmp_child('<?=$sub_row_1['idx']?>','mod');" readonly>
                                <div class="score_div">
                                    <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="decision_option_model_title_<?=$sub_row_1['idx']?>" class="left_input_score">
                                </div>
                                <div class="dec_bwrap">
                                    <div class="dec_add dec_add1">
                                        <button type="button"><img src="./img/plus_sq.png" alt="" onclick="go_tmp_child('<?=$sub_row_1['idx']?>','add');"></button>
                                    </div>
                                    <div class="dec_min dec_min1">
                                        <button type="button"><img src="./img/minus_sq.png" alt="" onclick="go_tmp_child('<?=$sub_row_1['idx']?>','minus');"></button>
                                    </div>
                                </div>
                            </div>
                        </li>
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
