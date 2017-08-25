<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="通信制高校とは？";
$PAGE_DESCRIPTION="通信制高校の制度についてご紹介いたします。";
$PAGE_KEYWORDS="制度,".SET_META_KEYWORDS_S;


	
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
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
			</div>
			<section class="contents_txt">
				<h3>通信制高校とはどういうもの？</h3>
				<h4>高校には、全日制、定時制、通信制があります。</h4>
					<p>定時制高校は夜間や午前など、特定の時間に通学して1日4時限の授業を行います。修学年は最短で3年。
					<br />全日制高校は、主に学年制が多く就学年数は3年です。1年生に決められた単位を取得したら2年生に。2年生の単位を取得したら3年生に進級します。
					<br />通信制高校の多くは単位制です。新卒で入学した場合、卒業までに74単位を取得すれば卒業できます。全日制高校と同様に3年で卒業が主流となっています。
					<br />全日制高校と異なるのが、留年がないことです。3年間で74単位を取得すればよいので、1年生で単位不足だったとしても2年に進級し、2年生で1年生の単位分を補うこともできるのです。通信制高校は、課題の添削（レポート）、面接指導（学校でスクーリング）、試験（テスト）などを通じて単位を取得していきます。
				</p>
				<h3>単位制と学年制</h3>
				<h4>全日制高校と通信制高校の大きな違いの一つが、通信制高校が採用している「単位制」というシステムです。</h4>
				<p>全日制高校でも「単位の取得」がありますが、全日制高校は「学年制」で、高校1年生で取得する
					<br />単位は1年生のうちに取得しなければなりません。単位を取得できない場合は、高校2年生に進級できず留年となります。一方単位制は、3年間のあいだに74単位を取得すればよいので、留年することはありません。
					<br />全日制高校で留年して友達より卒業年度が遅れてしまうのが嫌だという理由で、通信制高校に転校する人もいます。
				</p>
				<h3>公立通信制高校と私立通信制高校の違い</h3>
				<h4>高卒資格を取得する目的は同じです。</h4>
				<p>通信制高校の卒業者数をみると、私立高校の在籍者が多くなっており、年々増えている傾向にあります。
					<br />学費だけで比較すると公立高校の方が安いのですが、学習環境や高校卒業までのトータル的なサポート体制など私立校が手厚くなっています。
					<br />そのせいもあり、公立の通信制高校よりも、私立の通信制高校の卒業率の方が高くなっていいます。
				</p>
				<table class="aboutTable">
					<tr>
						<th></th>
						<td class="title">公立通信制高校</td>
						<td class="title">私立通信制高校</td>
					</tr>
					<tr>
						<th>学費</th>
						<td>1単位500～1,000円程度</td>
						<td>1単位8,000円～10,000円程度</td>
					</tr>
					<tr>
						<th>登校</th>
						<td>月数回決められて日に登校</td>
						<td>登校日は調整が可能</td>
					</tr>
					<tr>
						<th>勉強方法</th>
						<td>自己管理のもと自習が基本</td>
						<td>学習の苦手な人にも個別に指導</td>
					</tr>
					<tr>
						<th>トータルサポート体制</th>
						<td>サポート体制は私立より劣る</td>
						<td>カウンセラーの対応も</td>
					</tr>
				</table>
				<h3>通信制高校とサポート校の違い</h3>
				<h4>通信制高校とサポート校（通信制サポート校という場合も）は、本来は全く違うものです。</h4>
				<p>通信制高校は学校教育法という法律上「高等学校（高校）」であるのに対しサポート校は、通信制高校の
					<br />卒業をサポートする機関で、予備校のような位置づけです。
					<br />サポート校が通信制高校の運営母体のケースもあり、指定サポートキャンパスなどの表記をしています。
					<br />（このサイトでは、学校情報欄に「通信制高校」「サポート校」を明記しています。）
				</p>
				<table class="aboutTable">
					<tr>
						<th></th>
						<td class="title">高校卒業資格</td>
						<td class="title">費用</td>
					</tr>
					<tr>
						<th>通信制高校</th>
						<td>○</td>
						<td>通信制高校の学費のみ</td>
					</tr>
					<tr>
						<th>サポート校</th>
						<td>通信制高校卒業で取得</td>
						<td>通信制高校+サポート校の費用</td>
					</tr>
				</table>
				<h3>入学条件は？</h3>
				<h4>通信制高校は、中学校を卒業していれば年齢に関係なく、誰でも入学することができます。</h4>
				<p>ただし、入学可能な都道府県は学校ごとに異なります。（このサイトでは、学校情報欄に入学可能な都道府県を記載しています。）また、高校を卒業している方は入学できません。</p>
				<h3>入学時期はいつですか？</h3>
				<p>通常は4月入学ですが、前期・後期制で4月と10月に設けられている学校もあります。また、4期制で4月、6月、10月、1月に入学可能な学校もあります。学校により異なります。</p>

			</section>
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