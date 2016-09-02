var ST = window.ST || {}

ST.show_embed = function() {
    $embed_field = $('#embed_field');
    var lang_showcode = $embed_field.data('lang-showcode');
    $embed_field.hide();
    $embed_field.after('<a id="show_code" href="#">' + lang_showcode + '</a>');
    $('#show_code').live('click',
        function() {
            $(this).hide();
            $embed_field.show().select();
            return false;
        });
};

ST.expand = function() {
    $('.expander').show();
    $('.expand').click(function() {
        if ($('.paste').hasClass('full')) {
            return false;
        }
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

ST.spamadmin = function() {
    if ($('.content h1').text() == 'Spamadmin') {
        $('.content .hidden').show();
        $('.content .quick_remove').live('click', function(ev) {
            var ip = $(ev.target).data('ip');
            if (confirm('Delete all pastes belonging to ' + ip + '?')) {
                $.post(base_url + 'spamadmin/' + ip, {
                    'confirm_remove': 'yes',
                    'block_ip': 1
                }, function() {
                    window.location.reload();
                });
            }
            return false;
        });
    }
};

ST.init = function() {
    ST.expand();
    ST.show_embed();
    ST.spamadmin();
};

$(document).ready(function() {
    ST.init();
});
