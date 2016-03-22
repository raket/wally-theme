(function($, window, document) {

    var $navigation,
        $moreContentListItem,
        $moreContentButton,
        $moreContentSubList;

    $(document).ready(function() {

        /**
         * Setup $navigation
         */
        $navigation = $('.primary-navigation > ul');

        $navigation.fixOverflowingItems = function() {

            var navigationTotalWidth = $navigation.outerWidth();
            var moreContentListItemWidth = $moreContentListItem.outerWidth();
            var hasHiddenItems = $moreContentListItem.hiddenItemWidths.length;
            var itemsTotalWidth = 0;

            $navigation.children('li').each(function() {
                itemsTotalWidth += $(this).outerWidth();
            });

            if(navigationTotalWidth < itemsTotalWidth) {
                // Overflow found

                // Is the moreContentListItem attached?
                if(!$.contains(document, $moreContentListItem[0])) {

                    // If not - attach it
                    $moreContentListItem.appendTo($navigation);
                }

                $moreContentListItem.hidePreviousItem();

                this.fixOverflowingItems();

            } else {
                // Overflow not found
                if(hasHiddenItems) {
                    var hiddenItemWidth = $moreContentListItem.hiddenItemWidths[0];

                    if(hasHiddenItems == 1) {
                        // Only one item hidden? Could it be displayed if we removed the "more content" button?
                        if(navigationTotalWidth >= itemsTotalWidth - moreContentListItemWidth + hiddenItemWidth) {
                            $moreContentListItem.showPreviousItem();
                            $moreContentListItem.detach();
                        }
                    } else {
                        if(navigationTotalWidth >= itemsTotalWidth + hiddenItemWidth) {
                            $moreContentListItem.showPreviousItem();
                        }
                    }

                }

            }

        };

        /**
         * Setup $moreContentButton
         */
        $moreContentButton = $( '<button>', {
            'id': 'moreContentButton',
            'title': 'Mer innehåll',
            'aria-label': 'Tryck på nedåtpilen för att visa mer innehåll.'
        }).html('Mer innehåll <i class="material-icons" aria-label="Nedåtpil" aria-hidden="true">keyboard_arrow_down</i>');

        //
        $moreContentButton.on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $moreContentSubList.toggle();
        });
        //Mousetrap($moreContentButton[0]).bind('down', function(e) {
        //    e.preventDefault();
        //
        //    if(!$moreContentSubList.hasClass('is-open')) {
        //        $moreContentSubList.open();
        //    } else {
        //        $moreContentSubList.openAndFocus();
        //    }
        //});
        //
        //// Hide sublist
        //Mousetrap($moreContentButton[0]).bind('click', function(e) {
        //    e.preventDefault();
        //    if($moreContentSubList.hasClass('is-open')) {
        //        $moreContentSubList.removeClass('is-open');
        //        $moreContentButton.focus();
        //    }
        //});

        /**
         * Setup $moreContentSublist
         */
        $moreContentSubList = $( '<ul>', {
            'class': 'navigation__sublist',
            'role': 'menu',
            'aria-hidden': 'true'
        });

        $moreContentSubList.toggle = function() {
            if(this.isOpen) {
                this.close();
            } else {
                this.open();
            }
        };

        $moreContentSubList.open = function() {
            if(!$moreContentSubList.hasClass('is-open')) {
                $moreContentSubList.addClass('is-open');
            }

            this.isOpen = true;
            this.attr('aria-hidden', 'false');
            this.find('a').removeAttr('tabindex');

            this.appendTo($moreContentListItem);

        };

        $moreContentSubList.openAndFocus = function() {
            this.open();
            $moreContentSubList.children().first().children('a').focus();
        };

        $moreContentSubList.close = function() {
            if($moreContentSubList.hasClass('is-open')) {
                $moreContentSubList.removeClass('is-open');
            }
            this.isOpen = false;
            this.attr('aria-hidden', 'true');
            this.find('a').attr('tabindex', '-1');

            this.detach();
        };

        /**
         * Setup $moreContentListItem
         */
        $moreContentListItem = $('<li class="navigation__item">');

        $moreContentListItem.hiddenItemWidths = [];

        // Hide the previous item in $navigation relative to $moreContentListItem
        $moreContentListItem.hidePreviousItem = function() {

            var prevItem = this.prev();

            this.hiddenItemWidths.unshift(prevItem.outerWidth());

            prevItem.removeClass('navigation__item');
            prevItem.addClass('navigation__subitem');

            prevItem.children('a').first().attr('tabindex', -1);

            prevItem.detach().prependTo($moreContentSubList);

            return prevItem;
        };

        // Show the previous item in $navigation relative to $moreContentListItem
        $moreContentListItem.showPreviousItem = function() {

            var prevItem = $moreContentSubList.children().first();

            this.hiddenItemWidths.shift();

            prevItem.removeClass('navigation__subitem');
            prevItem.addClass('navigation__item');

            prevItem.removeAttr('tabindex');

            prevItem.detach().insertBefore(this);

            return prevItem;
        };
        $moreContentListItem.append($moreContentButton);
        $moreContentListItem.append($moreContentSubList);

        $moreContentButton.on('focusout', function(event) {

            console.log(this);
            console.log(event.target);

            if(!$(this).parent() == ($moreContentSubList.parent())) {
                $moreContentSubList.close();
            }

        });

        $(document).click(function() {
            $moreContentSubList.close();
        });

        $navigation.fixOverflowingItems();

    });

    $(window).on('resize', function() {
        $navigation.fixOverflowingItems();
    });


})(jQuery, window, document);