$(document).ready(function(e){
    $('.userRole').live('change',function(e) {
        var t = $(this).val() == 0 ? 'physical': 'juridical';
        var text = $('#filter .text').clone();
        if(t.length > 0) {
            $('#filter').html('<div><div class="text">'+text.html()+'</div>'+$('#'+t).html()+'</div>');
            $('#filter input.custom, #filter textarea.custom, #filter select.custom, #filter button, #filter checkbox').uniform();
        }


        $('.cityAutoCompleteField:visible').autocomplete({'minLength':'2','showAnim':'fold','select': function(event, ui) {
            event.preventDefault();
            event.stopPropagation();
            this.value = ui.item.label;
            $(this).next().val(ui.item.cityId);
            return false;
        },'source':'/site/city'});

        return false;
    });

    if($('.userRole:visible').val() != "") {
        $('.userRole:visible').change();
    }

})
