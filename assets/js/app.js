(function($) {

    $(document).ready(function () {
        /**
         * Sidebar logic
         */
        var mobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        var mainContent = 0;
        var bottom = false;
        var top = false;
        var onSidebar = false;


        $('.main-content').on('scroll', function () {
            if(mobile)return;
            var scrollValue = mainContent - $(this).scrollTop();
            mainContent = $(this).scrollTop();

            $(this).bind('scroll', chk_scroll);


            var siteheader = $('.site-header');
            siteheader.scrollTop(siteheader.scrollTop() - scrollValue);
        });

        $('.site-header').on("mouseenter mouseleave", function (event) {
            onSidebar = event.type === "mouseenter";
        });


        function chk_scroll(e) {
            var elem = $(e.currentTarget);
            bottom = elem[0].scrollHeight - elem.scrollTop() < elem.outerHeight() + 5;
            top = elem.scrollTop() === 0;
        }

        $(document).bind('mousewheel', function (evt) {
            if(mobile)return;
            var siteheader = $('.site-header');
            var mainContent = $('.main-content');
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

    FastClick.attach(document.body);

    window.isMobile = function() {
        var check = false;
        (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4)))check = true})(navigator.userAgent||navigator.vendor||window.opera);
        return check;
    };

    $(window).load(function(){

        $('.is-clickable').click(function() {
            var url = $(this).closest('article').find('header:first').find('a').attr('href');
            if(url) { window.location = url; }
        });

        $('[data-match="height"]').each(function(index, element) {
            $(element).matchHeight();
        });

        $('[data-fitvids]').fitVids();

    });

    if($('body').hasClass('single') && !isMobile()) {

        if($('body.single .sidebar').length) {
            $('body.single .sidebar').stick_in_parent({
                parent: $('.main'),
                offset_top: 20,

            }).on("sticky_kit:stick", function(e) {
                if ($(e.target).hasClass('sidebar--location-right')) {
	                $(e.target).parent().addClass('sidebar-spacer-sticky-right');
                } else {
	                $(e.target).parent().addClass('sidebar-spacer-sticky-left');
                }
            });
        }

        $('body').on('click', '.internal-navigation li a', function(e){
            e.preventDefault();
            var href = $(this).attr('href').replace('#', '');
            var target = $('[name="'+href+'"]');
            var offset = target.offset().top;
            var windowOffset = $(window).scrollTop();
            $('html, body').animate({'scrollTop': offset - 50}, 600);
        });
    }


    // Shortcuts
    Mousetrap(document).bind(['S', 's'], function(e) {
        e.preventDefault();
        $(window).scrollTop($("#site-content").offset().top);
    });
    Mousetrap(document).bind('0', function(e) {
        e.preventDefault();
        $(window).scrollTop($("#site-footer").offset().top);
    });


    var links = $('nav.primary-navigation ul').find('a');
    Mousetrap(document).bind('1', function(e) {
        e.preventDefault();
        window.location = links[0].href;
    });
    Mousetrap(document).bind('2', function(e) {
        e.preventDefault();
        window.location = links[1].href;
    });
    Mousetrap(document).bind('4', function(e) {
        e.preventDefault();
        $('#search-form-1').focus();
    });

    // WordPress doesn't offer a way of posting empty comments since 4.4, so we fix this with JS.
    $('#commentform').submit(function(e) {
        if($('#commentFormComment').val() === '') {
            $('#commentFormComment').html($('input[name=commentFormEmotion]:checked').val());
        }
    });

    // Allow :active despite removing -webkit-tab-highlight-color http://bit.ly/1WqdsZL
    document.addEventListener("touchstart", function(){}, true);

    // Bosse-fix
    if(($( window ).width())<960){
        $("ul.off-canvas__navigation__list").attr("aria-hidden", "false");
        $("ul.navigation__item").attr("aria-hidden", "true");
        $("div.off-canvas").attr("tabindex", "0");
        $("div.off-canvas").attr("aria-hidden", "false");
    } else {
        $("ul.off-canvas__navigation__item").attr("aria-hidden", "true");
        $("ul.navigation__list").attr("aria-hidden", "false");
        $("div.off-canvas").attr("tabindex", "-1");
        $("div.off-canvas").attr("aria-hidden", "true");
    }

    $(window).bind("resize",function(){
        if(($( window ).width())<960){
            $("ul.off-canvas__navigation__list").attr("aria-hidden", "false");
            $("ul.navigation__list").attr("aria-hidden", "true");
            $("div.off-canvas").attr("tabindex", "0");
            $("div.off-canvas").attr("aria-hidden", "false");
        } else {
            $("ul.off-canvas__navigation__list").attr("aria-hidden", "true");
            $("ul.navigation__list").attr("aria-hidden", "false");
            $("div.off-canvas").attr("tabindex", "-1");
            $("div.off-canvas").attr("aria-hidden", "true");
        }
    });


})(jQuery);