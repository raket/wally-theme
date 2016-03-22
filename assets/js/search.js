(function($) {

    $(document).ready(function() {

        $('input[type="search"]').autocomplete({
            serviceUrl: ajax.url,
            params: {
                'action': 'autocomplete'
            },
            onSearchComplete: function(query) {
                //console.log(query);
            },
            beforeRender: function(container) {
                //$('#searchAlert').html('Found '+ (container.children().length) +' results. Use up and down arrows to navigate.');
            },
            onSelect: function(suggestion) {
                $(this).val(suggestion.value);
                $(this).parent('form').submit();
            },
            showNoSuggestionNotice: false,
            triggerSelectOnValidInput: false
        });


    });

})(jQuery);