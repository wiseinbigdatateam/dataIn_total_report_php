<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
	<script src='./js/modal.js'></script>
<?
	$analysis_idx = trim(sqlfilter($_REQUEST['analysis_idx']));
	$quiz_no = trim(sqlfilter($_REQUEST['quiz_no']));

	$sub_sql_1 = "select distinct(data_val) from wise_analysis_data where analysis_idx='".$analysis_idx."' and quiz_no='".$quiz_no."' order by data_val asc";
	//echo $sub_sql_1."<br>";
	$sub_query_1 = mysqli_query($gconnet,$sub_sql_1);
	$sub_cnt_1 = mysqli_num_rows($sub_query_1);
?>
        <div id="mCSB_5" class="mCustomScrollBox mCS-light-3 mCSB_vertical mCSB_inside" tabindex="0" style="max-height: none;"><div id="mCSB_5_container" class="mCSB_container" style="position:relative; top:0; left:0;" dir="ltr">
                <ul class="pop_ul">
                <?
                    for($sub_i_1=0; $sub_i_1<$sub_cnt_1; $sub_i_1++){
                        $sub_row_1 = mysqli_fetch_array($sub_query_1);
                ?>
                    <li class="ui-widget-content item_serv pop_li  pop_c" ><a href="javascript:<?=$sub_row_1['data_val']?>;"><?=$sub_row_1['data_val']?></a></li>
                <?}?>
                </ul>
            </div>
            <div id="mCSB_5_scrollbar_vertical" class="mCSB_scrollTools mCSB_5_scrollbar mCS-light-3 mCSB_scrollTools_vertical" style="display: block;">
                <div class="mCSB_draggerContainer">
                    <div id="mCSB_5_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; top: 0px; display: block; height: 138px; max-height: 160px;">    <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                </div>
                    <div class="mCSB_draggerRail"></div>
                </div>
            </div>
        </div>