$(document).ready(function(){
    $('form.search_form select').on('change', function(e){
        $(this).parents('form').submit();
    });

    /* Selecion de la fecha */
    $('form.search_form input[type=text]').datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: new Date(),
        onSelect: function(date, obj){
            $(this).parents('form').submit();
        },
    });

    $('form #publishDate').datepicker({
        dateFormat: "yy-mm-dd",
        defaultDate: new Date(),
    });

    $('#load_form').on('submit', function(e){
        var _this = $(this);
        _this.css('display', 'none');
        $('.loader').css('display', 'block');
    });

    $('#excel').on('change', function(e){
        var fileName = e.target.value.split('\\').pop();
        var label    = $('label.btn-file');
        var labelVal = label.html();

        if(fileName)
            label.html(fileName);
        else
            label.html(labelVal);
    });
});
