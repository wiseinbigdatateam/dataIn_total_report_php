<? include $_SERVER["DOCUMENT_ROOT"]."/report_bn/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
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

if($memid){
	$where .= " and memid='".$memid."'";	
}
if($subid){
	$where .= " and subid='".$subid."'";
}

if ($keyword){
	if ($field){
		$where .= " and ".$field." like '%".$keyword."%'";
	} else {
		$where .= " and (product_name like '%".$keyword."%' or product_title like '%".$keyword."%')";
	}
}

$query_cnt = "select idx from wise_analysis_myreport where 1 ".$where;
$result_cnt = mysqli_query($gconnet,$query_cnt);
$num = mysqli_num_rows($result_cnt);

$pageScale = 6; // 페이지당 6 개씩
//$pageScale = $num;
$start = ($pageNo-1)*$pageScale;

$StarRowNum = (($pageNo-1) * $pageScale);
$EndRowNum = $pageScale;

$order_by = " order by wdate desc";

$query = "select * from wise_analysis_myreport where 1 ".$where.$order_by." limit ".$StarRowNum." , ".$EndRowNum;

//echo "<br><br>쿼리 = ".$query."<br><Br>";

$result = mysqli_query($gconnet,$query);

$iTotalSubCnt = $num;
$totalpage	= ($iTotalSubCnt - 1)/$pageScale  + 1;
?>

										<div class="list-th">
                                            <div class="rl-download">
                                                <span>다운로드</span>
                                            </div>
                                            <div class="rl-name">
                                                <span>제목</span>
                                            </div>
                                            <div class="rl-finish">
                                                <span>분석시작시간</span>
                                            </div>
                                            <div class="rl-finish">
                                                <span>분석종료시간</span>
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
                                                <div class="rl-con">
											<?if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"  || $_SERVER['REMOTE_ADDR'] == "211.227.88.137"){?>
												<button type="button" class="download" onclick="go_myreport_make('<?=$row['report_type']?>','<?=$row['idx']?>');">보고서 생성</button>
												<button type="button" class="downloadExcel" onclick="go_myreport_getreport('<?=$row['report_type']?>','<?=$row['report_idx']?>');"></button>
											<?}else{?>
												<?if($row['report_status'] == "com"){?>
                                                    <!--<button type="button" class="download" onclick="go_myreport_getreport('<?=$row['report_type']?>','<?=$row['report_idx']?>');">다운로드</button>-->
													<button type="button" class="downloadExcel" onclick="go_myreport_getreport('<?=$row['report_type']?>','<?=$row['report_idx']?>');"></button>
                                                    <button type="button" class="download" onclick="open_myreport_viewer('','<?=$row['report_type']?>','<?=$row['report_idx']?>');" title="보고서(PPT)">P</button>
													<button type="button" class="download" onclick="open_myreport_viewer('vr','<?=$row['report_type']?>','<?=$row['report_idx']?>');" title="보고서(HWP)">H</button>
												<?} else {?>
													<button type="button" class="download" onclick="go_myreport_make('<?=$row['report_type']?>','<?=$row['idx']?>');">보고서 생성</button>
												<? } ?>
											<?}?>
                                                </div>
                                                <div class="rl-con">
													<?if($_SERVER['REMOTE_ADDR'] == "211.227.88.137"){?>
														<button type="button" class="download" onclick="go_myreport_getreport('<?=$row['report_type']?>','<?=$row['report_idx']?>');">다운로드</button>
													<?}?>
                                                    <span class="flag"><?=get_report_type($row['report_type'])?></span>
                                                   
													<?if($_SERVER['REMOTE_ADDR'] == "59.5.188.44"){?>
														<?=$row['report_title']?>
														 <button type="button" onclick="window.open('<?=get_option_url($row['report_type'],$row['report_idx'])?>');">바로가기</button>
													<?} else {?>
														 <input type="text" placeholder="<?//=$row['report_name']?><?=$row['report_title']?>">
													<? } ?>
                                                </div>
                                                <div class="rl-con">
                                                    <span><?//=$row['report_sdate']?><?=$row['wdate']?></span>
                                                </div>
                                                <div class="rl-con">
                                                    <span><?=$row['report_edate']?></span>
						

                                                </div>
                                                <div class="rl-con">
                                                    <button type="button" onclick="go_report_delete('<?=$row['idx']?>');">삭제</button>
												                                                </div>
                                            </div>
					<?}?>
					</div>

					<div class="pagination" style="margin-top:50px;text-align:center;">
					<?
						$target_link = "inner_myreport_report.php";
						$target_id = "myreport_report_area";
						$target_param = $total_param;
						include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/paging_ajax.php";
					?>
					</div>