$(document).ready(function () {
    $('.js-pass-field-toggle').click(function () {
        if ($(this).parent().find('input').attr('type') === 'password') {
            $(this).parent().find('input').attr('type', 'text');
            $(this).find('.hide').removeClass('d-none');
            $(this).find('.show').hide();
        } else {
            $(this).parent().find('input').attr('type', 'password');
            $(this).find('.hide').addClass('d-none');
            $(this).find('.show').show();
        }
    });
    $('button[type="submit"]').click(function () {
        $(this).find('.indicator-label').hide();
        $(this).find('.indicator-progress').show();
    });

    if ($('.mp-item-iframe').length) {
        $('.mp-item-iframe').magnificPopup({
            type: 'iframe'
        });
    }

    if ($('.posters .poster-item .view-btn').length) {
        $('.posters .poster-item .view-btn').magnificPopup({
            type: 'image'
        });
    }

    $('.qa-toggle').click(function () {
        if ($('.qa-block').hasClass('hidden')) {
            $('.qa-block').animate({
                paddingLeft: 30,
                width: '360px'
            }, 300, function () {
                $('.qa-block').removeClass('hidden');
            });
        } else {
            $('.qa-block').animate({
                paddingLeft: 0,
                width: 0
            }, 300, function () {
                $('.qa-block').addClass('hidden');
            });
        }
    });

    $('.day-filter a').click(function (e) {
        e.preventDefault();
        $('.day-filter .action-buttons-holder').removeClass('opened');
        $('.schedule-view .day-boxes .day-box').removeClass('opened');
        $(this).parent().addClass('opened');
        $($(this).attr('href')).addClass('opened');
    });

    $('.day-box .rooms a').click(function (e) {
        e.preventDefault();
        $(this).parent().parent().find('a').removeClass('opened');
        $(this).parent().parent().next().find('.room-content').removeClass('opened');
        $(this).addClass('opened');
        $($(this).attr('href')).addClass('opened');
    });
});
