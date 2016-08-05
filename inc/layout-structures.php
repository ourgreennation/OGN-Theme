<?php
/**
 * @package  Our_Green_Nation
 */

/**
 * Actions & filters
 *
 * @since    1.0.0
 */

add_action( 'admin_init', 'ourgreennation_layout_create_defaults' );
add_action( 'add_meta_boxes', 'ourgreennation_layout_add_custom_layout_box' );
add_action( 'save_post', 'ourgreennation_layout_save' );
add_filter( 'body_class', 'ourgreennation_change_layout', 99, 1 );

/**
 * Create default layout options
 *
 * @since 1.0.0
 */
function ourgreennation_layout_create_defaults() {

    $layouts = apply_filters( 'ourgreennation_default_layouts', array(

        'content-sidebar' => array(
            'label'     => __( 'Content / Sidebar', 'our-green-nation' ),
            'img'       => OGN_IMG_DIR . 'content-sidebar.png',
            'default'   => true,
        ),

        'sidebar-content' => array(
            'label'     => __( 'Sidebar / Content', 'our-green-nation' ),
            'img'       => OGN_IMG_DIR . 'sidebar-content.png',
        ),

        'full-width' => array(
            'label'     => __( 'Full Width', 'our-green-nation' ),
            'img'       => OGN_IMG_DIR . 'full-width.png',
        ),

    ), OGN_IMG_DIR );

    foreach ( (array)  $layouts as $layout_id => $layout_args ) {
        ourgreennation_layout_register( $layout_id, $layout_args );
    }


}

/**
 * Register layout options, including defaults
 *
 * @since 1.0.0
 */
function ourgreennation_layout_register( $id = '', $args = array() ) {

    global $_ourgreennation_layouts;

    if ( ! is_array( $_ourgreennation_layouts ) ) {
        $_ourgreennation_layouts = array();
    }

    // Don't allow duplicate layout
    if ( isset( $_ourgreennation_layouts[$id] ) ) {
        return false;
    }

    $defaults = array(
        'label' => __( 'No Layout', 'our-green-nation' ),
        'img'   => OGN_IMG_DIR . '/thumbnail.png',
    );

    $args = wp_parse_args( $args, $defaults );

    $_ourgreennation_layouts[$id] = $args;

    return $args;

}

/**
 * Allow layouts to be unregistered
 *
 * @since 1.0.0
 */
function ourgreennation_layout_unregister( $id = '' ) {

    global $_ourgreennation_layouts;

    if ( ! $id || ! isset( $_ourgreennation_layouts[$id] ) ) {
        return false;
    }

    unset( $_ourgreennation_layouts[$id] );

    return true;

}

/**
 * Set default layout for site
 *
 * @since 1.0.0
 */
function ourgreennation_layout_set_default( $id = '' ) {

    global $_ourgreennation_layouts;

    if ( ! is_array( $_ourgreennation_layouts ) ) {
        $_ourgreennation_layouts = array();
    }

    // Remove default from all layouts
    foreach ( (array) $_ourgreennation_layouts as $value => $default_value ) {
        if ( isset( $_ourgreennation_layouts[$value]['default'] ) )
            unset( $_ourgreennation_layouts[$value]['default'] );
    }

    $_ourgreennation_layouts[$id]['default'] = true;

    return $id;

}

/**
 * Get default layout for site
 *
 * @since 1.0.0
 */
function ourgreennation_layout_get_default( $id = '' ) {

    global $_ourgreennation_layouts;

    $default = 'nolayout';

    foreach ( (array) $_ourgreennation_layouts as $value => $default_value ) {
        if ( isset( $default_value['default'] ) && $default_value['default'] ) {
            $default = $value;
        }
    }

    return $default;

}

/**
 * Return all registered layouts as wrapped form elements
 *
 * @since 1.0.0
 */
function ourgreennation_layout_return_registered_layouts() {

    global $_ourgreennation_layouts;

    // If no layouts exists, return empty array
    if ( ! is_array( $_ourgreennation_layouts ) ) {
        $_ourgreennation_layouts = array();
        return $_ourgreennation_layouts;
    }

    $layouts = array();
    foreach ( (array) $_ourgreennation_layouts as $id => $values ) {
        $layouts[$id] = $values;
    }

    return $layouts;

}

/**
 * Return a single registered layout
 *
 * @since 1.0.0
 */
function ourgreennation_layout_return_registered_layout( $id ) {

    $layouts = layout_return_registered_layouts();

    if ( ! $id || ! isset( $layouts[$id] ) )
        return;

    return $layouts[$id];

}


/**
 * Create a layout selector for each registered layout
 *
 * @since 1.0.0
 */
function ourgreennation_layout_generate_selector( $args ) {

    // should decide what our defaults should be, if any
    $defaults = array(
        'name' => '',
        'selected_layout' => ''
    );

    wp_parse_args( $args, $defaults );

    $output = '';

    foreach ( ourgreennation_layout_return_registered_layouts() as $id => $values ) {

        $class = ( $id == $args['selected_layout'] ) ? ' selected' : '';

        $output .= '<div class="layout-meta">';
        $output .= sprintf(
            '<label title="%1$s" class="box%2$s"><input type="radio" name="%4$s" id="%4$s" value="%5$s" %6$s /> %1$s<img src="%3$s" alt="%1$s" /></label>',
            esc_attr( $values['label'] ),
            esc_attr( $class ),
            esc_url( $values['img'] ),
            $args['name'],
            esc_attr( $id ),
            checked( $id, $args['selected_layout'], false )
        );

        $output .= '</div>';

    }

    return $output;

}

/**
 * Custom Layout Metabox for Editor Page
 * Adds a box to the main column on the Post and Page edit screens
 *
 * @since 1.0.0
 */
function ourgreennation_layout_set_layout() {

}

/**
 * Custom Layout Metabox for Editor Page
 * Adds a box to the main column on the Post and Page edit screens
 *
 * @since 1.0.0
 */
function ourgreennation_layout_add_custom_layout_box() {

    $layout = __( 'Layout Settings', 'our-green-nation' );
    add_meta_box(
        'ourgreennation_layout_custom_layout',
        $layout,
        'ourgreennation_layout_inner_custom_layout_box',
        'page'
    );

}

/**
 * Prints the box content
 *
 * @param  integer $post
 * @since  1.0.0
 */
function ourgreennation_layout_inner_custom_layout_box( $post ) {

    $selected_layout = get_post_meta( $post->ID, '_ourgreennation_post_layout', true );
    $custom_body_class = get_post_meta( $post->ID, '_ourgreennation_layout_custom_body_class', true);

    $selector_args = array(
        'name' => '_ourgreennation_post_layout',
        'selected_layout' => $selected_layout
    );

    $layouts = ourgreennation_layout_generate_selector( $selector_args );

    // Use nonce for verification
    wp_nonce_field( 'save_post_layout', 'layout_nonce' );

    $settings_url = '<a href="' . admin_url( 'admin.php?page=ourgreennation_theme_settings' ) . '">';

    ?>

    <fieldset class="clearfix">
        <div class="default-layout-meta">
            <input type="radio" id="default-layout" name="_ourgreennation_post_layout" value="" <?php checked( $selected_layout, '' ); ?> />
            <label for="default-layout">
                <span><?php echo sprintf( __( 'Defaul Layout Set in %1$sTheme Settings%2$s', 'our-green-nation' ), '<a href="' . admin_url() .'customize.php">', '</a>' ); ?></span>
            </label>
        </div>

        <?php echo $layouts; ?>

        <div class="layout-meta layout-class">
            <label for="ourgreennation_layout_new_field">
            <span><?php _e( 'Custom Body Class For This Page/Post:', 'our-green-nation' ); ?></span>
            </label>
            <br />
            <input type="text" id="ourgreennation_layout_custom_body_class" name="_ourgreennation_layout_custom_body_class" value="<?php echo esc_attr( sanitize_html_class( $custom_body_class ) ) ?>" size="20" />
        </div>
    </fieldset>

    <?php
}

/**
 * Save Custom Post Data
 *
 * @param  integer $post_id
 * @since  1.0.0
 */
function ourgreennation_layout_save( $post_id ) {


    // If this is an autosave, our form has not been submitted, so we don't want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return $post_id;

    // Check if our nonce is set
    if ( ! isset( $_POST['layout_nonce'] ) )
        return $post_id;

    // Set the nonce variable
    $nonce = $_POST['layout_nonce'];

    // Verify that the nonce is valid
    if ( ! wp_verify_nonce( $nonce, 'save_post_layout' ) )
        return $post_id;

    // Check the user's permissions
    if ( 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) )
            return $post_id;

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) )
            return $post_id;
    }

    // Sanitize the input
    $layout_data = esc_attr( strip_tags( $_POST['_ourgreennation_post_layout'] ) );
    $class_data = esc_attr( strip_tags( $_POST['_ourgreennation_layout_custom_body_class'] ) );

    // Update the layout and class meta
    if( isset( $_POST['_ourgreennation_post_layout'] ) )
        update_post_meta( $post_id, '_ourgreennation_post_layout', $layout_data );

    if( isset( $_POST['_ourgreennation_layout_custom_body_class'] ) )
        update_post_meta( $post_id, '_ourgreennation_layout_custom_body_class', $class_data );


}

/**
 * Sets Body Class For Styling
 *
 * @param  array    $classes
 * @global $post
 * @return array    $classes    modified classes for layout
 * @since  1.0.0
 */
function ourgreennation_change_layout( $classes ) {

    $theme_settings = get_option( 'ourgreennation_theme_settings' );
    $default_layout = $theme_settings[ 'ourgreennation_default_layout' ];

    // Make sure we have the current queried object
    $queried_object = get_queried_object();

    if ( is_home() || is_front_page() ){
        array_push( $classes, $default_layout );
    }

    if ( is_single() || is_page() ){

        // Set layout if selected, else set default
        if ( empty( $queried_object) ){ // this check might not be necessary
            array_push( $classes, $default_layout );
        } else {

            $_body_class = get_post_meta( $queried_object->ID, '_ourgreennation_post_layout', true );

            if ( ! empty( $_body_class ) ) {
                array_push( $classes, $_body_class );
            } else {
                array_push( $classes, $default_layout );
            }

            // If a custom body class is assigned, add that class to the body element
            $custom_body_class = get_post_meta( $queried_object->ID, '_ourgreennation_layout_custom_body_class', true );

            if ( ! empty( $custom_body_class ) )  {
                array_push( $classes, esc_attr( sanitize_html_class( $custom_body_class ) ) );
            }

        }

    }

    if ( is_archive() ){
        array_push( $classes, $default_layout );
    }

    return $classes;

}

/**
 * Adds Layout Structures
 *
 * @since  1.0.0
 */
function ourgreennation_template_layout() {

    $theme_settings = get_option( 'ourgreennation_theme_settings' );

    // Check to see if custom layout is set in page/post, else use theme default
    if ( is_single() || is_page() ) {

        $queried_object = get_queried_object();
        $layout = get_post_meta( $queried_object->ID, '_ourgreennation_post_layout', true );

        if ( empty( $layout) ) {
           $layout = $theme_settings['ourgreennation_default_layout'];
        }

    } else {

        if ( empty( $layout) ) {
            $layout = $theme_settings['ourgreennation_default_layout'];
        }

    }


    // If the post/page uses a layout of full width, do nothing
    if ( $layout == 'full-width' ) {

    // Else if the layout has a sidebar or isn't defined, include the sidebar
    } else {

        get_sidebar();

    }

}