<?php
include_once "../inc/common.php";
?>
<table class="table table-hover table-gnb2">
    <thead>
        <tr>
            <th scope="col">선택</th>
            <th scope="col" class="projName">프로젝트명</th>
            <th scope="col">등록날짜</th>
            <th scope="col">가져온날짜</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $param_list = array();
        if($project != "") $param_list[] = "project=".$project;
        if($searchkey != "") $param_list[] = "searchkey=".$searchkey;

        if(is_array($param_list)) $param = implode("&", $param_list);

        $page = $_REQUEST['page'];

        $search_sql = " WHERE memid = '$memid' ";
        if($subid != "") $search_sql .= " AND subid = '$subid' ";
        if($project != "") $search_sql .= " AND idx = '$project' ";
        if(trim($searchkey) != "") $search_sql .= " AND analysis_title LIKE '%".trim($searchkey)."%' ";

        $sql = "SELECT COUNT(idx) AS cnt FROM wise_analysis_main $search_sql";
        $result = mysqli_query($gconnet, $sql) or error('error:'.$sql);

        $row = mysqli_fetch_array($result);
        $total = $row['cnt'];

        $rows = 5;
        $lists = 10;

        $page_count = ceil($total/$rows);
        if(!$page || $page > $page_count) $page = 1;
        $start = ($page-1)*$rows;
        $no = $total-$start;

        $sql = "SELECT *, DATE_FORMAT(wdate, '%y.%m.%d') AS wdate, DATE_FORMAT(mv_edate, '%y.%m.%d') AS mdate FROM wise_analysis_main $search_sql ORDER BY idx DESC LIMIT $start, $rows";
        $result = mysqli_query($gconnet, $sql) or error('error');
        while($row = mysqli_fetch_array($result)) {
            $chk = ($project == $row['idx']) ? "checked" : "";
        ?>
        <tr>
            <td>
                <input class="form-check-input" type="radio" name="project" id="p<?=$row['idx']?>" value="<?=$row['idx']?>" <?=$chk?> />
            </td>
            <td class="projName"><label for="p<?=$row['idx']?>"><?=$row['analysis_title']?></label></td>
            <td><?=$row['wdate']?></td>
            <td><?=$row['mdate']?></td>
        </tr>
        <?php
        }

        if($total <= 0) {
        ?>
        <tr>
            <td colspan="4">등록된 항목이 없습니다.</td>
        </tr>
        <?php 
        }
        ?>
    </tbody>
</table>
<nav aria-label="Page">
    <?php 
    $ajax_page_info = array('id' => 'projectList', 'func' => 'setList', 'url' => $_SERVER['PHP_SELF']);
    print_pagelist($page, $lists, $page_count, $param, "", "", $ajax_page_info); 
    ?>
</nav>