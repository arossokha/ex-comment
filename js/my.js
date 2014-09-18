$(document).ready(function(e){

    $('.addMyTransport').live('click',function(e) {
        $.post('/transport/my',$(this).parents('form').serialize(),
            function(data) {
                $('#filter').html(data.html);
                $('#filter input.custom, #filter textarea.custom, #filter select.custom, #filter button, #filter checkbox').uniform();
                if(data.status) {
                    $.fn.yiiGridView.update('my-transport-grid');
                    $('.myTransportCount').html(($('.myTransportCount').html() - 0) +1);
                }

            },'json');

        return false;
    });

})
