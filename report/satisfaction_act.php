<?php
include_once "../inc/common.php";

$mode = $_REQUEST['mode'];
$idx = $_REQUEST['idx'];

if(in_array($mode, array("report_insert", "report_temporary", "report_analyzing"))) {

    $idx = $report_idx;
    $sql = "SELECT * FROM analysis_report WHERE idx = '$idx'";
    $result = mysqli_query($gconnet, $sql);
    $row = mysqli_fetch_array($result);

    $dataInIdx = $row['dataInIdx'];

    // analysis_report
    $upfile_sql = ""; $upfile_sql2 = "";
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


    // MM_analysis_report_data
    // 표본특성문항 선택하면 $mm_report_sample_character = "Y", $mm_report_sample_character_idx = $idx
    // 표본특성문항 선택안하면 $mm_report_sample_character = "N", $mm_report_sample_character_idx = ""
    // 케이스 선택하면 $mm_report_case = "Y", $mm_report_case_idx = $idx
    // 케이스 선택안하면 $mm_report_case = "N", $mm_report_case_idx = ""
    // 비교점수입력 compare_base_year 추가

    //                ,compare_base_year='$compare_base_year'

    $sql = "UPDATE MM_analysis_report_data
            SET mm_report_sample_character = 'Y',
                mm_report_sample_character_idx = '$idx',
                mm_report_score = '$mm_report_score',
                mm_report_percent = '$mm_report_percent',
                mm_report_scorepoint = '$mm_report_scorepoint',
                mm_report_scorepoint2 = '$mm_report_scorepoint2',
                mm_report_case = 'Y',
                mm_report_case_idx = '$idx'

            WHERE report_idx = '$idx'";
    mysqli_query($gconnet, $sql) or error('error:'.$sql);


    // MM_analysis_report_sample_character          - 표본특성
    $sql = "DELETE FROM MM_analysis_report_sample_character WHERE mm_report_sample_character_idx = '$idx' ";
    mysqli_query($gconnet, $sql);

    if(is_array($satis_sample_quiz)) {
        foreach($satis_sample_quiz as $quiz_no => $item) {
            $sql = "INSERT INTO MM_analysis_report_sample_character (mm_report_sample_character_idx, report_idx, analysis_idx, quiz_no)
                    VALUES ('$idx', '$idx', '$dataInIdx', '$item')";
            mysqli_query($gconnet, $sql) ;
        }
    }


    // MM_analysis_report_case               - 케이스
    $sql = "DELETE FROM MM_analysis_report_case WHERE mm_report_case_idx = '$idx' ";
    mysqli_query($gconnet, $sql);

//    print_r($case_quiz_no);

    if(is_array($case_quiz_no)) {
        foreach($case_quiz_no as $case_no => $case_quizno) {
            if(is_array($case_item_details[$case_no])) {
                foreach($case_item_details[$case_no] as $ii => $case_details) {
                    $sql = "INSERT INTO MM_analysis_report_case (mm_report_case_idx, report_idx, analysis_idx, case_no, quiz_no, data_val)
                            VALUES ('$idx', '$idx', '$dataInIdx','$case_no', '$case_quizno', '$case_details')";
                    mysqli_query($gconnet, $sql) or error('error:'.$sql);
                }
            }

        }
    }


    // MM_analysis_report_model       - 분석모델 설정
    $sql = "DELETE FROM MM_analysis_report_model WHERE mm_report_model_idx = '$idx' ";
    mysqli_query($gconnet, $sql);

    //가운데 모델 타입 0 왼쪽 모델 타입 1,2,3,... 오른쪽 모델 타입 101,102,103,...
    //요소만족도 선택하지 않으면 model_variable_element=0

    if(is_array($satis_model_quizno)){
        foreach($satis_model_quizno as $model_type => $model_type_list) {
            if($model_type_list != ''){
                if(is_array($model_type_list)){
                    foreach($model_type_list as $quiz_ii => $quiz_no) {
                        if($quiz_no != ''){
                            $sql = "INSERT INTO MM_analysis_report_model
                                    (mm_report_model_idx, analysis_idx, report_idx, model_status, quiz_no, model_type, model_title, model_weight, model_variable_element, wdate)
                                    VALUES
                                    ('$idx','$dataInIdx', '$idx', 'com','$quiz_no', '$model_type','model_title','0','0',now())";
                            mysqli_query($gconnet, $sql) or error('error:'.$sql);
                        }
                    }
                }
            }
        }
    }
    //요소만족도 있으면 해당 model_variable_element=1
//    print_r($element_model_box);
    if(is_array($element_model_box)){
        foreach($element_model_box as $model_type  => $element_quiz_list) {
            if($element_quiz_list != '') {
                $sql = "INSERT INTO MM_analysis_report_model
                        (mm_report_model_idx, analysis_idx, report_idx, model_status, quiz_no, model_type, model_title, model_weight, model_variable_element, wdate)
                        VALUES
                        ('$idx','$dataInIdx', '$idx', 'com','$element_quiz_list', '$model_type'+1,'model_title','0',1,now())";
                mysqli_query($gconnet, $sql) or error('error:' . $sql);
            }
        }
    }
    if(is_array($model_title)){
        foreach ($model_title as $model_type => $model_title_list) {
            if($model_title_list != '') {
                $sql = "UPDATE MM_analysis_report_model
                        SET model_title = '$model_title_list'
                        WHERE  mm_report_model_idx = '$idx' and model_type = '$model_type'";
                mysqli_query($gconnet, $sql) or error('error:'.$sql);
            }
        }
    }
    //요소만족도 있으면 해당 model_type의 다른 model_variable_element=2
    if(is_array($element_model_box)){
        foreach($element_model_box as $element_model_type => $element_quiz_list) {
            if ($element_quiz_list != '') {
                if(is_array($satis_model_quizno)){
                    foreach ($satis_model_quizno as $model_type => $element_model_box) {
                        $sql = "UPDATE MM_analysis_report_model
                                SET model_variable_element = 2
                                WHERE mm_report_model_idx = '$idx' and model_type = '$element_model_type'+1 and model_variable_element = 0";
                        mysqli_query($gconnet, $sql) or error('error:' . $sql);
                    }
                }
            }
        }
    }

    if(is_array($model_weight)) {
            $sum_weight = 0;
            foreach ($model_weight as $model_type => $model_weight_list) {
                if($model_weight_list != '') {
                    $sql = "UPDATE MM_analysis_report_model
                            SET model_weight = '$model_weight_list'
                            WHERE  mm_report_model_idx = '$idx' and model_type = '$model_type'";
                    mysqli_query($gconnet, $sql) or error('error:' . $sql);
                    $sum_weight += $model_weight_list;
                }
            }
            if($sum_weight != 100 && $sum_weight != 0){
                echo $sum_weight.'가중치의 합은 100이 되어야 합니다.';
            }
    }


    // MM_analysis_report_compare      - 비교점수입력
    $sql = "DELETE FROM MM_analysis_report_compare WHERE report_idx = '$idx' ";
    mysqli_query($gconnet, $sql);

    //echo $trendScore; echo $benchmarkingGroupScore;
    if($trendScore == 1 && $benchmarkingGroupScore == 0) {
        $analysis_compare_type = 1;
    } else if($trendScore == 0 && $benchmarkingGroupScore == 1) {
        $analysis_compare_type = 2;
    } else {
        $analysis_compare_type = 0;
    }
    echo $compare_value;

    //name = compare_value[추세점수1/벤치마킹점수2][compare_column][compare_title]
    if($analysis_compare_type != 0) {
        //1. 문항별 항목만족도 입력 3,1
        //   모델별 항목만족도 입력 3,2
        //        항목만족도 입력 3,3
        //2. 문항별 전반만족도 입력 4,1
        //        전반만족도 입력 4,3
        //3. 문항별 충성도 입력 5,1
        //   모델별 충성도 입력 5,2
        //4. 모델별 요소만족도 입력 2,2
        //        요소만족도 입력 2,3
        //5. 전체 CSI 입력 1,4
        echo $compare_value;
        if(is_array($compare_value)){
            if($compare_value!=''){
                $sql = "INSERT INTO MM_analysis_report_compare 
                        (report_idx, analysis_idx, analysis_type, analysis_type_detail, model_variable_element, model_type, quiz_no, compare_title, analysis_compare_type, compare_column, compare_value, wdate)
                        VALUES 
                        ('$idx','$dataInIdx',3, 1, '$model_variable_element', '$model_type', '$quiz_no', '$compare_title', '$analysis_compare_type', 'compare_column', '$compare_value', now())";
                mysqli_query($gconnet, $sql) or error('error:' . $sql);
            }
        }
    }

    if($mode == "report_insert") {
        //  모델설정 완료
        if($memid == 'cslee') {
            $sql = "UPDATE analysis_report SET stCode = 'AS' WHERE idx = '$idx'";
            mysqli_query($gconnet, $sql);
        }
        else {
            $sql = "UPDATE analysis_report SET stCode = 'ED' WHERE idx = '$idx'";
            mysqli_query($gconnet, $sql);
        // 프로시저 호출 시점 변경 (cron -> 저장 완료 시)
        $sql = "call MM_STEP01()";
        mysqli_query($gconnet, $sql);
        }
    }

    echo "OK|".$idx;

} else {
    echo "ERR|MODE 값이 누락되었습니다.";
}
?>