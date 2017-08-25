try { 
document.execCommand('BackgroundImageCache', false, true); 
} catch(e) {} 

$(function () {
  for (var i = 1; i <= $('ul').length; i++) {
    // クッキーがblockであれば読み込み時にメニューをオープンする 
    if ($.cookie('menu' + i) == 'block') {
      $('#menu' + i).show(); 
    }
  }
  
  $('h4').click(function() {
    var menu = $(this).next('ul');
    // メニュー表示/非表示
    $(menu).slideToggle('fast', function() {
      // 有効期限は1日（クッキーにはドメインをセットしない、ブラウザを閉じたら初期化）
      $.cookie($(menu).attr('id'), $(menu).css('display'), { expires: 1 });
    });
  });
});


$(document).ready(function() {
    $(".fcbox").fancybox({
		'overlayColor'		: '#eee',
		'overlayOpacity'	: 0.7,
		'cyclic'            : true
    });
    $(".fcbox3").fancybox({
       'width'        : 600,
       'height'       : 450,
       'autoScale'    : false,
       'transitionIn' : 'none',
       'transitionOut': 'none',
       'type'         : 'iframe'
    });
    $(".fcbox3b").fancybox({
       'width'        : 340,
       'height'       : 455,
       'autoScale'    : false,
       'transitionIn' : 'none',
       'transitionOut': 'none',
       'type'         : 'iframe'
    });
});


$(function(){
	var nav = $("#left_menu");
	//navの位置
	var navTop = nav.offset().top;
	//スクロールをするたびに実行
	$(window).scroll(function () {
		var winTop = $(this).scrollTop();
		nav.stop(); //これがないと連続して実行されたときに変な動きになります。
		//スクロール位置がnavの位置より下だったらクラスfixedを追加
		if (winTop >= navTop) {
			nav.addClass('left_menu_fixed');
			nav.animate({top: winTop +38 + "px"}, "slow");
		} else if (winTop <= navTop) {
			nav.removeClass('left_menu_fixed');
		}
	});
});
