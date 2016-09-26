(function($){

  function setupFitVids() {
    // FitVids is only loaded on the pages and single post pages. Check for it before doing anything.
    if (!$.fn.fitVids) {
      return;
    }

    $('#content').fitVids({ customSelector: "iframe[src*='www.youtube.com'],iframe[src*='www.dailymotion.com'],iframe[src*='www.viddler.com'],iframe[src*='money.cnn.com'],iframe[src*='www.educreations.com'],iframe[src*='blip.tv'],iframe[src*='embed.ted.com'],iframe[src*='www.hulu.com']" });

    // Fix padding issue with Blip.tv issues; note that this *must* happen after Fitvids runs
    // The selector finds the Blip.tv iFrame then grabs the .fluid-width-video-wrapper div sibling
    $('.fluid-width-video-wrapper:nth-child(2)', '.video-container')
      .css({ 'paddingTop': 0 });
  }

  $(document).on('ready', setupFitVids);
  $(document).on('post-load', setupFitVids);

  $(window).on('load', function(e){

    var $container = $(".masonry"),
        $activityContainer = $(".directory.activity #activity-stream"),
        $body = $("body"),
        rtl = false;

    if( $body.hasClass('rtl') ){
      rtl = true;
    }

    var masonry_options = {
      gutterWidth        : 40,
      // isFitWidth         : true,
      columnWidth        : '.grid-sizer',
      percentPosition    : true,
      itemSelector       : '.hentry',
      isRTL              : rtl,
      isResizable        : true,
      isAnimated         : true,
    };

    var activity_masonry_options = {
      gutterWidth        : 40,
      // isFitWidth         : true,
      columnWidth        : '.activity-item',
      percentPosition    : true,
      itemSelector       : '.activity-item',
      isRTL              : rtl,
      isResizable        : true,
      // isAnimated         : true,
    };

    // Can potentially remove imagesLoaded requirement
    imagesLoaded( $container, function( instance ) {
      $container.masonry(masonry_options);
      // $activityContainer.masonry(activity_masonry_options);
    });

  });

  // Triggers re-layout on infinite scroll
  $( document ).on( 'post-load', function (e) {
    infinite_count = infinite_count + 1;
    var $selector  = $('#infinite-view-' + infinite_count),
        $elements  = $selector.find('.hentry'),
        $container = $('.masonry');

    $elements.css({ 'opacity': 0 });

    if( typeof $container.masonry() !== false ){
      // Can potentially remove imagesLoaded requirement
      imagesLoaded( $selector, function( instance ) {
          $container.append( $elements ).masonry( 'appended', $elements ).find($selector).remove();
          // $activityContainer.append( $elements ).masonry( 'appended', $elements ).find($selector).remove();
      });
    }
  });

  $(document).ready(function(e){

    $('.menu-item-has-children > a').on('click',function(e){
      var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));

      if ( isTouch ) {
        if ($(this).attr("data-hover") != "true")
          e.preventDefault();
        $(this).attr("data-hover","true");
      }
    });

    $(function() {
      $('#top-menu').smartmenus({
        mainMenuSubOffsetX: -1,
        mainMenuSubOffsetY: 4,
        subMenusSubOffsetX: 6,
        subMenusSubOffsetY: -6,
        subIndicators: true,
      });
    });

    infinite_count = 0;



    /* getting viewport width */
    var responsive_viewport = $(window).width();

    /* if is above 900px */
    if (responsive_viewport > 900) {

      // Scroll down and stick header menu to top of screen
      var headerMenu = $("header#masthead");
          headerMenuScrolled = "main-nav-scrolled";
          headerHeight = $(headerMenu).height();

      $(window).scroll(function() {
        if( $(this).scrollTop() > headerHeight ) {
          headerMenu.addClass(headerMenuScrolled);
        } else {
          headerMenu.removeClass(headerMenuScrolled);
        }
      });

    }

    /* if is below 900px */
    if (responsive_viewport < 901) {

        /* load gravatars */
        $('.comment img[data-gravatar]').each(function(){
            $(this).attr('src',$(this).attr('data-gravatar'));
        });


        /* Load Sidr Menu */
        (function( $ ) {
            "use strict";
            $(function() {
            // Slide-Out Menu

                /* prepend menu icon */
                $('.site-menu-inner').prepend('<div id="mobile-header"><a class="responsive-menu-button fa fa-bars" href="#sidr"></a></div>');

                $('.responsive-menu-button').sidr({
                    name: 'sidr',
                    source: '#top-menu',
                    side: 'right',
                    onOpen: function () {
                        $('.responsive-menu-button').addClass('fa-close');
                        $('.responsive-menu-button').removeClass('fa-bars');
                    },
                    onClose: function () {
                        $('.responsive-menu-button').addClass('fa-bars');
                        $('.responsive-menu-button').removeClass('fa-close');
                    },
                });


            });

        }(jQuery));

    }

  });

})(jQuery);
