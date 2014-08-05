$(function() {
    
    $('.display-truulo-search-options').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).next('.truulo-search-options').toggle();
    });
    
    $('.truulo-search-options').click(function(e) {
        e.stopPropagation();
    });
    
    $('html').click(function() {
        $(this).parent().find('.truulo-search-options').hide();
    });
    
    $('.truulo-search-options input.all').click(function(){
        if($(this).is(':checked')) {
            $('.truulo-search-options input').each(function(){
                $(this).not('.all').removeAttr('checked');
            });
        } else {
            return false;
        }
        
    });
    
    $('.truulo-search-options input').not('.all').click(function(){
        if ($('.truulo-search-options input:checked').length == 0) {
            $('.truulo-search-options input.all').trigger('click');
            $('.truulo-search-options input.all').attr('checked', 'checked');
        } else {
            $('.truulo-search-options input.all').removeAttr('checked');
        }
    });
    
});