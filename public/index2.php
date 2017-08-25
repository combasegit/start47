<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
//メニューホバー及びslick.js用
$TOP_FLAG=1;
//画像アップフォルダ
$uploaddir = './school_img/';

//フィーチャー校一覧（4校）取得
$fs_sql = "SELECT m.school_id,m.school_name FROM mtb_school AS m, dtb_feature_school AS fs WHERE fs.school_id = m.school_id ";
$fs_sql .= "ORDER BY rand() LIMIT 0,4 ";
$fs_res = $mysqli->query($fs_sql);

//お知らせ一覧取得
$n_sql = "select n.*, s.school_name from dtb_school_news as n, mtb_school as s where n.school_id = s.school_id AND n.del_flag = '0' AND s.del_flag = '0' ORDER BY n.news_date DESC ";
$n_res = $mysqli->query($n_sql);


?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
		xmlns:fb="http://www.facebook.com/2008/fbml"
		xml:lang="ja" lang="ja">
<head>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
<script type="text/javascript">
$(document).ready(function(){
    $('.bxslider').bxSlider({
    auto: true,//自動切り替えの有無
    prevText: '前へ', //前へのテキスト
    nextText: '次へ' //次へのテキスト
    });
  });
</script>
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
	<div id="main_visual">
		<div id="inner_box">
			<div id="main_visual_contents">
				<div id="black_bord">
					<h2>保護者のみなさまへ</h2>
					<p>
						お子様の進路を一緒に考えましょう。
						通信制高校は、お子様に合った「最適値」で選ぶのが正しい選択だと考えます。
						学校選びを誤ると退学してしまう事も・・。
						どんな状況でもあきらめず、早まらず、一度立ち止まって欲しいと思います。
					</p>
					<div id="msg">（お子様の現状+目的+目標）×（お子様の生活スタイル）＝最適値の高いお子様に合う学校！</div>
				</div>
				<div id="slider">
					<div id="img_box">
						<ul class="bxslider">
							<li><img src="./img/slider/01.jpg" alt="親子で探すあなたにピッタリの通信制高校" /></li>
							<li><img src="./img/slider/01.jpg" alt="親子で探すあなたにピッタリの通信制高校" /></li>
							<li><img src="./img/slider/01.jpg" alt="親子で探すあなたにピッタリの通信制高校" /></li>
						</ul>
					</div>
				</div>
				<div id="banner_box">
					<a href="/first/" class="bn01"><img src="./banner/01.png" alt="初めての方は、まずこちらから" /></a>
					<a href="/concierge/" class="bn02"><img src="./banner/02.png" alt="通信制高校進学に関するご相談は「進学コンシェルジュ」まで" /></a>
				</div>
			</div>
		</div>
	</div>
	<div id="row_unit_01">
		<div id="u01_left_box">
			<h2>エリアから探す</h2>
			<a href="/search/all/"><img src="./img/jp_map.png" alt="日本地図から探す" /></a>
		</div>
		<div id="u01_center_box">
			<h2>学校からのお知らせ</h2>
			<a href="" class="lnk2lst">一覧を見る</a>
			<div id="news_lst">
				<?
				while($n_data = $n_res->fetch_assoc()){
					$n_date_ary = explode('-',$n_data[news_date]);
				?>
				<article>
					<a href="/school/<?=$n_data[school_id]?>/news/detail_<?=$n_data[news_id]?>.html">
						<div class="news_data">
							<div class="date"><?=$n_date_ary[0]?>年<br class="only_sp"/><?=$n_date_ary[1]?>月<?=$n_date_ary[2]?>日</div>
							<div class="cate"><?=$n_data[school_name]?></div>
						</div>
						<div class="news_content">
							<div class="ttl"><?=$n_data[news_title]?></div>
							<p><?=$n_data[news_txt]?></p>
						</div>
					</a>
				</article>
				<?}?>
			</div>
		</div>
		<div id="u01_right_box">
			<h2>特色から探す</h2>
			<ul>
				<li><a href=""><img src="./img/btn/characteristic_01.gif" alt="資格取得" /></a></li>
				<li><a href=""><img src="./img/btn/characteristic_02.gif" alt="クラブ活動" /></a></li>
			</ul>
		</div>
	</div>
	<div id="row_unit_02">
		<div class="row_unit_inner">
			<h2>通信制高校紹介</h2>
			<a href="" class="lnk2lst">一覧を見る</a>
			<?
				while($fs_data = $fs_res->fetch_assoc()){
					$path = $uploaddir.$fs_data['school_id']."/thumb.jpg";
					$path2 = $uploaddir.$fs_data['school_id']."/thumb.png";
					if (file_exists($path)) {
						$thumb_path = $path;
					} elseif (file_exists($path2)) {
						$thumb_path = $path2;
					} else {
						$thumb_path = $uploaddir."no_thumb.jpg";
					}

			?>
			<dl>
				<dt><a href="/school/<?=$fs_data['school_id']?>/"><img src="<?=$thumb_path?>" alt="<?=$fs_data['school_name']?>" /></a></dt>
				<dd><a href="/school/<?=$fs_data['school_id']?>/"><?=$fs_data[school_name]?></a></dd>
			</dl>
			<?}?>
		</div>
	</div>
	<div id="row_unit_03">
		<h2>特集</h2>
		<a href=""><img src="./banner/sp_01.png" alt="不安を一緒に解消しましょう" /></a>
		<a href=""><img src="./banner/sp_02.png" alt="通信制高校って？" /></a>
		<a href=""><img src="./banner/sp_03.png" alt="失敗しない通信制高校の選び方" /></a>
		<!--
		<a href=""><img src="./banner/sp_04.png" alt="どうやって学習するの？" class="ls" /></a>
		<a href=""><img src="./banner/sp_05.png" alt="ちゃんと卒業できる？" /></a>
		<a href=""><img src="./banner/sp_06.png" alt="卒業後は？" /></a>
		<a href=""><img src="./banner/sp_07.png" alt="卒業までにいくらかかる？" /></a>-->
	</div>
<?
//フッターパーツ を取り込む
include_once("./00_footer.php");
?>
</body>
</html>
