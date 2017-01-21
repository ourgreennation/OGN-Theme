<?php
/**
 * Widgets
 *
 * @package  Lift\OGN\Theme
 * @subpackage  Widgets
 */

namespace Lift\OGN\Theme;

/**
 * Class: Widgets
 *
 * @since  v1.2.0
 */
final class Widgets {

	/**
	 * Widget IDs added
	 *
	 * @var array|null
	 */
	protected $added_widget_ids;

	/**
	 * Constructor
	 *
	 * @return  Widgets Instance of self
	 */
	public function __construct() {
		$this->added_widget_ids = array();
		return $this;
	}

	/**
	 * Register Hooks
	 *
	 * @since  v1.2.0
	 * @return void
	 */
	public function register_widgets() {
		array_push( $this->added_widget_ids, $this->register_not_logged_sidebar() );
	}

	/**
	 * Register Not Logged In Widget Area
	 *
	 * @since  v1.2.0
	 * @return int Widget ID
	 */
	public function register_not_logged_sidebar() {
		return register_sidebar( array(
			'name'          => esc_html__( 'Not Logged In - Global', 'our-green-nation' ),
			'id'            => 'not-logged-in',
			'description'   => 'Sidebar that display across the site if a user is not logged in.',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
