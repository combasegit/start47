<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
//画像アップフォルダ
$uploaddir = './school_img/';
$uploaddir2 = '/school_img/';

$PAGE_TITLE="検討中の学校一覧";
$PAGE_DESCRIPTION="あなたが当サイトで検討中に選択された学校一覧です。";
$PAGE_KEYWORDS="検討,比較,".SET_META_KEYWORDS_S;

//■ウォッチリスト引き出し*************************************
$cookie = "WatchSid"; // Cookieの名前
if(isset($_COOKIE[$cookie])) {
	$sql = "SELECT s.*, c.* FROM mtb_school AS s, mtb_campus as c WHERE s.del_flag = '0' AND c.del_flag = '0' AND s.school_id = c.school_id AND c.sort_id = '0' ";
	$sql .= "AND s.school_id IN (".$_COOKIE[$cookie].") ";
	$res = $mysqli->query($sql); #echo $sql;
	$cnt = $res->num_rows;

}else{
	$err=1;
	$cnt="0";
}


//イベント一覧取得************************************************/
$evt_sql = "select DISTINCT m.* FROM mtb_school_event AS m, dtb_event_date AS d, mtb_school AS s ";
$evt_sql .= "WHERE s.school_id = m.school_id AND m.del_flag = '0' AND s.del_flag = '0' AND m.event_id = d.event_id ";
$evt_res = $mysqli->query($evt_sql);
while($evt_data=$evt_res->fetch_assoc()){
	$EVENT_DATA_LST[$evt_data['school_id']][$evt_data['event_id']]=$evt_data['event_title'];
}



	
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
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
include_once("./00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
				<div class="hit_cnt"><span class="hitcnt"><?=$cnt?></span>件</div>
			</div>
<?
if($cnt<1){
?>
			<p>現在検討中の学校は、ございません。</p>
<?}else{
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
			<div id="result_lst">
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
						<div><?=$data['pr_txt']?></div>
						<?if(strlen($data['many_from'])){?><div class="tg_area_txt">【入学者の多い地域】<?=$data['many_from']?></div><?}?>
					</div>
					<div class="entry_unit">
						<div>
							<a href="/entry.html?school_id=<?=$data['school_id']?>" class="entry_btn">資料を請求する</a>
							<?if(count($EVENT_DATA_LST[$data['school_id']])>0){?>
							<a href="/school/<?=$data['school_id']?>/opencampus/" class="ev_entry_btn">オープンキャンパス/説明会</a>
							<?}?>
							<a href="/add_watch_list.html?del_scool_id=<?=$data['school_id']?>" class="del_lst_btn">検討中から削除</a>
						</div>
					</div>
					<?}?>
				</article>
			</div>
<?
}
}
?>
		</article>
<?
//サイドパーツ を取り込む
include_once("./00_aside.php");
?>
	</main>
<?
//フッターパーツ を取り込む
include_once("./00_footer.php");
?>
</body>
</html>
