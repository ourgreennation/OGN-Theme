<?php
/**
 * @package OneSocial Theme
 */
?>

<article id="post-<?php the_ID(); ?>-ad" <?php post_class( 'advertisement' ); ?>>

	<div class="ad-wrap">

		<?php
			global $abinst;
			$def = array(
				'adbutler_id' => get_option('adbutler_id'),
				'host_name' => get_option('adbutler_host_name'),
				'ssl_host_name' => get_option('adbutler_ssl_host_name'),
				'zone_id' => '220857',
				'type' => 'asyncjs',
				'secure' => 'on',
				'size' => '300x250',
				'name' => 'sidebar_300x250',
				'responsive' => 'FIXED'
			);
			echo $abinst->build_ad_tag($def);
		?>

	</div>

</article>