<?php
include_once "../inc/common.php";

$mode = $_REQUEST['mode'];

if(in_array($mode, array("report_insert", "report_temporary"))) {

    $idx = $report_idx; // analysis_report.idx

    // analysis_report
    $upfile_sql = "";
    if($_FILES['log_path']['size'] > 0) {

        $sql = "SELECT log_path FROM analysis_report WHERE idx = '$idx'";
        $result = mysqli_query($gconnet, $sql) or error("error : " + $sql);
        $row = mysqli_fetch_array($result);

        $upfile_info = pathinfo($_FILES['log_path']['name']);

        $upfile_path = "./upfile/".$idx;
        if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

        $log_path = md5(time().rand(100,999)).".".strtolower($upfile_info['extension']);

        copy($_FILES['log_path']['tmp_name'], $upfile_path."/".$log_path);
        chmod($upfile_path."/".$log_path, 0606);

        $upfile_sql .= ", log_path = '$log_path' ";
        
    }
    $sql = "UPDATE analysis_report
            SET analysis_title = '$analysis_title',
                population = '$population', 
                sample_size = '$sample_size',
                sampling_method = '$sampling_method',
                survey_method = '$survey_method',
                analysis_period = '$analysis_period'
                $upfile_sql
            WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql) or error('error:'.$sql);

    // DM_option                    - 다면평가 옵션(필수, 단)  
    $sql = "SELECT COUNT(idx) AS cnt FROM DM_option WHERE idx = '$idx'";
    $result = mysqli_query($gconnet, $sql) or error("error : ".$sql);
    $row = mysqli_fetch_array($result);

    if($scoreRound < 0 || $scoreRound == "") $scoreRound = 0;

    $RANKYN = "1";                  // 사용안함
    $frequenRound = $scoreRound;    // scoreRound = frequenRound 동일하게 값 설정 

    if($row['cnt'] <= 0) {
        $sql = "INSERT INTO DM_option (idx,APPRAISER,APPRAISER_NO,MARYMONDYUM,RANKYN,100YN,indexValue,scoreRound,frequenRound)
                VALUES ('$idx','$appraiser','$appraiser_no','$marymondyum','$RANKYN','$score100YN','$indexValue','$scoreRound','$frequenRound')";
    } else {
        $sql = "UPDATE DM_option 
                SET APPRAISER = '$appraiser',
                APPRAISER_NO = '$appraiser_no',
                MARYMONDYUM = '$marymondyum',
                RANKYN = '$RANKYN',
                100YN = '$score100YN',
                indexValue = '$indexValue',
                scoreRound = '$scoreRound',
                frequenRound = '$frequenRound'
                WHERE idx = '$idx'";
    }
    mysqli_query($gconnet, $sql) or error('error:'.$sql);

    // DM_sample_case               - 케이스(옵션, 다 – groupIdx최대 2종류)
    $sql = "DELETE FROM DM_sample_case WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql);

    if(is_array($case_quiz_no)) {
        foreach($case_quiz_no as $case_no => $case_quizno) {
            
            if(is_array($case_item_details[$case_no])) {
                foreach($case_item_details[$case_no] as $ii => $case_details) {
                    $sql = "INSERT INTO DM_sample_case (idx, groupIdx, itemDetailsIndex)
                            VALUES ('$idx', '$case_quizno', '$case_details')";
                    mysqli_query($gconnet, $sql);
                }
            }

        }
    }

    //DM_group                      - 그룹
    $sql = "DELETE FROM DM_group WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql);
    
    if(is_array($itemIdx)) {
        foreach($itemIdx as $groupIdx => $item) {
            $sql = "INSERT INTO DM_group (idx, groupIdx, itemIdx, selectedItemNM)
                    VALUES ('$idx', '$groupIdx', '$item', '".$selectedItemNM[$groupIdx]."')";
            mysqli_query($gconnet, $sql);
        }
    }
 
    //DM_middle_model               - 중분류
    $sql = "DELETE FROM DM_middle_model WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql);

    if(is_array($middle_model_name)) {
        foreach($middle_model_name as $middle_model_index => $middle_model_name_str) {
            $middle_model_name_str = trim($middle_model_name_str);
            if($middle_model_name_str != "") {
                $sql = "INSERT INTO DM_middle_model (idx, middle_model_index, middle_model_name)
                        VALUES ('$idx', '$middle_model_index', '$middle_model_name_str')";
                mysqli_query($gconnet, $sql);
            }
        }
    }


    //DM_middle_model_sub           – 분석모델상세
    $sql = "DELETE FROM DM_middle_model_sub WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql);
    
    if(is_array($use_grade)) {
        foreach($use_grade as $ii => $grade) {
            $model_sub_list = ${"use_grade".$grade."_middle_model"};
            
            if(is_array($model_sub_list)) {
                foreach($model_sub_list as $jj => $middle_model_index) {

                    if(is_array($middle_model_sub_quizno[$grade][$middle_model_index])) {
                        foreach($middle_model_sub_quizno[$grade][$middle_model_index] as $quiz_ii => $quiz_no) {
                            $dis_txt = $distribution[$grade][$middle_model_index][$quiz_ii];
            
                            $sql = "INSERT INTO DM_middle_model_sub (idx, middle_model_index, appraisee_grade, quiz_no, distribution)
                                    VALUES ('$idx', '$middle_model_index', '$grade', '$quiz_no', '$dis_txt')";
                            mysqli_query($gconnet, $sql);
                        }
                    }

                }
            }
        }        
    }

    //DM_weight                     - 가중치
    $sql = "DELETE FROM DM_weight WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql);

    if(is_array($weight)) {
        foreach($weight as $index => $weight_list) {
            if(is_array($weight_list)) {
                foreach($weight_list as $grade => $weight_val) {
                    $sql = "INSERT INTO DM_weight (idx, middle_model_index, appraisee_grade, DM_weight)
                            VALUES ('$idx', '$index', '$grade', '$weight_val')";
                    mysqli_query($gconnet, $sql);
                }
            }
        }
    }

    if($mode == "report_insert") {
        $sql = "UPDATE analysis_report SET stCode = 'ED' WHERE idx = '$idx'";
        mysqli_query($gconnet, $sql);

        // 프로시저 호출 시점 변경 (cron -> 저장 완료 시)
        $sql = "call DM_STEP01()";
        mysqli_query($gconnet, $sql);
    }

}

echo "OK|".$idx;

?>