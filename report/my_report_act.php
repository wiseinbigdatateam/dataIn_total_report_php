<?php
include_once "../inc/common.php";

if($mode == "delete") {

    // 공통 테이블
    $sql = "SELECT memid, analysis_type, log_path, stCode, stCodeMake FROM analysis_report WHERE idx ='$idx'";
    $result = mysqli_query($gconnet, $sql);
    $row = mysqli_fetch_array($result);

    if($row['stCode'] == "PS") {
        echo "ERR|분석중인 보고서는 삭제할 수 없습니다.";
        exit;
    } 

    $upfile_path = "./upfile/".$idx."/".$row['log_path'];
    if($row['log_path'] != "" && is_file($upfile_path)) {
        unlink($upfile_path);
    }

    if($row['analysis_type'] == "DM") {         // 다면평가

        $db_table_list = array('DM_option','DM_group','DM_case','DM_middle_model','DM_middle_model_sub','DM_sample_case','DM_weight','DM_analysisDM_step01','DM_analysisDM_step02','DM_analysisDM_step02_middle_model','DM_analysisDM_step03','DM_analysisDM_step03_middle_model','DM_analysisDM_step04','DM_analysisDM_step04_appraisee_no','DM_analysisDM_step04_middle_model','DM_analysisMD_superior');

        if(is_array($db_table_list)) {
            foreach($db_table_list as $ii => $table_name) {
                $sql = "DELETE FROM ".$table_name." WHERE idx = '$idx'";
                mysqli_query($gconnet, $sql);
            }
        }

        // 다면평가 MRD HTML 파일 삭제
        if($row['stCodeMake'] == "Y") {
            @unlink("./report/".$row['memid']."/multi_".$idx.".html");
        }
        
    } else if($row['analysis_type'] == "AH") {  // 의사결정(AHP)
        
        $db_table_list = array('wise_analysis_myreport','wise_analysis_report_decision_100data','wise_analysis_report_decision_100data_detail',
                        'wise_analysis_report_decision_100data_detail2','wise_analysis_report_decision_100data_detail3',
                        'wise_analysis_report_decision_100data_detail_total','wise_analysis_report_decision_option',
                        'wise_analysis_report_decision_option_group','wise_analysis_report_decision_option_model',
                        'wise_analysis_report_decision_option_model_quiz','wise_analysis_report_decision_option_model_quiz_view',
                        'wise_analysis_report_decision_option_point_case','wise_analysis_report_decision_option_point_quiz');

        if(is_array($db_table_list)) {
            foreach($db_table_list as $ii => $table_name) {
                
                $key_name = (in_array($table_name, array("wise_analysis_myreport", "wise_analysis_report_decision_option"))) ? "idx" : "decision_option_idx";

                $sql = "DELETE FROM $table_name WHERE $key_name = '$idx'";
                mysqli_query($gconnet, $sql);
            }
        }
        
    } else if($row['analysis_type'] == "MM") {  // 만족도

        $db_table_list = array('MM_analysis_report_data', 'MM_analysis_report_model', 'MM_analysis_report_case', 'MM_analysis_report_sample_character');
        if(is_array($db_table_list)) {
            foreach($db_table_list as $ii => $table_name) {
                $sql = "DELETE FROM $table_name WHERE report_idx = '$idx'";
                mysqli_query($gconnet, $sql);
            }
        }
    }

    // 공통 테이블
    $sql = "DELETE FROM analysis_report WHERE idx ='$idx'";
    mysqli_query($gconnet, $sql);

    echo "OK|";

}
?>