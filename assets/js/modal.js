(function($) {

    $(document).ready(function() {

        $('[data-modal]').each(function(){
            var $modal = $(this);
            var $body = $modal.find('*[data-modal-body]');
            var $backdrop = $( "<div class='modal-backdrop'/>" );
            var $trigger = $modal.find("*[data-modal-trigger]");
            var $close = $modal.find("*[data-modal-close]");

            $modal.on('open', function(){
                console.log('Open');
                $backdrop.css({
                    zIndex: $body.css('z-index') - 1,
                    position: 'fixed',
                    top: '0px',
                    bottom: '0px',
                    left: '0px',
                    right: '0px'
                });

                $backdrop.on('click', function(e){
                    console.log('Backdrop close');
                    $modal.trigger('close');
                });

                $( "body" ).append($backdrop).addClass('lock');
                $modal.addClass('open');
                $body.attr('aria-hidden', 'false');
            });

            $modal.on('close', function(){
                console.log('Close');
                $backdrop.remove();
                $modal.removeClass('open');
                $body.attr('aria-hidden', 'true');
                $('body').removeClass('lock');
            });

            $close.on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $modal.trigger('close');
            })

            $trigger.on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                $modal.trigger('open');
            });


            Mousetrap(this).bind(['esc'], function(e) {
                $modal.trigger('close');
            })
        });

    });

})(jQuery);