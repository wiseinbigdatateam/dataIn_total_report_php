<?php
include "../../inc/common.php";
include "../../inc/db_conn_datain.php";

$mrd_type_path = "hr/multi";
$mrd_common_path = "hr/common";

$sql = "SELECT * FROM analysis_report WHERE idx = '$ridx'";
$result = mysqli_query($gconnet, $sql);
$report_info = mysqli_fetch_array($result);

$sql = "SELECT idx, APPRAISER, APPRAISER_NO, MARYMONDYUM, RANKYN, 100YN, indexValue, scoreRound, frequenRound from DM_option where idx =".$ridx;
$result = mysqli_query($gconnet, $sql);
$report_option_info = mysqli_fetch_array($result);

if($report_info['idx'] != "") {

    $memid = $report_info['memid'];
    $subid = $report_info['subid'];
    
    $upfile_path = "../report/".$report_info['memid']."/".$ridx;
    if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

    $pageno = 1;

    /* 표지 */
    $rdata = $report_info['analysis_title']."@다면평가 결과 보고서@".$report_info['population']."@".$pageno."@";

    $filename = "title";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 표지 : Part1 조사개요 */
    $rdata = "part1@조사 개요".$br;
    $rdata .= "1. 조사 배경 및 필요성".$br;
    $rdata .= "2. 조사 목적 및 기대효과".$br;
    $rdata .= "3. 조사 절차".$br;
    $rdata .= "4. 조사 설계".$br;
    $rdata .= "5. 표본 특성".$br;
    $rdata .= "6. 평가도 및 측정방법";

    $filename = "index";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 1.조사 배경 및 필요성 */
    $rdata = "1.조사 배경 및 필요성@Part1.조사개요@".$pageno."@@@@".$br;
    $rdata .= "조직원 능력과 자질에 대한 평가 패러다임 변화";
    $rdata .= "@상사-동료-부하 간의 상호작용 유형 변화";
    $rdata .= "@다양한 원천으로부터의 평가에 기반한 인사평가 체계의 정립";
    $rdata .= "@조직 구성원의 사고와 행동의 바람직한 변화 및 능력 개발을 위한 피드백 필요";
    $rdata .= "@조직 내 다면평가의 필요성은 다음과 같음 1. 객관성과 공정성 향상 2. 조직원간 관계 증진을 위한 강한 동기부여 3. 자기개발의 촉진제 역할 4. 피드백 시스템 정립으로 인한 조직 활성화의 촉매제";
    
    $filename = "survey_backgro";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 2.조사 목적 및 기대효과 */
    $rdata = "2.조사 목적 및 기대효과@Part1. 조사개요@".$pageno."@객관적/체계적 측정, 평가, 관리@평가 피드백 마인드 확산 및 수용력 향상@현 수준 대비 향상 방안 모색@평가 비교를 통한 발전 방향 설정@자기계발의 올바른 방향 제시@상사의 코칭, 체계적 교육훈련@조직경쟁력(인적 역량) 향상".$br;
    $rdata .= "객관적/공정한 평가 진단@구성원의 조직 내 가치 증명@개인의 인적 역량 향상".$br;
    $rdata .= "결과의 지속적 관리 및 분석@상호 신뢰와 믿음을 통한 조직의 발전 도모@효율적인 평가와 책임 경영";

    $filename = "survey_purpose";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 3.조사 절차 */
    $rdata = "3.조사 절차@Part1. 조사개요@".$pageno."@@다면 평가 모델을 기반으로, 실사진행, 자료검증, 에디팅, 데이터 입력 및 처리, 전산처리 등의 과정을 거쳐 최종 결과물이 제출됨@@".$br;
    $rdata .= "- 기관에 적합한 평가지표 및 평가 기획@- 조직 및 주요 업무 파악@- 평가대상자 확인을 위한 이메일/문자 발송@- 수집 자료에 대한 신뢰성 확보 위해 검증 실시@- 에디팅/코딩된 자료의 전산입력 및 전산처리@- 기업 전사 통합 보고서 작성@- 분석결과를 바탕으로 통계 솔루션에 의한 보고서 작성".$br;
    $rdata .= "@- 다면평가 구조 설계@- 시스템 사용법 안내@- 검증보고서 작성@- 기초결과표 및 평가점수 산출 위한 가중분석 실시@@- 종합 다면평가 분석보고서";

    $filename = "survey_proced";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 4.조사 설계 */
    $rdata = "4.조사 설계@Part1. 조사개요@6@조사 설계@@@".$br;
    $rdata .= $report_info['analysis_title']."@".$report_info['population']."@".$report_info['sample_size']."@".$report_info['sampling_method']."@".$report_info['survey_method']."@".$report_info['analysis_period'];
    
    $filename = "survey_design";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 표본 특성 */
    $sql = "SELECT COUNT(DISTINCT appraisee_no) AS ALLCOUNT FROM DM_analysisDM_step04_appraisee_no WHERE idx =".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $appraiseeno_all = mysqli_fetch_array($result);
    $rdata = "5. 표본 특성@Part1. 조사개요@".$pageno."@@@@@구분@표본수(N)@비율(%)".$br;
    $allcount = $appraiseeno_all['ALLCOUNT'];
    $rdata.= "전체@전체@".$allcount."@100.00@100.00".$br;
    $sql = "SELECT AAA.groupIdx, AAA.itemIdxValue, CONCAT(AAA.selectedItemNM,'@',AAA.selectedItemdetailsIndexNM,'@',AAA.cnt,'@',AAA.percent) AS content ";
    $sql .= "      FROM(SELECT BB.groupIdx, BB.itemIdxValue, BB.selectedItemNM, SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(AA.quiz_value, '^', BB.itemIdxValue  ), '^', -1), '|', -1) AS selectedItemdetailsIndexNM , BB.cnt AS cnt , ROUND(BB.cnt/".$allcount."*100, ".$report_option_info['scoreRound'].") as percent ";
    $sql .= "                  FROM wise_analysis_quiz AA";
    $sql .= "                  INNER JOIN ( SELECT A.groupIdx, A.itemIdx, A.selectedItemNM,B.itemIdxValue, B.cnt ";
    $sql .= "                                      FROM (SELECT groupIdx, itemIdx, selectedItemNM FROM DM_group WHERE idx = ".$ridx." ) A";
    $sql .= "                                      INNER JOIN ( SELECT groupIdx, itemIdx, itemIdxValue, count(appraisee_no) AS cnt ";
    $sql .= "                                                         FROM DM_analysisDM_step04_appraisee_no WHERE idx = ".$ridx." GROUP BY groupIdx, itemIdx, itemIdxValue) B ";
    $sql .= "                                      ON A.groupIdx = B.groupIdx AND A.itemIdx = B.itemIdx ";
    $sql .= "                              )BB ON BB.itemIdx = AA.quiz_no ";
    $sql .= "      WHERE AA.analysis_idx = ".$report_info['dataInIdx'];
    $sql .= "      )AAA ";
    $sql .= "      ORDER BY AAA.groupIdx, AAA.itemIdxValue ";
    $result = mysqli_query($gconnet, $sql);
    $pagenoPlusr = 0;
    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']).$br;
    }
    $pageno = $pageno + sprintf('%d',$pagenoPlusr / 17);
    
    $filename = "sample_charac";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    /* 평가척도 및 측정방법 */
    $pagenoPlusr6 = 22;
    /* 평가척도 및 측정방법_상사 */
    $sql = "SELECT B.frequenRound ,COUNT(DISTINCT middle_model_index) AS cnt from DM_middle_model_sub A ";
    $sql .= "JOIN DM_option B ON A.idx = B.idx ";
    $sql .= "WHERE  A.appraisee_grade = 1 AND A.idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $appraisee_grade_info = mysqli_fetch_array($result);
    $cntR = $appraisee_grade_info['cnt'];
    if ($cntR != "0"){
        $appraisee_grade_RD =number_format(100/$appraisee_grade_info['cnt'] ,$appraisee_grade_info['frequenRound']);
        $pageno++;
        $rdata = "6.평가척도 및 측정방법_상사@Part1. 조사개요@".$pageno."@평가내용 및 점수산출 기준@@@".$br;
        $sql = " SELECT CONCAT(A.middle_model_name,'(".$appraisee_grade_RD.")','@',D.quiz_title,'@','평가내용 직접 입력','@',B.distribution) AS content  ";
        $sql .= " FROM DM_middle_model A ";
        $sql .= " INNER JOIN DM_middle_model_sub B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
        $sql .= " INNER JOIN analysis_report C ON A.idx = C.idx ";
        $sql .= " INNER JOIN wise_analysis_quiz D ON C.dataInIdx = D.analysis_idx AND B.quiz_no = D.quiz_no ";
        $sql .= " WHERE A.idx = ".$ridx;
        $sql .= " AND B.appraisee_grade = 1";
        $result = mysqli_query($gconnet, $sql);

        $pagenoPlusr = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  $row['content'].$br;
        }
        $pageno = $pageno + sprintf('%d',$pagenoPlusr / $pagenoPlusr6);

        $filename = "mt_evalua_scale";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);
    
    }

    /* 평가척도 및 측정방법_부하 */
    $sql = "SELECT B.frequenRound ,COUNT(DISTINCT middle_model_index) AS cnt from DM_middle_model_sub A ";
    $sql .= "JOIN DM_option B ON A.idx = B.idx ";
    $sql .= "WHERE  A.appraisee_grade = 2 AND A.idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $appraisee_grade_info = mysqli_fetch_array($result);
    $cntR = $appraisee_grade_info['cnt'];
    if ($cntR != "0"){
        $appraisee_grade_RD =number_format(100/$appraisee_grade_info['cnt'] ,$appraisee_grade_info['frequenRound']);
        $pageno++;
        $rdata = "6.평가척도 및 측정방법_부하@Part1. 조사개요@".$pageno."@평가내용 및 점수산출 기준@@@".$br;
        $sql = " SELECT CONCAT(A.middle_model_name,'(".$appraisee_grade_RD.")','@',D.quiz_title,'@','평가내용 직접 입력','@',B.distribution) AS content  ";
        $sql .= " FROM DM_middle_model A ";
        $sql .= " INNER JOIN DM_middle_model_sub B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
        $sql .= " INNER JOIN analysis_report C ON A.idx = C.idx ";
        $sql .= " INNER JOIN wise_analysis_quiz D ON C.dataInIdx = D.analysis_idx AND B.quiz_no = D.quiz_no ";
        $sql .= " WHERE A.idx = ".$ridx;
        $sql .= " AND B.appraisee_grade = 2";
        $result = mysqli_query($gconnet, $sql);

        $pagenoPlusr = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  $row['content'].$br;
        }
        $pageno = $pageno + sprintf('%d',$pagenoPlusr / $pagenoPlusr6);

        $filename = "mt_evalua_scale";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);
    
    }

    /* 평가척도 및 측정방법_동료 */
    $sql = "SELECT B.frequenRound ,COUNT(DISTINCT middle_model_index) AS cnt from DM_middle_model_sub A ";
    $sql .= "JOIN DM_option B ON A.idx = B.idx ";
    $sql .= "WHERE  A.appraisee_grade = 3 AND A.idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $appraisee_grade_info = mysqli_fetch_array($result);
    $cntR = $appraisee_grade_info['cnt'];
    if ($cntR != "0"){
        $appraisee_grade_RD =number_format(100/$appraisee_grade_info['cnt'] ,$appraisee_grade_info['frequenRound']);
        $pageno++;
        $rdata = "6.평가척도 및 측정방법_동료@Part1. 조사개요@".$pageno."@평가내용 및 점수산출 기준@@@".$br;
        $sql = " SELECT CONCAT(A.middle_model_name,'(".$appraisee_grade_RD.")','@',D.quiz_title,'@','평가내용 직접 입력','@',B.distribution) AS content  ";
        $sql .= " FROM DM_middle_model A ";
        $sql .= " INNER JOIN DM_middle_model_sub B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
        $sql .= " INNER JOIN analysis_report C ON A.idx = C.idx ";
        $sql .= " INNER JOIN wise_analysis_quiz D ON C.dataInIdx = D.analysis_idx AND B.quiz_no = D.quiz_no ";
        $sql .= " WHERE A.idx = ".$ridx;
        $sql .= " AND B.appraisee_grade = 3";

        $result = mysqli_query($gconnet, $sql);

        $pagenoPlusr = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  $row['content'].$br;
        }
        $pageno = $pageno + sprintf('%d',$pagenoPlusr / $pagenoPlusr6);

        $filename = "mt_evalua_scale";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);
    
    }

    /* 평가척도 및 측정방법_자신 */
    $sql = "SELECT B.frequenRound ,COUNT(DISTINCT middle_model_index) AS cnt from DM_middle_model_sub A ";
    $sql .= "JOIN DM_option B ON A.idx = B.idx ";
    $sql .= "WHERE  A.appraisee_grade = 4 AND A.idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $appraisee_grade_info = mysqli_fetch_array($result);
    $cntR = $appraisee_grade_info['cnt'];
    if ($cntR != "0"){
        $appraisee_grade_RD =number_format(100/$appraisee_grade_info['cnt'] ,$appraisee_grade_info['frequenRound']);
        $pageno++;
        $rdata = "6.평가척도 및 측정방법_자신@Part1. 조사개요@".$pageno."@평가내용 및 점수산출 기준@@@".$br;
        $sql = " SELECT CONCAT(A.middle_model_name,'(".$appraisee_grade_RD.")','@',D.quiz_title,'@','평가내용 직접 입력','@',B.distribution) AS content  ";
        $sql .= " FROM DM_middle_model A ";
        $sql .= " INNER JOIN DM_middle_model_sub B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
        $sql .= " INNER JOIN analysis_report C ON A.idx = C.idx ";
        $sql .= " INNER JOIN wise_analysis_quiz D ON C.dataInIdx = D.analysis_idx AND B.quiz_no = D.quiz_no ";
        $sql .= " WHERE A.idx = ".$ridx;
        $sql .= " AND B.appraisee_grade = 4";
        $result = mysqli_query($gconnet, $sql);

        $pagenoPlusr = mysqli_num_rows($result);
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  $row['content'].$br;
        }
        $pageno = $pageno + sprintf('%d',$pagenoPlusr / $pagenoPlusr6);

        $filename = "mt_evalua_scale";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);
    
    }

    $pageno++;
    /* 가중치 */
    $rdata = "6.평가척도 및 측정방법@Part1. 조사개요@".$pageno."@평가 가중치@평가대상@상사평가@부하평가@동료평가@본인평가@Y";
    $sql = "SELECT DISTINCT appraisee_grade AS grade ";
    $sql .= "FROM DM_weight WHERE idx =  ".$ridx;
    $result = mysqli_query($gconnet, $sql);

    $appraisee_grade_info = array();
    while($row = mysqli_fetch_array($result)){
        array_push ($appraisee_grade_info , ($row['grade']));
    }

    $rdata .= (in_array("1", $appraisee_grade_info)) ? "@Y" : "@N";
    $rdata .= (in_array("2", $appraisee_grade_info)) ? "@Y" : "@N";
    $rdata .= (in_array("3", $appraisee_grade_info)) ? "@Y" : "@N";
    $rdata .= (in_array("4", $appraisee_grade_info)) ? "@Y" : "@N";

    $sql = "SELECT middle_model_index, middle_model_name ";
    $sql .= "FROM DM_middle_model WHERE idx =  ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    while($row = mysqli_fetch_array($result)){
        $rdata .= $br.$row['middle_model_name'];

        $sql = "SELECT appraisee_grade, DM_weight ";
        $sql .= " FROM DM_weight WHERE idx =  ".$ridx;
        $sql .= " AND middle_model_index =  ".$row['middle_model_index'];
        $result2 = mysqli_query($gconnet, $sql);

        $DM_weight = array();
        while($row = mysqli_fetch_array($result2)){
            $DM_weight[$row['appraisee_grade']] = $row['DM_weight'];
        }
        $rdata .= (in_array("1", $appraisee_grade_info)) ? "@".$DM_weight['1'] : "@";
        $rdata .= (in_array("2", $appraisee_grade_info)) ? "@".$DM_weight['2'] : "@";
        $rdata .= (in_array("3", $appraisee_grade_info)) ? "@".$DM_weight['3'] : "@";
        $rdata .= (in_array("4", $appraisee_grade_info)) ? "@".$DM_weight['4'] : "@";
    }

    $filename = "mt_weight";
    $report_file = $mrd_type_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    if($report_option_info['100YN'] == "1"){
        $pageno++;
        /* 평가척도 및 측정방법 */
        $rdata = "6.평가척도 및 측정방법@Part1. 조사개요";

        $filename = "measure_".$report_option_info['indexValue'];
        $report_file = $mrd_common_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);    
    }

    $pageno++;
    /* 표지 : Part2 종합분석 */
    $rdata = "part2@종합분석".$br;
    $rdata .= "1. 종합평가".$br;

    $sql = " SELECT CONCAT(groupIdx + 1,'. ',selectedItemNM) AS content from DM_group ";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " ORDER BY groupIdx";
    $result = mysqli_query($gconnet, $sql);

    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'].$br;
    }
    
    $filename = "sub_title";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);    

    /* part2 종합분석 */
    /* 평가 가중치 */
    $pageno++;

    $columCount = 18;
    $rdata = "1.종합평가@Part2. 종합분석@".$pageno."@1-1.종합점수@● 분석결과, ".$report_info['analysis_title']."의 다면평가";
    $sql = " SELECT CONCAT(' 총점은 ',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound']."),'점으로 나타남@● 영역별로는 ') AS content ";
    $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx." GROUP BY appraisee_no )A";
    $result = mysqli_query($gconnet, $sql);

    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'];
    }
    $sql = " ( SELECT CONCAT(B.middle_model_name,' ',A.data,'점, ') AS content";
    $sql .= " FROM ";
    $sql .= " (SELECT idx, middle_model_index , FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].") AS data ";
    $sql .= " FROM DM_analysisDM_step03_middle_model";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " GROUP BY middle_model_index) A ";
    $sql .= " INNER  JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ORDER BY A.data DESC )";
    $result = mysqli_query($gconnet, $sql);

    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'];
    }
    $rdata = substr($rdata , 0, -2);
    $rdata.= "으로 각각 나타남";

    if($report_option_info['100YN'] == "1"){
        $rdata.="@[단위: 100점 만점]@구분@피평가자수@총점";
    }else{
        $rdata.="@[단위: 점 만점]@구분@피평가자수@총점";
    }

    $sql = " SELECT CONCAT('@',middle_model_name) AS content ";
    $sql .= " FROM DM_middle_model ";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " ORDER BY middle_model_index limit 5";
    $result = mysqli_query($gconnet, $sql);
    $rowcount = mysqli_num_rows($result);


    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'];
    }

    for($ii = $rowcount ; $ii < $columCount - 3 ; $ii++){
        $rdata.= "@";
    }

    for ($ii = 0 ; $ii < $rowcount + 3 ; $ii++){
        $rdata.= "@Y";
    }

    for($ii = $rowcount + 3 ; $ii < $columCount ; $ii++){
        $rdata.= "@N";
    }
    $rdata.= $br;

    $sql = " SELECT CONCAT('총점','@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content ";
    $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx."  GROUP BY appraisee_no ) A";
    $sql .= " UNION ALL";
    $sql .= " SELECT CONCAT(B.middle_model_name,'@',A.data) AS content";
    $sql .= " FROM ";
    $sql .= " (SELECT idx, middle_model_index , FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].") AS data ";
    $sql .= " FROM DM_analysisDM_step03_middle_model";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " GROUP BY middle_model_index) A ";
    $sql .= " INNER  JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index";

    $result = mysqli_query($gconnet, $sql);

    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'].$br;
    }

    $rdata.= "//EOR//".$br;

    $sql = " SELECT CONCAT('전체','@',COUNT(DISTINCT appraisee_no)) AS content FROM DM_analysisDM_step03_middle_model";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " UNION ALL";
    $sql .= " SELECT CONCAT('@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content ";
    $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx." GROUP BY appraisee_no ) A";
    $sql .= " UNION ALL";
    $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content";
    $sql .= " FROM DM_analysisDM_step03_middle_model";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " GROUP BY middle_model_index";
    $sql .= " ORDER BY middle_model_index )";
    $result = mysqli_query($gconnet, $sql);

    while($row = mysqli_fetch_array($result))
    {
        $rdata.=  $row['content'];
    }

    // 2022-04-28 : 문항이 부족한 경우 구분자(@) 부족하여 오류 발생하여 구분자(@) 추가 ----- kky
    //for($ii = $rowcount + 3 ; $ii < $columCount ; $ii++){
    //for($ii = $rowcount ; $ii < $columCount ; $ii++){
    for($ii = $rowcount -1; $ii < $columCount ; $ii++){
        $rdata.= "@";
    }

    $filename = "graph_table_1";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $sql = " SELECT COUNT(DISTINCT middle_model_index) AS cnt FROM DM_analysisDM_step03_middle_model ";
    $sql .= " WHERE idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $middle_model_cnt = mysqli_fetch_array($result);
    $middle_model_index = 0;

    for ($jj = 0 ; $jj < $middle_model_cnt['cnt'] ; $jj++) {
        $pageno++;
        $middle_model_index++;
        // 2022-05-12 : 값이 없을 경우 추가, IFNULL 추가 ----- kky
        $sql = " ( SELECT IFNULL(CONCAT('1.종합평가@Part2. 종합분석@','".$pageno."','@1-',A.middle_model_index,'. ',B.middle_model_name,' 항목별 점수@● 분석결과, ',B.middle_model_name,' 전체 점수는 ',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound']."),'점으로 파악되었음@● 항목별로는 '), '1.종합평가@Part2. 종합분석@".$pageno."@@@@@') AS content ";
        $sql .= " FROM (SELECT idx, middle_model_index, SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data  FROM DM_analysisDM_step03_middle_model ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND middle_model_index = ".$middle_model_index." GROUP BY appraisee_no ) A";
        $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ) ";
        $result = mysqli_query($gconnet, $sql);
        $rdata = '';
        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'];
        }

        $sql = " ( SELECT CONCAT(B.quiz_title,' ',A.data,'점, ') AS content ";
        $sql .= " FROM (SELECT quiz_no, FORMAT(ROUND(SUM(data_val)/SUM(IF(data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].") AS data ";
        $sql .= " FROM DM_analysisDM_step03 ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no) A ";
        $sql .= " INNER  JOIN wise_analysis_quiz B ON A.quiz_no = B.quiz_no ";
        $sql .= " AND B.analysis_idx = ".$report_info['dataInIdx']." ORDER BY A.data DESC  )";
        $result = mysqli_query($gconnet, $sql);

        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'];
        }
        $rdata = substr($rdata, 0, -2);
        $rdata .= "으로 각각 나타남";

        if ($report_option_info['100YN'] == "1") {
            $rdata .= "@[단위: 100점 만점]@구분@피평가자수";
        } else {
            $rdata .= "@[단위: 점 만점]@구분@피평가자수";
        }

        $sql = " SELECT CONCAT('@',middle_model_name)  AS content ";
        $sql .= " FROM DM_middle_model ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND  middle_model_index = ".$middle_model_index;
        $result = mysqli_query($gconnet, $sql);

        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'];
        }

        $sql = " SELECT CONCAT('@',B.quiz_title) AS content ";
        $sql .= " FROM (SELECT quiz_no ";
        $sql .= " FROM DM_analysisDM_step03 ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no) A ";
        $sql .= " INNER  JOIN wise_analysis_quiz B ON A.quiz_no = B.quiz_no ";
        $sql .= " AND B.analysis_idx = ".$report_info['dataInIdx'];
        $result = mysqli_query($gconnet, $sql);
        $rowcount = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'];
        }

        for ($ii = $rowcount; $ii < $columCount - 3; $ii++) {
            $rdata .= "@";
        }

        for ($ii = 0; $ii < $rowcount + 3; $ii++) {
            $rdata .= "@Y";
        }

        for ($ii = $rowcount + 3; $ii < $columCount; $ii++) {
            $rdata .= "@N";
        }
        $rdata .= $br;

        $sql = " ( SELECT CONCAT(B.middle_model_name,'@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound']."),'@') AS content ";
        $sql .= " FROM (SELECT idx, middle_model_index, SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data  FROM DM_analysisDM_step03_middle_model ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND middle_model_index = ".$middle_model_index." GROUP BY appraisee_no ) A";
        $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ) ";
        $sql .= " UNION ALL";
        $sql .= " SELECT CONCAT(B.quiz_title,'@',A.data,'@') AS content ";
        $sql .= " FROM (SELECT quiz_no, FORMAT(ROUND(SUM(data_val)/SUM(IF(data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].") AS data ";
        $sql .= " FROM DM_analysisDM_step03 ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no) A ";
        $sql .= " INNER  JOIN wise_analysis_quiz B ON A.quiz_no = B.quiz_no ";
        $sql .= " AND B.analysis_idx = ".$report_info['dataInIdx'];

        $result = mysqli_query($gconnet, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'].$br;
        }

        $rdata .= "//EOR//".$br;

        $sql = " SELECT CONCAT('전체','@',COUNT(DISTINCT appraisee_no)) AS content FROM DM_analysisDM_step03_middle_model";
        $sql .= " WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
        $sql .= " UNION ALL ";
        $sql .= " ( SELECT CONCAT('@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM ( SELECT idx, middle_model_index, SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data  FROM DM_analysisDM_step03_middle_model ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND middle_model_index = ".$middle_model_index." ) A ";
        $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index )";
        $sql .= " UNION ALL";
        $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(data_val)/SUM(IF(data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS data ";
        $sql .= " FROM DM_analysisDM_step03 ";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no ) ";

        $result = mysqli_query($gconnet, $sql);

        // 2022-05-12 : 값이 없을 경우 추가 ----- kky
        $rdata_row = "";
        while ($row = mysqli_fetch_array($result)) {
            $rdata .= $row['content'];
            $rdata_row .= $row['content'];
        }

        for ($ii = $rowcount + 3; $ii < $columCount; $ii++) {
            $rdata .= "@";
            $rdata_row .= "@";
        }

        // 2022-05-12 : 값이 없을 경우 추가 ----- kky
        for($ii = count(explode($rdata_row, "@")); $ii < 18; $ii++) {
            $rdata .= "@";
        }

        $filename = "graph_table_1";
        $report_file = $mrd_common_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);

    }

    $sql = " SELECT COUNT(DISTINCT groupIdx) AS cnt FROM DM_group ";
    $sql .= " WHERE idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql);
    $group_cnt = mysqli_fetch_array($result);
    $group_index = 0;
    for ($kk = 0 ; $kk < $group_cnt['cnt'] ; $kk++) {
        $pageno++;
        $group_index++;
        $titleNum = $group_index + 1;
        $rdata = "";
        $sql = " SELECT CONCAT('".$titleNum.".',selectedItemNM,' 평가@Part2. 종합분석@',".$pageno.",'@".$titleNum."-',groupIdx,', ',selectedItemNM,'의 종합점수@● 분석결과, ') AS content  FROM DM_group ";
        $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
        $sql .= " UNION ALL ";
        $sql .= " SELECT CONCAT(' 총점은 ',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound']."),'점으로 나타남@● 영역별로는 ') AS content ";
        $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx." GROUP BY appraisee_no )A";
        $result = mysqli_query($gconnet, $sql);

        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  $row['content'];
        }
                    //작업
        $sql = " SELECT  CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(quiz_value, '^', B.itemIdxValue ), '^', -1), '|', -1),' ',B.con,'점, ') AS content ";
        $sql .= "        FROM wise_analysis_quiz A ";
        $sql .= "        INNER JOIN (( ";
        $sql .= "                     SELECT itemIdx, itemIdxValue, IF (AA.sum_data IS NOT NULL, FORMAT(ROUND(SUM(AA.sum_data)/COUNT(AA.sum_data), ".$report_option_info['scoreRound']."  ), ".$report_option_info['scoreRound']." ), '') AS con  ";
        $sql .= "                            FROM ( SELECT itemIdx, itemIdxValue, SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step04_middle_model ";
        $sql .= "                            WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
        $sql .= "                            GROUP BY appraisee_no, itemIdx, itemIdxValue )AA";
        $sql .= "                            GROUP BY  itemIdx, itemIdxValue  )";
        $sql .= "        )B ";
        $sql .= "        ON A.quiz_no = B.itemIdx ";
        $sql .= "        WHERE  A.analysis_idx = ".$report_info['dataInIdx'];
        $sql .= "        ORDER BY B.con DESC ";
        $result = mysqli_query($gconnet, $sql);
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']);
        }
        $rdata = substr($rdata , 0, -2);
        $rdata.= "으로 각각 나타남";

        if($report_option_info['100YN'] == "1"){
            $rdata.="@[단위: 100점 만점]@구분@피평가자수@총점";
        }else{
            $rdata.="@[단위: 점 만점]@구분@피평가자수@총점";
        }

        $sql = " SELECT CONCAT('@',A.middle_model_name) AS content FROM ";
        $sql .= " (SELECT middle_model_index, middle_model_name FROM DM_middle_model ";
        $sql .= " WHERE idx = ".$ridx." GROUP BY middle_model_index) A ";
        $sql .= " INNER JOIN (SELECT middle_model_index from DM_analysisDM_step04_middle_model ";
        $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." GROUP BY middle_model_index) B ON A.middle_model_index = B.middle_model_index limit 5";

        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $rowcount = mysqli_num_rows($result);

        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $rowcount ; $ii < $columCount - 3 ; $ii++){
            $rdata.= "@";
        }

        for ($ii = 0 ; $ii < $rowcount + 3 ; $ii++){
            $rdata.= "@Y";
        }

        for($ii = $rowcount + 3 ; $ii < $columCount ; $ii++){
            $rdata.= "@N";
        }
        $rdata.= $br;

        $sql = " SELECT CONCAT('총점','@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content ";
        $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx." GROUP BY appraisee_no )A";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']).$br;
        }

        $sql = " SELECT  CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(quiz_value, '^', B.itemIdxValue ), '^', -1), '|', -1),'@',B.con) AS content ";
        $sql .= "        FROM wise_analysis_quiz A ";
        $sql .= "        INNER JOIN (( ";
        $sql .= "                     SELECT itemIdx, itemIdxValue, IF (AA.sum_data IS NOT NULL, FORMAT(ROUND(AVG(AA.sum_data), ".$report_option_info['scoreRound']." ), ".$report_option_info['scoreRound']." ), '0') AS con  ";
        $sql .= "                            FROM ( SELECT itemIdx, itemIdxValue, SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step04_middle_model ";
        $sql .= "                            WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
        $sql .= "                            GROUP BY appraisee_no, itemIdx, itemIdxValue )AA";
        $sql .= "                            GROUP BY  itemIdx, itemIdxValue  )";
        $sql .= "        )B ";
        $sql .= "        ON A.quiz_no = B.itemIdx ";
        $sql .= "        WHERE  A.analysis_idx = ".$report_info['dataInIdx'];
        $sql .= "        ORDER BY B.itemIdxValue ASC ";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']).$br;
        }

        $rdata.= "//EOR//".$br;

        $sql = " SELECT CONCAT('전체','@',COUNT(DISTINCT appraisee_no)) AS content FROM DM_analysisDM_step03_middle_model";
        $sql .= " WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
        $sql .= " UNION ALL ";

        $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content ";
        $sql .= " FROM ( SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step03_middle_model WHERE idx = ".$ridx." GROUP BY appraisee_no )A)";
        $sql .= " UNION ALL";
        $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content";
        $sql .= " FROM DM_analysisDM_step03_middle_model";
        $sql .= " WHERE idx = ".$ridx;
        $sql .= " GROUP BY middle_model_index";
        $sql .= " ORDER BY middle_model_index )";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

        // 2022-05-12 : 값이 없을 경우 추가 ----- kky
        $rdata_row = "";
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  preg_replace('/\r\n|\r|\n/','',$row['content']);
            $rdata_row .= preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $rowcount + 3 ; $ii < $columCount ; $ii++){
            $rdata.= "@";
            $rdata_row .= "@";
        }

        // 2022-05-12 : 값이 없을 경우 추가 ----- kky
        for($ii = count(explode($rdata_row, "@")); $ii < 18; $ii++) {
            $rdata .= "@";
        }

        $rdata.= $br;

        $sql = " SELECT COUNT(DISTINCT middle_model_index) AS cnt FROM DM_analysisDM_step04_middle_model ";
        $sql .= " WHERE idx = ".$ridx;
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $step04_middle_model_cnt = mysqli_fetch_array($result);

        $sql = "SELECT distinct itemIdxValue AS groupValue FROM DM_analysisDM_step04_appraisee_no";
        $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
        $sql .= " ORDER BY itemIdxValue ";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

        while($groupValuerow = mysqli_fetch_array($result))
        {
            $itemIdxValue =  $groupValuerow['groupValue'];
            $sql = " (SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(quiz_value, '^', ".$itemIdxValue." ), '^', -1), '|', -1)  AS content FROM wise_analysis_quiz A ";
            $sql .= " INNER JOIN DM_group B ON A.quiz_no = B.itemIdx AND groupIdx = ".$group_index." AND B.idx = ".$ridx;
            $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx']." )";
            $sql .= " UNION ALL";
            $sql .= " (SELECT CONCAT('@',COUNT(DISTINCT appraisee_no)) AS content FROM DM_analysisDM_step04_appraisee_no";
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND itemIdxValue = ".$itemIdxValue." )";
            $sql .= " UNION ALL";
            $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM ";
            $sql .= " (SELECT  SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data FROM DM_analysisDM_step04_middle_model  " ;
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND itemIdxValue = ".$itemIdxValue." GROUP BY appraisee_no)A )";

            for($jj = 1 ; $jj < $step04_middle_model_cnt['cnt'] + 1 ; $jj++) {
                $sql .= " UNION ALL";
                $sql .= " (SELECT IF(SUM(IF(sum_data_val >0 , 1, 0)) > 0 , CONCAT('@',sum_data_val) , '@-') AS content ";
                $sql .= " FROM ( SELECT FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].") AS sum_data_val ";
                $sql .= " FROM DM_analysisDM_step04_middle_model";
                $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND itemIdxValue = ".$itemIdxValue." AND middle_model_index = ".$jj;
                $sql .= " GROUP BY middle_model_index) A )";
            };

            $groupresult = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            // 2022-05-12 : 값이 없을 경우 추가 ----- kky
            $rdata_row = "";
            while($grouprow = mysqli_fetch_array($groupresult))
            {
                $rdata.=  preg_replace('/\r\n|\r|\n/','',$grouprow['content']);
                $rdata_row .= preg_replace('/\r\n|\r|\n/','',$grouprow['content']);
            }
            for($groupValuerowii = $rowcount + 3 ; $groupValuerowii < $columCount ; $groupValuerowii++){
                $rdata.= "@";
                $rdata_row .= "@";
            }

            // 2022-05-12 : 값이 없을 경우 추가 ----- kky
            for($ii = count(explode($rdata_row, "@")); $ii < 18; $ii++) {
                $rdata .= "@";
            }

            $rdata.= $br;
        }
        
        $filename = "graph_table_1";
        $report_file = $mrd_common_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);

        $sql = " SELECT COUNT(DISTINCT middle_model_index) AS cnt FROM DM_analysisDM_step04_middle_model ";
        $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $middle_model_cnt = mysqli_fetch_array($result);
        $middle_model_index = 0;
        for ($jj = 0 ; $jj < $middle_model_cnt['cnt'] ; $jj++) {
            $pageno++;
            $middle_model_index++;
            // 2022-05-12 : 값이 없을 경우 추가, IFNULL 추가 ----- kky
            $sql = " SELECT IFNULL(CONCAT('".$titleNum.".',selectedItemNM,' 평가@Part2. 종합분석@',".$pageno.",'@".$titleNum."-',groupIdx,', ',selectedItemNM,'의 '), '".$titleNum.". 평가@Part2. 종합분석@".$pageno."@@@@@".$titleNum."의 ') AS content  FROM DM_group ";
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
            $sql .= " UNION ALL";
            $sql .= " ( SELECT IFNULL(CONCAT(B.middle_model_name,' 항목별 점수@● 분석결과, ',B.middle_model_name,' 전체 점수는 ',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']."  ),".$report_option_info['scoreRound']."),'점으로 파악되었음@● 항목별로는 '), '항목별 점수@● 분석결과, 전체 점수는 점으로 파악되었음@● 항목별로는 ') AS content FROM DM_analysisDM_step04_middle_model A ";
            $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
            $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index;
            $sql .= " AND A.middle_model_index = ".$middle_model_index." )";
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            $rdata = '';
            while ($row = mysqli_fetch_array($result)) {
                $rdata .= $row['content'];
            }

            $sql = " SELECT  CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue ), '^', -1), '|', -1),' ',B.data,'점, ') AS content ";
            $sql .= "        FROM (SELECT quiz_no, quiz_value FROM wise_analysis_quiz WHERE analysis_idx = ".$report_info['dataInIdx']." )A ";
            $sql .= "        INNER JOIN (SELECT  itemIdx , itemIdxValue, IF (sum_data_val IS NOT NULL, FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound']."), '')  AS data ";
            $sql .= "                            FROM DM_analysisDM_step04_middle_model ";
            $sql .= "                            WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND middle_model_index = ".$middle_model_index;
            $sql .= "                            GROUP BY itemIdx, itemIdxValue, groupIdx ";
            $sql .= "                     )B ";
            $sql .= "         ON A.quiz_no = B.itemIdx ";
            $sql .= "         ORDER BY B.data DESC ";

            //작업1
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']);
            }
            $rdata = substr($rdata, 0, -2);
            $rdata .= "으로 각각 나타남";

            if ($report_option_info['100YN'] == "1") {
                $rdata .= "@[단위: 100점 만점]@구분@피평가자수@";
            } else {
                $rdata .= "@[단위: 점 만점]@구분@피평가자수@";
            }
            $sql = "SELECT middle_model_name AS content ";
            $sql .= " FROM DM_middle_model ";
            $sql .= " WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']);
            }

            $sql = " SELECT CONCAT('@',B.quiz_title) AS content ";
            $sql .= " FROM (SELECT quiz_no ";
            $sql .= " FROM DM_analysisDM_step04 ";
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
            $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no) A ";
            $sql .= " INNER  JOIN wise_analysis_quiz B ON A.quiz_no = B.quiz_no ";
            $sql .= " AND B.analysis_idx = ".$report_info['dataInIdx'];
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            $rowcount = mysqli_num_rows($result);

            // 2022-05-12 : 값이 없을 경우 추가 ----- kky
            $rdata_row = "";
            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']);
                $rdata_row .= preg_replace('/\r\n|\r|\n/','',$row['content']);
            }

            for ($ii = $rowcount; $ii < $columCount - 3; $ii++) {
                $rdata .= "@";
                $rdata_row .= "@";
            }

            for ($ii = 0; $ii < $rowcount + 3; $ii++) {
                $rdata .= "@Y";
            }

            for ($ii = $rowcount + 3; $ii < $columCount; $ii++) {
                $rdata .= "@N";
            }
            $rdata .= $br;

            $sql = " SELECT CONCAT('전체','@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound']."),'@') AS content FROM DM_analysisDM_step04_middle_model ";
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND middle_model_index = ".$middle_model_index;
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']).$br;
            }
            $sql = " SELECT  CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue ), '^', -1), '|', -1),'@',B.data) AS content ";
            $sql .= "        FROM (SELECT quiz_no, quiz_value FROM wise_analysis_quiz WHERE analysis_idx = ".$report_info['dataInIdx']." )A ";
            $sql .= "        INNER JOIN ( ";
            $sql .= "                     SELECT A.itemIdx , A.itemIdxValue, IF(B.data IS NOT NULL,B.data, '') AS data ";
            $sql .= "                            FROM (SELECT DISTINCT itemIdx, itemIdxValue FROM DM_analysisDM_step04_middle_model WHERE idx = ".$ridx." AND groupIdx = ".$group_index.") A ";
            $sql .= "                            LEFT JOIN (SELECT  itemIdx , itemIdxValue, FORMAT(ROUND(AVG(sum_data_val),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].") AS data ";
            $sql .= "                                               FROM DM_analysisDM_step04_middle_model WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND middle_model_index = ".$middle_model_index;
            $sql .= "                                               GROUP BY itemIdx, itemIdxValue, groupIdx)B ";
            $sql .= "                             ON A.itemIdx = B.itemIdx AND A.itemIdxValue = B.itemIdxValue ";
            $sql .= "                     )B ";
            $sql .= "         ON A.quiz_no = B.itemIdx ";
            $sql .= "         ORDER BY B.itemIdxValue ASC ";

            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']).$br;
            }

            $rdata.= "//EOR//".$br;

            $sql = " SELECT CONCAT('전체','@',COUNT(DISTINCT A.appraisee_no)) AS content FROM DM_analysisDM_step04_appraisee_no A ";
            $sql .= " INNER JOIN DM_analysisDM_step03_middle_model B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
            $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index;
            $sql .= " UNION ALL ";
            $sql .= " ( SELECT CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step04_middle_model A ";
            $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
            $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index;
            $sql .= " AND A.middle_model_index = ".$middle_model_index." )";
            $sql .= " UNION ALL";
            $sql .= " SELECT CONCAT('@',FORMAT(ROUND(SUM(data_val)/SUM(IF(data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS data ";
            $sql .= " FROM DM_analysisDM_step04 ";
            $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index;
            $sql .= " AND  middle_model_index = ".$middle_model_index." GROUP BY quiz_no";

            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            // 2022-05-12 : 값이 없을 경우 추가 ----- kky
            $rdata_row = "";
            while ($row = mysqli_fetch_array($result)) {
                $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']);
                $rdata_row .= preg_replace('/\r\n|\r|\n/','',$row['content']);
            }

            for ($ii = $rowcount + 3; $ii < $columCount; $ii++) {
                $rdata .= "@";
                $rdata_row .= "@";
            }

            // 2022-05-12 : 값이 없을 경우 추가 ----- kky
            for($ii = count(explode($rdata_row, "@")); $ii < 18; $ii++) {
                $rdata .= "@";
            }

            $rdata.= $br;

            $sql = " SELECT distinct A.itemIdxValue AS groupValue FROM DM_analysisDM_step04_appraisee_no A ";
            $sql .= "LEFT JOIN DM_analysisDM_step03_middle_model B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
            $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index;
            $sql .= " ORDER BY A.itemIdxValue ";
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

            while($groupValuerow = mysqli_fetch_array($result))
            {
                $itemIdxValue =  $groupValuerow['groupValue'];
                $sql = " SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(quiz_value, '^', ".$itemIdxValue." ), '^', -1), '|', -1)  AS content FROM wise_analysis_quiz A ";
                $sql .= " INNER JOIN DM_group B ON A.quiz_no = B.itemIdx AND groupIdx = ".$group_index." AND B.idx = ".$ridx;
                $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
                $groupresult = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
                while($grouprow = mysqli_fetch_array($groupresult))
                {
                    $rdata.=  preg_replace('/\r\n|\r|\n/','',$grouprow['content']);
                }
                $sql = " SELECT CONCAT('@',COUNT(DISTINCT A.appraisee_no)) AS content FROM DM_analysisDM_step04_appraisee_no A ";
                $sql .= " INNER JOIN DM_analysisDM_step03_middle_model B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
                $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index." AND A.itemIdxValue = ".$itemIdxValue;
                $groupresult = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
                while($grouprow = mysqli_fetch_array($groupresult))
                {
                    $grouprowCnt = preg_replace('/\r\n|\r|\n/','',$grouprow['content']);
                    $rdata.=  $grouprowCnt;
                }

                if ($grouprowCnt == '@0'){
                    for($groupValuerowii = 2 ; $groupValuerowii < $columCount ; $groupValuerowii++){
                        $rdata.= "@-";
                    }
                }else{
                    $sql = " (SELECT CONCAT('@',IF(sum_data_val IS NOT NULL, FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound']."), '-'))  AS content ";
                    $sql .= " FROM DM_analysisDM_step04_middle_model ";
                    $sql .= " WHERE idx = ".$ridx." AND groupIdx = ".$group_index." AND middle_model_index = ".$middle_model_index." AND itemIdxValue = ".$itemIdxValue;
                    $sql .= " GROUP BY itemIdx, itemIdxValue, groupIdx ) ";

                    // $sql = " SELECT CONCAT('@',FORMAT(ROUND(SUM(B.data_val)/SUM(IF(B.data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step04_appraisee_no A ";
                    // $sql .= " INNER JOIN DM_analysisDM_step03 B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
                    // $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index." AND A.itemIdxValue = ".$itemIdxValue;
                    $sql .= " UNION ALL";
                    /**************************** 2022-03-30 : 중분류 사용하지 않는 문항의 경우 공백처리 ----- kky
                    $sql .= " (SELECT CONCAT('@',FORMAT(ROUND(SUM(B.data_val)/SUM(IF(B.data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content";
                    $sql .= " FROM DM_analysisDM_step04_appraisee_no A";
                    $sql .= " INNER JOIN DM_analysisDM_step03 B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
                    $sql .= " WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index." AND A.itemIdxValue = ".$itemIdxValue;
                    $sql .= " GROUP BY B.quiz_no";
                    $sql .= " ORDER BY B.quiz_no )";
                    *************************************************************************************************/
                    $sql .= " (SELECT IFNULL(C.content, '@-') AS content";	// *
                    $sql .= " FROM DM_middle_model_sub AS S";
                    $sql .= " LEFT JOIN (SELECT CONCAT('@',FORMAT(ROUND(SUM(B.data_val)/SUM(IF(B.data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content, B.quiz_no, A.idx";
                    $sql .= " 	FROM DM_analysisDM_step04_appraisee_no A";
                    $sql .= " 	INNER JOIN DM_analysisDM_step03 B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no AND middle_model_index = ".$middle_model_index;
                    $sql .= " 	WHERE A.idx = ".$ridx." AND A.groupIdx = ".$group_index." AND A.itemIdxValue = ".$itemIdxValue;
                    $sql .= " GROUP BY B.quiz_no) AS C ON S.idx = C.idx AND S.quiz_no = C.quiz_no";
                    $sql .= " WHERE S.idx = $ridx AND S.middle_model_index = $middle_model_index";
                    $sql .= " ORDER BY S.quiz_no ASC)";

                    $groupresult = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

                    while($grouprow = mysqli_fetch_array($groupresult))
                    {
                        $rdata.=  preg_replace('/\r\n|\r|\n/','',$grouprow['content']);
                    }
                    for($groupValuerowii = $rowcount + 3 ; $groupValuerowii < $columCount ; $groupValuerowii++){
                        $rdata.= "@";
                    }
                }
                $rdata.= $br;
            }

            $filename = "graph_table_1";
            $report_file = $mrd_common_path."/".$filename.".mrd";
            $data_file = $filename."_".$pageno.".txt";
            make_data_file($data_file, $report_file, $pageno, $rdata);
    
        }
    }

    $pageno++;
    /* 표지 : Part3 개인별 평가결과 */
    $rdata = "part3@개인별 평가결과";
    
    $filename = "sub_title";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $sql = "SELECT DISTINCT appraisee_no FROM DM_analysisDM_step03";
    $sql .= " WHERE idx = ".$ridx." ORDER BY appraisee_no";
    $appraisee_no_result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $appraisee_no_count = 0;

    $sql = " SELECT COUNT(DISTINCT groupIdx) AS cnt FROM DM_group ";
    $sql .= " WHERE idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $group_cnt = mysqli_fetch_array($result);
    $group_cnt = $group_cnt['cnt'];

    //자신평가 유무
    $appraiseeGrade4 = false;
    $sql = " SELECT COUNT(*) AS cnt FROM DM_analysisDM_step02 ";
    $sql .= " WHERE appraiseeGrade = 4 AND idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $appraiseeGrade4cnt = mysqli_fetch_array($result);
    $appraiseeGrade4cnt = $appraiseeGrade4cnt['cnt'];

    if ((int)$appraiseeGrade4cnt > 0 ){
        $appraiseeGrade4 = true;
    }

    $tableData = array();
    //타이틀
    $sql = " SELECT '0' AS ordr , '총점' AS content ";
    $sql .= " UNION ALL ";
    $sql .= " SELECT CONCAT( 1, middle_model_index ) AS ordr , middle_model_name AS content FROM DM_middle_model ";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " UNION ALL ";
    $sql .= " SELECT CONCAT( 2, A.quiz_no ) AS ordr , B.quiz_title AS content  FROM DM_analysisDM_step03 A ";
    $sql .= " INNER JOIN wise_analysis_quiz B ON A.quiz_no = B.quiz_no AND B.analysis_idx = ".$report_info['dataInIdx'];
    $sql .= " WHERE A.idx = ".$ridx;
    $sql .= " GROUP BY ordr, content ORDER BY ordr ASC";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $pagenoPlusr = mysqli_num_rows($result);

    $step = array();
    $format = array();
    $dumpData = array();
    while ($row = mysqli_fetch_array($result)) {
        $ordr = $row['ordr'];
        array_push( $step, $ordr);
        $format[$ordr] = '@-';
        array_push( $dumpData, $row['content']);
    }
    array_push( $tableData, $dumpData);

    //총점수
    $sql = " (SELECT '0' AS ordr, CONCAT('@',FORMAT(ROUND(SUM(A.sum_data)/COUNT(A.sum_data),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content ";
    $sql .= " from (SELECT SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)) AS sum_data from DM_analysisDM_step03_middle_model ";
    $sql .= " WHERE idx = ".$ridx." GROUP BY appraisee_no)A  ) ";
    $sql .= " UNION ALL ";
    $sql .= " SELECT CONCAT( 1 ,middle_model_index) AS ordr, CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content";
    $sql .= " FROM DM_analysisDM_step03_middle_model";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " GROUP BY middle_model_index ";
    $sql .= " UNION ALL ";
    $sql .= " SELECT CONCAT( 2, quiz_no ) AS ordr , CONCAT('@',FORMAT(ROUND(SUM(data_val)/SUM(IF(data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content";
    $sql .= " FROM DM_analysisDM_step03";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " GROUP BY ordr, quiz_no ";
    $sql .= " ORDER BY ordr ASC";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

    $dumpData = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push( $dumpData, $row['content']);
    }

    array_push( $tableData, $dumpData);

    // 2022-05-09 : 다면평가 구성원 파일 등록 (통합리포팅, 다면평가Adv) ----- kky
    $sql = "SELECT * FROM wise_analysis_main WHERE idx = '".$report_info['dataInIdx']."'";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $analysis_info = mysqli_fetch_array($result);

    if(in_array($analysis_info['data_type'], array("FILE", "MSF")) && $analysis_info['data_key'] > 0) {
        switch($analysis_info['data_type']) {
            case "FILE" : $msf_date = "000000"; $msf_seq = $analysis_info['data_key']; break;
            case "MSF" : $msf_date = substr($analysis_info['data_key'], 0, 6); $msf_seq = substr($analysis_info['data_key'], 6); break;
        }

        unset($member_list);
        $sql = "SELECT seq, id, name FROM wise_msf_member WHERE msf_date = '$msf_date' AND msf_seq = '$msf_seq'";
        $result = mysqli_query($dconnet, $sql) or die(mysqli_error($dconnet));
        while($row = mysqli_fetch_array($result)) {
            $member_list[$row['seq']] = array('id' => $row['id'], 'name' => $row['name']);
        }
    }

    while($appraisee_no_list = mysqli_fetch_array($appraisee_no_result)){
        $appraisee_no = $appraisee_no_list['appraisee_no'];//피평가자 번호
        // 2022-05-09 : 다면평가 구성원 파일 등록 (통합리포팅, 다면평가Adv) ----- kky
        /*
        $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(quiz_value, '^', ".$appraisee_no." ), '^', -1), '|', -1)  AS appraisee_name FROM wise_analysis_quiz";
        $sql .= " WHERE analysis_idx = ".$report_info['dataInIdx']." AND quiz_no = ".$report_option_info['MARYMONDYUM'];
        $result = mysql_query($sql) or die(mysqli_error($gconnet));
        $appraisee_name = mysql_fetch_array($result);
        $appraisee_name = $appraisee_name['appraisee_name'];//피평가 이름
        */
        $appraisee_name = ($member_list[$appraisee_no]['name'] != "") ? $member_list[$appraisee_no]['name'] : $appraisee_no;

        $appraisee_no_count++ ;//피평가 순번수

        $rdata = $appraisee_no_count."@".$appraisee_name."@".$pageno;

        $sql = " SELECT A.quiz_title AS content FROM wise_analysis_quiz A";
        $sql .= " INNER  JOIN DM_analysisDM_step04_appraisee_no B ON B.idx = ".$ridx." AND B.appraisee_no = ".$appraisee_no." AND B.itemIdx = A.quiz_no ";
        $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
        $sql .= " UNION ALL ";
        $sql .= "  SELECT '총점' ";
        $sql .= " UNION ALL ";
        $sql .= " SELECT DISTINCT B.middle_model_name  AS content FROM DM_analysisDM_step03 A ";
        $sql .= " INNER JOIN DM_middle_model B ON A.idx = B.idx AND A.middle_model_index = B.middle_model_index ";
        $sql .= " WHERE A.idx = ".$ridx." AND A.appraisee_no = ".$appraisee_no;
        $sql .= " UNION ALL ";
        $sql .= "  SELECT '전체순위' ";
        $sql .= " UNION ALL ";
        $sql .= " SELECT CONCAT(SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue  ), '^', -1), '|', -1), '내 순위')  AS content FROM wise_analysis_quiz A ";
        $sql .= " INNER  JOIN DM_analysisDM_step04_appraisee_no B ON B.idx = ".$ridx." AND B.appraisee_no = ".$appraisee_no." AND B.itemIdx = A.quiz_no ";
        $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $rowcount = mysqli_num_rows($result);
        $columCount = 14;
        while($row = mysqli_fetch_array($result))
        {
            $rdata.=  "@".preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $rowcount ; $ii < $columCount + 1 ; $ii++){
            $rdata.= "@";
        }

        $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue  ), '^', -1), '|', -1)  AS content FROM wise_analysis_quiz A ";
        $sql .= " INNER  JOIN DM_analysisDM_step04_appraisee_no B ON B.idx = ".$ridx." AND B.appraisee_no = ".$appraisee_no." AND B.itemIdx = A.quiz_no ";
        $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
        $sql .= " UNION ALL ";
        $sql .= " ( SELECT FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")  AS content  FROM DM_analysisDM_step03_middle_model ";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no." ) ";
        $sql .= " UNION ALL ";
        $sql .= " ( SELECT FORMAT(ROUND(SUM(sum_data_val)/COUNT(sum_data_val ),".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")  AS content ";
        $sql .= " FROM DM_analysisDM_step03_middle_model";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        $sql .= " GROUP BY middle_model_index ORDER BY middle_model_index )";
        $sql .= " UNION ALL ";

        // $sql .= " ( SELECT FORMAT(ROUND(data_val),".$report_option_info['scoreRound'].")  AS content  FROM DM_analysisDM_step03 ";
        // $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        // $sql .= " GROUP BY middle_model_index ) ";
        // $sql .= " UNION ALL ";
        //총 순위
        $sql .= " (SELECT A.RAN AS content FROM  ( ";
        $sql .= "        SELECT appraisee_no, RANK() over (ORDER BY SUM(sum_data_val) / SUM(IF(sum_data_val > 0, 1, 0)) DESC ) AS RAN FROM DM_analysisDM_step03_middle_model ";
        $sql .= "               WHERE idx = ".$ridx." GROUP BY appraisee_no ) A ";
        $sql .= " WHERE A.appraisee_no = ".$appraisee_no." ) ";
        $sql .= " UNION ALL ";
        //그룹별 순위
        $sql .= " (SELECT A.RAN  AS content FROM ( ";
        $sql .= " SELECT A.appraisee_no, RANK() over (PARTITION BY B.groupIdx ORDER BY SUM(sum_data_val) / SUM(IF(sum_data_val > 0, 1, 0)) DESC ) AS RAN FROM DM_analysisDM_step03_middle_model A ";
        $sql .= "        JOIN( ";
        $sql .= "        SELECT A.idx, A.groupIdx, A.appraisee_no FROM DM_analysisDM_step04_appraisee_no A ";
        $sql .= "               JOIN( ";
        $sql .= "               SELECT idx, groupIdx, itemIdx, itemIdxValue FROM DM_analysisDM_step04_appraisee_no ";
        $sql .= "                      WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no." ) B ";
        $sql .= "               ON A.idx = B.idx AND A.groupIdx = B.groupIdx AND A.itemIdx = B.itemIdx AND A.itemIdxValue = B.itemIdxValue ) B ";
        $sql .= "        ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no ";
        $sql .= "        GROUP BY B.groupIdx, A.appraisee_no ORDER BY groupIdx ";
        $sql .= " )A WHERE appraisee_no = ".$appraisee_no." )";

        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $rowcount = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $rdata.=  "@".preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $rowcount ; $ii < $columCount + 1 ; $ii++){
            $rdata.= "@";
        }

        $rdata .= ($appraiseeGrade4) ? "@본인평가" : "@";

        $sql = "SELECT SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue  ), '^', -1), '|', -1)  AS content FROM wise_analysis_quiz A ";
        $sql .= " INNER  JOIN DM_analysisDM_step04_appraisee_no B ON B.idx = ".$ridx." AND B.appraisee_no = ".$appraisee_no." AND B.itemIdx = A.quiz_no ";
        $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $rowcount = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $rdata.=  "@".preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $rowcount ; $ii < 4 ; $ii++){
            $rdata.= "@";
        }
        ////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////// 하단 데이터(그래프)////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////////////////
        $rdata .= $br;
        $tableDataInbivi = array();
        $tableDataInbivi = $tableData;

        ////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////// 타인 평가       ////////////////////////////////////////
        // 2022-05-18 : double 타입 데이터 근사값으로 저장되어 ROUND 함수 사용 시 반올림이 제대로 되지 않아서 FLOOR 함수로 대체 ----- kky
        $sql = " SELECT '0' AS ordr, CONCAT('@',FORMAT(FLOOR(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0))*POWER(10,".$report_option_info['scoreRound'].")+0.5)/POWER(10,".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step03_middle_model  ";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        $sql .= " UNION  ALL ";
        $sql .= " ( SELECT CONCAT( 1 ,middle_model_index) AS ordr, CONCAT('@',FORMAT(FLOOR(SUM(sum_data_val)/COUNT(sum_data_val)*POWER(10,".$report_option_info['scoreRound'].")+0.5)/POWER(10,".$report_option_info['scoreRound']."),".$report_option_info['scoreRound']."))  AS content ";
        $sql .= " FROM DM_analysisDM_step03_middle_model";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        $sql .= " GROUP BY middle_model_index ORDER BY middle_model_index )";
        // $sql .= " SELECT CONCAT( 1 ,middle_model_index) AS ordr, CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step03_middle_model  ";
        // $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        // $sql .= " GROUP BY middle_model_index ";
        $sql .= " UNION ALL ";
        $sql .= " SELECT CONCAT( 2, quiz_no ) AS ordr , CONCAT('@',FORMAT(FLOOR(data_val * POWER(10,".$report_option_info['scoreRound'].")+0.5)/POWER(10,".$report_option_info['scoreRound']."),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step03  ";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        $sql .= " ORDER BY ordr ASC";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

        $dumpData = array();
        $dumpData2 = array();
        $dumpData = $format;
        while ($row = mysqli_fetch_array($result)) {
            $dumpData[$row['ordr']] = preg_replace('/\r\n|\r|\n/','',$row['content']);
        }
        foreach ($step as $key) {
            array_push( $dumpData2, $dumpData[$key]);
        }
        array_push( $tableDataInbivi, $dumpData2);

        ////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////// 본인 평가       ////////////////////////////////////////
        $dumpData2 = array();
        foreach ($step as $key) {
            array_push( $dumpData2, '@-');
        }
        if($appraiseeGrade4){
            $sql = " SELECT COUNT(*) AS cnt FROM DM_analysisDM_step02 ";
            $sql .= " WHERE appraiseeGrade = 4 AND idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            $appraiseeGrade4cntInbivi = mysqli_fetch_array($result);
            $appraiseeGrade4cntInbivi = $appraiseeGrade4cntInbivi['cnt'];

            if ((int)$appraiseeGrade4cntInbivi > 0 ){

                $sql = " SELECT '0' AS ordr, CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step02_middle_model  ";
                $sql .= " WHERE appraiseeGrade =4 AND idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
                $sql .= " UNION  ALL ";
                $sql .= " SELECT CONCAT( 1 ,middle_model_index) AS ordr, CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step02_middle_model  ";
                $sql .= " WHERE appraiseeGrade =4 AND idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
                $sql .= " GROUP BY middle_model_index ";
                $sql .= " UNION ALL ";
                $sql .= " SELECT CONCAT( 2, quiz_no ) AS ordr , CONCAT('@',FORMAT(ROUND(data_val,".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step02  ";
                $sql .= " WHERE appraiseeGrade =4 AND idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
                $sql .= " ORDER BY ordr ASC";
                $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));

                $dumpData = array();
                $dumpData2 = array();
                $dumpData = $format;
                while ($row = mysqli_fetch_array($result)) {
                    $dumpData[$row['ordr']] = preg_replace('/\r\n|\r|\n/','',$row['content']);
                }
                foreach ($step as $key) {
                    array_push( $dumpData2, $dumpData[$key]);
                }
            }
        }
        array_push( $tableDataInbivi, $dumpData2);

        ////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////// 그룹별 평가     ////////////////////////////////////////

        // 2022-05-12 : 값이 없을 경우 추가, IFNULL 추가 ----- kky
        for ($kk = 1 ; $kk < $group_cnt + 1 ; $kk++) {
            $sql = " (SELECT '0' AS ordr, IFNULL(CONCAT('@',FORMAT(ROUND(SUM(AA.sum_data)/COUNT(AA.sum_data ),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")), '@')  AS content FROM  ";
            $sql .= " ( SELECT SUM(A.sum_data_val)/SUM(IF(A.sum_data_val >0 , 1, 0)) AS sum_data from DM_analysisDM_step03_middle_model A ";
            $sql .= " INNER JOIN (SELECT A.idx, A.appraisee_no FROM DM_analysisDM_step04_appraisee_no A ";
            $sql .= "             INNER JOIN (SELECT idx, itemIdx, itemIdxValue FROM DM_analysisDM_step04_appraisee_no ";
            $sql .= "                          WHERE idx = ".$ridx." AND  appraisee_no = ".$appraisee_no." AND groupIdx = ".$kk." ) B   ";
            $sql .= " ON A.idx = B.idx AND A.itemIdx =B.itemIdx AND A.itemIdxValue = B.itemIdxValue) B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no ";
            $sql .= " GROUP BY A.appraisee_no )AA )";
            $sql .= " UNION ALL ";

            $sql .= " (SELECT CONCAT( 1 ,middle_model_index) AS ordr, IFNULL(CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/COUNT(sum_data_val),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")), '@')  AS content ";
            $sql .= " FROM ( SELECT DISTINCT groupIdx, itemIdx, itemIdxValue FROM DM_analysisDM_step04_middle_model ";
            $sql .= "        WHERE idx = ".$ridx." AND  appraisee_no = ".$appraisee_no." AND groupIdx = ".$kk." ) A ";
            $sql .= " INNER JOIN (SELECT * FROM DM_analysisDM_step04_middle_model WHERE idx = ".$ridx."  ) B ";
            $sql .= " ON A.groupIdx = B.groupIdx AND A.itemIdx = B.itemIdx AND A.itemIdxValue = B.itemIdxValue ";
            $sql .= " GROUP BY B.middle_model_index  ORDER BY B.middle_model_index) ";

            $sql .= " UNION ALL ";
            $sql .= " (SELECT CONCAT( 2, quiz_no ) AS ordr , IFNULL(CONCAT('@',FORMAT(ROUND(SUM(A.data_val)/SUM(IF(A.data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")), '@')  AS content FROM DM_analysisDM_step03 A ";
            $sql .= " INNER JOIN (SELECT A.idx, A.appraisee_no FROM DM_analysisDM_step04_appraisee_no A ";
            $sql .= "             INNER JOIN (SELECT idx, itemIdx, itemIdxValue FROM DM_analysisDM_step04_appraisee_no ";
            $sql .= "                          WHERE idx = ".$ridx." AND  appraisee_no = ".$appraisee_no." AND groupIdx = ".$kk." ) B  ";
            $sql .= " ON A.idx = B.idx AND A.itemIdx =B.itemIdx AND A.itemIdxValue = B.itemIdxValue) B ON A.idx = B.idx AND A.appraisee_no = B.appraisee_no  ";
            $sql .= " GROUP BY A.quiz_no  ) ";
            $sql .= " ORDER BY ordr ASC";

            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            $dumpData = array();
            $dumpData2 = array();
            $dumpData = $format;
            while ($row = mysqli_fetch_array($result)) {
                $dumpData[$row['ordr']] = preg_replace('/\r\n|\r|\n/','',$row['content']);
            }
            foreach ($step as $key) {
                array_push( $dumpData2, $dumpData[$key]);
            }
            array_push( $tableDataInbivi, $dumpData2);
        }

        // 2022-04-28 : 문항이 부족한 경우 구분자(@) 부족하여 오류 발생하여 구분자(@) 추가 ----- kky
        //for ($kk = $group_cnt ; $kk < 4 ; $kk++) {
        for ($kk = $group_cnt -1 ; $kk < 4 ; $kk++) {
            $dumpData2 = array();
            foreach ($step as $key) {
                array_push( $dumpData2, '@-');
            }
            array_push( $tableDataInbivi, $dumpData2);
        }

        $dumpData = array();
        foreach($tableDataInbivi as $key1 => $val1) {
            foreach($val1 as $key2 => $val2) {
                $dumpData[$key2][$key1] = $val2;
            }
        }
        foreach($dumpData as $key1 => $val1) {
            foreach($val1 as $key2 => $val2) {
                $rdata .= $val2;
            }
            $rdata .= $br;
        }
        $pageno = $pageno + sprintf('%d',$pagenoPlusr / 13);

        $filename = "mt_indivi_evalua";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);

    }

    $pageno++;
    /* 표지 : Part3 개인별 평가결과 */
    $rdata = "부록@평가결과표";

    $filename = "sub_title";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $sql = " SELECT DISTINCT groupIdx FROM DM_group ";
    $sql .= " WHERE idx = ".$ridx;
    $group_result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $group_cnt = mysqli_num_rows($group_result);

    //중분류
    $sql = " SELECT DISTINCT middle_model_index AS content FROM DM_middle_model ";
    $sql .= " WHERE idx = ".$ridx;
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $middle_model_list = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push( $middle_model_list, $row['content'] );
    }

    //타이틀
    $commonrdata = "";
    $sql = " SELECT CONCAT('@',selectedItemNM) AS content FROM DM_group ";
    $sql .= " WHERE idx = ".$ridx;
    $sql .= " ORDER BY groupIdx ";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while ($row = mysqli_fetch_array($result)) {
        $commonrdata .= $row['content'];
    }
    $commonrdata .= '@총점';

    $sql = "SELECT DISTINCT appraisee_no AS content FROM DM_analysisDM_step03";
    $sql .= " WHERE idx = ".$ridx." ORDER BY appraisee_no";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    $appraisee_no_list = array();
    while ($row = mysqli_fetch_array($result)) {
        array_push( $appraisee_no_list, $row['content'] );
    }
    $appraisee_no_count = 0;
    $tableData = array();
    $dumpData = array();
    $dumpData2 = array();

    foreach ($appraisee_no_list as $appraisee_no) {
        //$appraisee_no = $appraisee_no_list['appraisee_no'];//피평가자 번호
        // 2022-05-09 : 다면평가 구성원 파일 등록 (통합리포팅, 다면평가Adv) ----- kky
        $appraisee_name = ($member_list[$appraisee_no]['name'] != "") ? $member_list[$appraisee_no]['name'] : $appraisee_no;
        $appraisee_name = "@".$appraisee_name;

        $appraisee_no_count++ ;//피평가 순번수
        array_push( $dumpData, $appraisee_no_count);
        array_push( $dumpData2, $appraisee_name);
    }
    array_push( $tableData, $dumpData);
    array_push( $tableData, $dumpData2);

    while($group_list = mysqli_fetch_array($group_result)){
        $group_no = $group_list['groupIdx'];//피평가자 번호
        $dumpData = array();
        foreach ( $appraisee_no_list as $appraisee_no ){
            //$appraisee_no = $appraisee_no_list['appraisee_no'];//피평가자 번호

            $sql = "SELECT CONCAT('@',SUBSTRING_INDEX(SUBSTRING_INDEX(SUBSTRING_INDEX(A.quiz_value, '^', B.itemIdxValue  ), '^', -1), '|', -1))  AS content FROM wise_analysis_quiz A ";
            $sql .= " INNER  JOIN DM_analysisDM_step04_appraisee_no B ON B.idx = ".$ridx." AND B.appraisee_no = ".$appraisee_no." AND B.groupIdx = ".$group_no." AND B.itemIdx = A.quiz_no ";
            $sql .= " WHERE A.analysis_idx = ".$report_info['dataInIdx'];
            $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            while ($row = mysqli_fetch_array($result)) {
                $content = preg_replace('/\r\n|\r|\n/','',$row['content']);
                array_push( $dumpData, $content);
            }
        }
        array_push( $tableData, $dumpData);
    }

    $step = array();
    $format = array();
    $dumpData = array();
    $dumpData2 = array();
    foreach ( $appraisee_no_list as $appraisee_no ){
        $sql = "SELECT CONCAT('@',FORMAT(ROUND(SUM(sum_data_val)/SUM(IF(sum_data_val >0 , 1, 0)),".$report_option_info['scoreRound']." ),".$report_option_info['scoreRound'].")) AS content FROM DM_analysisDM_step03_middle_model ";
        $sql .= " WHERE idx = ".$ridx." AND appraisee_no = ".$appraisee_no;
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        while ($row = mysqli_fetch_array($result)) {
            $content = preg_replace('/\r\n|\r|\n/','',$row['content']);
            array_push( $dumpData, $content);
        }
        array_push( $step, $appraisee_no);
        $format[$appraisee_no] = '@-';
    }
    array_push( $tableData, $dumpData);

    foreach ( $middle_model_list as $middle_model_index ) {

        $pageno++;

        $tableDataMiddle = $tableData;
        $sql = " SELECT middle_model_name AS content FROM DM_middle_model ";
        $sql .= " WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $result = mysqli_fetch_array($result);
        $title_sub=$result['content'];
        $rdata = "평가결과표_".$title_sub;
        $rdata .= "@부록@".$pageno.$commonrdata;
        $rdata .= "@".$title_sub;

        $sql = " SELECT CONCAT('@', B.quiz_title ) AS content " ;
        $sql .= " FROM (SELECT distinct quiz_no FROM DM_analysisDM_step03 ";
        $sql .= "                               WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index." ) A ";
        $sql .= "       INNER JOIN (SELECT quiz_no, quiz_title FROM wise_analysis_quiz ";
        $sql .= "                               WHERE analysis_idx = ".$report_info['dataInIdx']." ) B ";
        $sql .= " ON A.quiz_no = B.quiz_no ";
        $sql .= " ORDER BY A.quiz_no ";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $quizNum = mysqli_num_rows($result);

        while ($row = mysqli_fetch_array($result)) {
            $rdata .= preg_replace('/\r\n|\r|\n/','',$row['content']);
        }

        for($ii = $group_cnt+$quizNum ; $ii < 14 ; $ii++){
            $rdata.= "@";
        }
        $rdata .= $br;

        $sql = "SELECT appraisee_no AS ordr, CONCAT('@',ROUND(sum_data_val,".$report_option_info['scoreRound']."))  AS content FROM DM_analysisDM_step03_middle_model ";
        $sql .= "       WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        $dumpData = array();
        $dumpData2 = array();
        $dumpData = $format;
        while ($row = mysqli_fetch_array($result)) {
            $dumpData[$row['ordr']] = $row['content'];
        }
        foreach ($step as $key) {
            array_push( $dumpData2, $dumpData[$key]);
        }
        array_push( $tableDataMiddle, $dumpData2);

        $sql = " SELECT distinct quiz_no AS content FROM DM_analysisDM_step03 ";
        $sql .= "       WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index;
        $sql .= "       ORDER BY quiz_no ASC";
        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        while ($row = mysqli_fetch_array($result)) {
            $quiz_no = $row['content'];
            $sql = "SELECT appraisee_no AS ordr, CONCAT('@',ROUND(data_val,".$report_option_info['scoreRound']."))  AS content FROM DM_analysisDM_step03 ";
            $sql .= "       WHERE idx = ".$ridx." AND middle_model_index = ".$middle_model_index." AND quiz_no = ".$quiz_no;

            $result2 = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
            $dumpData = array();
            $dumpData2 = array();
            $dumpData = $format;
            while ($row2 = mysqli_fetch_array($result2)) {
                $dumpData[$row2['ordr']] = $row2['content'];
            }
            foreach ($step as $key) {
                array_push( $dumpData2, $dumpData[$key]);
            }
            array_push( $tableDataMiddle, $dumpData2);
        }

        for($ii = $group_cnt+$quizNum ; $ii < 14 ; $ii++){
            $dumpData2 = array();
            foreach ($step as $key) {
                array_push( $dumpData2, '@-');
            }
            array_push( $tableDataMiddle, $dumpData2);
        }

        $dumpData = array();
        foreach($tableDataMiddle as $key1 => $val1) {
            foreach($val1 as $key2 => $val2) {
                $dumpData[$key2][$key1] = $val2;
            }
        }

        foreach($dumpData as $key1 => $val1) {
            foreach($val1 as $key2 => $val2) {
                // 2022-05-12 : 값이 없을 경우 추가 ----- kky
                if($val2 == "") $val2 = "@-";
                $rdata .= $val2;
            }
            $rdata .= $br;
        }

        $pageno = $pageno + sprintf('%d',$appraisee_no_count / 29);

        $filename = "mt_supple";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);

    }
}
?>