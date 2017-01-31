( function ( $ ) {
    $( '#masonry' ).imagesLoaded().done( () => {
        $( '#masonry' ).masonry( {
            itemSelector : '.hentry',
            columnWidth  : '.hentry',
            gutter       : 20,
            isFitWidth   : true,
        } );
    });

    setTimeout( () => { $( '#masonry').masonry() }, 500 );

    $( document ).on( 'click', '.button-load-more-posts', function ( event ) {
        event.preventDefault();

        var self = $( this );

        var page = self.data( 'page' ),
            template = self.data( 'template' ),
            href = self.attr( 'href' );

        self.addClass( 'loading' );

        $.get( href, function ( response ) {
            $( '.pagination-below' ).remove();

            if ( template === 'home' ) {
                $( response ).find( '.article-outher' ).each( function () {
                    $( '#content' ).append( $( this ) );
                } );
            } else if ( template === 'search' ) {
                $( response ).find( 'article.hentry' ).each( function () {
                    $( '.search-content-inner' ).append( $( this ) );
                } );
            } else {
                $( response ).find( 'article.type-post' ).each( function () {
                    if ( $( this ).hasClass( 'advertisement' ) ) {
                        this.innerHTML = '';
                        $( '#masonry' ).append( $( this ) );
                        var $el = adbutlerLoadAd( $( this ) );
                        $( '#masonry' )
                            .append( $el )
                            .imagesLoaded()
                            .done( () => { $( '#masonry' ).masonry( 'appended', $el ) } );
                    } else {
                        $( '#masonry' )
                            .append( $( this ) )
                            .imagesLoaded()
                            .done( () => { $( '#masonry' ).masonry( 'appended', $( this ) ) } );
                    }        
                } );
            }

            $( '#content' ).append( $( response ).find( '.pagination-below' ) );
        } );
    } );

    $( document ).on( 'scroll', function () {

        var load_more_posts = $( '.post-infinite-scroll' );

        if ( load_more_posts.length ) {

            var pos = load_more_posts.offset();

            if ( $( window ).scrollTop() + $( window ).height() > pos.top ) {

                if ( !load_more_posts.hasClass( 'loading' ) ) {
                    load_more_posts.trigger( 'click' );
                }
            }
        }

    } );

    /**
     * AdbutlerLoadAd
     *
     * Sets up variables to pass to retrieveAd based on a 
     * @param  {object} $el jQuery element object
     * @return {object}     jQuery element object
     */
    function adbutlerLoadAd( $el ) {
        var pageID = ';pid='+ Math.floor(Math.random() * 10e6);
        var zonetag = 'https://servedbyadbutler.com/adserve/;ID=168865;size=300x250;setID=220857;type=json;click=CLICK_MACRO_PLACEHOLDER';
        var i = 0;
        $element = retrieveAd( zonetag, $el[0].id, i, pageID );
        return $element;
    }

    /**
     * Retrieve Ad from AdButler
     * 
     * @param  {string} zone     String of zone.
     * @param  {string} id       ID of the element to put the ad in.
     * @param  {int}    iterator Iterator index.
     * @param  {string} pageID   Generate Page ID
     * @return {object}          jQuery element object.
     */
    function retrieveAd(zone,id,iterator,pageID) {
        var i = iterator || 0;
        var pid = pid || "";
        var start = zone.indexOf(';type');
        var place = ';place='+iterator;
        var tagpt1 = zone.slice(0,start);
        var tagpt2 = zone.slice(start,200);
        zone = tagpt1+';pid='+pid+place+tagpt2;
        let retVal;
        
        $.ajax({
            url:zone,  
            success:function(data) {
                if (data.status == "SUCCESS"){
                    i ++;
                    retVal = buildBanner(data.placements.placement_1,id); 
                }
                else if (data.status == "NO_ADS" && i > 0) {
                    i = 0;
                    retVal = retrieveAd(zonetag,id,i,pageID);
                }
            }
        });
        return retVal;
    }

    /**
     * Builds a Banner Ad
     * 
     * @param  {object} data Data object frm AdButler
     * @param  {string} id   Id of the element to buid the banner in.
     * @return {object}      jQuery object of the element.
     */
    function buildBanner(data,id){
        if (data == undefined){
            return false;
        }
        $('#'+id).html('<a><img id="bannerImage" /></a>');
        $('#'+id).css({
            width: 270,
            paddingBottom: '20px'
        });
        if (data.body != ""){
            $('#'+id).html(data.body);
            if (data.accupixel_url){
                $('#'+id).append('<img src="'+data.accupixel_url+'" />');
            }
        }
        else if (data.image_url != ""){
            if (data.redirect_url){
                $('#'+id+' a').attr({
                    href: data.redirect_url,
                    target: data.target
                });
            }
            $('#'+id+' #bannerImage').attr({
                'alt': data.alt_text,
                'src': data.image_url,
                'width': 270,
                'height': 'auto',
            });
            $('#'+id+' img').on('load',function(){
                if (data.accupixel_url){
                    $('#'+id).append('<img src="'+data.accupixel_url+'" />');
                }
            })
        }
        if (data.tracking_pixel){
            $('#'+id).append('<img src="'+data.tracking_pixel+'" />');
        }
        return $('#'+id);
    }

} )( jQuery );
