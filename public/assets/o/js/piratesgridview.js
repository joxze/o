$(document).on('change', '.pgv-search', function() {
    search($(this), location.href);
});

$(document).on('click', '.pagination a', function(){
    var url = $(this).attr('href');
    search($(this), url);
    return false;
});

function search (_el, url) {
    var div     = _el.closest('.div-pgv');
    var column  = div.find('.pgv-col').val();
    var setting = div.find('.pgv-col').val();
    var _search ={};
    $('.pgv-search').each(function(){
        var dataSearch = $(this).attr('data-name');
        if (dataSearch) {
            _search[dataSearch] = $(this).val();
        }
    });

    var data = {
        column  : column,
        setting : setting,
        search  : _search,
    }

    $.ajax({
        data    : data,
        url     : url,
        dataType: 'HTML',
        type    : 'POST',
        headers : {
            'X-CSRF-TOKEN': $('meta[name="ooo"]').attr('content')
        },
        success: function (result,status,xhr) {
            if (result) {
                var div = _el.closest('.table-pgv');
                div = div.closest('.div-pgv');
                console.log(div.html());
                div.empty();
                div.html(result);
                div.find('.pgv-search').each(function(){
                    var dataSearch = $(this).attr('data-name');
                    if (_search[dataSearch]) {
                        $(this).val(_search[dataSearch]);
                    }
                });
            }
        }
    });
}
