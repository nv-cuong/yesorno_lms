$('select').select2({ closeOnSelect: false }).on("change", function(e) {
    $('.select2-selection__rendered li:not(.select2-search--inline)').hide();
    $('.counter').remove();
    var counter = $(".select2-selection__choice").length;
    $('.select2-selection__rendered').after('<div style="line-height: 28px; padding: 5px;" class="counter">' + counter + ' selected</div>');
});