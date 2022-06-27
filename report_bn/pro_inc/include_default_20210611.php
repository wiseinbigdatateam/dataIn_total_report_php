<?
ini_set("session.cache_expire", 60000); // 세션 유효시간 : 분
ini_set("session.gc_maxlifetime", 3600000); // 세션 가비지 컬렉션(로그인시 세션지속 시간) : 초
session_cache_limiter("private");
session_start();
date_default_timezone_set('Asia/Seoul');
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate");
header('Content-Type: text/html; charset=UTF-8');
ini_set('memory_limit','-1');

ini_set('max_execution_time', '300');
set_time_limit(300);

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

//error_reporting( E_CORE_ERROR | E_COMPILE_ERROR | E_ERROR | E_PARSE | E_USER_ERROR );
ini_set("display_errors", "1");

//@ini_set("allow_url_fopen ", true);
//오류 코드 - 없는 변수를 출력하라고

include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/db_conn.php";
include $_SERVER["DOCUMENT_ROOT"]."/report/pro_inc/user_function.php"; // PHP 유저 함수 모음

/*$sitetitle_set_sql = "select set_title,set_keyword,menu_name1 from sitetitle_set where 1 order by idx desc";
$sitetitle_set_query = mysqli_query($gconnet,$sitetitle_set_sql);
$sitetitle_set_cnt = mysqli_num_rows($sitetitle_set_query);

if($sitetitle_set_cnt > 0 ){
	$sitetitle_set_row = mysqli_fetch_array($sitetitle_set_query);
	$_SITE_TITLE = $sitetitle_set_row[set_title];
	$_SITE_KEYWORDS = $sitetitle_set_row[set_keyword];
	$_SITE_MENU_1 = $sitetitle_set_row[menu_name1];
	$_SITE_ADMIN_TITLE = $_SITE_TITLE."_전체관리자";
	$_SITE_PARTNER_TITLE = $_SITE_TITLE."_업체관리자";
} else {
	$_SITE_TITLE = "DATA IN";
	$_SITE_ADMIN_TITLE = $_SITE_TITLE."_전체관리자";
	$_SITE_PARTNER_TITLE = $_SITE_TITLE."_업체관리자";
}
*/

$_SITE_TITLE = "DATA IN";

// 첨부파일 저장
$_P_DIR_FILE =  $_SERVER["DOCUMENT_ROOT"]."/report/upload_file/"; //게시판,자료 등에서 업로드하는 폴더가 저장되는 경로
$_P_DIR_WEB_FILE= "/report/upload_file/";

if(!isset($_SERVER["HTTPS"])) {
	$inc_fdata_ctype = "http";
	$inc_fdata_domain = "http://".$_SERVER["HTTP_HOST"]."";
} else {
	$inc_fdata_ctype = "https";
	$inc_fdata_domain = "https://".$_SERVER["HTTP_HOST"]."";
}

$inc_fdata_url = $_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];

?>