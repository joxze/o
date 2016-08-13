$(document).on('click', '.add-multiple-row', function(){
    var main        = $(this).closest('.form-multiple-row');
    var template    = main.find('.main-form');
    var multiple    = main.find('.form-row');
    var append      = multiple.append(template.html());
    var countData   = template.find('.add-multiple-row').attr('data-count');
    countData       = parseInt(countData) + 1;
    $(append)
        .find('.add-multiple-row')
        .removeClass('btn-primary add-multiple-row')
        .addClass('btn-danger remove-multiple-row')
        .attr('data-count', countData)
        .text('-');
    $(append).children('div').addClass('div-row');
    template.find('.add-multiple-row').attr('data-count', countData);
    console.info(countData);
});
$(document).on('click', '.remove-multiple-row', function(){
    $(this).closest('.div-row').remove();
});