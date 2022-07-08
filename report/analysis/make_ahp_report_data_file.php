<?php
include "../../inc/common.php";
include "../../inc/db_conn_datain.php";

$mrd_type_path = "hr/ahp";
$mrd_common_path = "hr/common";

$level_max = 3; // 최대 4단계까지 설정가능

$sql = "SELECT o.*, a.analysis_title, DATE_FORMAT(a.wdate, '%Y.%m.%d') AS wdate, a.data_cnt FROM wise_analysis_report_decision_option AS o, wise_analysis_main AS a WHERE o.idx='$ridx' AND o.analysis_report_idx = a.idx";
$result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
$report_info = mysqli_fetch_array($result);

if($report_info['idx'] != "") {

    $memid = $report_info['memid'];
    $subid = $report_info['subid'];
    
    $upfile_path = "../report/".$report_info['memid']."/".$ridx;
    if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

    $pageno = 1;

    /* 표지 */
    $rdata = "@@2@@@@".$br.$report_info['analysis_report_option_title']."@AHP 분석 보고서@".$report_info['wdate']."@".$pageno."@";

    $filename = "title";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 표지 : Part1 조사개요 */
    $rdata = "1. 조사 배경 및 필요성@2. 조사 절차@3. 조사 설계@4. 표본 특성@5. 평가 모델";
    $rdata = "Part1@조사 개요".$br;
    $rdata .= "1. 조사 배경 및 필요성".$br;
    $rdata .= "2. 조사 절차".$br;
    $rdata .= "3. 조사 설계".$br;
    $rdata .= "4. 표본 특성".$br;
    $rdata .= "5. 평가 모델";

    $filename = "index";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 조사개요 : 1. 조사 배경 및 필요성 */
    $rdata = "1.조사 배경 및 필요성@Part1. 조사개요@".$pageno."@@@@".$br;
    $rdata .= "기존 우선순위 선정의 비체계적인 문제점@체계적으로 평가하여 우선순위를 도출하는 의사결정방법 필요@AHP는 복잡한 대안을 단계적/계층적으로 평가하는 체계적인 방법@수리분석에 기반하여 합의된 대안 및 가중치의 결정@기업의 성격 및 요구 상황을 감안할 때, 평가기반 혁신 활동 전개는 필수불가결하며, 이러한 활동이 제대로 이루어지고 있는지 확인하고, 개선 방향을 도출하여 서비스 품질을 향상시키기 위해서는 정기적인 조직 내외부의 평가 기반 조사가 이루어져야 함";
    
    $filename = "survey_backgro";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 조사개요 : 2.조사 절차 */
    $rdata = "2.조사 절차@Part1.조사개요@".$pageno."@@‘고객만족도 조사 모델’ 을 기반으로, 실사진행, 자료검증, 에디팅, 데이터 입력 및 처리, 전산처리 등의 과정을 거쳐 최종 결과물이 제출됨@@".$br;
    $rdata .= "- AHP 평가 기반 모델 개발@- 연구 및 조사성격에 따른 조사대상 확정 및 표본 설계@- 구조화된 쌍대비교 설문지 이용@- 수집 자료에 대한 신뢰성 확보 위해 검증 실시@- 에디팅/코딩된 자료의 전산입력 및 전산처리@- 기업 전사 통합 보고서 작성@- 분석결과를 바탕으로 통계 솔루션에 의한 종합지수 산출 및 AHP 분석 보고서 작성".$br;
    $rdata .= "@- 설문지 작성@- 조사방법 진행@- 검증보고서 작성@- 기초결과표 및 지수 산출 위한 가중분석 실시@@@";

    $filename = "survey_proced";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 조사개요 : 3.조사 설계 */
    $rdata = "3.조사 설계@Part1.조사개요@".$pageno."@조사설계@@@".$br;
    $rdata .= $report_info['analysis_report_decision_option_sampling']."@";
    $rdata .= $report_info['analysis_report_decision_option_population']."@";
    $rdata .= $report_info['analysis_report_decision_option_samplingmethod']."@";
    $rdata .= "총 ".$report_info['data_cnt']." Samples@";
    $rdata .= $report_info['analysis_report_decision_option_surveymethod']."@";
    $rdata .= $report_info['analysis_report_decision_option_data'];
    
    $filename = "survey_design";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    $pageno++;
    /* 조사개요 : 4.표본 특성 */
    $rdata = "4.표본 특성@Part1.조사개요@".$pageno."@@@@@구분@표본수(N)@비율(%)".$br;
    // 문항정보
    unset($quiz_list);
    $sql = "SELECT q.quiz_no, q.quiz_title, q.quiz_value FROM wise_analysis_report_decision_option_group AS g, wise_analysis_quiz AS q
    WHERE g.decision_option_idx = '".$ridx."' AND q.analysis_idx = '".$report_info['analysis_report_idx']."' AND g.analysis_report_decision_option_group_no = q.idx";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while($row = mysqli_fetch_array($result)) {
        $quiz_list[$row['quiz_no']]['name'] = $row['quiz_title'];
        $quiz_val_list = explode("^", $row['quiz_value']);
        if(is_array($quiz_val_list)) {
            foreach($quiz_val_list as $ii => $quiz_val) {
                list($quiz_val_no, $quiz_val_name) = explode("|", $quiz_val);
                $quiz_list[$row['quiz_no']]['sub'][$quiz_val_no] = $quiz_val_name;
            }
        }
    }
    // 응답자데이터
    unset($data_list); unset($data_total);
    $sql = "SELECT g.analysis_report_decision_option_group_title, d.quiz_no, d.data_val, COUNT(d.idx) AS cnt FROM wise_analysis_report_decision_option_group AS g, wise_analysis_quiz AS q, wise_analysis_data AS d
    WHERE g.decision_option_idx = '".$ridx."' AND q.analysis_idx = '".$report_info['analysis_report_idx']."' AND d.analysis_idx = '".$report_info['analysis_report_idx']."' AND g.analysis_report_decision_option_group_no = q.idx AND q.quiz_no = d.quiz_no
    GROUP BY d.quiz_no, d.data_val
    ORDER BY d.quiz_no ASC, d.data_val ASC";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while($row = mysqli_fetch_array($result)) {
        $data_list[$row['quiz_no']][$row['data_val']] = $row['cnt'];
        $data_total += $row['cnt'];

        // 문항 보기가 정의되지 않은 경우
        if($quiz_list[$row['quiz_no']]['sub'][$row['data_val']] == "") $quiz_list[$row['quiz_no']]['sub'][$row['data_val']] =  $row['data_val'];
    }
    $point = $report_info['analysis_report_decision_option_scorepoint2'];	// 소수첨 출력 자리수

    $data_total = ($data_total > 0 && count($data_list) > 0) ? $data_total/count($data_list) : 0;

    $rdata .= "전체@전체@".$data_total."@".set_decimal_point(100, $point).$br;
    if(is_array($quiz_list)) {
        foreach($quiz_list as $quiz_no => $quiz_info) {
            if(is_array($quiz_info['sub'])) {
                foreach($quiz_info['sub'] as $val_no => $val_name) {
                    if($val_name != "") {
                        $data_cnt = $data_list[$quiz_no][$val_no];
                        $data_per = ($data_cnt > 0 && $data_total > 0) ? ($data_cnt/$data_total) * 100 : 0;
                        $data_per = set_decimal_point($data_per, $point);
                        $rdata .= trim($quiz_info['name'])."@".trim($val_name)."@".$data_cnt."@".$data_per.$br;
                    }
                }
            }
        }
    }
    
    $filename = "sample_charac";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    /* 평가모델 */
    $pageno++;
    $rdata = "5. 평가모델@Part1. 조사개요@".$pageno."@@@@";
    
    $filename = "ahp_evalua_model";
    $report_file = $mrd_type_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    /* 분석 결과 */
    $pageno++;
    $rdata = "part2@분석 결과".$br;
    $rdata .= "1. 일관성 지수 결과".$br;
    $rdata .= "2. AHP 분석결과".$br;
    $rdata .= "2.1 단계별 결과".$br;
    $rdata .= "2.2 통합 결과".$br;
    
    $filename = "index";
    $report_file = $mrd_common_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

    /* 분석 결과 */
    $pageno++;

    // 개인별 계산방식
    switch($report_info['analysis_report_decision_option_calpath']) {
        case "1" : // eigen(고유치)
            $data_table = "wise_analysis_report_decision_100data_detail";
            break;
        case "2" : // mean(평균)
            $data_table = "wise_analysis_report_decision_100data_detail2";
            break;
        case "3" : // geom mean(기하평균)
            $data_table = "wise_analysis_report_decision_100data_detail3";
            break;
        default :
            $data_table = "wise_analysis_report_decision_100data_detail";	// 옵션값이 없을 경우 임의로 지정
            break;
    }

    $_tmp_data_no = "";
    $_tmp_quiz_list = array();
    $_tmp_title_list = array();
    $_tmp_rdata = array();
    $_tmp_data_yn = array();

    $sql = "SELECT *
            FROM ".$data_table."
            WHERE decision_option_idx = '".$ridx."' AND analysis_report_decision_100data_quiz_title LIKE '%_CI'
            GROUP BY analysis_report_decision_100data_no, analysis_report_decision_100data_quiz_title
            ORDER BY analysis_report_decision_100data_no ASC, idx ASC";
    //$cnt_tmp_data_no = count($_tmp_data_no);
    $cnt_tmp_data_no = 0;
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while($row = mysqli_fetch_array($result)) {
        if($_tmp_data_no != $row['analysis_report_decision_100data_no']) {
            $_tmp_rdata[$row['analysis_report_decision_100data_no']] .= $row['analysis_report_decision_100data_no'];
            $cnt_tmp_data_no++;
        }
        $_tmp_quiz_val = ($row['analysis_report_decision_100data_quiz_val'] == "" || $row['analysis_report_decision_100data_quiz_val'] == "NAN") ? "NAN" : set_decimal_point($row['analysis_report_decision_100data_quiz_val'], $report_info['analysis_report_decision_option_scorepoint']);
        $_tmp_rdata[$row['analysis_report_decision_100data_no']] .= "@".$_tmp_quiz_val;

        $_tmp_data_no = $row['analysis_report_decision_100data_no'];

        // 분석모델 문항리스트
        if(!in_array($row['analysis_report_decision_100data_quiz_title'], $_tmp_quiz_list)) $_tmp_quiz_list[] = $row['analysis_report_decision_100data_quiz_title'];
    }

    // 표의 최대 항목보다 문항이 많은 경우 다음페이지로 넘겨서 출력
    $table_max_cnt = 7;
    $quizpage_cnt = ceil(count($_tmp_quiz_list)/$table_max_cnt);

    for($ii = 0; $ii < $quizpage_cnt; $ii++) {
        $pagename = "1.일관성 지수 결과";
        // 페이지가 넘어가면 제목부분에 _(숫자) 추가
        if($quizpage_cnt > 1) {
            $pagename = $pagename."_".($ii+1);
        }

        $rdata = $pagename."@Part2.분석결과@".$pageno."@@";
        if($report_info['analysis_report_decision_option_case'] == "Y") {	// 일관성지수 "적용"
            $rdata .= "● 본 분석에서는 일관성 지수 ".$report_info['analysis_report_decision_option_case_no']." 미만의 응답만을 분석대상으로 삼았음";
        } else {																													// 일관성지수 "적용안함"
            $rdata .= "● 본 분석에서는 모든 응답을 분석대상으로 삼았음";
        }
        $rdata .= "@● 아래는 각 응답자들의 일관성을 계산한 결과임";
        $rdata .= "@ID";

        $rdata_ex = "@All_CI";
        $rdata_ex_y = "@Y";
        $rdata_ex_g = "";

        $sql = "SELECT DISTINCT q.decision_option_model_quiz_level AS quiz_level,
                                q.decision_option_model_quiz_parent AS quiz_parent,
                                v.parent_quiz_title,
                                v.view_title,
                                d.analysis_report_decision_100data_quiz_val
                FROM wise_analysis_report_decision_100data_detail_total AS d
                LEFT JOIN
                wise_analysis_report_decision_option_model_quiz AS q
                ON q.decision_option_idx = d.decision_option_idx AND q.view_title = d.analysis_report_decision_100data_quiz_title
                INNER JOIN
                (SELECT analysis_report_decision_option_model_quiz_no AS parent_quiz_no,
                    analysis_report_decision_option_model_quiz_title AS parent_quiz_title,
                    view_title
                FROM wise_analysis_report_decision_option_model_quiz
                WHERE decision_option_idx = '".$ridx."' ) AS v
                ON q.decision_option_model_quiz_parent = v.parent_quiz_no
                WHERE d.decision_option_idx = '".$ridx."' AND d.analysis_report_decision_100data_model_no = '2' AND q.decision_option_model_quiz_level != ''
                ORDER BY q.decision_option_model_quiz_parent ASC, d.analysis_report_decision_100data_quiz_val DESC";

        $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
        while($row = mysqli_fetch_array($result)){
            if(is_array($_tmp_title_list)) {
                if(!in_array($row['view_title'], $_tmp_title_list)) $_tmp_title_list[] = $row['view_title'];
            } else {
                $_tmp_title_list[] = $row['view_title'];
            }
        }

        for($jj = ($ii * $table_max_cnt); $jj < ($ii * $table_max_cnt) + $table_max_cnt -1; $jj++) {
            $rdata_ex .= (trim($_tmp_quiz_list[$jj]) != "") ? "@".$_tmp_title_list[$jj] : "@";
        }
        //print_r($_tmp_title_list);

        for($jj = ($ii * $table_max_cnt); $jj < ($ii * $table_max_cnt) + $table_max_cnt; $jj++) {
            $rdata_ex_y .= (trim($_tmp_quiz_list[$jj]) != "") ? "@Y" : "@N";
            $rdata_ex_g .= (trim($_tmp_quiz_list[$jj]) != "") ? "" : "@";
        }
        $rdata .= $rdata_ex.$rdata_ex_y;
        $rdata .= $br;

        if(is_array($_tmp_rdata)) $rdata .= implode($rdata_ex_g.$br, $_tmp_rdata);
        $rdata .= $rdata_ex_g;

        $filename = "ahp_consis_Indica";
        $report_file = $mrd_type_path."/".$filename.".mrd";
        $data_file = $filename."_".$pageno.".txt";
        make_data_file($data_file, $report_file, $pageno, $rdata);

        // 데이터 row 24개 넘어가면 페이지 수 ++
        if($cnt_tmp_data_no>24){
            $pageno += ceil($cnt_tmp_data_no/24);
        }else{$pageno++;}
    }

    // 단계별 문항 가져오기
    /* 퀴즈 depth 값 가져오기
    -- decision_option_model_quiz_level : 퀴즈 depth
    -- decision_option_model_quiz_group : 퀴즈 그룹
    */
    unset($quiz_dep_list); unset($quiz_dep_title_list); unset($quiz_dep_quizno_list); unset($quiz_dep_parent);
    $sql = "SELECT * FROM wise_analysis_report_decision_option_model_quiz WHERE decision_option_idx = '$ridx' AND view_yn != 'none' ORDER BY decision_option_model_quiz_level ASC, decision_option_model_quiz_group ASC, idx ASC";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while($row = mysqli_fetch_array($result)) {
        $quizno = $row['analysis_report_decision_option_model_quiz_no'];
        /*
        $quizkey = $row['view_title'];	// 하단 분석 데이터에서 quizno 값이 아닌 title 로 저장되어 있음
        $quiz_dep_list[$row['decision_option_model_quiz_level']][$quizkey]['quizno'] = $quizno;																		// 문항 고유값
        $quiz_dep_list[$row['decision_option_model_quiz_level']][$quizkey]['parent'] = $row['decision_option_model_quiz_parent'];	// 부모문항 고유값
        $quiz_dep_list[$row['decision_option_model_quiz_level']][$quizkey]['title'] = $row['view_title'];													// 문항명
        */
        $quiz_dep_quizno_list[$quizno] = $row['view_title'];
        $quiz_dep_title_list[$row['decision_option_model_quiz_level']][] = $row['view_title'];
        /*
        if($quiz_dep_parent != $row['decision_option_model_quiz_parent']) {
            $quiz_dep_total_title_list[$row['decision_option_model_quiz_level']][] = $row['view_title']."_CI";	// 첫번째 문항이름_CI 로 합계 계산결과가 저장되어있기 때문에 첫번째 항목이름_CI 를 추가함
        }
        */
        $quiz_dep_parent = $row['decision_option_model_quiz_parent'];
    }

    // analysis_report_decision_option_calpath2 : 1(산술평균), 2(기하평균)
    switch($report_info['analysis_report_decision_option_calpath2']) {
        case "1" : $quizlvl_val_name = "analysis_report_decision_100data_quiz_val"; break;
        case "2" : $quizlvl_val_name = "analysis_report_decision_100data_quiz_val2"; break;
        default : $quizlvl_val_name = "analysis_report_decision_100data_quiz_val"; break;
    }
    $rdata_list = "";	// 표 데이터
    $rdata_word = "";	// 해석

    $quizlvl_rank = 1;	// 순위
    $quizlvl_no = 1;		// 해당 단계의 문항번호 +1

    unset($quizlvl_data_list);	// 문항정보
    unset($total_data_list);		// CI 계산결과값
    unset($total_value_list);		// 단계별 계산결과값 곱한값
    unset($quizlvl_word_data_list); // 단계별 결과 설명 부분

    $rank_list = array();	// 2022-05-27 : 단계별 순위 ----- kky

    $sql = "SELECT d.*, q.decision_option_model_quiz_level AS quiz_level, q.decision_option_model_quiz_group AS quiz_group, q.decision_option_model_quiz_parent AS quiz_parent, q.analysis_report_decision_option_model_quiz_no AS quiz_no
            FROM wise_analysis_report_decision_100data_detail_total AS d LEFT JOIN wise_analysis_report_decision_option_model_quiz AS q ON q.decision_option_idx = d.decision_option_idx AND q.view_title = d.analysis_report_decision_100data_quiz_title
            WHERE d.decision_option_idx = '".$ridx."' AND d.analysis_report_decision_100data_model_no = '".$report_info['analysis_report_decision_option_calpath']."'
            ORDER BY q.decision_option_model_quiz_parent ASC, d.$quizlvl_val_name DESC";
    $result = mysqli_query($gconnet, $sql) or die(mysqli_error($gconnet));
    while($row = mysqli_fetch_array($result)) {
        if($row['quiz_no'] == "") {	// _CI 또는 문항명을 제대로 가져오지 못한 데이터(ex:대소문자 구분되어 A_B, A_C, b_C 인 경우 A, B, b 로 저장되어있음)는 quiz_no 조인되지 않음
            $quiz_title_list = explode("_", $row['analysis_report_decision_100data_quiz_title']);
            if($quiz_title_list[1] == "CI") {	// _CI 로 끝나는 계산결과값인 경우
                $total_data_list[$quiz_title_list[0]] = $row[$quizlvl_val_name];
            }
        } else {

            $quiz_quizno = $row['quiz_no'];	// 문항명
            $quiz_title = $row['analysis_report_decision_100data_quiz_title'];	// 문항명
            $quiz_value = $row[$quizlvl_val_name];															// 결과값
            $quiz_level = $row['quiz_level'];																		// 단계

            $parent_quizno = $row['quiz_parent'];																// 부모문항번호
            $parent_title = $quiz_dep_quizno_list[$row['quiz_parent']];					// 부모문항명
            $parent_level = $quizlvl - 1;																				// 부모문항단계

            if($quizlvl_no == 0 || $tmp_value > $quiz_value) $quizlvl_rank = $quizlvl_no;	// 순위지정

            if($tmp_parent != $parent_quizno) {	// 부모문항에 따라 순위가 지정되기 때문에 부모문항이 바뀐 경우 순위, 문항번호 초기화
                $quizlvl_rank = 1;
                $quizlvl_no = 1;
            }
            $quiz_word = $quiz_title." ".$quiz_value.",";

            $quizlvl_data_list[$quiz_title]['quizno'] = $quiz_quizno;
            $quizlvl_data_list[$quiz_title]['title'] = $quiz_title;
            $quizlvl_data_list[$quiz_title]['value'] = $quiz_value;
            $quizlvl_data_list[$quiz_title]['rank'] = $quizlvl_rank;
            $quizlvl_data_list[$quiz_title]['level'] = $quiz_level;	// 단계
            $quizlvl_data_list[$quiz_title]['word'] = $quiz_word;		// 해석

            // 단계별 값 곱한 값
            $total_value = $quiz_value;

            if($row['quiz_level'] > 1) {
                for ($ii = $quiz_level - 1; $ii > $quiz_level - 2; $ii--) {
                    $quizlvl_word_data_list[$parent_title][$quiz_title] = " ".$quiz_title." ".$quiz_value;
                }
            } else {
                $quizlvl_word_data_list[''][$quiz_title] = " ".$quiz_title." ".$quiz_value;
            }


            // 부모항목 정보
            if($row['quiz_level'] > 1) {
                $parent_title = $quiz_dep_quizno_list[$parent_quizno];
                for($ii = $quiz_level - 1; $ii > 0; $ii--) {

                    $parent_row = $quizlvl_data_list[$parent_title];

                    $quizlvl_data_list[$quiz_title]['parent_list'][$ii]['title'] = $parent_row['title'];
                    $quizlvl_data_list[$quiz_title]['parent_list'][$ii]['value'] = $parent_row['value'];
                    $quizlvl_data_list[$quiz_title]['parent_list'][$ii]['level'] = $parent_row['level'];	// 부모level
                    $quizlvl_data_list[$quiz_title]['parent_list'][$ii]['quizno'] = $parent_row['quizno'];				// 부모quiz_no

                    //$quizlvl_word_data_list[$parent_title][$quiz_title] = " ".$quiz_title." ".$quiz_value;

                    $parent_title = $parent_row['parent_list'][$ii-1]['title'];

                    $total_value *= $parent_row['value'];
                }
            }
        }
        $quizlvl_data_list[$quiz_title]['total_value'] = set_decimal_point($total_value,3);	// 전체 결과값
        $total_value_list[$row['quiz_level']][$quiz_title] = $total_value;

        $rank_list_chk = false;
        if($row['quiz_level'] == 1) {
            $rank_array = $rank_list[$row['quiz_level']]['title'];
        } else {
            $rank_array = $rank_list[$row['quiz_level']][$row['quiz_parent']]['title'];
        }

        if(!is_array($rank_array)) {
            $rank_list_chk = true;
        } else {
            if(!in_array($quiz_title, $rank_array)) {
                $rank_list_chk = true;
            }
        }

        if($rank_list_chk == true) {
            if($row['quiz_level'] == 1) {
                $rank_list[$row['quiz_level']]['title'][] = $quiz_title;
                $rank_list[$row['quiz_level']]['total_value'][] = $quizlvl_data_list[$quiz_title]['total_value'];
            } else {
                $rank_list[$row['quiz_level']][$row['quiz_parent']]['title'][] = $quiz_title;
                $rank_list[$row['quiz_level']][$row['quiz_parent']]['total_value'][] = $quizlvl_data_list[$quiz_title]['total_value'];
            }
        }

        $tmp_value = $quiz_value;
        $tmp_level = $quiz_level;
        $tmp_parent = $parent_quizno;

        $quizlvl_no++;
    }

    if(is_array($quiz_dep_title_list)) {
        foreach($quiz_dep_title_list as $quizlvl => $quiz_dep_row) {
            // 해당 단계에 보여줘야할 문항인 경우 출력
            if(is_array($quiz_dep_row)) {
                unset($word_list); unset($word_txt); unset($tmp_parent);
                foreach($quiz_dep_row as $ii => $quiz_title) {
                    $quiz_row = $quizlvl_data_list[$quiz_title];

                    $parent_title = $quiz_row['parent_list'][$quizlvl-1]['title'];

                    if($quiz_row['level'] == 1) {
                        if(count($quizlvl_word_data_list['']) > 5){
                            $word_txt = "1단계 중요도 상위 5개는".implode(",", array_slice($quizlvl_word_data_list[''],0,5))." 순으로 나타남. ";
                        } else{
                            $word_txt = "1단계 중요도는".implode(",", $quizlvl_word_data_list[''])." 순으로 나타남. ";
                        }
                    } else {
                        if(count($quizlvl_word_data_list[$parent_title])>5){
                            if($tmp_parent != $parent_title)
                                $word_txt .= $parent_title." 내에서 상위 5개는".implode(",", array_slice($quizlvl_word_data_list[$parent_title],0,5))." 순으로 나타남. <br>";
                        } else{
                            if($tmp_parent != $parent_title)
                                $word_txt .= $parent_title." 내에서".implode(",", $quizlvl_word_data_list[$parent_title])." 순으로 나타남. <br>";
                        }
                    }
                    $tmp_parent = $parent_title;
                }

                $rdata = "2.AHP 분석결과@Part2.분석결과@".$pageno."@2-1. 단계별 결과@".$word_txt;

                $rdata_ex = ""; $rdata_ex_y = "";
                $rdata_ex .= ($quizlvl >= 1) ? "@1단계" : "@"; $rdata_ex_y .= ($quizlvl >= 1) ? "Y" : "N";
                $rdata_ex .= ($quizlvl >= 2) ? "@2단계" : "@"; $rdata_ex_y .= ($quizlvl >= 2) ? "@Y" : "@N";
                $rdata_ex .= ($quizlvl >= 3) ? "@3단계" : "@"; $rdata_ex_y .= ($quizlvl >= 3) ? "@Y" : "@N";
                $rdata_ex .= ($quizlvl == 4) ? "@4단계" : "@"; $rdata_ex_y .= ($quizlvl == 4) ? "@Y" : "@N";
                $rdata_ex .= "@중요도@순위";
                $rdata_ex_y .= "@Y@Y";
                $rdata .= $rdata_ex."@".$rdata_ex_y.$br;

                $rdata_list = "";
                if(is_array($quiz_dep_title_list[$quizlvl])) {
                    foreach($quiz_dep_title_list[$quizlvl] as $quiz_dep_ii => $quiz_dep_title) {

                        // 2022-05-27 : 단계별 순위 ----- kky
                        if($quizlvl == 1) {
                            $rank_array = $rank_list[$quizlvl];
                        } else {
                            $rank_array = $rank_list[$quizlvl][$quizlvl_data_list[$quiz_dep_title]['parent_list'][$quizlvl-1]['quizno']];
                        }

                        if(is_array($rank_array['total_value'])) {
                            array_multisort($rank_array['total_value'], SORT_DESC, SORT_NUMERIC, $rank_array['title']);
                        }

                        //$rank = $quizlvl_data_list[$quiz_dep_title]['rank'];
                        $rank = 1;
                        if(is_array($rank_array['title'])) {
                            $rank = array_search($quiz_dep_title, $rank_array['title']) + 1;
                        }

                        if($quizlvl == 1) $rdata_list .= $quiz_dep_title."@@@@";
                        if($quizlvl == 2) $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quiz_dep_title."@@@";
                        if($quizlvl == 3) $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['title']."@".$quiz_dep_title."@@";
                        if($quizlvl == 4) $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][3]['title']."@".$quiz_dep_title."@";
                        $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['value']."@".$rank.$br;
                    }
                }
                $rdata .= $rdata_list;

                $filename = "ahp_result_step";
                $report_file = $mrd_type_path."/".$filename.".mrd";
                $data_file = $filename."_".$pageno.".txt";
                make_data_file($data_file, $report_file, $pageno, $rdata);

                $pageno++;
            }
        }
    }

    $rdata = "2.AHP 분석결과@Part2.분석결과@".$pageno."@2-2. 통합 결과@";

    $rdata_word = "통합분석 결과, ";

    // 전체 결과값 순위별 정렬
    if(is_array($total_value_list)) {
        $total_max_level = max(array_keys($total_value_list));
        $total_value_rank = 1;
        $total_value_no = 1;
        if(is_array($total_value_list[$total_max_level])) {
            arsort($total_value_list[$total_max_level]);
            foreach($total_value_list[$total_max_level] as $total_value_title => $total_value) {
                if($total_value_no == 0 || $tmp_value > $total_value) $total_value_rank = $total_value_no;	// 순위지정
                $quizlvl_data_list[$total_value_title]['total_rank'] = $total_value_rank;	// 전체 결과값 순위
                $tmp_value = $total_value;
                $total_value_no++;
                if($total_value_rank < 6){
                    $total_word .= " ".$quizlvl_data_list[$total_value_title]['title']." ".$quizlvl_data_list[$total_value_title]['total_value'].",";
                }
            }
            if($total_value_rank > 5){
                $rdata_word .= "상위 5개는";
            }
        }
    }

    $rdata_word .= substr($total_word,0,-1);
    $rdata_word .= " 순으로 나타남.";
    $rdata .= $rdata_word;
    $rdata_ex = ""; $rdata_ex_y = "";
    $rdata_ex .= ($quizlvl >= 1) ? "@Ⅰ단계@중요도" : "@@"; $rdata_ex_y .= ($quizlvl >= 1) ? "Y@Y" : "N@N";
    $rdata_ex .= ($quizlvl >= 2) ? "@Ⅱ단계@중요도" : "@@"; $rdata_ex_y .= ($quizlvl >= 2) ? "@Y@Y" : "@N@N";
    $rdata_ex .= ($quizlvl >= 3) ? "@Ⅲ단계@중요도" : "@@"; $rdata_ex_y .= ($quizlvl >= 3) ? "@Y@Y" : "@N@N";
    $rdata_ex .= ($quizlvl == 4) ? "@Ⅳ단계@중요도" : "@@"; $rdata_ex_y .= ($quizlvl == 4) ? "@Y@Y" : "@N@N";
    $rdata_ex .= "@통합중요도"; $rdata_ex_y .= "@Y";
    $rdata_ex .= "@순위"; $rdata_ex_y .= "@Y";

    $rdata .= $rdata_ex."@".$rdata_ex_y.$br;

    //@Ⅰ단계@중요도@Ⅱ단계@중요도@Ⅲ단계@중요도@추가단계@중요도@통합중요도@순위
    $rdata_list = "";
    if(is_array($quiz_dep_title_list[$quizlvl])) {
        foreach($quiz_dep_title_list[$quizlvl] as $quiz_dep_ii => $quiz_dep_title) {
            if($quizlvl == 1) {
                $rdata_list .= $quiz_dep_title."@".$quizlvl_data_list[$quiz_dep_title]['value']."@@@@@@@";
            }
            if($quizlvl == 2) {
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['value']."@";
                $rdata_list .= $quiz_dep_title."@".$quizlvl_data_list[$quiz_dep_title]['value']."@@@@@";
            }
            if($quizlvl == 3) {
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['value']."@";
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['value']."@";
                $rdata_list .= $quiz_dep_title."@".$quizlvl_data_list[$quiz_dep_title]['value']."@@@";
            }
            if($quizlvl == 4) {
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][1]['value']."@";
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][2]['value']."@";
                $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['parent_list'][3]['title']."@".$quizlvl_data_list[$quiz_dep_title]['parent_list'][3]['value']."@";
                $rdata_list .= $quiz_dep_title."@".$quizlvl_data_list[$quiz_dep_title]['value']."@";
            }
            $rdata_list .= $quizlvl_data_list[$quiz_dep_title]['total_value']."@".$quizlvl_data_list[$quiz_dep_title]['total_rank'].$br;
            //$rdata_list .= $quizlvl_data_list[$quiz_dep_title]['total_rank'].$br;
        }
    }
    $rdata .= $rdata_list;

    $filename = "ahp_result_total";
    $report_file = $mrd_type_path."/".$filename.".mrd";
    $data_file = $filename."_".$pageno.".txt";
    make_data_file($data_file, $report_file, $pageno, $rdata);

}
?>