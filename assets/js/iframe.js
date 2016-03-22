(function($) {

    $(document).ready(function() {

        var $iframe = $('iframe'),
            $parent = $iframe.parents('article, section').first(),
            $text   = $parent.find('h1, h2, h3').first().text();

        $iframe.attr('title', 'Ett videoklipp till inlägget ' + $text);

    });

})(jQuery);