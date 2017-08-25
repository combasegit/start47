<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

if($_REQUEST[area_id]){
	$area_id = $_REQUEST[area_id];
	#	if($pref>39){
	#		$area_id = 8;
	#	}elseif($pref>35){
	#		$area_id = 7;
	#	}elseif($pref>30){
	#		$area_id = 6;
	#	}elseif($pref>24){
	#		$area_id = 5;
	#	}elseif($pref>20){
	#		$area_id = 4;
	#	}elseif($pref>14){
	#		$area_id = 3;
	#	}elseif($pref>7){
	#		$area_id = 2;
	#	}else{
	#		$area_id = 1;
	#	}
	if($area_id == 8){
		$a_min= 40;
		$a_max= 47;
	}elseif($area_id == 7){
		$a_min= 36;
		$a_max= 39;
	}elseif($area_id == 6){
		$a_min= 31;
		$a_max= 35;
	}elseif($area_id == 5){
		$a_min= 25;
		$a_max= 30;
	}elseif($area_id == 4){
		$a_min= 21;
		$a_max= 24;
	}elseif($area_id == 3){
		$a_min= 15;
		$a_max= 20;
	}elseif($area_id == 2){
		$a_min= 8;
		$a_max= 14;
	}else{
		$a_min= 1;
		$a_max= 7;
	}
}else{
		$a_min= 1;
		$a_max= 47;
}
?>
					<div class="select-box01">
						<select name="pref_id">
							<option value="">選択</option>
							<?
								for($i=$a_min;$i<=$a_max;$i++){
							?>
							<option value="<?=$i?>"><?=$PREFECTURE[$i]?></option>
							<?
								}
							?>
						</select>
					</div>
