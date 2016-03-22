(function($) {

    $(document).ready(function() {

        var $cfa = $('#commentFormAuthor'),
            $cft = $('#commentFormComment'),
            $cfe = $('input[name="commentFormEmotion"]');

        var $cfpa = $('#commentFormPreviewAuthor'),
            $cfpt = $('#commentFormPreviewText'),
            $cfpe = $('#commentFormPreviewEmotion');

        $cfa.on('input', function() {
            if($cfa.val() == '') {
                $cfpa.html('Förnamn Efternamn');
            } else {
                $cfpa.html($cfa.val());
            }
        });

        $cft.on('input', function() {
            if($cft.val() == '') {
                $cfpt.html('Min kommentar...');
            } else {
                $cfpt.html($cft.val());
            }
        });

        $cfe.on('change', function(e) {

            if(!$cfpt.parent().hasClass('has-emotion')) {
                $cfpt.parent().addClass('has-emotion');
            }
            var emotion = this.value;
            $cfpe.attr('src', '/wp-content/themes/wally/assets/icons/twemojis/' + emotion.substr('emotion'.length) + '.svg');
            $cfpe.show();
        });

    });

})(jQuery);