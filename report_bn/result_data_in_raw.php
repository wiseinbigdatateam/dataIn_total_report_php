<? include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/include_default.php"; // 공통함수 인클루드 ?>
<?
$bbs_code = "excel_result_data";
$_P_DIR_FILE = $_P_DIR_FILE.$bbs_code."/";
$file_name = "service_result_raw.xls";

require_once $_SERVER["DOCUMENT_ROOT"].'/report/PROGRAM_excel/reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('UTF-8'); // 이부분만 바꿨습니다.
$data->read($_SERVER["DOCUMENT_ROOT"]."/report/upload_file/".$bbs_code."/".$file_name);

//echo "전체카운트 = ".$data->sheets[0]['numRows']; exit;		
for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {

	$rdata_no = $data->sheets[0]['cells'][$i][1];
	$rdata_con = $data->sheets[0]['cells'][$i][2];
	$rdata_receive = $data->sheets[0]['cells'][$i][3];
	$rdata_first = $data->sheets[0]['cells'][$i][4];
	$rdata_speech = $data->sheets[0]['cells'][$i][5];
	$rdata_rounge = $data->sheets[0]['cells'][$i][6];
	$rdata_attens = $data->sheets[0]['cells'][$i][7];
	$rdata_kind = $data->sheets[0]['cells'][$i][8];
	$rdata_end = $data->sheets[0]['cells'][$i][9];
	$rdata_final = $data->sheets[0]['cells'][$i][10];
	$rdata_tel = $data->sheets[0]['cells'][$i][11];
	$rdata_satisf = $data->sheets[0]['cells'][$i][12];
	$rdata_gubun1 = $data->sheets[0]['cells'][$i][13];
	$rdata_gubun2 = $data->sheets[0]['cells'][$i][14];
	$rdata_gubun3 = $data->sheets[0]['cells'][$i][15];
	$rdata_gender = $data->sheets[0]['cells'][$i][16];
	$rdata_age = $data->sheets[0]['cells'][$i][17];
	$rdata_part = $data->sheets[0]['cells'][$i][18];
	$rdata_position = $data->sheets[0]['cells'][$i][19];
	
	$query_in = "insert into wise_analysis_report_service_result_data_raw set"; 
	$query_in .= " rdata_no = '".$rdata_no."', ";
	$query_in .= " rdata_con = '".$rdata_con."', ";
	$query_in .= " rdata_receive = '".$rdata_receive."', ";
	$query_in .= " rdata_first = '".$rdata_first."', ";
	$query_in .= " rdata_speech = '".$rdata_speech."', ";
	$query_in .= " rdata_rounge = '".$rdata_rounge."', ";
	$query_in .= " rdata_attens = '".$rdata_attens."', ";
	$query_in .= " rdata_kind = '".$rdata_kind."', ";
	$query_in .= " rdata_end = '".$rdata_end."', ";
	$query_in .= " rdata_final = '".$rdata_final."', ";
	$query_in .= " rdata_tel = '".$rdata_tel."', ";
	$query_in .= " rdata_satisf = '".$rdata_satisf."', ";
	$query_in .= " rdata_gubun1 = '".$rdata_gubun1."', ";
	$query_in .= " rdata_gubun2 = '".$rdata_gubun2."', ";
	$query_in .= " rdata_gubun3 = '".$rdata_gubun3."', ";
	$query_in .= " rdata_gender = '".$rdata_gender."', ";
	$query_in .= " rdata_age = '".$rdata_age."', ";
	$query_in .= " rdata_part = '".$rdata_part."', ";
	$query_in .= " rdata_position = '".$rdata_position."', ";
	$query_in .= " wdate = now() ";
	
	//echo $query_in; exit;
	
	$result_in = mysqli_query($gconnet,$query_in);
	
}
?>