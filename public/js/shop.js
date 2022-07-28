$(function () {
    $('.category-anchor').on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href').replace('#' , 'category_id=' + $(this).data('categoryId'));
        window.location.href = url;
    })

    $('#sort-select').on('change', function (e) {
        if ($('[name=sort]').length === 1) {
            const sortInputTag = $('<input>').attr({
                type: 'hidden',
                name: 'sort',
                value: $('#sort-select').val(),
                id: 'input_sort',
            });
            $('.search-hidden').first().append(sortInputTag);
        } else {
            $('#input_sort').val($('#sort-select').val());
        }
        $('#navigation-form').submit();
    })

    $(".content-anchor").on('click', function (e) {
        e.preventDefault();
        const url = $(this).attr('href') + $(location).attr('search');
        window.location.href = url;
    })

    // 画像のスライド表示処理
    $("document").ready(function () {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            animationLoop: true,
            itemWidth: 400,
            maxItems: 1,
            itemMargin: 0,
        });
    });

    $(".logout-anchor").on('click', function (e) {
        document.getElementById('logout-form').submit();
    })
})