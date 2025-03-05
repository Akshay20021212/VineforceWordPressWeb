<?php
/**
 * Displays the post entry skills
 *
 * @package KillarWT
 * @since 1.0.0
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$skills_list = get_the_term_list(get_the_ID(), 'portfolio-skills', '', '&nbsp;&nbsp;', '');
if ( $skills_list ) {
$args = array();
$args['class'][] = 'entry-skills post-skills modal-tags d-sm-flex align-items-center pt-25';
?>	
<div <?php echo killarwt_stringify_atts( $args ); ?>>
	<span class="tags-label mb-0 pr-15 black-color f-700"><?php esc_html_e( 'Skills: ', 'killar' ); ?></span>
	<span class="cat-links tag-list"><?php echo wp_kses_post($skills_list);?></span>
</div>				
<?php
}
?>