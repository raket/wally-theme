(function($) {

    $(document).ready(function() {

        if(isMobile()) {
            var headerHeight = $('#site-header').outerHeight();
            $("#site-header").headroom({
                offset: headerHeight,
                onTop : function() {
                    $('#site-content').css({'padding-top': 0})
                },
                onNotTop : function() {
                    $('#site-content').css({'padding-top': headerHeight})
                }
            });
        }

        var offCanvas = $('.off-canvas');
        var overlay = $('.overlay');

        // Off-canvas navigation
        $('.off-canvas__navigation__toggle').click(function(e) {
            e.preventDefault();
            e.stopPropagation();

            var $subList = $(this).parent().siblings('ul');

            $subList.slideToggle();
            $subList.toggleClass('is-open');
            $(e.target).toggleClass('is-open');

            return false;

        });

        $('.off-canvas__open').click(function() {
            openOffCanvas();
        });

        $('.off-canvas__close, .overlay').click(function() {
            closeOffCanvas();
        });

        function openOffCanvas() {
            if(!offCanvas.hasClass('is-open')) {
                $('body').css({'overflow-y': 'hidden'});
                offCanvas.addClass('is-open');
                overlay.addClass('is-visible');
            }

        }

        function closeOffCanvas() {
            if(offCanvas.hasClass('is-open')) {
                $('body').css({'overflow-y': 'visible'});
                offCanvas.removeClass('is-open');
                overlay.removeClass('is-visible');
            }
        }

    });

})(jQuery);