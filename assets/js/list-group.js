'use strict';
(function($) {

    $(document).ready(function() {

        var $listGroups = $('.list-group');
        var $listGroupLinks = $( '.list-group__item a' );
        var $listGroupButtons = $('.list-group__item button');

        $listGroupLinks.each(function(index, link) {
            if($(link).attr('href') != window.location.href && !$(link).parent('li').hasClass('current_page_ancestor')) {
                $(link).removeClass('is-open');

                if($(link).siblings('.list-group__sublist').length) {
                    $(link).siblings('.list-group__sublist').removeClass('is-open');
                }

            } else {
                $(link).parents()
            }
        });
        $listGroupButtons.each(function(index) {
            var subList = $(this).siblings('.list-group__sublist');
            if(subList.length) {

                subList.on('toggle', function(e){

                    if(window.isMobile()) {

                        $(this)
                            .parent()
                            .siblings('.list-group__item')
                            .find('.is-open').each(function() {
                                //$(this).slideUp();
                                $(this).attr('tabindex', '-1');
                                $(this).removeClass('is-open');
                            })
                    }

                    //subList.slideToggle();
                    subList.toggleClass('is-open');
                    $(this).prev('a').toggleClass('is-open');

                    e.stopPropagation();

                });

                subList.on('retract', function(){
                    //subList.slideUp();
                    $(this).attr('tabindex', '-1');
                    subList.removeClass('is-open');
                    $(this).prev('a').removeClass('is-open');
                    
                });

                subList.on('expand', function(){
                    //subList.slideDown();
                    $(this).attr('tabindex', '0');
                    subList.addClass('is-open');
                    $(this).prev('a').addClass('is-open');
                });

                $(this).click(function(e) {
                    e.preventDefault();
                    subList.trigger('toggle');
                });
            }
        });


    });


})(jQuery);