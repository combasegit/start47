	<footer>
		<div id="foot_unit_01">
		
		</div>
		<div id="foot_unit_02">
			<div id="foot_unit_02_wrap">
			<?for($i=1;$i<=4;$i++){?>
				<div class="foot_area_lst">
					<ul>
						<?
							for($a=(1+($i-1)*2);$a<=(2+($i-1)*2);$a++){
								if($a == 8){
									$a_min= 40;
									$a_max= 47;
								}elseif($a == 7){
									$a_min= 36;
									$a_max= 39;
								}elseif($a == 6){
									$a_min= 31;
									$a_max= 35;
								}elseif($a == 5){
									$a_min= 25;
									$a_max= 30;
								}elseif($a == 4){
									$a_min= 21;
									$a_max= 24;
								}elseif($a == 3){
									$a_min= 15;
									$a_max= 20;
								}elseif($a == 2){
									$a_min= 8;
									$a_max= 14;
								}else{
									$a_min= 1;
									$a_max= 7;
								}
						?>
						<li>
							<a href="/search/<?=$AREA_E[$a]?>/" class="area"><?=$AREA[$a]?>エリアの通信制高校</a>
							<ul>
							<?
							for($b=$a_min;$b<=$a_max;$b++){
							?>
							<li class="pref">
								<a href="/search/<?=$AREA_E[$a]?>/<?=$PREFECTURE_E[$b]?>/"><?=$PREFECTURE[$b]?>の通信制高校</a>
							</li>
							<?}?>
							</ul>
						</li>
						<?}?>
					</ul>
				</div>
			<?}?>
			</div>
		</div>
		<div id="foot_unit_03">
			<div class="foot_unit_inner">
				<ul>
					<li><a href="/sitemap.html">サイトマップ</a></li>
					<li><a href="/about_us.html">当サイトについて</a></li>
					<li><a href="/privacy.html">個人情報保護方針</a></li>
					<li><a href="/company.html">運営会社</a></li>
				</ul>
				<address><?=SET_COPYRIGHT?></address>
			</div>
		</div>
	</footer>
	<div id="footerMenu">
		<div class="content-wrap">
			<div class="cart_box">
				<a href="/watch_list.html" class="ttl"><p>検討中の学校を一覧で比較する</p></a>
				<div class="con">
					<div class="txt01">現在検討中の学校は</div>
					<div class="txt02"><?=$wl_cnt_txt?></div>
				</div>
			</div>
			<div class="concierge_box">
				<p>通信制高校の進学についてのご相談なら</p>
				<a href="/concierge/">進学コンシェルジュ</a>
				<img src="/img/concierge.png" alt="通信制高校進学コンシェルジュ" />
			</div>
		</div>
	</div>
	<script type="text/javascript" src="<?=SET_ROOT_DIR?>/js/jquery.footerMenu.js"></script>
	<script>
		$("body").footerMenu();
	</script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-104185041-1', 'auto');
  ga('send', 'pageview');

</script>