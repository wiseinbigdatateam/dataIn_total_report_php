<?php
$memid = $_SESSION['wiz_session']['id'];
$subid = $_SESSION['wiz_session']['subid'];
$email = $_SESSION['wiz_session']['email'];

if($memid == "" && !in_array(basename($_SERVER['PHP_SELF']), array("auth.html","cron_decision_report.php"))) {
    error_go("로그인 후 이용해주세요.", "https://datain.co.kr/guide/html/member-login.html?prev=report");
    exit;
}
?>