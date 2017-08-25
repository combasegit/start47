<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

/*資料請求手続きページ（フォーム）*/

//学校Email配列
$m_sql = "SELECT school_id, school_name, info_email FROM mtb_school WHERE del_flag = '0' ";
$m_res = $mysqli->query($m_sql);
while($m_data = $m_res->fetch_assoc()){
	$SC_DATA_LST[$m_data[school_id]][school_name]=$m_data[school_name];
	if(strlen($m_data[info_email])){
		$SC_DATA_LST[$m_data[school_id]][info_email]=$m_data[info_email];
	}else{
		$SC_DATA_LST[$m_data[school_id]][info_email]="hiro@acsel-ltd.co.jp";//なければ、元柏さんEメール
	}
}

//資料請求先学校リスト
$entry_list = $_SESSION['entry_list'];
#print_r($entry_list);

if($_REQUEST["mode"]=="fin"){
	$mode="fin";
	
	
}else{
	if(!is_array($entry_list)){
		$err=1;
	}else{
		//初期値
		$client_kind_id=1;
		$sex=1;
		$sc_info_mail=1;
		
		//ボタン押し後
		if($_REQUEST["check"]){
			//データ受け取り
			$client_kind_id=$_REQUEST["client_kind_id"];
			$client_name=$_REQUEST["client_name"];
			$client_name_kana=$_REQUEST["client_name_kana"];
			$age=$_REQUEST["age"];
			$grade=$_REQUEST["grade"];
			$sex=$_REQUEST["sex"];
			$email=$_REQUEST["email"];
			$email2=$_REQUEST["email2"];
			$zip1=$_REQUEST["zip1"];
			$zip2=$_REQUEST["zip2"];
			$pref=$_REQUEST["pref"];
			$addr=$_REQUEST["addr"];
			$tel=$_REQUEST["tel"];
			$entry_note=$_REQUEST["entry_note"];
			$sc_info_mail=$_REQUEST["sc_info_mail"];
			
			//入力チェック
			$ary = array(array("empty"),
				 		array("NGchar"),
					array("maxZen", 30));
			$chk = new CheckError($client_name, "お名前", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[client_name] = 1;
				 $errmsg[client_name] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("NGchar"),
					array("maxZen", 50));
			$chk = new CheckError($client_name_kana, "ふりがな", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[client_name_kana] = 1;
				 $errmsg[client_name_kana] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("num"));
			$chk = new CheckError($age, "年齢", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[age] = 1;
				 $errmsg[age] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"));
			$chk = new CheckError($grade, "学年など", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[grade] = 1;
				 $errmsg[grade] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("email"));
			$chk = new CheckError($email, "メールアドレス", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[email] = 1;
				 $errmsg[email] = $chk->checkErrorAll();
			}
			$chk = new CheckError($email2, "確認用アドレス", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[email2] = 1;
				 $errmsg[email2] = $chk->checkErrorAll();
			}
			if($email!=$email2){
				 $err[email2] = 1;
				 $errmsg[email2] .= "メールアドレスと確認用アドレスが異なります。<br />";
			}
			$ary = array(array("empty"),
				 		array("num"),
						array("max", 3));
			$chk = new CheckError($zip1, "郵便番号上3桁", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[zip1] = 1;
				 $errmsg[zip1] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("num"),
						array("max", 4));
			$chk = new CheckError($zip2, "郵便番号下4桁", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[zip2] = 1;
				 $errmsg[zip2] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"));
			$chk = new CheckError($pref, "都道府県", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[pref] = 1;
				 $errmsg[pref] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("NGchar"),
					array("maxZen", 120));
			$chk = new CheckError($addr, "住所", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[addr] = 1;
				 $errmsg[addr] = $chk->checkErrorAll();
			}
			$ary = array(array("empty"),
				 		array("num"),
						array("max", 20));
			$chk = new CheckError($tel, "電話番号", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[tel] = 1;
				 $errmsg[tel] = $chk->checkErrorAll();
			}
			$ary = array(array("NGchar"),
					array("maxZen", 500));
			$chk = new CheckError($entry_note, "備考", $ary);
			if (strlen($chk->checkErrorAll())) {
				 $err[entry_note] = 1;
				 $errmsg[entry_note] = $chk->checkErrorAll();
			}
			
			
			//エラーがなければチェックモードへ
			if(!is_array($err)){
				$mode="check";
			}
		}if($_REQUEST["back_submit"]){
			$mode="";
			//データ受け取り
			$client_kind_id=$_REQUEST["client_kind_id"];
			$client_name=$_REQUEST["client_name"];
			$client_name_kana=$_REQUEST["client_name_kana"];
			$age=$_REQUEST["age"];
			$grade=$_REQUEST["grade"];
			$sex=$_REQUEST["sex"];
			$email=$_REQUEST["email"];
			$email2=$_REQUEST["email2"];
			$zip1=$_REQUEST["zip1"];
			$zip2=$_REQUEST["zip2"];
			$pref=$_REQUEST["pref"];
			$addr=$_REQUEST["addr"];
			$tel=$_REQUEST["tel"];
			$entry_note=$_REQUEST["entry_note"];
			$sc_info_mail=$_REQUEST["sc_info_mail"];
			
		}if($_REQUEST["submit"]){
			$mode="check";
			
			//IP取得
			if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])
			&& ereg('^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$',$_SERVER['HTTP_X_FORWARDED_FOR'])){
				$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
			}else{
				$ip = $_SERVER["REMOTE_ADDR"];
			}
			//USER_AGENT
			$user_agent = $_SERVER["HTTP_USER_AGENT"];
			
			//自動裁番
			$idset_flg = "ng";
			while($idset_flg == "ng"){
				$newid = mkrnd(10); // $newidに10桁の乱数を与える
				$cntsql = "select count(*) as cnt from mtb_client where client_id = '$newid' ";
				$cntres = $mysqli->query($cntsql);
				$cntdata = $cntres->fetch_assoc();
				if($cntdata["cnt"] == 0){
					$idset_flg = "ok";
					$client_id = $newid;
				}
			}
			//データ受け取り
			$client_kind_id=$_REQUEST["client_kind_id"];
			$client_name=$_REQUEST["client_name"];
			$client_name_kana=$_REQUEST["client_name_kana"];
			$age=$_REQUEST["age"];
			$grade=$_REQUEST["grade"];
			$sex=$_REQUEST["sex"];
			$email=$_REQUEST["email"];
			$email2=$_REQUEST["email2"];
			$zip1=$_REQUEST["zip1"];
			$zip2=$_REQUEST["zip2"];
			$pref=$_REQUEST["pref"];
			$addr=$_REQUEST["addr"];
			$tel=$_REQUEST["tel"];
			$entry_note=$_REQUEST["entry_note"];
			$sc_info_mail=$_REQUEST["sc_info_mail"];
			
			//DB書き込み
			$up_sql = "INSERT INTO mtb_client (client_id,client_kind_id,client_name,client_name_kana,age,grade,sex,email,zip1,zip2,pref,addr,tel,entry_note,sc_info_mail,insert_date) 
										VALUES ('$client_id','$client_kind_id','$client_name','$client_name_kana','$age','$grade','$sex','$email','$zip1','$zip2','$pref','$addr','$tel','$entry_note','$sc_info_mail',now()) ";
			if(!$mysqli->query($up_sql)){
				$err0 = 1;#echo $up_sql;
				$errmsg0 = "DBの書き込みに失敗しました。お手数ですが、再度ご入力をお願いします。エラーコード01<br />";
			}else{
				foreach($entry_list as $val){
					$up_sql2 = "INSERT INTO dtb_entry_client_school (client_id,school_id,insert_date) VALUES ('$client_id', '$val', now()) ";
					$res_sql2 = $mysqli->query($up_sql2);
					//学校向けお知らせメール
					$subject  = "START47－資料請求発生";
					$content  = $SC_DATA_LST[$val][school_name]." 様\r\n";
					$content .= "「通信制高校からはじめよう」より資料請求が発生しました。\r\n";
					$content .= "管理画面にログインして、ご対応をお願い致します。\r\n";
					$content .= "---------------------------------------\r\n";
					$content .= "氏　名：".$client_name. "様"."\r\n";
					$content .= "ふりがな：".$client_name_kana. "様"."\r\n";
					$content .= "請求者：".$CLIENT_KIND[$client_kind_id]. "\r\n";
					$content .= "年　齢：".$age."歳\r\n";
					$content .= "学　年：".$GRADE_KIND[$grade]."\r\n";
					$content .= "性　別：".$SEX_ARY[$sex]."\r\n";
					$content .= "Eメール：".$email."\r\n";
					$content .= "郵便番号：〒".$zip1."-".$zip2."\r\n";
					$content .= "都道府県：".$PREFECTURE[$pref]."\r\n";
					$content .= "住　所：".$addr."\r\n";
					$content .= "電　話：".$tel."\r\n";
					$content .= "備　考：\r\n";
					$content .= $entry_note."\r\n";
					if($sc_info_mail==1){
						$content .= "お知らせ配信：希望する\r\n";
					}else{
						$content .= "お知らせ配信：しない\r\n";
					}
					$content .= "---------------------------------------\r\n";
					$content .= "【アクセス情報】\r\n";
					$content .= "IP：".$ip."\r\n";
					$content .= "UA：".$user_agent."\r\n";
					$content .= "---------------------------------------\r\n";
					$content .= "通信制高校からはじめよう【START47】\r\n";
					$content .= SET_SITE_URL."\r\n";
					send_mail($SC_DATA_LST[$val][info_email], $subject, $content, SET_SITE_MAIL, SET_SITE_MASTER, SET_SITE_MAIL);
					send_mail(SET_SITE_MAIL2, $subject, $content, SET_SITE_MAIL, SET_SITE_MASTER, SET_SITE_MAIL);
				}
				//サンクスメール
				$subject  = "資料請求ありがとうございます";
				$content  = $client_name." 様\r\n";
				$content .= "この度は、「通信制高校からはじめよう」をご利用いただき、ありがとうございます。\r\n";
				$content .= "下記の内容にて、資料請求を承りました。\r\n";
				$content .= "---------------------------------------\r\n";
				$content .= "【資料請求先学校】\r\n";
				foreach($entry_list as $val){
					$content .= "・".$SC_DATA_LST[$val][school_name]."\r\n";
				}
				$content .= "---------------------------------------\r\n";
				$content .= "【資料請求者情報】\r\n";
				$content .= "氏　名：".$client_name. "様"."\r\n";
				$content .= "ふりがな：".$client_name_kana. "様"."\r\n";
				$content .= "請求者：".$CLIENT_KIND[$client_kind_id]. "\r\n";
				$content .= "年　齢：".$age."歳\r\n";
				$content .= "学　年：".$GRADE_KIND[$grade]."\r\n";
				$content .= "性　別：".$SEX_ARY[$sex]."\r\n";
				$content .= "Eメール：".$email."\r\n";
				$content .= "郵便番号：〒".$zip1."-".$zip2."\r\n";
				$content .= "都道府県：".$PREFECTURE[$pref]."\r\n";
				$content .= "住　所：".$addr."\r\n";
				$content .= "電　話：".$tel."\r\n";
				$content .= "備　考：\r\n";
				$content .= $entry_note."\r\n";
				if($sc_info_mail==1){
					$content .= "お知らせ配信：希望する\r\n";
				}else{
					$content .= "お知らせ配信：しない\r\n";
				}
				$content .= "---------------------------------------\r\n";
				$content .= "通信制高校からはじめよう【START47】\r\n";
				$content .= SET_SITE_URL."\r\n";
				send_mail($email, $subject, $content, SET_SITE_MAIL, SET_SITE_MASTER, SET_SITE_MAIL);
				send_mail(SET_SITE_MAIL2, $subject, $content, SET_SITE_MAIL, SET_SITE_MASTER, SET_SITE_MAIL);
				//完了したら、サンクスページへ
				header("Location: ./entry_form.html?mode=fin");
				exit;
			}
		}
		
	}

}
?>
<!DOCTYPE html>
<?
//メタ情報 を取り込む
include_once("./00_meta.php");
?>
<script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
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
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;資料請求
		</div>
<?if($mode=="fin"){?>
		<article id="main_box">
			<p>資料請求のお申し込み、ありがとうございました。</p>
			<p>下記学校に対して、資料請求のご連絡をいたしました。<br />
			<?foreach($entry_list as $val){?>
				　・<?=$SC_DATA_LST[$val][school_name]?><br />
			<?}?>
			<br />1週間以内に学校より資料が届くと思いますので、今しばらくお待ち下さい。</p>
			<p>10日を過ぎても資料が届かない場合には、お手数ですが当サイトお問合せフォームよりご連絡下さい。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>	
<?}else{?>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。資料請求先の学校情報の引き出しが出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}else{?>
		<article id="main_box">
			<div id="sc_entry">
				<h3>資料請求情報入力フォーム</h3>
				<form action="entry_form.html" name="entry02" method="post">
<?if($mode=="check"){?>
				<table>
					<tr>
						<th>資料請求をされた方</th>
						<td>
							<?=$CLIENT_KIND[$client_kind_id]?>
							<input type="hidden" name="client_kind_id" value="<?=$client_kind_id?>" />
						</td>
					</tr>
					<tr>
						<th>お名前　<span class="red">(必須)</span></th>
						<td><?=$client_name?><input type="hidden" name="client_name" value="<?=$client_name?>" /></td>
					</tr>
					<tr>
						<th>フリガナ　<span class="red">(必須)</th>
						<td><?=$client_name_kana?><input type="hidden" name="client_name_kana" value="<?=$client_name_kana?>" /></td>
					</tr>
					<tr>
						<th>年齢　<span class="red">(必須)</th>
						<td><?=$age?>歳<input type="hidden" name="age" value="<?=$age?>" /></td>
					</tr>
					<tr>
						<th>学年など　<span class="red">(必須)</th>
						<td><?=$GRADE_KIND[$grade]?><input type="hidden" name="grade" value="<?=$grade?>" /></td>
					</tr>
					<tr>
						<th>性別</th>
						<td><?=$SEX_ARY[$sex]?><input type="hidden" name="sex" value="<?=$sex?>" /></td>
					</tr>
					<tr>
						<th>メールアドレス<br /><span class="red">(必須)</th>
						<td><?=$email?><input type="hidden" name="email" value="<?=$email?>" /></td>
					</tr>
					<tr>
						<th>住所　<span class="red">(必須)</th>
						<td>
							〒<?=$zip1?>&nbsp;-<?=$zip2?><br /><?=$PREFECTURE[$pref]?><?=$addr?>
							<input type="hidden" name="zip1" value="<?=$zip1?>" />
							<input type="hidden" name="zip2" value="<?=$zip2?>" />
							<input type="hidden" name="pref" value="<?=$pref?>" />
							<input type="hidden" name="addr" value="<?=$addr?>" />
						</td>
					</tr>
					<tr>
						<th>電話番号　<span class="red">(必須)</th>
						<td><?=$tel?><input type="hidden" name="tel" value="<?=$tel?>" /></td>
					</tr>
					<tr>
						<th>備考</th>
						<td><?=nl2br($entry_note)?><input type="hidden" name="entry_note" value="<?=$entry_note?>" /></td>
					</tr>
					<tr>
						<th>学校からのお知らせ配信</th>
						<td>
							<?if($sc_info_mail=="1"){echo "希望する";}else{echo "しない";}?>
							<input type="hidden" name="sc_info_mail" value="<?=$sc_info_mail?>" />
						</td>
					</tr>
				</table>
				<div class="buttons">
					<button type="submit" name="back_submit" value="back_submit" class="btn_entry2 fl">内容を修正する</button>
					<button type="submit" name="submit" value="submit" class="btn_entry fr">資料請求する</button>
				</div>
<?}else{?>
				<table>
					<tr>
						<th>資料請求をされた方</th>
						<td>
							<?foreach($CLIENT_KIND as $k=>$val){?>
							<label><input type="radio" name="client_kind_id" value="<?=$k?>" <?if($client_kind_id==$k){echo "checked";}?>/><?=$val?></label>　　
							<?}?>
						</td>
					</tr>
					<tr class="<?if($err[client_name]==1){echo "err_bg";}?>">
						<th>お名前　<span class="red">(必須)</span></th>
						<td><input type="text" name="client_name" value="<?=$client_name?>" size="40" placeholder="通信 太郎" /><?if($err[client_name]==1){echo "<br /><span class=\"esg\">".$errmsg[client_name]."</span>";}?></td>
					</tr>
					<tr class="<?if($err[client_name_kana]==1){echo "err_bg";}?>">
						<th>フリガナ　<span class="red">(必須)</th>
						<td><input type="text" name="client_name_kana" value="<?=$client_name_kana?>" size="40" placeholder="ツウシン　タロウ" /><?if($err[client_name_kana]==1){echo "<br /><span class=\"esg\">".$errmsg[client_name_kana]."</span>";}?></td>
					</tr>
					<tr class="<?if($err[age]==1){echo "err_bg";}?>">
						<th>年齢　<span class="red">(必須)</th>
						<td><input type="text" pattern="\d*" title="半角数字" class="age" name="age" value="<?=$age?>" size="4" maxlength="2" />歳<?if($err[age]==1){echo "<br /><span class=\"esg\">".$errmsg[age]."</span>";}?></td>
					</tr>
					<tr class="<?if($err[grade]==1){echo "err_bg";}?>">
						<th>学年など　<span class="red">(必須)</th>
						<td>
							<select name="grade">
								<option value=""<?if($grade==""){echo " selected";}?>>選択して下さい</option>
<?
	foreach($GRADE_KIND as $k=>$tmp){
?>
								<option value="<?=$k?>"<?if($grade==$k){echo " selected";}?>><?echo $tmp;?></option>
<?
	}
?>
							</select>

						<?if($err[grade]==1){echo "<br /><span class=\"esg\">".$errmsg[grade]."</span>";}?>
						</td>
					</tr>
					<tr>
						<th>性別</th>
						<td>
							<?foreach($SEX_ARY as $k=>$val){?>
							<label><input type="radio" name="sex" value="<?=$k?>" <?if($sex==$k){echo "checked";}?>/><?=$val?></label>　　
							<?}?>
						</td>
					</tr>
					<tr class="<?if($err[email]==1||$err[email2]==1){echo "err_bg";}?>">
						<th>メールアドレス<br /><span class="red">(必須)</th>
						<td>
							<input type="text" name="email" value="<?=$email?>" size="50" style="ime-mode: disabled;" placeholder="例)info@start47.com" /><br />
							<input type="text" name="email2" value="<?=$email2?>" size="50" style="ime-mode: disabled;" placeholder="例)info@start47.com" /><br />
							<p class="red">※確認のため、2度入力してください</p>
							<?if($err[email]==1){echo "<br /><span class=\"esg\">".$errmsg[email]."</span>";}?>
							<?if($err[email2]==1){echo "<br /><span class=\"esg\">".$errmsg[email2]."</span>";}?>
						</td>
					</tr>
					<tr class="<?if($err[zip1]==1||$err[zip2]==1||$err[pref]==1||$err[addr]==1){echo "err_bg";}?>">
						<th>住所　<span class="red">(必須)</th>
						<td>
							〒<input name="zip1" type="text" pattern="\d*" title="半角数字" class="zip" size="3" value="<?=$zip1?>" maxlength="3" style="ime-mode:disabled" placeholder="100" />&nbsp;-
							<input name="zip2" type="text" pattern="\d*" title="半角数字" class="zip" size="4" value="<?=$zip2?>" maxlength="4" style="ime-mode:disabled" onKeyUp="AjaxZip3.zip2addr('zip1','zip2','pref','addr');" placeholder="0001" />&nbsp;
							<select name="pref">
								<option value="">都道府県</option>
<?
	foreach($PREFECTURE as $p_key=>$tmp){
?>
								<option value="<?=$p_key?>"<?if($pref==$p_key){echo " selected";}?>><?echo $tmp;?></option>
<?
	}
?>
							</select><br />
							<input name="addr" type="text" size="50" value="<?=$addr?>" style="ime-mode: active;" /><br class="only_sp" /><span class="red">建物・号室まで</span>
							<?if($err[zip1]==1){echo "<br /><span class=\"esg\">".$errmsg[zip1]."</span>";}?>
							<?if($err[zip2]==1){echo "<br /><span class=\"esg\">".$errmsg[zip2]."</span>";}?>
							<?if($err[pref]==1){echo "<br /><span class=\"esg\">".$errmsg[pref]."</span>";}?>
							<?if($err[addr]==1){echo "<br /><span class=\"esg\">".$errmsg[addr]."</span>";}?>
						</td>
					</tr>
					<tr class="<?if($err[tel]==1){echo "err_bg";}?>">
						<th>電話番号　<span class="red">(必須)</th>
						<td><input name="tel" pattern="\d*" title="ハイフン無し「半角数字」" type="text" size="50" value="<?=$tel?>" placeholder="0312345678(ハイフンなし)" style="ime-mode:disabled;" /><?if($err[tel]==1){echo "<br /><span class=\"esg\">".$errmsg[tel]."</span>";}?></td>
					</tr>
					<tr class="<?if($err[entry_note]==1){echo "err_bg";}?>">
						<th>備考</th>
						<td>
							<textarea name="entry_note" placeholder="その他お問合わせやご希望がある場合はこちらに入力して下さい。"><?=$entry_note?></textarea><?if($err[entry_note]==1){echo "<br /><span class=\"esg\">".$errmsg[entry_note]."</span>";}?>
						</td>
					</tr>
					<tr>
						<th>学校からのお知らせ配信</th>
						<td>
							<label><input type="radio" name="sc_info_mail" value="1" <?if($sc_info_mail=='1'){echo "checked";}?>/>希望する</label>　　　
							<label><input type="radio" name="sc_info_mail" value="0" <?if($sc_info_mail=='0'){echo "checked";}?>/>しない</label>
						</td>
					</tr>
				</table>
				<button type="submit" name="check" value="check" class="btn_entry">確認画面へ</button>
<?}?>
				</form>
				<ul>
					<li>※お客様の個人情報は、プライバシーポリシーに従って管理されます。</li>
					<li>※ご利用のメールサービスや携帯電話の設定により、メール受信がブロックされたり、迷惑メールフォルダに振り分けられてしまう場合がございます。その場合には、「@start47.com」の受信を許可する設定が出来ているか、ご確認をお願いします。</li>
				</ul>
			</div>
		</article>
	<?}?>
<?}?>
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
