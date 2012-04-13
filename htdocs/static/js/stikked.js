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
		var window_width = $(window).width();
		var spacer = 20;
		if (window_width < 900) {
			window_width = 900;
			spacer = 0;
		}
		var new_width = (window_width - (spacer * 3));
		$('.text_formatted').animate({
			'width': new_width + 'px',
			'left': '-' + (((window_width - 900) / 2 - spacer)) + 'px'
		},
		200);
		return false;
	});
};

$(document).ready(function() {
	ST.init();
});
