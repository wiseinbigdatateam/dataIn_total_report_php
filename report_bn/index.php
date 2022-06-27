<?php
// DB Connect 또는 로그인 정보가 필요한 경우 common.php 파일 include 후 사용 가능
include "../admin/common.php";

echo "mainid => ".$memid."<br>";
echo "subid => ".$subid."<br>";

$search_sql = ($subid != "") ? " AND subid = '$subid' " : "";

$sql = "SELECT * FROM wise_analysis_main WHERE memid = '$memid' $search_sql ORDER BY idx DESC";
$result = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($result)) {
	echo $row['analysis_title']."<br>";

	// 분석 문항
	$sql = "SELECT * FROM wise_analysis_quiz WHERE analysis_idx = '".$row['idx']."' ORDER BY quiz_no ASC";

	// 분석 데이터
	$sql = "SELECT * FROM wise_analysis_data WHERE analysis_idx = '".$row['idx']."' ORDER BY data_no ASC, quiz_no ASC, answer_no ASC";
	// data_no = 응답자 번호, quiz_no = 문항 번호, answer_no = 응답 번호 (다중응답인 경우 순서대로 1,2,3...)
	// 예) 첫번째 응답자 A 가 3번 문항에 최대 3개까지 응답한 경우 총 3개의 로우데이터가 존재
	//			data_no = 1, quiz_no = 3, answer_no = 1
	// 			data_no = 1, quiz_no = 3, answer_no = 2
	// 			data_no = 1, quiz_no = 3, answer_no = 3
}
?>