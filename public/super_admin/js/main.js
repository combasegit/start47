try { 
document.execCommand('BackgroundImageCache', false, true); 
} catch(e) {} 

$(function () {
  for (var i = 1; i <= $('ul').length; i++) {
    // �N�b�L�[��block�ł���Γǂݍ��ݎ��Ƀ��j���[���I�[�v������ 
    if ($.cookie('menu' + i) == 'block') {
      $('#menu' + i).show(); 
    }
  }
  
  $('h4').click(function() {
    var menu = $(this).next('ul');
    // ���j���[�\��/��\��
    $(menu).slideToggle('fast', function() {
      // �L��������1���i�N�b�L�[�ɂ̓h���C�����Z�b�g���Ȃ��A�u���E�U������珉�����j
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
	//nav�̈ʒu
	var navTop = nav.offset().top;
	//�X�N���[�������邽�тɎ��s
	$(window).scroll(function () {
		var winTop = $(this).scrollTop();
		nav.stop(); //���ꂪ�Ȃ��ƘA�����Ď��s���ꂽ�Ƃ��ɕςȓ����ɂȂ�܂��B
		//�X�N���[���ʒu��nav�̈ʒu��艺��������N���Xfixed��ǉ�
		if (winTop >= navTop) {
			nav.addClass('left_menu_fixed');
			nav.animate({top: winTop +38 + "px"}, "slow");
		} else if (winTop <= navTop) {
			nav.removeClass('left_menu_fixed');
		}
	});
});
