<?php
if(!function_exists("decrypt")) {

/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 * 복호화
/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*/
function decrypt($string, $key) {
	$result = '';
	$string = base64_decode($string);
	for($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result .= $char;
	}
	return $result;
}

function decode_str($str) {
	$key = ENCODE_KEY;
	$str = trim($str);	// 공백제거
	return decrypt($str, $key);
}

// 에러 출력
function error($msg, $go_url=""){
	echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
	if($go_url == "") {
		//echo "<script>alert(\"$msg\");history.go(-1);</script>";
		echo "<script>alert(\"$msg\");</script>";
		echo $msg;
		exit;
	} else {
		echo "<script>alert(\"$msg\");document.location=\"$go_url\";</script>";
		exit;
	}
}

/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 * 페이지 리스트 출력
/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*/
function print_pagelist($page, $list_amount, $page_count, $param, $page_type = "", $btns = "", $ajax_array = ""){

	global $ptype;

	if($param != "") $param = "&".$param;

	if(($page%$list_amount) == 0) $tmp = $page-1;
	else $tmp = $page;

	$spage = floor($tmp/$list_amount)*$list_amount+1;
	if($spage <= 1) $ppage = 1;
	else $ppage = $spage - $list_amount;

	$epage = $spage+$list_amount-1;
	if($epage >= $page_count){
		$epage = $page_count;
		$npage = $page_count;
	}else{
		$npage = $epage + 1;
	}

	if(!empty($page_type)) {
		$page_name = strtolower($page_type)."page";
	} else {
		$page_name = "page";
	}

	// 2021-07-15 : 페이지 버튼 추가 ----- kky
	if(!is_array($btns)) {
		$btns = array();
		$btns['first'] = "<span aria-hidden='true'>&laquo; </span>";
		$btns['prev'] = "<span aria-hidden='true'>&lt; </span>";
		$btns['next'] = "<span aria-hidden='true'>&gt; </span>";
		$btns['last'] = "<span aria-hidden='true'>&raquo; </span>";
	}

	if($ptype != "") $param .= "&ptype=".$ptype;

	if($epage > 0) {

		$first_url = $_SERVER['PHP_SELF']."?$page_name=1$param";
		$prev_url = $_SERVER['PHP_SELF']."?$page_name=$ppage$param";
		$next_url = $_SERVER['PHP_SELF']."?$page_name=$npage$param";
		$last_url = $_SERVER['PHP_SELF']."?$page_name=$page_count$param";

		if($ajax_array != "") {
			$first_url = "javascript:".$ajax_array['func']."('".$ajax_array['id']."', '".$ajax_array['url']."', '".$page_name."=1".$param."')";
			$prev_url = "javascript:".$ajax_array['func']."('".$ajax_array['id']."', '".$ajax_array['url']."', '$page_name=$ppage$param')";
			$next_url = "javascript:".$ajax_array['func']."('".$ajax_array['id']."', '".$ajax_array['url']."', '$page_name=$npage$param')";
			$last_url = "javascript:".$ajax_array['func']."('".$ajax_array['id']."', '".$ajax_array['url']."', '$page_name=$page_count$param')";
		}
		
		echo "<ul class='pagination'>";
		echo "<li class='page-item'>";
		echo "	<a class='page-link' href=\"".$first_url."\" aria-label='Previous'>";
		echo "		".$btns['first']."";
		echo "	</a>";
		echo "</li>";
		echo "<li class='page-item'>";
		echo "	<a class='page-link' href=\"".$prev_url."\" aria-label='Previous'>";
		echo "		".$btns['prev']."";
		echo "	</a>";
		echo "</li>";

		for($spage; $spage <= $epage; $spage++){
		if($page == $spage) {
			echo "<li class='page-item active'><a class='page-link' href='javascript:void(0)'>$spage</a></li>";
		} else {
			$page_url = $_SERVER['PHP_SELF']."?$page_name=$spage$param";
			if($ajax_array != "") {
				$page_url = "javascript:".$ajax_array['func']."('".$ajax_array['id']."', '".$ajax_array['url']."', '$page_name=$spage$param')";
			}
			echo "<li class='page-item'><a class='page-link' href=\"".$page_url."\">$spage</a></li>";
		}
		}


		echo "<li class='page-item'>";
		echo "		<a class='page-link' href=\"".$next_url."\" aria-label='Next'>";
		echo "			<span aria-hidden='true'>".$btns['next']."</span>";
		echo "		</a>";
		echo "	</li>";
		echo "<li class='page-item'>";
		echo "		<a class='page-link' href=\"".$last_url."\" aria-label='Next'>";
		echo "			<span aria-hidden='true'>".$btns['last']."</span>";
		echo "		</a>";
		echo "	</li>";
		echo "</ul>";

	}
}

/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 * 보고서 상태
/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*/
function get_report_status($status = "") {

	$list = array('EE' => '임시저장', 'ED' => '작성완료', 'AS' => '분석중', 'AE' => '분석완료',  'PS' => '보고서생성중', 'PE' => '보고서생성완료');

	if($status != "") return $list[$status];
	else return $list;


}

/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
 * 보고서 유형
/*-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=*/
if(!function_exists("get_report_type")) {
	function get_report_type($type = "") {
		$list = array('SV' => '서비스평가', 'DM' => '다면평가', 'AH' => '의사결정(AHP)', 'MM' => '만족도');

		if($type != "") return $list[$type];
		else return $list;
	}
}


// 2022-01-17 : 로그인 데이터 권한 확인 ----- kky
// 결제내역별 서비스 이용권한
function get_payment_permit($memid, $orderid = "") {

	$dconnet = $GLOBALS['dconnet'];
	if(!$dconnet) {
		include $_SERVER['DOCUMENT_ROOT']."/inc/db_conn_datain.php";
	}

	$today = date("Y-m-d");

	// 결제내역별 서비스 이용권한 상태(Y)
	// 2020-04-09 : 프리미엄 등급 체크하기 위해 wise_product.memlvlcd 호출 ----- kky
	// 2020-04-29 : 기간이 겹치는 내역이 있으면 상품 권한이 큰 순서대로 (작은 숫자가 우선순위) wp.prior DESC -> ASC
	$sql = "SELECT wpp.*, wp.prdname_kor AS level_str, wp.memlvlcd, wo.name, wo.email
					FROM wise_payment_permit AS wpp INNER JOIN wise_order AS wo ON wpp.orderid = wo.orderid INNER JOIN wise_product AS wp ON wp.prdcode = wo.prdcode
					WHERE wpp.memid = '$memid' AND wpp.status = 'Y' AND wpp.sdate <= '$today' AND wpp.edate >= '$today'
					ORDER BY wp.prior ASC LIMIT 1";
	$result = mysqli_query($dconnet, $sql) or error_frame(mysqli_error($dconnet));
	$row = mysqli_fetch_array($result);

	//2018-05-23 : 회원구분 인증 추가, 상품권한 수정 ==> 결제 내역이 없는 경우 FREE 상품권한으로 기본설정 ----- kky
	if($row['orderid'] == "") {
		/*
		// 2020-04-09 : 프리미엄 등급 체크하기 위해 wise_product.memlvlcd 호출 ----- kky
		$sql = "SELECT prdcode, prdname_kor, memlvlcd FROM wise_product WHERE memlvlcd = 'FR' AND status = 'Y' ORDER BY prdcode DESC LIMIT 1";
		$result = mysqli_query($dconnet, $sql) or error_frame(mysqli_error($dconnet));
		$prd_row = mysqli_fetch_array($result);

		$row = get_product_permit($prd_row['prdcode']);

		$row['level_str'] = $prd_row['prdname_kor'];
		// 2020-04-09 : 프리미엄 등급 체크하기 위해 wise_product.memlvlcd 호출 ----- kky
		$row['memlvlcd'] = $prd_row['memlvlcd'];
		*/
	}

	// 2018-12-19 : 권한 추가하기 전 임의로 권한 부여 ----- kky
	// 2019-03-05 : 주석처리 ----- kky
	// $row['msf_project'] = "Y";

	/* close connection */
	/* mysqli_close($dconnet); */

	return $row;
}

function check_payment_permit($memid, $mode = "") {
	
	$gconnet = $GLOBALS['gconnet'];

	$permit_info = get_payment_permit($memid);

	$permit_chk = false;
	$permit_msg = "이용 권한이 없습니다.";

	if($permit_info['report_project'] == "Y") {
		$permit_chk = true;
		$permit_msg = "";
	}

	if($permit_info['report_project'] != "N" && $permit_info['report_project'] > 0) {

		if($mode == "project") {
			$sql = "SELECT COUNT(idx) AS cnt FROM wise_analysis_main WHERE memid = '$memid'";
			$result = mysqli_query($gconnet,$sql);
			$row = mysqli_fetch_array($result);

			if($permit_info['report_project'] <= $row['cnt']) {
				$permit_chk = false;
				$permit_msg = $permit_info['level_str']." 상품은 통합리포팅 프로젝트를 ".$permit_info['report_project']."번만 등록할 수 있습니다.";
			}
		}

	}

	// 2022-02-23 : 권한체크 임시 처리 ----- kky	
	$permit_chk = true;
	$permit_msg = "";

	return array('chk' => $permit_chk, 'msg' => $permit_msg, 'permit_info' => $permit_info);
}

function update_payment_permit($memid, $mode) {

	$dconnet = $GLOBALS['dconnet'];
	if(!$dconnet) {
		include_once $_SERVER['DOCUMENT_ROOT']."/inc/db_conn_datain.php";
	}
	
	$permit_info = get_payment_permit($memid);

	if($permit_info['orderid'] != "" && $mode != "") {

		$sql = "UPDATE wise_payment_permit SET ".$mode." = ".$mode." + 1 WHERE orderid = '".$permit_info['orderid']."'";
		mysqli_query($dconnet, $sql);
	
	}

}

}
?>