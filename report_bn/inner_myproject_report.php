<? include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
function get_project_status($status) {
	switch($status) {
		case "Y" : $status_name = "완료"; break;
		case "N" : $status_name = "미완료"; break;
	}

	return $status_name;
}
$target_id = trim(sqlfilter($_REQUEST['target_id']));
$memid = $_SESSION['wiz_session']['id'];
$subid = $_SESSION['wiz_session']['subid'];

$pageNo = trim(sqlfilter($_REQUEST['pageNo']));
$field = trim(sqlfilter($_REQUEST['field']));
$keyword = sqlfilter($_REQUEST['keyword']);
################## 파라미터 조합 #####################
$total_param = 'target_id='.$target_id.'&field='.$field.'&keyword='.$keyword;

if(!$pageNo){
	$pageNo = 1;
}

$where = " where memid = '$memid' ";

if($subid){
	$where .= " and subid='".$subid."'";
}

if ($keyword){
	if ($field){
		$where .= " and ".$field." like '%".$keyword."%'";
	} else {
		$where .= " and (analysis_title like '%".$keyword."%')";
	}
}

$query_cnt = "select idx from wise_analysis_main ".$where;
$result_cnt = mysqli_query($gconnet,$query_cnt);
$num = mysqli_num_rows($result_cnt);

$pageScale = 6; // 페이지당 6 개씩
//$pageScale = $num;
$start = ($pageNo-1)*$pageScale;

$StarRowNum = (($pageNo-1) * $pageScale);
$EndRowNum = $pageScale;

$order_by = " order by mv_sdate desc";

$query = "select * from wise_analysis_main ".$where.$order_by." limit ".$StarRowNum." , ".$EndRowNum;

//echo "<br><br>쿼리 = ".$query."<br><Br>";

$result = mysqli_query($gconnet,$query);

$iTotalSubCnt = $num;
$totalpage	= ($iTotalSubCnt - 1)/$pageScale  + 1;
?>

										<div class="list-th">
                        <div class="rl-download">
                            <span>NO</span>
                        </div>
                        <div class="rl-name">
                            <span>제목</span>
                        </div>
                        <div class="rl-finish">
                            <span>시작시간</span>
                        </div>
                        <div class="rl-finish">
                            <span>완료시간</span>
                        </div>
                        <div class="rl-delete">
                            <span>삭제</span>
                        </div>
                    </div>
									<div class="list-td">
									<?
									for ($i=0; $i<mysqli_num_rows($result); $i++){
										$row = mysqli_fetch_array($result);
										$listnum	= $iTotalSubCnt - (( $pageNo - 1 ) * $pageScale ) - $i;
									?>
											<div class="con-line">
											<div class="rl-con"><?=$listnum?></div>
											<div class="rl-con">
													<span class="flag"><?=get_project_status($row['mv_status'])?> (<?=number_format($row['data_cnt'])?>건)</span>
													<input type="text" placeholder="<?//=$row['analysis_title']?><?=$row['analysis_title']?>">
											</div>
		                  <div class="rl-con">
		                      <span><?=$row['mv_sdate']?></span>
		                  </div>
		                  <div class="rl-con">
		                      <span><?=$row['mv_edate']?></span>
		                  </div>
		                  <div class="rl-con">
		                      <button type="button" onclick="go_project_delete('<?=$row['idx']?>');">삭제</button>
											</div>
		              </div>
									<?}?>
								</div>

								<div class="pagination" style="margin-top:50px;text-align:center;">
								<?
									$target_link = "inner_myproject_report.php";
									$target_id = "myproject_report_area";
									$target_param = $total_param;
									include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/paging_ajax.php";
								?>
								</div>