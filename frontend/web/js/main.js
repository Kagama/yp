/**
 * Created by developer on 15.09.14.
 */
$(document).ready(function(){

    //#####################################################
    // Закладки
    //#####################################################
    // Добавляем закладку
    $('.add-bookmark').on('click', function() {
        UpdateBookMark(this);
        return false;
    });
    // Удаляем закладку
    $(document).on('click', '.remove-bookmark', function() {
        UpdateBookMark(this);
        return false;
    });
    //#####################################################

});

function UpdateBookMark(_this) {
    var _url = $(_this).attr('href');
    var _element = $(_this);
    $.ajax({
        type: 'get',
        url:_url,
        success: function (result) {
            $('.bookmark-block').replaceWith(result);
        }
    });
}