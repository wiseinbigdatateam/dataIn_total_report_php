<? include "./inc/header.php"; ?>
<?
	$amt = 100000;
	$damt = 45000;

	// 판매가 - 공급가 =  수익
		$margin = (int)$amt - (int)$damt;
		if((int)$amt>0 && (int)$damt>0 && (int)$amt>(int)$damt){
			$margin_value = ($margin/$amt)*100;
			//2019.04.10 신동열 : 15%이상 전체지급조건 삭제
			//if($margin_value>=15){
			//	$sun_mileage = $margin;
			//}else{

				echo "마진율 = ".$margin_value."<br>";

				// 수익 * 1.1  = 부가세
				$vat = $margin - round(($margin) / 1.1);

				echo "부가세 = ".$vat."<br>";

				// 수익 - 부가세 = 합계
				$total = $margin - (int)$vat;

				echo "합계 = ".$total."<br>";

				// 판매가 * 0.03 = 카드수수료
				// 2020.06.18 판매가 * 0.031 = 카드수수료 +카드수수료부가세 반영 (김영휘 전무 확인)
				$card_mny = round($amt * 0.031);

				echo "카드수수료 = ".$card_mny."<br>";

				// 수익 - 카드수수료 =  차액
				$cha_mny = $total - (int)$card_mny;

				echo "차액 = ".$cha_mny."<br>";

				// 차액에서 90%
				//$mileage = round($cha_mny * 0.9);
				if($cha_mny>0){
					$sun_mileage = $cha_mny;
				}else{
					$sun_mileage = 0;
				}
			//}
		}else{
			$sun_mileage = 0;
		}

		echo "sun_mileage = ".$sun_mileage."<br>";

		///////////////////////////////////////////////////////////////////////////////////////////////////
		## 2019/08/28 전략 구매 상품 마진 변경으로 인해서 나눔 마일리지 변경
		## 나눔마일리지중에서 회사수익(25%)를 제외한 금액을 나눔 마일리지로 변경함
		## 나눔 마일리지에서 회원 수익률은 35%를 최대치로 정한다.

		## $sun_mileage로 순수익률을 구한다.
		$pureRatio = $sun_mileage / (int)$amt * 100;
		
		echo "순수익율 pureRatio = ".$pureRatio."<br>";

		## 순수익률이 20%이상일 경우 $sun_mileage를 재 계산한다.
		$sun_mileage2 = 0;
		$sunmileRatio = 0.75;
		if($pureRatio >= 20){
			$sun_mileage2 = $sun_mileage * $sunmileRatio;
		}
		else{
			$sun_mileage2 = $sun_mileage;
		}

		echo "sun_mileage2 = ".$sun_mileage2."<br>";

		## (20% 이상일 경우 75%만 지급하고 지급률은 35% 이하이다.
		$gadianRatio = $pureRatio * $sunmileRatio;

		echo "가디언 수익율 gadianRatio = ".$gadianRatio."<br>";

		if($gadianRatio >= 35){
			$exceedRatio = $gadianRatio - 35;  //
			echo "exceedRatio = ".$exceedRatio."<br>";
			echo "sun_mileage = ".$sun_mileage."<br>";
			$temp = ($sun_mileage * $exceedRatio/100);
			echo "sun_mileage * exceedRatio/100 = ".$temp."<br>";
			echo "sun_mileage2 = ".$sun_mileage2."<br>";
			$sun_mileage2 = $sun_mileage2 - $temp;

			echo "가디언 수익율 35 이상 재계산 = ".$sun_mileage2."<br>";
		}

		$sun_mileage = floor($sun_mileage2);
		///////////////////////////////////////////////////////////////////////////////////////////////////
?>