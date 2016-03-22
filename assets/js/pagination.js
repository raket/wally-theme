(function($) {

    var currentPage = 2;

    $(document).ready(function() {

        var $pagination = $('[data-pagination]'),
            $button = $( '<button>', {
                'class': 'button button--primary pagination__button icon-load',
                'type': 'button'
            }).html('<span>Ladda fler artiklar</span>'),
            post = $pagination.data('pagination');

        $button.on('click', function(e) {
            var $this = $(this),
                currentText = $this.html(),
                newText = 'Laddar...';

            e.preventDefault();

            $this.html(newText);
            $this.attr('disabled', 'true');
            $this.attr('aria-disabled', 'true');

            $.ajax({
                url: ajax.url,
                data: {
                    action: 'ajax_pagination',
                    page: currentPage,
                    post: post
                },
                dataType: 'json',
                success: function(response) {

                    // The articles are sent in pure HTML
                    var $response = $($.parseHTML(response.articles)),
                        maxNumPages = response.pages;

                    if($pagination.length) {
                        $response.insertBefore($pagination);
                    }

                    if(currentPage >= maxNumPages) {
                        $this.html('Inga fler inlägg');
                    } else {
                        $this.removeAttr('disabled');
                        $this.attr('aria-disabled', 'false');
                        $this.html(currentText);
                    }

                    currentPage++;

                }
            });

        });

        $pagination.empty();
        $button.appendTo($pagination);

    });

})(jQuery);