<?php
include_once "../inc/common.php";

$mode = $_REQUEST['mode'];

$dataInIdx = $project;

if($mode == "insert") { // 분석모델 생성하기 

    $permit_info = get_payment_permit($memid);

    if($permit_info['report_project'] == "Y") {

    } else if($permit_info['report_project'] == "N" || $permit_info['report_project'] == "") {
        echo "ERR|새 프로젝트를 등록할 권한이 없습니다.";
        exit;
    } else {

        $sql = "SELECT COUNT(idx) AS cnt FROM analysis_report WHERE memid = '$memid'";
        $result = mysqli_query($gconnet, $sql);
        $row = mysqli_fetch_array($result);
        $project_cnt = $row['cnt'];        

        if($permit_info['report_project'] <= $project_cnt) {
            echo "ERR|프로젝트는 최대 ".$permit_info['report_project']."건 등록이 가능합니다.";
            exit;
        }
    }

    //$변수명 = $_REQUEST['변수명'];
    switch($analysis_type) {
        case "multi" : $analysis_type = "DM"; break;
        case "ahp" : $analysis_type = "AH"; break;
        case "satisfaction" : $analysis_type = "MM"; break;
    }
    
    if($copy == "Y") {

        $sql = "SELECT * FROM analysis_report WHERE idx = '$copyidx'";
        $result = mysqli_query($gconnet, $sql);
        $row = mysqli_fetch_array($result);

        $dataInIdx = $row['dataInIdx'];
        $memid = $row['memid'];
        $subid = $row['subid'];
        $analysis_title = $row['analysis_title'];
        $analysis_type = $row['analysis_type'];

    }

    if($analysis_title == "") {
        echo "ERR|보고서명을 입력하세요.";
        exit;
    }
    if($analysis_type == "") {
        echo "ERR|보고서 형식을 선택하세요.";
        exit;
    }
    if($dataInIdx == "") {
        echo "ERR|프로젝트를 선택하세요.";
        exit;
    }

    //analysis_report 테이블 INSERT QUERY
    $sql = "INSERT INTO analysis_report(dataInIdx, memid, subid, analysis_title, analysis_type, stCode, reg_date)
            VALUES ('$dataInIdx', '$memid', '$subid', '$analysis_title', '$analysis_type', 'EE',  now())";
    $result = mysqli_query($gconnet, $sql) or error('error:'.$sql);

    //analysis_report idx 값 구하기
    $report_idx = mysqli_insert_id($gconnet);

    //중간에 오류가 나는 경우 
    //echo "ERR|오류메세지";

    // 의사결정모델(AHP)인 경우 BN 테이블 INSERT 
    if($analysis_type == "AH") {
        $sql = "INSERT INTO wise_analysis_report_decision_option 
                    (idx,decision_option_status,memid,subid,analysis_report_idx,analysis_report_option_idx,analysis_report_option_title,analysis_report_decision_option_name,wdate)
                VALUES 
                    ('$report_idx','tmp','$memid','$subid','$dataInIdx','1','$analysis_title','$analysis_title',now())";
        mysqli_query($gconnet, $sql);     
        
        // 의사결정 복사 시 분석모델설정 추가 
        if($copy == "Y") {
            unset($model_list);
            $cp_sql = "SELECT * FROM wise_analysis_report_decision_option_model WHERE decision_option_idx='$copyidx'";
            $cp_result = mysqli_query($gconnet, $cp_sql);
            while($cp_row = mysqli_fetch_array($cp_result)) {
                $in_sql = "INSERT INTO wise_analysis_report_decision_option_model (decision_option_idx,analysis_report_decision_option_model_title,wdate) VALUES ('$report_idx','".$cp_row['analysis_report_decision_option_model_title']."',now())";
                mysqli_query($gconnet, $in_sql);

                $model_list[$cp_row['idx']] = mysqli_insert_id($gconnet);
            }

            $cp_sql = "SELECT * FROM wise_analysis_report_decision_option_model_quiz WHERE decision_option_idx='$copyidx'";
            $cp_result = mysqli_query($gconnet, $cp_sql);
            while($cp_row = mysqli_fetch_array($cp_result)) {

                $decision_option_model_quiz_parent = ($cp_row['decision_option_model_quiz_parent'] != "") ? $cp_row['decision_option_model_quiz_parent'] : "NULL";

                $in_sql = "INSERT INTO wise_analysis_report_decision_option_model_quiz 
                (decision_option_idx,decision_option_model_idx,decision_option_model_quiz_level,decision_option_model_quiz_group,decision_option_model_quiz_parent,
                analysis_report_decision_option_model_quiz_no,analysis_report_decision_option_model_quiz_type,analysis_report_decision_option_model_quiz_title,
                view_yn,view_title,wdate) 
                VALUES ('$report_idx','".$model_list[$cp_row['decision_option_model_idx']]."','".$cp_row['decision_option_model_quiz_level']."',
                '".$cp_row['decision_option_model_quiz_group']."',$decision_option_model_quiz_parent,'".$cp_row['analysis_report_decision_option_model_quiz_no']."',
                '".$cp_row['analysis_report_decision_option_model_quiz_type']."','".$cp_row['analysis_report_decision_option_model_quiz_title']."',
                '".$cp_row['view_yn']."','".$cp_row['view_title']."',now())";
                mysqli_query($gconnet, $in_sql);
                    
/*
                echo "parent => ".$cp_row['decision_option_model_quiz_parent']."\n";
                echo "\n";
                echo $in_sql;
                echo "\n";
*/
            }
        }
    }
    //만족도모델인 경우 MM_analysis_report_data 테이블 INSERT
    if($analysis_type == "MM") {
        $sql = "INSERT INTO MM_analysis_report_data
                    (report_idx,analysis_idx,memid,subid,mm_report_score,mm_report_percent,mm_report_scorepoint,mm_report_scorepoint2,mm_report_model_idx,wdate)
                VALUES
                    ('$report_idx','$dataInIdx','$memid','$subid',5,1,2,2,'$report_idx',now())";
        mysqli_query($gconnet, $sql);
    }

    switch($analysis_type) {
        case "DM" : $analysis_page = "multi"; break;
        case "AH" : $analysis_page = "ahp"; break;
        case "MM" : $analysis_page = "satisfaction"; break;
        default : $analysis_page = ""; break;
    }
    
    // 성공
    echo "OK|".$report_idx."|".$analysis_page;

}

?>