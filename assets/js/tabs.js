(function($) {

    $(document).ready(function() {

        $('[data-tabs]').each(function() {

            var $tabs = $(this);

            $tabs.find('a').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();

                    var $panel = $($(this).attr('href'));

                    $(this).parent().siblings('.is-active').removeClass('is-active');
                    $(this).parent().addClass('is-active');

                    $panel.siblings('.is-active').removeClass('is-active');
                    $panel.addClass('is-active');

                });
            });

        });

    });

})(jQuery);