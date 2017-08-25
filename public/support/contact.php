<?
//inc.php を取り込む
include_once("./../inc/inc.php");
//sess.php を取り込む
include_once("./../inc/sess.php");

$PAGE_TITLE="お問合せ";
$PAGE_DESCRIPTION="当サイトに関するご質問は、こちらのページからお願いいたします。";
$PAGE_KEYWORDS="お問合せ,フォーム,".SET_META_KEYWORDS_S;


//確認ボタン押し後
if($_POST["submit"]){
	$name = $_REQUEST["name"];
	$name_kana = $_REQUEST["name_kana"];
	$email = $_REQUEST["email"];
	$email2 = $_REQUEST["email2"];
	$tel = $_REQUEST["tel"];
	$c_type = $_REQUEST["c_type"];
	$comment = $_REQUEST["comment"];
	
	//入力チェック
	// *必須* 名前
	 $ary = array(array("empty"),
				 array("NGchar"),
				 array("maxZen", 20));
	 $chk = new CheckError($name, "名前", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	// *必須* ふりがな
	 $ary = array(array("empty"),
				 array("NGchar"),
				 array("hkana"),
				 array("maxZen", 20));
	 $chk = new CheckError($name_kana, "ふりがな", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	//*必須* メールアドレス
	 $ary = array(array("email"),
				 array("empty"),
				 array("NGchar"),
				 array("max", 100));
	 $chk = new CheckError($email, "メールアドレス", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	 $chk = new CheckError($email2, "メールアドレス(確認用)", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	 if($email!=$email2){
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>メールアドレスが確認用と異なります</li>";
	 }
	// 電話番号 
	 $ary = array(array("han"),
				array("NGchar"));
	 $chk = new CheckError($tel, "電話番号", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	//お問合せ内容
	 $ary = array(array("NGchar"),
	 			 array("empty"),
				 array("maxZen", 1000));
	 $chk = new CheckError($comment, "お問合せ内容", $ary);
	 if (strlen($chk->checkErrorAll())) {
	 	 $err = 1;
	 	 $errmsg = $errmsg . "<li>".$chk->checkErrorAll()."</li>";
	 }
	 
	//IP取得
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])
	&& ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	//USER_AGENT
	$user_agent = $_SERVER["HTTP_USER_AGENT"];

	//すべての入力項目に誤りが無ければメール送信
	if($err==""){
			//メール送信＜サンキュー＞
			$subject  = "お問合せ完了";
			$content  = $name . "様"."\r\n\r\n";
			$content .= "お問合せありがとうございました。\r\n";
			$content .= "下記の内容でお問合せを受け付けました。\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= "お名前　：".$name."　様\r\n";
			$content .= "E-mail　：".$email."\r\n";
			$content .= "電話番号：".$tel."\r\n";
			$content .= "問合せ種類：".$contact_type[$c_type]."\r\n";
			$content .= "【お問合せ内容】\r\n";
			$content .= $comment."\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= "数日以内に担当者よりご連絡差し上げますので\r\n";
			$content .= "今しばらくお待ち下さい。\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= SET_SITE_TITLE."\r\n";
			$content .= SET_SITE_URL;
			send_mail($email, $subject, $content, SET_SITE_MAIL, SET_SITE_TITLE_S, SET_SITE_MAIL);

			//メール送信＜管理者向け＞
			$subject  = "■HPお問合せ発生■　";
			$content  = "HPよりお問合せがありました。\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= "お名前　：".$name."　様\r\n";
			$content .= "E-mail　：".$email."\r\n";
			$content .= "電話番号：".$tel."\r\n";
			$content .= "問合せ種類：".$contact_type[$c_type]."\r\n";
			$content .= "【お問合せ内容】\r\n";
			$content .= $comment."\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= "【アクセス情報】\r\n";
			$content .= "IP：".$ip."\r\n";
			$content .= "UA：".$user_agent."\r\n";
			$content .= "---------------------------------------\r\n";
			$content .= SET_SITE_TITLE_S."\r\n";
			$content .= SET_SITE_URL;
			#send_mail(SET_SITE_MAIL, $subject, $content, $email, $name, SET_SITE_MAIL);
			send_mail('arai@combase.jp', $subject, $content, $email, $name, SET_SITE_MAIL);

			//完了フラグ立てる
			$ok = 1;
		
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
			<a href="/"><?=SET_SITE_TITLE_S?>TOP</a>&nbsp;&gt;&nbsp;<a href="./">Ｑ＆Ａ・お問合せ</a>&nbsp;&gt;&nbsp;<?=$PAGE_TITLE?>
		</div>
		<article id="main_box">
			<div id="search_title_box">
				<h2><?=$PAGE_TITLE?></h2>
			</div>
			<section class="contents_txt">
				<p>当サイトの内容やご利用についてのご質問は以下のフォームよりお願いいたします。<br />※通信制高校進学に関するご質問でしたら、『<a href="/concierge/">進学コンシェルジュ</a>』をご利用下さい。</p>

				<h3>お問合せフォーム</h3>

<?
if($ok==1){//送信完了
?>
						<div class="ok_cmt">ご入力ありがとうございました。<br />数日以内にご連絡致しますので、今しばらくお待ち下さい。<br />また、１週間しても連絡がない場合には、お手数ですが下記メールアドレスまでご連絡下さい。<br />mail：<a href="mailto:<?=SET_SITE_MAIL?>"><?=SET_SITE_MAIL?></a></div>
<?
}else{
	//エラー表示
	if($err>0){
?>
						<div class="ng_cmt">ご入力ありがとうございます。<br />恐れ入りますが、以下の項目をご確認の上再度ご入力をお願いします。<br /><br />
						<ul><?=$errmsg?></ul>
						</div>
<?
	}
?>
						<p><span class="red">※</span>印は必須項目です。</p>
						<form method="post" action="./contact.html" name="contact_frm" enctype="multipart/form-data">
							<table class="frm01">
								<tr>
									<th>お名前<span class="red">※</span></th>
									<td>
										<input type="text" name="name" value="<?=$name?>" style="ime-mode: active;" required />
									</td>
								</tr>
								<tr>
									<th>ふりがな<span class="red">※</span></th>
									<td>
										<input type="text" name="name_kana" value="<?=$name_kana?>" style="ime-mode: active;" required />
									</td>
								</tr>
								<tr>
									<th>メールアドレス<span class="red">※</span></th>
									<td>
										<input type="email" name="email" value="<?=$email?>" style="ime-mode: disabled;"/>
									</td>
								</tr>
								<tr>
									<th>メールアドレス(確認用)<span class="red">※</span></th>
									<td>
										<input type="email2" name="email2" value="<?=$email2?>" style="ime-mode: disabled;"/>
									</td>
								</tr>
								<tr>
									<th>電話番号</th>
									<td>
										<input type="text" name="tel" value="<?=$tel?>" style="ime-mode: disabled;" />
									</td>
								</tr>
								<tr>
									<th>お問合せの種類<span class="red">※</span></th>
									<td>
										<select name="c_type">
											<?foreach($contact_type as $k=>$val){?>
											<option value="<?=$k?>"<?if($k==$c_type){echo " selected";}?>><?=$val?></option>
											<?}?>
										</select>
									</td>
								</tr>
								<tr>
									<th>お問合せ内容 <span class="red">※</span></th>
									<td>
										<textarea name="comment" class="txt_area"><?=$comment?></textarea>
									</td>
								</tr>
								<tr>
									<td colspan="2" class="submit_btn"><input type="submit" name="submit" value="　　送　信　　" /></td>
								</tr>
							</table>
							<p class="b">注意：ご入力いただきました個人情報は当サイトに関してのみ使用されます。他の機関や組織又は個人の目的で利用することはありません。</p>
						</form>
<?
}
?>

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
