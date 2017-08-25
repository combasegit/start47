<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="進学コンシェルジュ";
$PAGE_DESCRIPTION="進学コンシェルジュに、ご相談ください。";
$PAGE_KEYWORDS="進学,コンシェルジュ,相談,質問,".SET_META_KEYWORDS_S;

$CONCIERGE_ASK_KIND=array('sel'=>"学校の選び方",'fee'=>"学費の事",'scl'=>"登校・通学に関して",'tgs'=>"具体的な学校について質問",'oth'=>"その他");

if($_REQUEST["mode"]){
	$mode=$_REQUEST["mode"];
}else{
	$mode=1;
}
$img_num=1;//画像デフォ

if($mode==1){
	$voice="こんにちは。今日は、どのようなご相談でしょうか？";
}elseif($mode==2){
	$ask_kind=$_REQUEST["ask_kind"];
	$voice="かしこまりました。".$CONCIERGE_ASK_KIND[$ask_kind]."のご相談という事ですね。<br />";
	$voice.="それでは、まずあなたの事を教えてください。";
}elseif($mode==3){
	$ask_kind=$_REQUEST["ask_kind"];
	$name=$_REQUEST["name"];
	$email=$_REQUEST["email"];
	$email2=$_REQUEST["email2"];
	$age=$_REQUEST["age"];
	//チェック
	$ary = array(array("empty"),
		 		array("NGchar"),
			array("maxZen", 30));
	$chk = new CheckError($name, "お名前", $ary);
	if (strlen($chk->checkErrorAll())) {
		 $err[name] = 1;
		 $errmsg[name] = $chk->checkErrorAll();
	}
	$ary = array(array("empty"),
		 		array("email"));
	$chk = new CheckError($email, "メールアドレス", $ary);
	if (strlen($chk->checkErrorAll())) {
		 $err[email] = 1;
		 $errmsg[email] = $chk->checkErrorAll();
	}
	$chk = new CheckError($email2, "メールアドレス2", $ary);
	if (strlen($chk->checkErrorAll())) {
		 $err[email2] = 1;
		 $errmsg[email2] = $chk->checkErrorAll();
	}
	if($email!=$email2){
		 $err[email2] = 1;
		 $errmsg[email2] .= "メールアドレスと確認用アドレスが異なります。<br />";
	}
	$ary = array(array("empty"),
		 		array("num"));
	$chk = new CheckError($age, "年齢", $ary);
	if (strlen($chk->checkErrorAll())) {
		 $err[age] = 1;
		 $errmsg[age] = $chk->checkErrorAll();
	}
	if(is_array($err)){
		$mode=2;
		$voice=$name."様、申し訳ありません。送信いただきました情報にエラーがあるようです。".$CONCIERGE_ASK_KIND[$ask_kind]."のご相談で承っておりますが、もう一度あなたの事を教えてください。";
	}else{
		$voice=$name."様、宜しくお願いいたします。<br />";
		$voice.="それでは、具体的なご相談内容を教えていただけますか？";
	}
	
}elseif($mode==4){
	$ask_kind=$_REQUEST["ask_kind"];
	$name=$_REQUEST["name"];
	$email=$_REQUEST["email"];
	$email2=$_REQUEST["email2"];
	$age=$_REQUEST["age"];
	$ask_content=$_REQUEST["ask_content"];
	//チェック
	$ary = array(array("empty"),
		 		array("NGchar"),
			array("maxZen", 3000));
	$chk = new CheckError($ask_content, "ご相談内容", $ary);
	if (strlen($chk->checkErrorAll())) {
		 $err[ask_content] = 1;
		 $errmsg[ask_content] = $chk->checkErrorAll();
	}
	if(is_array($err)){
		$mode=3;
		$voice=$name."様、申し訳ありません。送信いただきました情報にエラーがあるようです。もう一度ご相談内容を教えてください。";
	}else{
		$img_num=2;//画像お辞儀に変更
		$voice=$name."様、内容かしこまりました。<br />";
		$voice.="それでは、ご相談内容について情報をおまとめして、後ほどメールにてお返事を送らせていただきます。今しばらくお待ちください。<br />ご相談、ありがとうございました。";

			//DB書き込み
			$up_sql = "INSERT INTO dtb_concierge_ask (ask_kind, ask_name, ask_email, ask_age, ask_content, insert_date)
								 VALUES ('$ask_kind','$name','$email','$age','$ask_content',now()) ";
			if(!( $up_res = $mysqli->query($up_sql))){
				$mode=3;
				$voice=$name."様、申し訳ありません。DBの書き込みに失敗しました。もう一度ご相談内容を教えてください。";
			}else{
				//IP取得
				if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])
				&& ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$_SERVER['HTTP_X_FORWARDED_FOR'])){
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				}else{
					$ip = $_SERVER["REMOTE_ADDR"];
				}
				//USER_AGENT
				$user_agent = $_SERVER["HTTP_USER_AGENT"];

				//メール送信＜管理者向け＞
				$subject  = "■コンシェルジュ発生■　";
				$content  = "コンシェルジュ問合せがありました。\r\n";
				$content .= "---------------------------------------\r\n";
				$content .= "お名前　：".$name."　様\r\n";
				$content .= "　年齢　：".$age."　歳\r\n";
				$content .= "E-mail　：".$email."\r\n";
				$content .= "相談種類：".$CONCIERGE_ASK_KIND[$ask_kind]."\r\n";
				$content .= "【相談内容】\r\n";
				$content .= $ask_content."\r\n";
				$content .= "---------------------------------------\r\n";
				$content .= "【アクセス情報】\r\n";
				$content .= "IP：".$ip."\r\n";
				$content .= "UA：".$user_agent."\r\n";
				$content .= "---------------------------------------\r\n";
				$content .= SET_SITE_TITLE_S."\r\n";
				$content .= SET_SITE_URL;
				#send_mail(SET_SITE_MAIL, $subject, $content, $email, $name, SET_SITE_MAIL);
				send_mail('arai@combase.jp', $subject, $content, $email, $name, SET_SITE_MAIL);
				
				$fin=1;
			}
	}

}
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
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<a href="./">進学コンシェルジュ</a>&nbsp;&gt;&nbsp;相談する
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
			</div>
			<section id="concierge_box">
				<div class="concierge">
					<img src="/img/concierge/<?=$img_num?>.png" alt="進学コンシェルジュ" />
					<div class="concierge_voice">
						<p><?=$voice?></p>
<?
if($fin!=1){
?>
						<form action="ask.html" name="ask" method="post">
						<input type="hidden" name="mode" value="<?=$mode+1?>" />
						<input type="hidden" name="ask_kind" value="<?=$ask_kind?>" />
						<input type="hidden" name="name" value="<?=$name?>" />
						<input type="hidden" name="email" value="<?=$email?>" />
						<input type="hidden" name="age" value="<?=$age?>" />
<?if($mode==1){?>
						<select name="ask_kind" onchange="submit(this.form)">
								<option>選択</option>
							<?foreach($CONCIERGE_ASK_KIND as $k=>$val){?>
								<option value="<?=$k?>"><?=$val?></option>
							<?}?>
						</select>
<?}elseif($mode==2){?>
						お名前：<input type="text" name="name" value="<?=$name?>" placeholder="例）通信はじめ" /><br />
						<?if($err[name]!=0){echo "<span class=\"red\">".$errmsg[name]."</span>";}?>
						メール：<input type="text" name="email" value="<?=$email?>" placeholder="例）info@start47.com" /><br />
						<?if($err[email]!=0){echo "<span class=\"red\">".$errmsg[email]."</span>";}?>
						(確認)：<input type="text" name="email2" value="<?=$email?>" placeholder="例）info@start47.com" /><br />
						<?if($err[email2]!=0){echo "<span class=\"red\">".$errmsg[email2]."</span>";}?>
						年　齢：<input type="text" name="age" value="<?=$age?>" maxlength="2" style="width:30px;" />歳<br />
						<?if($err[age]!=0){echo "<span class=\"red\">".$errmsg[age]."</span>";}?>
						<button type="submit" name="submit" value="submit" class="btn_entry">送信</button>
<?}elseif($mode==3){?>
						ご相談内容：<br />
						<textarea name="ask_content" placeholder="ご相談内容は必須です"><?=$ask_content?></textarea><br />
						<?if($err[ask_content]!=0){echo "<span class=\"red\">".$errmsg[ask_content]."</span>";}?>
						<button type="submit" name="submit" value="submit" class="btn_entry">送信</button>
<?}?>
						</form>
<?}?>
					</div>
				</div>
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
