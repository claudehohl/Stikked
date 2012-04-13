var ST = window.ST || {}

ST.init = function() {
	ST.change();
	ST.show();
	ST.expand();
};

ST.change = function() {
	$('.change').oneTime(3000,
	function() {
		$(this).fadeOut(2000);
	});
};

ST.show = function() {
	$('.show').click(function() {
		$('.advanced').hide();
		$('.advanced_options').show();
		return false;
	});
};

ST.expand = function() {
	$('.expand').click(function() {
		$('.paste').css('width', '90%');
		$('.text_formatted').hide().css('width', '100%').css('margin-left', '0').fadeIn(500);
		return false;
	});
};

$(document).ready(function() {
	ST.init();
});
