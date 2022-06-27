<?php
// 비엔시스템 인클루드 파일
include $_SERVER['DOCUMENT_ROOT']."/report_bn/pro_inc/include_default.php";

set_time_limit(3000);
ini_set('max_execution_time', 3000);

@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');

// 오류메세지
ini_set('display_errors','On');
//error_reporting(E_ALL^E_NOTICE);
error_reporting(E_ERROR | E_WARNING);

@ini_set("session.use_trans_sid", 0);	// PHPSESSID를 자동으로 넘기지 않음	=> session.auto_start = 0 으로 설정 / PHP 5 이상 버전부터 session.use_trans_sid 설정을 ini_set으로 바꿀 수 없음
@ini_set("url_rewriter.tags","");			// 링크에 PHPSESSID가 따라다니는것을 무력화함

@session_save_path("$_SERVER[DOCUMENT_ROOT]/data/session");

@ini_set("session.cache_expire", 1440);			// 세션 캐쉬 보관시간 (분)
@ini_set("session.gc_maxlifetime", 86400);	// session data의 gabage collection 존재 기간을 지정 (초)

@session_set_cookie_params(0, "/", ".".$_SERVER['HTTP_HOST']); // 2021-08-18 : http, https 이동 시 로그인 풀리는 현상 ==> 도메인 추가 ----- kky
@ini_set("session.cookie_domain", ".".$_SERVER['HTTP_HOST']); // 2021-08-18 : http, https 이동 시 로그인 풀리는 현상 ==> 도메인 추가 ----- kky

@session_start();

// register_globals off 처리
@extract($_GET);
@extract($_POST);
@extract($_SERVER);
@extract($_ENV);
@extract($_SESSION);
@extract($_COOKIE);
@extract($_REQUEST);
@extract($_FILES);

// 변수정의
define('ENCODE_KEY', "wiseinc!@#$");

// 사용자함수 
include $_SERVER['DOCUMENT_ROOT']."/inc/lib.php";

// 데이터인 DB 접속 
if($_REQUEST['mode'] == "datacopy") {
    include $_SERVER['DOCUMENT_ROOT']."/inc/db_conn_datain.php";
}

// 로그인정보
$memid = $_SESSION['wiz_session']['id'];
$subid = $_SESSION['wiz_session']['subid'];
$memname = decode_str($_SESSION['wiz_session']['name']);
$mememail = decode_str($_SESSION['wiz_session']['email']);
?>