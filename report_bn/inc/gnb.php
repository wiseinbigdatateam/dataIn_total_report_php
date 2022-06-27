<?
	$gnb_current_page = basename($_SERVER['PHP_SELF']);
	$gnb_current_page_arr = explode("_",$gnb_current_page);

	//echo $gnb_current_page_arr[0]."<br>";
?>
				<div class="main_cmenu">
                    <ul>
                        <li <?if(trim($gnb_current_page_arr[0]) == "manjok"){?>class="selected"<?}?>><a href="./manjok_1.php">만족도모델 보고서</a></li>
                        <li <?if(trim($gnb_current_page_arr[0]) == "service"){?>class="selected"<?}?>><a href="./service_1.php">서비스평가모델 보고서</a></li>
                        <li <?if(trim($gnb_current_page_arr[0]) == "damyun"){?>class="selected"<?}?>><a href="./damyun_1.php">다면평가모델 보고서</a></li>
                        <li <?if(trim($gnb_current_page_arr[0]) == "decision"){?>class="selected"<?}?>><a href="./decision_1.php">의사결정모델 보고서</a></li>
												<li <?if(trim($gnb_current_page_arr[0]) == "my-report.php"){?>class="selected"<?}?>><a href="./my-report.php">나의 보고서 관리</a></li>
												<li <?if(trim($gnb_current_page_arr[0]) == "my-project.php"){?>class="selected"<?}?>><a href="./my-project.php">나의 프로젝트 관리</a></li>
                    </ul>
                </div>