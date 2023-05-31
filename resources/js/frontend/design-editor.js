$(document).ready(function () {
    $('#designEditor .close').click(function (e) {
        e.preventDefault();
        $('#designEditor').animate({
            width: 0
        });
        $('#designEditor .editor-box').animate({
            width: 0
        });
        $('#designEditor .editor-box .wrapper').animate({
            left: '-300px'
        });
    });
    $('.open-editor').click(function (e) {
        e.preventDefault();
        $('#designEditor').animate({
            width: 300
        });
        $('#designEditor .editor-box').animate({
            width: 300
        });
        $('#designEditor .editor-box .wrapper').animate({
            left: 0
        });
    });
    $('input[name="settings[title_fontsize]"]').change(function () {
        console.log('change');
        $('.event-title h1').css("font-size", $(this).val() + 'px');
    });
    $('input[name="settings[title_logo_size]"]').change(function () {
        console.log('change');
        $('.event-title').css("height", $(this).val() + 'px');
    });
    $('input[name="settings[title_color]"]').on('input', function () {
        console.log('change');
        $('.event-title h1').css("color", $(this).val());
    });
    $('select[name="settings[title_effect]"]').on('change', function () {
        $('.shadow-color').hide();
        $('.outline-color').hide();
        if ($(this).val() == 1) {
            $('.shadow-color').show();
            console.log('shadow added');
            $('.event-title h1').css("text-shadow", "0 0 4px #000");
        } else if ($(this).val() == 2) {
            $('.outline-color').show();
            $('.event-title h1').css("text-shadow", "0 0 4px " + $('input[name="title_shadow_color"]').val());
        } else {
            $('.event-title h1').css("text-shadow", "none");
        }
    });
    $('input[name="settings[title_shadow_color]"]').on('input', function () {
        console.log('change');
        $('.event-title h1').css("text-shadow", "0px 0px 4px " + $(this).val());
    });
    $('input[name="settings[bg_color]"]').on('input', function () {
        console.log('change');
        $('#eventLanding').css("background-color", $(this).val());
    });
    $('select[name="settings[show_days]"]').on('change', function () {
        if ($(this).val() == 1) {
            $('#eventSchedule .day-filter').show();
        } else {
            $('#eventSchedule .day-filter').hide();
        }
    });
    $('select[name="settings[show_rooms]"]').on('change', function () {
        if ($(this).val() == 1) {
            $('#eventSchedule .rooms').show();
        } else {
            $('#eventSchedule .rooms').hide();
        }
    });
    $('input[name="settings[day_button_bg]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .day-filter a').css("background", $(this).val());
        $('#eventSchedule .day-filter a').css("border-color", $(this).val());
    });
    $('input[name="settings[day_button_text]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .day-filter a').css("color", $(this).val());
    });
    $('input[name="settings[room_button_bg]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .rooms a').css("background", $(this).val());
        $('#eventSchedule .rooms a').css("border-color", $(this).val());
    });
    $('input[name="settings[room_button_text]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .rooms a').css("color", $(this).val());
    });
    $('input[name="settings[time_col_bg_even]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .left-side.even').css("background", $(this).val());
    });
    $('input[name="settings[time_col_text_even]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .left-side.even').css("color", $(this).val());
    });
    $('input[name="settings[time_col_bg_odd]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .left-side.odd').css("background", $(this).val());
    });
    $('input[name="settings[time_col_text_odd]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .left-side.odd').css("color", $(this).val());
    });
    $('select[name="settings[border_style]"]').on('change', function () {
        $('#eventSchedule .schedule-content-item .right-side').css('border-top-style', $(this).val());
        $('#eventSchedule .room-content .content-items .content-row:last-child .schedule-content-item .right-side').css('border-bottom-style', $(this).val());
    });
    $('input[name="settings[border_color]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .right-side').css("border-color", $(this).val());
    });
    $('input[name="settings[item_title]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .right-side .title, #eventSchedule .schedule-content-item .right-side .sub-items .sub-content-title').css("color", $(this).val());
    });
    $('input[name="settings[item_subtitle]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .schedule-content-item .right-side .subtitle, #eventSchedule .schedule-content-item .right-side .sub-items .sub-content-sub-title').css("color", $(this).val());
    });
    $('input[name="settings[item_button_bg]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .content-button a').css("background", $(this).val());
    });
    $('input[name="settings[item_button_text]"]').on('input', function () {
        console.log('change');
        $('#eventSchedule .content-button a').css("color", $(this).val());
    });
    $('input[name="settings[nav_bg_color]"]').on('input', function () {
        console.log('change');
        $('#kt_app_footer').css("background", $(this).val());
        $('.event-navigation > li > a').css("background", $(this).val());
    });
    $('input[name="settings[nav_buttons_color]"]').on('input', function () {
        console.log('change');
        $('.event-navigation > li > a, .event-navigation > li > a.active, .event-navigation > li > a:hover, .event-navigation > li > a:focus').css("color", $(this).val());
        $('.event-navigation > li > a svg, .event-navigation > li > a.active svg, .event-navigation > li > a:hover svg, .event-navigation > li > a:focus svg').css("fill", $(this).val());
        $('.event-navigation > li > a svg path, .event-navigation > li > a.active svg path, .event-navigation > li > a:hover svg path, .event-navigation > li > a:focus svg path').css("stroke", $(this).val());
    });
    $('input[name="settings[nav_buttons_border_color]"]').on('input', function () {
        console.log('change');
        $('.event-navigation > li').css("border-color", $(this).val());
    });
});
