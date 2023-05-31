$(document).ready(function () {
    if ($('.action-dropdown .js-dropdown-toggle').length) {
        $('.action-dropdown .js-dropdown-toggle').click(function (e) {
            console.log('clicked');
            e.preventDefault();
            $(this).next().show();
        });
    }

    if ($('button[type="submit"]').length) {
        $('button[type="submit"]').click(function () {
            $(this).find('.indicator-label').hide();
            $(this).find('.indicator-progress').show();
        });
    }

    if ($('.js-datepick').length) {
        $('.js-datepick').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                autoApply: true,
                timePicker: true,
                timePicker24Hour: true,
                locale: {
                    format: 'YYYY-MM-DD HH:mm'
                }
            }
        );
    }

    if ($('select[name="room_participants[]"]').length) {
        $('select[name="room_participants[]"]').select2({
            multiple: true,
            placeholder: $('select[name="room_participants[]"]').data('placeholder'),
            ajax: {
                url: $('select[name="room_participants[]"]').data('route'),
                data: function (params) {
                    var query = {
                        keyword: params.term,
                        ids: $('select[name="room_participants[]"]').data('ids')
                    }

                    return query;
                },
                processResults: function (data, params) {
                    console.log(data);
                    return {
                        results: data
                    };
                }
            }
        });
    }

    if ($('select[name="allow_all"]').length) {

        if ($('select[name="allow_all"]').val() != 1) {
            $('.js-participants-box').show();
        } else {
            $('.js-participants-box').hide();
        }

        $('select[name="allow_all"]').change(function () {
            if ($(this).val() != 1) {
                $('.js-participants-box').show();
            } else {
                $('.js-participants-box').hide();
            }
        });
    }

    if ($('select[name="banner_type"]').length) {
        $('select[name="banner_type"]').change(function () {
            $('.js-field-banner-type').hide();
            $('[data-field-type="' + $(this).val() + '"]').show();
        });
    }

    if ($('select[name="item_type"]').length) {
        $('select[name="item_type"]').change(function () {
            $('.js-field-banner-type').hide();
            $('.item-field-' + $(this).val()).show();
        });
    }

    if (document.querySelectorAll('.stand-items').length) {
        let sort_items = $('.stand-items .stand-item');
        let sort_array = [];
        let ajax_route = $('.stand-items').data('reorder-route');

        sort_items.each(function (item, index) {
            sort_array.push({
                'id': $(this).data('id')
            });
        });

        const standItemsSortable = new Draggable.Sortable(document.querySelectorAll('.stand-items'), {
            draggable: '.stand-item',
            handle: '.stand-item .handle',
            mirror: {
                appendTo: document.querySelectorAll('.stand-items'),
                constrainDimensions: true,
            },
        });

        standItemsSortable.on('sortable:stop', (event) => {
            sort_array = move(sort_array, event.oldIndex, event.newIndex);

            for (let i = 0; i < sort_array.length; i++) {
                $('.stand-items .stand-item .number.index-' + sort_array[i].id).text(i + 1);
            }

            axios.post(ajax_route, {items: sort_array})
        });
    }

    if (document.querySelectorAll('.posters-table').length) {
        let sort_items = $('.posters-table tbody tr');
        let sort_array = [];
        let ajax_route = $('.posters-table').data('reorder-route');

        sort_items.each(function (item, index) {
            sort_array.push({
                'id': $(this).data('id')
            });
        });

        const postersSortable = new Draggable.Sortable(document.querySelectorAll('.posters-table tbody'), {
            draggable: '.posters-table tbody tr',
            handle: '.posters-table tbody tr .handle',
            mirror: {
                appendTo: document.querySelectorAll('.posters-table'),
                constrainDimensions: true,
            },
        });

        postersSortable.on('sortable:stop', (event) => {
            sort_array = move(sort_array, event.oldIndex, event.newIndex);
            console.log(sort_array);
            axios.post(ajax_route, {items: sort_array})
        });
    }

    function move(arr, old_index, new_index) {
        while (old_index < 0) {
            old_index += arr.length;
        }
        while (new_index < 0) {
            new_index += arr.length;
        }
        if (new_index >= arr.length) {
            let key = new_index - arr.length;
            while ((key--) + 1) {
                arr.push(undefined);
            }
        }
        arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);

        return arr;
    }
});
