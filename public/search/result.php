<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

//画像アップフォルダ
$uploaddir = './../school_img/';
$uploaddir2 = '/school_img/';

//イベント一覧取得************************************************/
$evt_sql = "select DISTINCT m.* FROM mtb_school_event AS m, dtb_event_date AS d, mtb_school AS s ";
$evt_sql .= "WHERE s.school_id = m.school_id AND m.del_flag = '0' AND s.del_flag = '0' AND m.event_id = d.event_id AND s.show_flag = '1' ";
$evt_res = $mysqli->query($evt_sql);
while($evt_data=$evt_res->fetch_assoc()){
	$EVENT_DATA_LST[$evt_data['school_id']][$evt_data['event_id']]=$evt_data['event_title'];
}
#echo $evt_sql;
#print_r($EVENT_DATA_LST);
//検索条件その１**************************************************/
if($_GET[school_type]){
	$school_type=$_GET[school_type];
	$search_condition = "&school_type=".$school_type;
	$search_title2 = "[".$SCHOOL_TYPE_ARY[$school_type]."]";
}
if(strlen($_GET[uniform_ck])){
	$uniform_ck=$_GET[uniform_ck];
	$search_condition .= "&uniform_ck=".$uniform_ck;
	if($uniform_ck=="1"){
		$search_title2 .= "[制服あり]";
	}else{
		$search_title2 .= "[制服なし]";
	}
}
if($_GET[schooling_level]){
	$schooling_level=$_GET[schooling_level];
	$schooling_level_lst=implode(",",$schooling_level);
	$search_condition .= "&schooling_level_lst=".$schooling_level_lst;
	foreach($schooling_level AS $val){
		$search_title2 .= "[".$SCHOOLING_LEVEL_ARY[$val]."]";
	}
}
//条件整理
$search_condition ="?".substr($search_condition, 1);

//サーチindexの地域・都道府県から検索******************************************
if($_GET[area_id]){
	$area_id=$_GET[area_id];
	$area_code=$AREA_E[$area_id];
	if($_GET[pref_id]){
		$pref_id=$_GET[pref_id];
		$pref_code=$PREFECTURE_E[$pref_id];
		header("Location: /search/".$area_code."/".$pref_code."/".$search_condition);
		exit();
	}
	header("Location: /search/".$area_code."/".$search_condition);
	exit();
}elseif($_GET[pref_id]){
	$pref_id=$_GET[pref_id];
	$pref_code=$PREFECTURE_E[$pref_id];
	if($pref_id>39){
		$area_id = 8;
	}elseif($pref_id>35){
		$area_id = 7;
	}elseif($pref_id>30){
		$area_id = 6;
	}elseif($pref_id>24){
		$area_id = 5;
	}elseif($pref_id>20){
		$area_id = 4;
	}elseif($pref_id>14){
		$area_id = 3;
	}elseif($pref_id>7){
		$area_id = 2;
	}else{
		$area_id = 1;
	}
	$area_code=$AREA_E[$area_id];
	header("Location: /search/".$area_code."/".$pref_code."/".$search_condition);
	exit();
}


//検索条件その２******************************************
/*エリア*/
if($_GET[area_code]){
	$area_code=$_GET[area_code];
	$area_id = array_search($area_code, $AREA_E);
	$search_title = "の".$AREA[$area_id];
}else{
	$area_code="all";//無い時は全国に固定
	$search_title = "の全国";
}
/*都道府県*/
if($_GET[pref_code]){
	$pref_code=$_GET[pref_code];
	$pref_id = array_search($pref_code, $PREFECTURE_E);
	$search_title .= "の".$PREFECTURE[$pref_id];
}

$search_title = mb_substr($search_title, 1);
	
//検索ロジック******************************************
$sql = "SELECT s.*, c.* FROM mtb_school AS s, mtb_campus as c ";
if(strlen($schooling_level_lst)){
	$sql .= ",dtb_school_schooling_level AS sl ";
}
$sql .= "WHERE s.del_flag = '0' AND c.del_flag = '0' AND s.school_id = c.school_id AND c.sort_id = '0' AND s.show_flag = '1' ";
$sql2 = "SELECT * FROM mtb_campus WHERE del_flag = '0' ";
if($area_code!="all"){
	$sql .= "AND c.area_id = '$area_id' ";
	$sql2 .= "AND area_id = '$area_id' ";
}
if(strlen($pref_code)){
	$sql .= "AND c.pref = '$pref_id' ";
	$sql2 .= "AND pref = '$pref_id' ";
}
if(strlen($school_type)){
	$sql .= "AND s.school_type = '$school_type' ";
}
if(strlen($uniform_ck)){
	if($uniform_ck=="1"){
		$sql .= "AND s.uniform != '0' ";
	}else{
		$sql .= "AND s.uniform != '1' ";
	}
}
if(strlen($schooling_level_lst)){
	$sql .= "AND sl.school_id = s.school_id AND sl.schooling_level IN (".$schooling_level_lst.") ";
}
	$sql .= "ORDER BY contract_rank ";
$res = $mysqli->query($sql); #echo $sql;
$cnt = $res->num_rows;

#$res2 = $mysqli->query($sql2); #echo $sql;
#while($data2=$res2->fetch_assoc()){
#	$campus_addr[$data2['school_id']]="〒".$data2['zip1']."-".$data2['zip2']."　".$PREFECTURE[$data2['pref']].$data2['address'];
#}

$p_key_w=str_replace("の",",",$search_title.$search_title2);
$p_key_w=str_replace("][",",",$p_key_w);
$p_key_w=str_replace("[",",",$p_key_w);
$p_key_w=str_replace("]","",$p_key_w);
//メタ情報
$PAGE_TITLE=$search_title.$search_title2."で検索";
$PAGE_DESCRIPTION=$search_title.$search_title2."で検索した結果の通信制高校一覧です。";
$PAGE_KEYWORDS=$p_key_w;

?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./../00_meta.php");
?>
</head>
<body>
<script>
(function($) {
    $(function() {
        var $header = $('#header_con');
        // Nav Toggle Button
        $('#nav-toggle').click(function(){
            $header.toggleClass('open');
        });
    });
})(jQuery);
</script>
<?
//ヘッダーパーツ を取り込む
include_once("./../00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<a href="/search/">学校を探す</a><?if($AREA[$area_id]){?>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$area_id]?>/"><?=$AREA[$area_id]?></a><?}?><?if($PREFECTURE_E[$pref_id]){?>&nbsp;&gt;&nbsp;<a href="/search/<?=$AREA_E[$area_id]?>/<?=$PREFECTURE_E[$pref_id]?>/"><?=$PREFECTURE[$pref_id]?></a><?}?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$search_title.$search_title2?>で検索</h2>
				<div class="hit_cnt"><span class="hitcnt"><?=$cnt?></span>件</div>
			</div>
<?
while($data=$res->fetch_assoc()){
	$contract_rank = $data['contract_rank'];//	$CONTRACT_RANK_ARY = array("1"=>"フル有料", "5"=>"お試し", "10"=>"無料");
	$path = $uploaddir.$data['school_id']."/thumb.jpg";
	$path2 = $uploaddir.$data['school_id']."/thumb.png";
	if (file_exists($path)) {
		$thumb_path = $uploaddir2.$data['school_id']."/thumb.jpg";
	} elseif (file_exists($path2)) {
		$thumb_path = $uploaddir2.$data['school_id']."/thumb.png";
	} else {
		$thumb_path = $uploaddir2."no_thumb.jpg";
	}

?>
			<section id="result_lst">
				<article class="result_school">
					<?if($contract_rank==10){//無料校?>
					<div class="sc_data_f">
						<?=$ESTABLISH_TYPE_ARY[$data['establish_type']]?> / <?=$SCHOOL_TYPE_ARY[$data['school_type']]?>
						<h3><?=$data['school_name']?></h3>
						<p><?="〒".$data['zip1']."-".$data['zip2']."　".$PREFECTURE[$data['pref']].$data['address']?></p>
					</div>
					<?}else{//フル有料・お試し?>
					<a href="/school/<?=$data['school_id']?>/" class="thumb"><img src="<?=$thumb_path?>" alt="<?=$data['school_name']?>" /></a>
					<div class="sc_data">
						<?=$ESTABLISH_TYPE_ARY[$data['establish_type']]?> / <?=$SCHOOL_TYPE_ARY[$data['school_type']]?>
						<a href="/school/<?=$data['school_id']?>/"><h3><?=$data['school_name']?></h3></a>
						<p><?=$data['catch_copy']?></p>
						<div class="pr_txt"><?=nl2br($data['pr_txt'])?></div>
						<?if(strlen($data['many_from'])){?><div class="tg_area_txt">【入学者の多い地域】<?=$data['many_from']?></div><?}?>
					</div>
					<div class="entry_unit">
						<div>
							<?if(is_array($sc_lst)&&in_array($data['school_id'],$sc_lst)){?>
							<div class="add_lst_btn2">検討中</div>
							<?}else{?>
							<a href="/add_watch_list.html?school_id=<?=$data['school_id']?>" class="add_lst_btn">検討中リストに追加</a>
							<?}?>
							<a href="/entry.html?school_id=<?=$data['school_id']?>" class="entry_btn">資料を請求する</a>
							<?if(count($EVENT_DATA_LST[$data['school_id']])>0){?>
							<a href="/school/<?=$data['school_id']?>/opencampus/" class="ev_entry_btn">オープンキャンパス/説明会</a>
							<?}?>
						</div>
					</div>
					<?}?>
				</article>
			</section>
<?
}
?>
		</article>
<?
//サイドパーツ を取り込む
include_once("./../00_aside.php");
?>
	</main>
<?
//フッターパーツ を取り込む
include_once("./../00_footer.php");
?>
</body>
</html>
