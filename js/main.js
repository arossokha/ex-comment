$(document).ready(function() {

    $('input.custom, textarea.custom, select.custom, button').filter(':visible').uniform();

    $(':file').uniform({
        fileDefaultText: ''
    });

    $('.enter').live('click', function() {
        $.post('/site/login', $(this).parent('form').serialize(), function(data) {
            console.dir(data);
        }, 'json');
    })

    $('.showContactInfo').live('click', function(e) {
        $(this).parents('#table').children('.more:last').toggle();
        return false;
    });

    $('.removeTransport').live('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = '/transport/delete/' + $(this).next().val();
        if($(this).next().val() == undefined) {
            url = $(this).attr('href');
        }
        if(confirm("Вы уверенны что хотите удалить этот элемент?")) {
            $.post(url, {}, function() {
                if($('#transport-view').size()) {
                    $.fn.yiiListView.update('transport-view', {});
                }
                if($('#order-view-list').size()) {
                    $.fn.yiiListView.update('order-view-list', {});
                }
                $('.myOrdersCount').text($('.myOrdersCount').text() -0 -1);
            });
        }
        return false;
    });

    $('.removeCargo').live('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = '/cargo/delete/' + $(this).next().val();
        if($(this).next().val() == undefined) {
            url = $(this).attr('href');
        }
        if(confirm("Вы уверенны что хотите удалить этот элемент?")) {
            $.post(url, {}, function() {
                if($('#cargo-view').size()) {
                    $.fn.yiiListView.update('cargo-view', {});
                }
                if($('#order-view-list').size()) {
                    $.fn.yiiListView.update('order-view-list', {});
                }
                $('.myOrdersCount').text($('.myOrdersCount').text() -0 -1);
            });
        }
        return false;
    });

    $('.removeFavorite').live('click', function() {
        var id = $(this).next().val();
        var item = this;
        if(confirm("Вы уверенны что хотите удалить этот элемент?")) {
            $.post('/favorite/delete/' + id, {
                id: id
            }, function() {
                $(item).parents('#table').remove();
                $('.myFavoritesCount').text($('.myFavoritesCount').text() -0 -1);
            });
        }
        return false;
    });

    $('.removeTender').live('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        var url = '/tender/delete/' + $(this).next().val();
        if($(this).next().val() == undefined) {
            url = $(this).attr('href');
        }
        if(confirm("Вы уверенны что хотите удалить этот элемент?")) {
            $.post(url, {}, function() {
                if($('#tender-view').size()) {
                    $.fn.yiiListView.update('tender-view', {});
                }
                if($('#order-view-list').size()) {
                    $.fn.yiiListView.update('order-view-list', {});
                }
            });
        }
        return false;
    });

    $('.favoriteAdd').live('click', function() {
        var link = this;
        if($(this).parents('#table').size()) {
            var el = $(this).parents('#table');
        } else {
            var el = $(this).parents('#info');
        }

        $.post('/favorite/create', $(el).find('.favoriteInfo').children().serialize(), function(data) {
            if(data.status) {
                $(link).text('Добавлено в избранное');
                $(link).removeClass('favoriteAdd');
                $('.myFavoritesCount').html(($('.myFavoritesCount').html() - 0) + 1);
            }
        }, 'json');
        return false;
    });

    $('.calculateSymbols').live('keyup', function() {
        //        $(this).val().length
        if($(this).val().length >= 200) {
            $('.countSymbols').html(0);
            if($(this).val().length > 200) {
                $(this).val($(this).val().substring(0, 200));
            }
        } else {
            $('.countSymbols').html(200 - $(this).val().length);
        }
    })

    $('.calculateSymbols110').live('keyup', function() {
        //        $(this).val().length
        if($(this).val().length >= 110) {
            $('.countSymbols').html(0);
            if($(this).val().length > 110) {
                $(this).val($(this).val().substring(0, 110));
            }
        } else {
            $('.countSymbols').html(110 - $(this).val().length);
        }
    })


    $('.calculateSymbols150').live('keyup', function() {
        //        $(this).val().length
        if($(this).val().length >= 125) {
            $('.countSymbols').html(0);
            if($(this).val().length > 125) {
                $(this).val($(this).val().substring(0, 125));
            }
        } else {
            $('.countSymbols').html(125 - $(this).val().length);
        }
    })

    $('.readyToLoadField').live('change', function() {
        if($(this).val() == 1) {
            $('.howOftenField').removeAttr('disabled');
            $('.howOftenField').css({
                'background-color': 'white'
            });
            $('.loadDateField').attr('disabled', 'disabled');
            $('.loadDateField').css({
                'background-color': '#F4F4F4'
            });
        } else if($(this).val() == 2) {
            $('.loadDateField').removeAttr('disabled');
            $('.loadDateField').css({
                'background-color': 'white'
            });
            $('.howOftenField').attr('disabled', 'disabled');
            $('.howOftenField').css({
                'background-color': '#F4F4F4'
            });
        } else {
            $('.howOftenField').css({
                'background-color': '#F4F4F4'
            });
            $('.loadDateField').css({
                'background-color': '#F4F4F4'
            });
        }
    })

    $('.readyToLoadField').change();

    $('.checkBoxRequestPrice').change(function() {
        if($(this).attr('checked')) {

            $('.pay').children('input').attr('disabled', 'disabled').css({
                'background-color': '#F4F4F4'
            }).end().children().children('select').attr('disabled', 'disabled').css({
                'background-color': '#F4F4F4'
            });
        } else {
            $('.pay').children('input').removeAttr('disabled').css({
                'background-color': 'white'
            }).end().children().children('select').removeAttr('disabled').css({
                'background-color': 'white'
            });
        }
    });

    $('.checkBoxRequestPrice').change();

    $('.faqQuestion').live('click', function() {
        $(this).next().slideToggle();
    });

    $('.ui-autocomplete-input').keyup(function(e) {

    });

});