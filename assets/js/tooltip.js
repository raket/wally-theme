(function($) {

    $(document).ready(function() {

        $('[data-tooltip]').each(function(){

            var $trigger = $(this),
                $tooltip = $( '<div>', {
                    'class': 'tooltip',
                    'role': 'menu',
                    'aria-hidden': 'false'
                }).html($trigger.data('tooltip')),
                $close = $('<button>', {
                    'class': 'tooltip__close'
                });


            $trigger.attr('tabindex', 0);

            $tooltip.append($close);

            $tooltip.on('open', function(){
                $tooltip.appendTo($trigger);
                setTimeout(function() {
                    $tooltip.addClass('is-open');
                }, 125);
            });

            $tooltip.on('close', function(){
                $tooltip.removeClass('is-open');
                $tooltip.detach();
            });

            $tooltip.on('click', '.tooltip__close', function(e){
                e.preventDefault();
                e.stopPropagation();
                $tooltip.trigger('close');
            });

            $trigger.on('click, focus', function(e){
                $tooltip.trigger('open');
            });

            $trigger.on('focusout', function(e) {
                $tooltip.trigger('close');
            });

            Mousetrap(this).bind(['space', 'enter'], function(e) {
                $tooltip.trigger('open');
            });

            Mousetrap($close.get(0)).bind(['space', 'enter'], function(e) {
                e.preventDefault();
                e.stopPropagation();
                $tooltip.trigger('close');
                $trigger.focus();
            });

        });

    });

})(jQuery);