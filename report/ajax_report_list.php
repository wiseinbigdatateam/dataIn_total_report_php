<?php
include_once "../inc/common.php";
?>
<table class="table table-hover table-gnb1">
    <thead>
        <tr>
            <th scope="col">
                <i class="bi bi-arrow-clockwise" data-bs-toggle="tooltip" data-bs-placement="top" title="상태 새로고침" onclick="window.location.reload()"></i>
                상태
            </th>
            <th scope="col">형식</th>
            <th scope="col" class="projName w35">프로젝트명</th>
            <th scope="col">생성날짜</th>
            <th scope="col">선택</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $param_list = array();
        if(is_array($sstatus)) {
            foreach($sstatus as $ii => $scode) {
                if($param != "") $param .= "&";
                $param_list[] = "sstatus[]=".$scode;
            }
        }
        if($searchkey != "") $param_list[] = "searchkey=".$searchkey;
        if($sdate != "") $param_list[] = "sdate=".$sdate;
        if($edate != "") $param_list[] = "edate=".$edate;

        if(is_array($param_list)) $param = implode("&", $param_list);

        $search_sql = " WHERE memid = '$memid' ";
        if($subid != "") $search_sql .= " AND subid = '$subid' ";
        if(is_array($sstatus)) $search_sql .= " AND stCode IN (".implode(",", $sstatus).") ";
        if($searchkey != "") $search_sql .= " AND analysis_title LIKE '%".$searchkey."%' ";
        if($sdate != "") $search_sql .= " AND reg_date >= '".$sdate." 00:00:00' ";
        if($edate != "") $search_sql .= " AND reg_date <= '".$edate." 23:59:59' ";

        $sql = "SELECT COUNT(idx) AS cnt FROM analysis_report $search_sql";
        $result = mysqli_query($gconnet, $sql) or error('error:'.$sql);
        $row = mysqli_fetch_array($result);
        $total = $row['cnt'];

        $rows = 10;
        $lists = 10;

        $page_count = ceil($total/$rows);
        if(!$page || $page > $page_count) $page = 1;
        $start = ($page-1)*$rows;
        $no = $total-$start;

        $sql = "SELECT *, DATE_FORMAT(reg_date, '%y.%m.%d') AS reg_date FROM analysis_report $search_sql ORDER BY idx DESC LIMIT $start, $rows";
        $result = mysqli_query($gconnet, $sql) or error('error:'.$sql);
        while($row = mysqli_fetch_array($result)) {
            // 의사결정(AHP) BN 테이블 분석 미완료, 모델 이미지 생성 미완료 시 분석중(PS) 로 상태 변경

            //if($row['analysis_type'] == "AH" && $row['stCode'] == "PE") {
            if($row['analysis_type'] == "AH") {
                $my_sql = "SELECT * FROM wise_analysis_myreport WHERE idx = '".$row['idx']."'";
                $my_result = mysqli_query($gconnet, $my_sql);
                $my_row = mysqli_fetch_array($my_result);

                if($my_row['report_status'] == "com") $row['stCode'] = "PE";

                if($row['stCode'] == "PE") {
                    if($my_row['report_status'] != "com" || $my_row['image_status'] != "Y") {
                        $row['stCode'] = "PS";
                    }
                }
            }

            // 상태별 class
            switch($row['stCode']) {
                case "EE" :  //임시저장
                    $status_class = "con-writing";
                    break;
                case "ED" :  //작성완료
                    $status_class = "con-writing-completed";
                    break;
                case "AS" :  //만족도모델 분석중
                    $status_class = "con-analyzing";
                    break;
                case "AE" :  //만족도모델 분석완료 => 비교점수 입력가능
                    $status_class = "con-analyzing";
                    break;
                case "PS" :  //분석완료
                    $status_class = "con-analyzing";
                    break;
                case "PE" :  //보고서생성완료
                    $status_class = "con-analyzing-completed";
                    break;
                default :
                    $status_class = "";
                    break;
            }
        ?>
        <tr>
            <th scope="row" class="<?=$status_class?>"><?=get_report_status($row['stCode'])?></th>
            <td><?=get_report_type($row['analysis_type'])?></td>
            <td class="projName"><?=$row['analysis_title']?><input type="hidden" name="report_idx" value="<?=$row['idx']?>"></td>
            <td><?=$row['reg_date']?></td>
            <td class="complete-btn-group">
                <?php
                $report_url = "";
                if($row['analysis_type'] == "MM") $report_url = "satisfaction.html";
                else if($row['analysis_type'] == "SV") $report_url = "service.html"; 
                else if($row['analysis_type'] == "DM") $report_url = "multi.html"; 
                else if($row['analysis_type'] == "AH") $report_url = "ahp.html"; 

                $modify_url = $report_url."?mode=modify&idx=".$row['idx'];
                $compare_url = $report_url."?mode=compare&idx=".$row['idx'];
                $copy_url = $report_url."?mode=copy&idx=".$row['idx'];

                // 상태별 button 
                switch($row['stCode']) {
                    case "EE" :
                ?>
                    <button type="button" class="btn-modify" onclick="document.location='<?=$modify_url?>'">
                        <i class="bi bi-pencil"></i><span>수정</span>
                    </button>
                <?php
                        break;
                    case "ED" :
                    case "PS" :
                        //echo "-";
                ?>
                <?php
                        break;
                    case "PE" :
                        $report_view_url = "http://datain.co.kr/report/".$report_url."?ridx=".$row['idx'];
                        if($row['analysis_type'] == "DM" && $memid == "cslee") {
                           $report_view_url = "./view/".$report_url."?ridx=".$row['idx']."&id=".$row['memid'];
                        }
                ?>
                    <button type="button" class="btn-preview" onclick="openReport('<?=$report_view_url?>', '<?=$row['idx']?>')">
                        <i class="bi bi-play-circle"></i><span>보고서 보기</span>
                    </button>
                            <!--
                            <button type="button" class="btn-excel"></button>
                            <button type="button" class="btn-word"></button>
                            -->
                <?php
                        break;
                }
                ?>
                    <button type="button" class="btn-preview" onclick="copyReport('<?=$row['idx']?>');">
                        <i class="bi bi-clipboard-check"></i><span>설정복사</span>
                    </button>
                    <button type="button" class="btn-delete" onclick="deleteReport('<?=$row['idx']?>')">
                        <i class="bi bi-trash3"></i>
                    </button>
            </td>
        </tr>
        <?php
            $no--;
        }
        if($total == 0) {
        ?>
        <tr>
            <td colspan="5">등록된 항목이 없습니다.</td>
        </tr>
        <?php   
        }
        ?>
    </tbody>
</table>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
<nav aria-label="Page">
    <div class="infobox">
        <div class="announce">
            <i class="bi bi-exclamation-circle"></i>
            <span class="fontcolor-red">작성이 완료된 이후에는 수정할 수 없습니다.</span>
        </div>
    </div>
    <?php 
    $ajax_page_info = array('id' => 'reportList', 'func' => 'setList', 'url' => $_SERVER['PHP_SELF']);
    print_pagelist($page, $lists, $page_count, $param, "", "", $ajax_page_info); 
    ?>
</nav>