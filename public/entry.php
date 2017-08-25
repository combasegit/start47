<?
//inc.php を取り込む
include_once("./inc/inc.php");
//sess.php を取り込む
include_once("./inc/sess.php");

/*資料請求ページ*/

if($_POST['entry']){
	//入力チェック
	$entry_list = $_POST['entry_list'];
	if(!is_array($entry_list)){
		$err=3;
	}else{
		//学校IDをセッションに登録
		$_SESSION["entry_list"] = $entry_list;
		//フォームページへリダイレクト
	 	header("Location: ./entry_form.html");
	 	exit();
	}
	
}

//学校ID取得
$school_id = $_GET['school_id'];
//学校情報引き出し
$sql = "select * from mtb_school where school_id = '$school_id' AND del_flag = '0' ";
$res = $mysqli->query($sql);
$cnt = $res->num_rows;
if($cnt>0){
	$data = $res->fetch_assoc();
	$contract_rank = $data["contract_rank"];//	$CONTRACT_RANK_ARY = array("1"=>"フル有料", "5"=>"お試し", "10"=>"無料");
	$school_name = $data["school_name"];
	if($contract_rank=='10'){
		$err=2;
	}
}else{
	$err=1;
}

?>
<!DOCTYPE html>
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
			<a href="/">ホーム</a>&nbsp;&gt;&nbsp;資料請求
		</div>
	<?if($err==1){?>
		<article id="main_box">
			<p>申し訳ございません。こちらのIDの学校は、登録が無いか現在表示が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}elseif($err==2){?>
		<article id="main_box">
			<p>申し訳ございません。こちらの学校へは、現在資料請求が出来ません。</p>
			<p><a href="/search/">学校検索画面に戻る</a></p>
		</article>
	<?}else{?>
		<article id="main_box">
			<div id="sc_entry">
				<h3>資料請求する学校</h3>
				<?if($err==3){?><p class="red">資料請求する学校を１校以上チェックしてください。</p><?}?>
				<form action="" name="entry01" method="post">
				<table>
					<tr>
						<th style="width:100px;">チェック</th>
						<th>学校名</th>
					</tr>
					<tr>
						<td style="text-align:center;"><input type="checkbox" name="entry_list[]" value="<?=$school_id?>" checked /></td>
						<td><?=$school_name?></td>
					</tr>
				</table>
				<p>資料請求をする学校にチェックを入れて、「資料請求手続きへ」をクリックしてください。</p>
				<button type="submit" name="entry" value="entry" class="btn_entry">資料請求手続きへ</button>
				</form>
			</div>
		</article>
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
