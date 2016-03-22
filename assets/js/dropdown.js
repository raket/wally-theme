(function($) {

    $(document).ready(function() {

        $('*[data-dd]').each(function(){
            var dd = $(this);
            var drawer = dd.find('*[data-dd-drawer]');
            var $backdrop = $( "<div class='backdrop'/>" );
            var $trigger = dd.find("*[data-dd-trigger]");

            dd.on('open', function(){
                $backdrop.css({
                    zIndex: drawer.css('z-index') - 1,
                    position: 'fixed',
                    top: '0',
                    bottom: '0',
                    left: '0',
                    right: '0'
                });

                $backdrop.on('click', function(e){
                    $backdrop.remove();
                    dd.removeClass('open');
                    $trigger.focus();
                });

                $( "body" ).append($backdrop);
                dd.addClass('open');
            });
            dd.on('close', function(){
                $backdrop.remove();
                dd.removeClass('open');
                $trigger.focus();
            });


            $trigger.on('click', function(e){
                e.preventDefault();
                dd.trigger('open');
            });

            drawer.on('click', 'a', function(e){
                e.preventDefault();
                dd.find('li').removeClass('active');
                $(this).parent().addClass('active');
                dd.find('.value').html($(this).html());

                dd.trigger('close');
            });

            Mousetrap(this).bind(['esc'], function(e) {
                dd.trigger('close');
            });
        });

    });

})(jQuery);