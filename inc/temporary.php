<?php

// Temporary Functions


/* TODO: Regex some stuff! */
function fix_content_regex( $content ) {
	// find strings that match <p style="text-align:center;"> + Any characters + </p>
	// /(<p style="text-align:center;">).*(<\/p>)/g
   // return preg_replace('/(<p style="text-align:center;">).*(<\/p>)/', '/.*/', $content);

	// $string = $content;
	// $pattern = '/(<p style="text-align:center;">)(.*)(<\/p>)/';
	// $replacement = '$2';
	// echo preg_replace($pattern, $replacement, $string);



	// find strings that match <li style="text-align:left;"> + Any characters + </li>
	// /(<li style="text-align:left;">).*(<\/li>)/g
}

// add_action( 'the_content', 'fix_content_regex', 99 );



/*
 * Set first image as featured by default
 */
function ourgreennation_auto_featured_image() {

    global $post;

    // First make sure we don't have a featured image
    if ( !has_post_thumbnail( $post->ID ) ) {

	    $attached_image = get_children( "post_parent=$post->ID&amp;post_type=attachment&amp;post_mime_type=image&amp;numberposts=1" );

	     if ( $attached_image ){
			foreach ( $attached_image as $attachment_id => $attachment ){
				set_post_thumbnail( $post->ID, $attachment_id );
			}
	    }

    }

}
// Use it temporary to generate all featured images
// add_action('the_post', 'ourgreennation_auto_featured_image');
// // Used for new posts
// add_action('save_post', 'ourgreennation_auto_featured_image');
// add_action('draft_to_publish', 'ourgreennation_auto_featured_image');
// add_action('new_to_publish', 'ourgreennation_auto_featured_image');
// add_action('pending_to_publish', 'auto_featured_image');
// add_action('future_to_publish', 'auto_featured_image');

function ourgreennation_convert_post_format() {
	$posts_array = get_posts( array( 'posts_per_page' => 500, 'orderby' => 'date', 'order' => 'DESC', 'offset' => '1000' ) );
	foreach ( $posts_array as $post ) {
        // set_post_format($post->ID, 'standard' );
        // var_dump($post->ID);
        $format = get_post_format($post->ID);
        // var_dump($format);
        if( $format == 'gallery' ) {
        	set_post_format($post->ID, 'standard' );
        }
	}
	// var_dump($posts_array);
}

// add_action( 'admin_footer', 'ourgreennation_convert_post_format' );




