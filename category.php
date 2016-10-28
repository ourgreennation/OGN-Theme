<?php
/**
 * The template for displaying category pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Our_Green_Nation
 */

get_header();

add_filter( 'get_the_archive_title', 'ourgreennation_category_icons' );
function ourgreennation_category_icons() {

	// Get the current category
	$current_cat = get_query_var('cat');
	$category = get_category( $current_cat );

	// Parent categories
	$career_cat = 15;
	$community_cat = 3;
	$creative_cat = 44;
	$fitness_cat = 28;
	$food_cat = 10;
	$health_cat = 36;
	$house_cat = 117;
	$mindfulness_cat = 11;
	$relationship_cat = 7;
	$selfcare_cat = 66;


	if( is_category( $career_cat ) || cat_is_ancestor_of( $career_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_career.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $community_cat ) || cat_is_ancestor_of( $community_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_community.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $creative_cat ) || cat_is_ancestor_of( $creative_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_creative.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $fitness_cat ) || cat_is_ancestor_of( $fitness_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_fitness.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $food_cat ) || cat_is_ancestor_of( $food_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_food.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $health_cat ) || cat_is_ancestor_of( $health_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_health.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $house_cat ) || cat_is_ancestor_of( $house_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_house.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $mindfulness_cat ) || cat_is_ancestor_of( $mindfulness_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_mindfulness.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $relationship_cat ) || cat_is_ancestor_of( $relationship_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_relationship.jpg" class="category-icon" /> ' . $category->name;
	} elseif( is_category( $selfcare_cat ) || cat_is_ancestor_of( $selfcare_cat, $current_cat ) ) {
		return '<img src="' . get_stylesheet_directory_uri() . '/assets/img/icon_selfcare.jpg" class="category-icon" /> ' . $category->name;
	} else {
		return;
	}

}
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) : ?>

				<header class="page-header">
					<?php
						the_archive_title( '<h1 class="page-title">', '</h1>' );

						// Get the current category
						$current_cat = get_query_var('cat');
						$category = get_category( $current_cat );

						// Only display category dropdown if on a parent category
						$children = get_categories( array( 'child_of' => $current_cat,'hide_empty' => 0 ) );
						if ( count( $children ) >= 1 ){
							$cat_args = array(
								'show_option_none' => __( 'Subcategories', 'our-green-nation' ),
	 							'hierarchical' => 1,
	 							'depth'	=> 0,
	 							'child_of' => $current_cat,
	 							'echo' => 0,
								);

							// Change option_none title for subcategories
							if ( $category->category_parent > 0 ){
								$cat_args['show_option_none'] = __( 'Subcategories', 'our-green-nation' );
							}


							echo '<form id="category-select" class="category-select" action="' . esc_url( home_url( '/' ) ) . '" method="get">';

								// Change category links to display with JS to submit form
								$select  = wp_dropdown_categories( $cat_args );
								$replace = "<select$1 onchange='return this.form.submit()'>";
								$select  = preg_replace( '#<select([^>]*)>#', $replace, $select );

								echo $select;

								// displays submit button if JS is not available
								echo '<noscript><input type="submit" value="View" /></noscript>';

							echo '</form>';
						}

						// Display description of category
						the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header>

				<div class="masonry">

					<div class="grid-sizer"></div>

					<?php
					/* Start the Loop */
					while ( have_posts() ) : the_post();

						/*
						 * Include the Post-Format-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'components/post/content', get_post_format() );

					endwhile;
					?>

				</div>

				<?php

				the_posts_navigation();

			else :

				get_template_part( 'components/post/content', 'none' );
			endif;
			?>

		</main>
	</div>
<?php
// Choose to pull sidebar based on layout
ourgreennation_template_layout();
get_footer();