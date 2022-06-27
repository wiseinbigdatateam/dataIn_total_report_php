                    <script>
                        $(window).on("scroll", function() {
                            var scroll_top = $(this).scrollTop(); // scroll top

                            var prev_top = 0;
                            var prev_index = 0;
                            $(".div_left > div").each(function(div_index) {

                                var section_top = $(this).offset().top;
                                //var section_next_top = $(this).next().offset().top;
                                var section_next_top = 0;

                                var active_index = 0;

                                $(".step-progress > .stepBadge").removeClass("active");

                                if(scroll_top > section_top) {
                                    active_index = div_index;
                                }
/*
console.log("("+div_index+")");
console.log("prev_top : " + prev_top);
console.log("scroll_top : " + scroll_top);
console.log("section_top : " + section_top);
console.log("active_index : " + active_index);
*/
                                $(".step-progress > .stepBadge:eq("+active_index+")").addClass("active");

                                prev_top = section_top;
                                prev_index = div_index;


                            });

                            // 임시 
                            $(".stepBadge").addClass("active");
                        });
                    </script>
                    
                    <div class="step-progress">
                        <span onclick="fnScrollTop('section1')" class="stepBadge active">STEP 1</span>
                        <span onclick="fnScrollTop('section2')" class="stepBadge active">STEP 2</span>
                        <span onclick="fnScrollTop('section3')" class="stepBadge active">STEP 3</span>
                        <?php
                        if(basename($_SERVER['PHP_SELF']) == "satisfaction.html") {
                        ?>
                        <span onclick="fnScrollTop('section4')" class="stepBadge active">STEP 4</span>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="step-line"></div>
                    <div class="sec_title">
                        <span class="sec_title_listOf"><i class="bi bi-list-ul m10"></i>문항리스트</span>
                        <button type="button" class="btn-default btn-cancleAll" onclick="cancleAll()">선택해제</button>
                    </div>
                    <div class="sec_con original-bg-style">
                        <ul class="que_l">
                            <?php
                            $quiz_list = array();
                            $quiz_sql = "SELECT * FROM analysis_report AS r, wise_analysis_quiz AS q
                                        WHERE r.dataInIdx = q.analysis_idx AND r.idx = '$idx' ORDER BY q.quiz_no ASC";
                            $result = mysqli_query($gconnet, $quiz_sql) or error('error:'.$quiz_sql);

                            while($row = mysqli_fetch_array($result)){
                                $quiz_list[$row['quiz_no']] = $row['quiz_title'];
                                $quiz_value_list[$row['quiz_no']] = explode("^", $row['quiz_value']);
                                $quiz_no_list[$row['idx']] = $row['quiz_no'];
                            ?>
                            <li id="ql_<?=$row['idx']?>" class="item_serv">
                                <div class="form-check node ui-selectee ui-selected selected-flag">

                                    <?php
                                    if($report_info['analysis_type'] == "AH") {
                                    ?>
                                    <span class="close ui-selectee" style="">
                                        <button type="button" class="ui-selectee"><img src="../report_bn/img/remove.png" alt=""></button>
                                    </span>
                                    <?php
                                    }
                                    ?>

                                    <input class="form-check-input" type="checkbox" value="<?=$row['quiz_no']?>" id="ckList<?=$row['quiz_no']?>" exlist="<?=$row['quiz_value']?>" name="quiz_list">
                                    <label class="form-check-label" for="ckList<?=$row['quiz_no']?>"><?=$row['quiz_title']?></label>

                                    <?php
                                    if($report_info['analysis_type'] == "AH") {
                                    ?>
                                    <a href="javascript:<?=$row['idx']?>;" class="overtext ui-selectee" title="<?=$row['quiz_title']?>"></a>

                                    <input class="dec_in ui-selectee" type="text" name="decision_option_model_title_<?=$row['idx']?>" onblur="go_tmp_child('<?=$row['idx']?>','mod');" readonly>

                                    <div class="score_div ui-selectee ui-selected selected-flag">
                                        <input type="text" value="<?=$row['quiz_title']?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="decision_option_model_title_<?=$row['idx']?>" class="left_input_score">
                                    </div>
                                    <div class="dec_bwrap ui-selectee">
                                        <div class="dec_add dec_add1 ui-selectee">
                                            <button type="button" class="ui-selectee btn-secondary btn-plus" onclick="go_tmp_child('<?=$row['idx']?>','add');">+</button>
                                        </div>
                                        <div class="dec_min dec_min1 ui-selectee" style="display:none">
                                            <button type="button" class="ui-selectee btn-outline-secondary btn-minus" onclick="go_tmp_child('<?=$row['idx']?>','minus');">-</button>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="btnGroup">
                        <button class="btn btn-outline-primary" id="btnReportTemporary">임시저장</button>
                        <button class="btn btn-primary" id="btnReportCreate">작성완료</button>
                    </div>
                    <div class="announce announce-light">
                        <p>
                            <ul>
                                <li>임시저장 시 이어서 작성할 수 있습니다.</li>
                                <li>작성완료 시 수정할 수 없습니다.</li>
                            </ul>
                        </p>
                    </div>