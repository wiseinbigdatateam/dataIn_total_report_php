<?php
include_once "../inc/common.php";

$idx = $report_idx; // analysis_report.idx

if(in_array($mode, array("report_insert", "report_temporary"))) {

    $sample_size = $analysis_report_decision_option_sampling;           // 조사대상 - analysis_report 테이블에 조사대상 필드가 없기때문에 표본크기 필드로 대체
    $population = $analysis_report_decision_option_population;          // 모집단
    $sampling_method = $analysis_report_decision_option_samplingmethod; // 표본추출방법
    $survey_method = $analysis_report_decision_option_surveymethod;     // 조사방법
    $analysis_period = $analysis_report_decision_option_data;           // 조사기간

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
        
        /****************************** BN System 개발 DB 입력 start ******************************/
        $upfile_sql2 .= ", analysis_report_decision_option_logo_o='".$_FILES['log_path']['name']."', analysis_report_decision_option_logo_c='$log_path' ";
        /****************************** BN System 개발 DB 입력 end ******************************/
        
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

    /****************************** BN System 개발 DB 입력 start ******************************/
    if($case_quiz_no[1] != "") {
        $sql = "SELECT * FROM wise_analysis_quiz WHERE analysis_idx = '$analysis_idx' AND quiz_no = '".$case_quiz_no[1]."'";
        $result = mysqli_query($gconnet, $sql);
        $quiz_row = mysqli_fetch_array($result);     
        
        $analysis_report_decision_option_case_title = $quiz_row['quiz_title'];
        $analysis_report_decision_option_case_content = $quiz_row['quiz_content'];

        $analysis_report_decision_option_case_value = ""; $val_list = array();
        $quiz_value_list = explode("^", $quiz_row['quiz_value']);
        if(is_array($quiz_value_list)) {
            foreach($quiz_value_list as $ii => $quiz_value) {
                list($val_no, $val) = explode("|", $quiz_value);
                $val_list[$val_no]['no'] = $val_no;
                $val_list[$val_no]['title'] = $val;
            }
        }
        if(is_array($case_item_details[1])) {
            foreach($case_item_details[1] as $ii => $case_quiz_value_no) {
                if($analysis_report_decision_option_case_value != "") $analysis_report_decision_option_case_value .= "^";
                $analysis_report_decision_option_case_value .= $val_list[$case_quiz_value_no]['no']."|".$val_list[$case_quiz_value_no]['title'];

            }
        }
    }

    $sql = "UPDATE wise_analysis_report_decision_option
            SET analysis_report_option_title = '$analysis_title',
                analysis_report_decision_option_name = '$analysis_title',
                analysis_report_decision_option_population = '$analysis_report_decision_option_population',
                analysis_report_decision_option_sampling = '$analysis_report_decision_option_sampling',
                analysis_report_decision_option_samplingmethod = '$analysis_report_decision_option_samplingmethod',
                analysis_report_decision_option_surveymethod = '$analysis_report_decision_option_surveymethod',
                analysis_report_decision_option_data = '$analysis_report_decision_option_data',
                analysis_report_decision_option_scorepoint = '$scoreRound',
                analysis_report_decision_option_scorepoint2 = '$frequenRound',
                analysis_report_decision_option_calpath = '$decision_option_calpath',
                analysis_report_decision_option_calpath2 = '$decision_option_calpath2',
                analysis_report_decision_option_case = '$decision_option_case',
                analysis_report_decision_option_case_no = '$decision_option_case_no',
                analysis_report_decision_option_case_title = '$analysis_report_decision_option_case_title',
                analysis_report_decision_option_case_content = '$analysis_report_decision_option_case_content',
                analysis_report_decision_option_case_value = '$analysis_report_decision_option_case_value'
                $upfile_sql2
            WHERE idx = '$idx'";
    mysqli_query($gconnet, $sql) or error('error:'.$sql);

    $sql = "DELETE FROM wise_analysis_report_decision_option_group WHERE decision_option_idx = '$idx'";
    mysqli_query($gconnet, $sql);

    $itemIdx = array_filter($itemIdx);

    if(count($itemIdx) > 0) {
        // 문항정보 가져오기
        unset($quiz_list);
        $sql = "SELECT * FROM wise_analysis_quiz WHERE analysis_idx = '$analysis_idx' AND quiz_no IN (".implode(",", $itemIdx).")";
        $result = mysqli_query($gconnet, $sql);
        while($row = mysqli_fetch_array($result)) {
            $quiz_list[$row['quiz_no']] = $row;
        }

        foreach($itemIdx as $itemNo => $itemQuizNo) {
            if($itemQuizNo != "") {
                $analysis_report_decision_option_group_no = $quiz_list[$itemQuizNo]['idx'];
                $analysis_report_decision_option_group_type = $quiz_list[$itemQuizNo]['quiz_type'];
                $analysis_report_decision_option_group_title = $quiz_list[$itemQuizNo]['quiz_title'];
                $analysis_report_decision_option_group_answer = "";
                
                $sql = "INSERT INTO wise_analysis_report_decision_option_group
                            (decision_option_idx,analysis_report_decision_option_group_no,analysis_report_decision_option_group_type,analysis_report_decision_option_group_title,analysis_report_decision_option_group_answer,wdate)
                        VALUES
                            ('$idx','$analysis_report_decision_option_group_no','$analysis_report_decision_option_group_type','$analysis_report_decision_option_group_title','$analysis_report_decision_option_group_answer',now())";
                mysqli_query($gconnet, $sql);
            }
        }
    }
    /****************************** BN System 개발 DB 입력 end ******************************/

    if($mode == "report_insert") {
        $sql = "UPDATE analysis_report SET stCode = 'ED' WHERE idx = '$idx'";
        mysqli_query($gconnet, $sql);

        /****************************** BN System 개발 DB 입력 start ******************************/
        $report_type = "decision";
        $report_idx = $idx;
        $report_name = $analysis_title;
        $report_email = $mememail;
        $report_title = $analysis_title;

        $sql_file_0 = "select idx from wise_analysis_myreport where memid='".$memid."' and report_type='".$report_type."' and report_idx='".$report_idx."'"; 
        $query_file_0 = mysqli_query($gconnet,$sql_file_0);
        if(mysqli_num_rows($query_file_0) > 0){
            $query = "update wise_analysis_myreport set"; 
            $query .= " report_status = 'tmp', ";
            $query .= " report_name = '".$report_name."', ";
            $query .= " report_email = '".$report_email."', ";
            $query .= " report_title = '".$report_title."', ";
            $query .= " wdate = now() ";
            $query .= " where memid='".$memid."' and report_type='".$report_type."' and report_idx='".$report_idx."'";
        } else {
            $query = "insert into wise_analysis_myreport set"; 
            $query .= " idx = '".$report_idx."', ";
            $query .= " memid = '".$memid."', ";
            $query .= " subid = '".$subid."', ";
            $query .= " report_type = '".$report_type."', ";
            $query .= " report_idx = '".$report_idx."', ";
            $query .= " report_name = '".$report_name."', ";
            $query .= " report_email = '".$report_email."', ";
            $query .= " report_title = '".$report_title."', ";
            $query .= " wdate = now() ";
        }
        $result = mysqli_query($gconnet,$query);
        
        $query_option = "update wise_analysis_option set"; 
        $query_option .= " report_name = '".$report_title."', ";
        $query_option .= " report_edate = now() ";
        $query_option .= " where report_type = '".$report_type."' and report_idx = '".$report_idx."'";
        $result_option = mysqli_query($gconnet,$query_option);    
        /****************************** BN System 개발 DB 입력 end ******************************/
    }

    echo "OK|".$idx;
}
?>