<?php
/**
 * The template for displaying a search form
 *
 * @package Our_Green_Nation
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
    <label>
        <span class="screen-reader-text">Search For:</span>
        <input type="search" class="search-field" placeholder="Search &hellip;" value="<?php get_search_query() ?>" name="s" />
    </label>
    <button class="search-button" type="submit"><i class="fa fa-search"></i></button>
</form>