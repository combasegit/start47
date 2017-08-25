				<div class="act_box w100p">
					<a href="#" class="act01">全画面プリント</a>
					<a href="#" class="act02">本文プリント</a>
					<?if(is_array($sc_lst)&&in_array($data['school_id'],$sc_lst)){?>
					<div class="act03b">　検討中　</div>
					<?}else{?>
					<a href="/add_watch_list.html?school_id=<?=$data['school_id']?>" class="act03">検討中に追加する</a>
					<?}?>
				</div>
