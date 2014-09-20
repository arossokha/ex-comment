function commentAjaxHandler(data) {
    $(".loader").hide();
    $(".form").show();
    $(".captchaLink").click();
    if (data.status) {
        $.fn.yiiListView.update("comment-list");
        $("#comment-form")[0].reset();
    } else {
        $("#comment-form").data("submitObject").submit();
    }
}

function commentBeforeSendHandler() {
    $(".loader").show();
    $(".form").hide();
}