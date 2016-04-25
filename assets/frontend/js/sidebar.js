(function($) {
$.fn.orphans = function(){
    var txt = [];
    this.each(function(){$.each(this.childNodes, function() {
        if (this.nodeType == 3 && $.trim(this.nodeValue)) txt.push(this)
    })}); 
    return $(txt);
};
})(jQuery);
$(function() {
    $('.sidebar .expand').orphans().wrap('<a href="#" title="expand/collapse"></a>');
    
    //Slide Effects  - Always keep one sublist shown
    $('div.sidemenu ul').find('ul.collapse:not(:last)').hide().end().find('.expand:last').addClass('open');
    $('div.sidemenu .expand').click(function() {
        $(this).addClass('open').siblings().removeClass('open').end()
        .find('ul:hidden').slideToggle().end()
        .siblings('li').find('ul:visible').slideUp();
        return false;
    });
    
});
