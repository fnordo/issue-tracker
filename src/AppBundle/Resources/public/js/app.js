$(function(){

    /*
     * Initialize handlers to programmatically submit form.
     */
    $('.trigger-submit').click(function(e){
        e.preventDefault();
        var $form = $(this).data('form')
        $($form).submit();
    });

});