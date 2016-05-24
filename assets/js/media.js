(function($) {

    $(document).ready(function() {

        // Fullscreen images
        $('[data-image]').magnificPopup({
            delegate: '.make-fullscreen',
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-fade',
            image: {
                titleSrc: function(item) {
                    return item.el.parents('figure').find('img').first().attr('alt');
                }
            },
            tLoading: '' // Remove "Loading..."
        });

        $('figure[data-image]').each(function(){
            var bg = $(this).data('image');
            $(this).css('background-image', 'url(' + bg + ')').addClass('loaded');
            $(this).append('<img src="' + bg +'" />');
        });

    });

})(jQuery);