<?
//■ウォッチリスト引き出し*************************************
$cookie = "WatchSid"; // Cookieの名前
if(isset($_COOKIE[$cookie])) {
	$sc_lst=explode(",",$_COOKIE[$cookie]);
	$watch_sc_cnt=count($sc_lst);
	$wl_cnt_txt="<strong>".$watch_sc_cnt."</strong>校です";
}else{
	$wl_cnt_txt="まだありません";
}

?>
	<header>
		<div id="header_con">
			<a href="/" id="logo"><img src="/img/logo.png" alt="<?=SET_SITE_TITLE?>" /></a>
			<h1>親子で探す通信制高校探しをサポートするサイト</h1>
			<div id="header_con_box">
				<div class="cart_box">
					<a href="/watch_list.html" class="ttl"><p>検討中の学校を一覧で比較する</p></a>
					<div class="con">
						<div class="txt01">現在検討中の学校は</div>
						<div class="txt02"><?=$wl_cnt_txt?></div>
					</div>
				</div>
				<div class="sub_navi_box">
					<ul>
						<li><a href="/support/">Ｑ＆Ａ・お問合せ</a></li>
						<li><a href="/sitemap.html">サイトマップ</a></li>
					</ul>
				</div>
				<div class="site_search_box">
					<form action="/search/this_site.html" method="GET">
						<input type="text" name="p" value="<?=$p?>" />
						<input type="submit" name="submit" value="サイト内検索">
					</form>
				</div>
			</div>
			<div id="nav-toggle">
				<div>
					<span></span>
					<span></span>
					<span></span>
				</div>
			</div>
			<nav id="global_navi">
				<ul>
					<li class="gn01<?if(stristr($_SERVER['PHP_SELF'], "/search/")||stristr($_SERVER['PHP_SELF'], "/school/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/search/">学校を探す</a></li>
					<li class="gn02<?if(stristr($_SERVER['PHP_SELF'], "/first/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/first/">初めての方へ</a></li>
					<li class="gn03<?if(stristr($_SERVER['PHP_SELF'], "/about/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/about/">通信制高校とは</a></li>
					<li class="gn04<?if(stristr($_SERVER['PHP_SELF'], "/howto/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/howto/">学校の選び方</a></li>
					<li class="gn05<?if(stristr($_SERVER['PHP_SELF'], "/expense/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/expense/">学費について</a></li>
					<li class="gn06<?if(stristr($_SERVER['PHP_SELF'], "/after_graduation/")){echo "_active";}?>"><a href="<?=SET_ROOT_DIR?>/after_graduation/">卒業後について</a></li>
				</ul>
			</nav>
		</div>
	</header>
