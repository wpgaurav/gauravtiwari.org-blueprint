<?php

/**
 * A useful function that can be used to output Page Leads
 * setting fields. This function evaluates whether or not to
 * display a field as post meta or the Settings API.
 *
 * @since 4.0
 */

function page_lead_field( $group, $field ) {
	$id      = get_queried_object_id();
	$display = page_lead_display( $group );
	$is_tax  = is_category() || is_tax() ? true : false;

	if ( $is_tax ) {
		$activate = md_term_meta( array( $group, 'activate' ) );
		$custom   = md_term_meta( array( $group, 'custom' ) );
	}
	else {
		$activate = md_post_meta( array( $group, 'activate' ) );
		$custom   = md_post_meta( array( $group, 'custom' ) );
	}

	if ( ! empty( $activate['enable'] ) && ! empty( $custom['enable'] ) ) {
		if ( is_singular() )
			return md_post_meta( array( $group, $field ) );
		elseif ( $is_tax )
			return md_term_meta( array( $group, $field ) );
	}
	elseif ( ! empty( $activate['enable'] ) || $display )
		return md_setting( array( $group, $field ) );
}


/**
 * Checks if Page Lead should be output on blog.
 *
 * @since 4.0
 */

function page_lead_display( $lead ) {
	$data = get_md( $lead );

	if (
		! is_paged() && ! empty( $data ) &&
		(
			! empty( $data['display']['site'] )                               || // sitewide
			( ! empty( $data['display']['blog'] ) && is_home() )              || // blog
			( ! empty( $data['display']['posts'] ) && is_singular( 'post' ) ) || // posts
			( ! empty( $data['display']['pages'] ) && is_page() )                // pages
		)
	)
		return true;
}

/*----------------------------------*\
	NOTE: MD4.8 adds a new design
	system, these functions are now
	on the chopping block.
\*----------------------------------*/

function md_design_background( $bg_color, $bg_image ) {
	$bg_color_prop = ! empty( $bg_color ) ? 'background-color: ' . esc_url( $bg_color ) . ';' : '';
	$bg_image_prop = ! empty( $bg_image ) ? 'background-image: url(' . esc_url( $bg_image ) . ');"' : '';
	return ! empty( $bg_color ) || ! empty( $bg_image ) ? ' style="' . $bg_color_prop . $bg_image_prop . '"' : '';
}
function md_design_block( $position ) {
	if ( ! function_exists( 'md_has_sidebar' ) )
		return;
	if ( ! empty( $position ) && $position == 'md_hook_content' && md_has_sidebar() )
		return 'block-double';
	else
		return 'block-full-lr block-triple-tb';
}
function md_design_columns_block( $position ) {
	if ( ! function_exists( 'md_has_sidebar' ) )
		return;
	if ( ! empty( $position ) && $position == 'md_hook_content' && md_has_sidebar() )
		return ' block-single-flex-lr block-mid-top';
	elseif ( $position == 'md_hook_content' )
		return ' block-double';
	else
		return ' block-double-tb';
}
function md_design_classes( $position, $design = null ) {
	if ( ! function_exists( 'md_has_sidebar' ) )
		return;
	$classes = '';
	if ( $position == 'md_hook_content' && ! md_has_sidebar() )
		$classes .= ' inner';
	return $classes;
}