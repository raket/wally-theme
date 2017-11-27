(function($, window, document) {

    var $navigation,
        $moreContentListItem,
        $moreContentButton,
        $moreContentSubList,
        $verticalLayout;

    $(document).ready(function() {

        /**
         * Setup $navigation
         */

        $verticalLayout = $('body').hasClass('vertical-header');


        $navigation = $('.primary-navigation > ul');

        $navigation.fixOverflowingItems = function() {

            var navigationTotalWidth = $navigation.outerWidth();
            var moreContentListItemWidth = $moreContentListItem.outerWidth();
            var hasHiddenItems = $moreContentListItem.hiddenItemWidths.length;
            var itemsTotalWidth = 0;

            $navigation.children('li').each(function() {
                itemsTotalWidth += $(this).outerWidth();
            });

            if( navigationTotalWidth < itemsTotalWidth && ! $verticalLayout ) {
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

(function ($) {
    $(document).ready(function () {
        /**
         * Sidebar logic
         */
        var mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        var mainContent = 0;
        var bottom = false;
        var top = false;
        var onSidebar = false;


        $('.vertical-header .main-content').on('scroll', function () {
            if(mobile)return;
            var scrollValue = mainContent - $(this).scrollTop();
            console.log(scrollValue);
            mainContent = $(this).scrollTop();

            $(this).bind('scroll', chk_scroll);


            var siteheader = $('.vertical-header .site-header');
            siteheader.scrollTop(siteheader.scrollTop() - scrollValue);
        });

        $('.vertical-header .site-header').on("mouseenter mouseleave", function (event) {
            onSidebar = event.type === "mouseenter";
        });


        function chk_scroll(e) {
            var elem = $(e.currentTarget);
            bottom = elem[0].scrollHeight - elem.scrollTop() < elem.outerHeight() + 5;
            top = elem.scrollTop() === 0;
        }

        $(document).bind('mousewheel', function (evt) {
            if(mobile)return;
            var siteheader = $('.vertical-header .site-header');
            var mainContent = $('.vertical-header .main-content');
            var delta = evt.originalEvent.wheelDelta;
            if (bottom && delta < 0  || onSidebar || top && delta > 0) {
                siteheader.scrollTop(siteheader.scrollTop() - (delta / 2));
                mainContent.scrollTop(mainContent.scrollTop() - (delta / 2));
                /** TODO
                 * Add smooth scrolling
                 */
            }

        });
    });
})(jQuery);