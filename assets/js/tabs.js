(function($) {

    $(document).ready(function() {

        $('[data-tabs]').each(function() {

            var $tabs = $(this);

            $tabs.find('a').each(function() {
                $(this).on('click', function(e) {
                    e.preventDefault();

                    var $panel = $($(this).attr('href'));

                    $(this).parent().siblings('.is-active').attr('aria-selected', 'false');
                    $(this).parent().siblings('.is-active').removeClass('is-active');

                    $(this).parent().addClass('is-active');
                    $(this).parent().attr('aria-selected', 'true');

                    $panel.siblings('.is-active').attr('aria-hidden', 'true');
                    $panel.siblings('.is-active').removeClass('is-active');

                    $panel.attr('aria-hidden', 'false');
                    $panel.addClass('is-active');

                });
            });

        });

    });

})(jQuery);