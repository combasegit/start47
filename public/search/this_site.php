<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$p=$_GET['p'];
if(strlen($p)){
	//検索ロジック******************************************
	$sql = "SELECT s.*, c.* FROM mtb_school AS s, mtb_campus as c WHERE s.del_flag = '0' AND c.del_flag = '0' AND s.school_id = c.school_id AND s.show_flag = '1' ";
	$sql .= "AND (s.school_name LIKE '%".$p."%' || s.catch_copy LIKE '%".$p."%' || s.pr_txt LIKE '%".$p."%' || c.campus_name LIKE '%".$p."%' || c.address LIKE '%".$p."%' ) ";
	$sql .= "ORDER BY contract_rank ";
	$res = $mysqli->query($sql); #echo $sql;
	$cnt = $res->num_rows;
}else{
	$err=1;
}
//メタ情報
$PAGE_TITLE="サイト内検索「".$p."」";
$PAGE_DESCRIPTION="当サイト内で「".$p."」というキーワードが使われてるページの一覧です。";
$PAGE_KEYWORDS=$p.",検索";

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

//ロード時
$(function(){
		var aid = $("#area_id option:selected").val();
		jQuery . ajax(
			'./pref_data_back.php',
			{
				data: {
					area_id: aid
				},
				success: function( data ) {
					jQuery( '#pref_data_box' ) . html( data );
				},
			}
		);
});

$(function(){
	$("#area_id").change(function(){
		var aid = $("#area_id option:selected").val();
		jQuery . ajax(
			'./pref_data_back.php',
			{
				data: {
					area_id: aid
				},
				success: function( data ) {
					jQuery( '#pref_data_box' ) . html( data );
				},
			}
		);
	});
});
</script>
<?
//ヘッダーパーツ を取り込む
include_once("./../00_header.php");
?>
	<main>
		<div class="bread_list">
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;サイト内検索：『<?=$p?>』にて検索
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2>サイト内検索『<?=$p?>』にて検索</h2>
				<?if($err!=1){?><div class="hit_cnt"><span class="hitcnt"><?=$cnt?></span>件</div><?}?>
			</div>
<?if($err==1){?>
			<p>キーワードを入れて検索してください。</p>
<?}else{
while($data=$res->fetch_assoc()){
	$contract_rank = $data['contract_rank'];//	$CONTRACT_RANK_ARY = array("1"=>"フル有料", "5"=>"お試し", "10"=>"無料");
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
					<div class="sc_data">
						<?=$ESTABLISH_TYPE_ARY[$data['establish_type']]?> / <?=$SCHOOL_TYPE_ARY[$data['school_type']]?>
						<a href="/school/<?=$data['school_id']?>/"><h3><?=$data['school_name']?></h3></a>
						<p><?=$data['catch_copy']?></p>
						<div><?=$data['pr_txt']?></div>
						<?if(strlen($data['many_from'])){?><div class="tg_area_txt">【入学者の多い地域】<?=$data['many_from']?></div><?}?>
					</div>
					<?}?>
				</article>
			</section>
<?
}
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
