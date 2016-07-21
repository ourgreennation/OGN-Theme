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

    imagesLoaded( $container, function( instance ) {
      $container.masonry(masonry_options);
    });

    $("#access").sticky({
      topSpacing : 0
    });

    $(".flexslider").flexslider({
      controlNav: false,
      smoothHeight: true,
      animationSpeed: 200,
      slideshow: false,
      prevText: "<i class='fa fa-chevron-circle-left' aria-hidden='true'></i>",
      nextText: "<i class='fa fa-chevron-circle-right' aria-hidden='true'></i>",
      init : function(){
        if( typeof $('.masonry').masonry() !== false ){
          $('.masonry').masonry( 'reloadItems' );
        }
      },
      after : function(){
        if( typeof $('.masonry').masonry() !== false ){
          $('.masonry').masonry( 'reloadItems' );
        }
      }
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
      imagesLoaded( $selector, function( instance ) {
          $container.append( $elements ).masonry( 'appended', $elements ).find($selector).remove();
      });
    }
  });

  $(document).ready(function(e){

    $('nav .menu').meanmenu({meanScreenWidth: "768",meanMenuClose: "&#215;"});

    $('.menu-item-has-children > a').on('click',function(e){
      var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0));

      if ( isTouch ) {
        if ($(this).attr("data-hover") != "true")
          e.preventDefault();
        $(this).attr("data-hover","true");
      }
    });

    $('.menu').find('button').addClass('disabled');

    $('.menu').find('button').on('click',function(e){
      if( $(this).hasClass('disabled') ){
        e.preventDefault();
        $(this).removeClass('disabled');
        $(this).parents('.search-box-wrapper').addClass('boom');
      }
    });

    $('.menu').find('.search-form').append('<span class="close-search"><i class="fa fa-close"></i></span>').find('.close-search').on('click',function(e){
      $(this).parents('.search-box-wrapper').find('button').addClass('disabled');
      $(this).parents('.search-box-wrapper').removeClass('boom');
    });

    $('.menu').find('.menu-item-has-children').find('> a').append('<span class="menu-indicator"/>');

    infinite_count = 0;

  });
})(jQuery);
