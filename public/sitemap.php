<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");
//画像アップフォルダ
$uploaddir = './school_img/';
$uploaddir2 = '/school_img/';

$PAGE_TITLE="サイトマップ";
$PAGE_DESCRIPTION="当サイトのサイトマップをご案内いたします。";
$PAGE_KEYWORDS="サイトマップ,".SET_META_KEYWORDS_S;

	
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
			</div>
			<section class="contents_txt">
				<ul class="sitemap">
					<li>
						<a href="/search/">学校を探す</a>
						<ul>
							<li>
								<a href="/search/hokkaido_tohoku/" class="area">北海道・東北エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/hokkaido_tohoku/hokkaido/">北海道</a></li>
									<li><a href="/search/hokkaido_tohoku/aomori/">青森</a></li>
									<li><a href="/search/hokkaido_tohoku/iwate/">岩手</a></li>
									<li><a href="/search/hokkaido_tohoku/miyagi/">宮城</a></li>
									<li><a href="/search/hokkaido_tohoku/akita/">秋田</a></li>
									<li><a href="/search/hokkaido_tohoku/yamagata/">山形</a></li>
									<li><a href="/search/hokkaido_tohoku/fukushima/">福島</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/kanto/" class="area">関東エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/kanto/ibaraki/">茨城</a></li>
									<li><a href="/search/kanto/tochigi/">栃木</a></li>
									<li><a href="/search/kanto/gunma/">群馬</a></li>
									<li><a href="/search/kanto/saitama/">埼玉</a></li>
									<li><a href="/search/kanto/chiba/">千葉</a></li>
									<li><a href="/search/kanto/tokyo/">東京</a></li>
									<li><a href="/search/kanto/kanagawa/">神奈川</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/hokuriku_koshinetsu/" class="area">北陸・甲信越エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/hokuriku_koshinetsu/niigata/">新潟</a></li>
									<li><a href="/search/hokuriku_koshinetsu/toyama/">富山</a></li>
									<li><a href="/search/hokuriku_koshinetsu/ishikawa/">石川</a></li>
									<li><a href="/search/hokuriku_koshinetsu/fukui/">福井</a></li>
									<li><a href="/search/hokuriku_koshinetsu/yamanashi/">山梨</a></li>
									<li><a href="/search/hokuriku_koshinetsu/nagano/">長野</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/tokai/" class="area">東海エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/tokai/gifu/">岐阜</a></li>
									<li><a href="/search/tokai/shizuoka/">静岡</a></li>
									<li><a href="/search/tokai/aichi/">愛知</a></li>
									<li><a href="/search/tokai/mie/">三重</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/kinki/" class="area">近畿エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/kinki/shiga/">滋賀</a></li>
									<li><a href="/search/kinki/kyoto/">京都</a></li>
									<li><a href="/search/kinki/osaka/">大阪</a></li>
									<li><a href="/search/kinki/hyogo/">兵庫</a></li>
									<li><a href="/search/kinki/nara/">奈良</a></li>
									<li><a href="/search/kinki/wakayama/">和歌山</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/chugoku/" class="area">中国エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/chugoku/tottori/">鳥取</a></li>
									<li><a href="/search/chugoku/shimane/">島根</a></li>
									<li><a href="/search/chugoku/okayama/">岡山</a></li>
									<li><a href="/search/chugoku/hiroshima/">広島</a></li>
									<li><a href="/search/chugoku/yamaguchi/">山口</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/shikoku/" class="area">四国エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/shikoku/tokushima/">徳島</a></li>
									<li><a href="/search/shikoku/kagawa/">香川</a></li>
									<li><a href="/search/shikoku/ehime/">愛媛</a></li>
									<li><a href="/search/shikoku/kochi/">高知</a></li>
								</ul>
							</li>
							<li>
								<a href="/search/kyushu_okinawa/" class="area">九州・沖縄エリアの通信制高校</a>
								<ul class="prefs">
									<li><a href="/search/kyushu_okinawa/fukuoka/">福岡</a></li>
									<li><a href="/search/kyushu_okinawa/saga/">佐賀</a></li>
									<li><a href="/search/kyushu_okinawa/nagasaki/">長崎</a></li>
									<li><a href="/search/kyushu_okinawa/kumamoto/">熊本</a></li>
									<li><a href="/search/kyushu_okinawa/oita/">大分</a></li>
									<li><a href="/search/kyushu_okinawa/miyazaki/">宮崎</a></li>
									<li><a href="/search/kyushu_okinawa/kagoshima/">鹿児島</a></li>
									<li><a href="/search/kyushu_okinawa/okinawa/">沖縄</a></li>
								</ul>
							</li>
						</ul>
					</li>
					<li>
						<a href="/first/">初めての方へ</a>
						<ul>
							<li><a href="/first/relieve_concern.html">不安を一緒に解決しましょう</a></li>
						</ul>
					</li>
					<li><a href="/about/">通信制高校とは</a></li>
					<li><a href="/howto/">学校の選び方</a></li>
					<li><a href="/expense/">学費について</a></li>
					<li><a href="/after_graduation/">卒業後について</a></li>
					<li><a href="/about_us.html">当サイトについて</a></li>
					<li><a href="/privacy.html">個人情報保護方針</a></li>
					<li><a href="/company.html">運営会社</a></li>
					<li><a href="/concierge/">進学コンシェルジュ</a></li>
					<li>
						<a href="/support/">Ｑ＆Ａ・お問合せ</a>
						<ul>
							<li><a href="/support/faq.html">よくあるご質問</a></li>
							<li><a href="/support/contact.html">お問合せ</a></li>
						</ul>
					</li>
				</ul>
			</section>
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
