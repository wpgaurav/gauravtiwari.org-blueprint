<?php
/**
 * Shorthand way to display a Action Lead field.
 *
 * @since 4.0
 */

function action_lead_field( $field ) {
	return page_lead_field( 'action_lead', $field );
}

/**
 * Check if page has the Action Lead. This function can be used
 * like any WordPress conditional (like is_page(), is_single(), etc.)
 * and is used in this plugin to load styles.
 *
 * @since 4.0
 */

function has_action_lead() {
	$checkmarks       = action_lead_field( 'checkmarks' );

	$type = action_lead_field( 'type' );

	if (
		action_lead_field( 'headline' ) ||
		action_lead_field( 'subtitle' ) ||
		action_lead_field( 'desc' )     ||
		( ! empty( $type ) && (
			( $type == 'email' && ( action_lead_field( 'email_list' ) || action_lead_field( 'email_code' ) ) ) ||
			( $type != 'email' && action_lead_field( 'button_link' ) )
		) )
	)
		return true;
}

/**
 * Create options array to feed to the email form function
 * (used in display() method).
 *
 * @since 4.0
 */

function action_lead_email_form() {
	return array(
		'email_title'       => action_lead_field( 'email_title' ),
		'email_desc'        => action_lead_field( 'email_desc' ),
		'email_list'        => action_lead_field( 'email_list' ),
		'email_input'       => action_lead_field( 'email_input' ),
		'email_name_label'  => action_lead_field( 'email_name_label' ),
		'email_email_label' => action_lead_field( 'email_email_label' ),
		'email_submit_text' => action_lead_field( 'email_submit_text' ),
		'email_form_style'  => action_lead_field( 'email_form_style' ),
		'email_form_title'  => action_lead_field( 'email_form_title' ),
		'email_form_footer' => action_lead_field( 'email_form_footer' ),
		'email_thank_you'   => action_lead_field( 'email_thank_you' ),
		'email_classes'     => action_lead_field( 'email_classes' ),
		'email_code'        => action_lead_field( 'email_code' )
	);
}

function action_lead_has_intro() {
	$subtitle = action_lead_field( 'subtitle' );
	$headline = action_lead_field( 'headline' );
	$desc     = action_lead_field( 'desc' );

	if ( ! empty( $headline ) || ! empty( $subtitle ) || ! empty( $desc ) )
		return true;
}

function action_lead_block( $type, $position, $button_style, $fields ) {
	if ( $type == 'button_simple' && ! empty( $button_style['left_right'] ) && $position != 'md_hook_content' )
		$classes = 'block-mid-tb';
	else
		$classes = 'block-double';

	return $classes;
}

function action_lead_content_box_classes( $type, $position, $button_style ) {
	if ( $position != 'md_hook_content' && action_lead_has_intro() && ! empty( $type ) && ( $type != 'button_simple' || ! empty( $button_style['left_right'] ) ) )
		$classes = 'content-sidebar content-box-slim';
	else
		$classes = 'text-center';

	return $classes;
}

function action_lead_content_classes( $type, $position, $button_style ) {
	$classes = '';

	if ( $type != 'button_simple' && $position != 'md_hook_content' )
		return ' mb-double';

	if ( ( $type == 'button_simple' && empty( $button_style['left_right'] ) ) || $position == 'md_hook_content' )
		return ' mb-mid';
}

function action_lead_sidebar_classes( $type, $position, $button_style ) {
	$classes = '';

	if ( $position != 'md_hook_content' && ! empty( $button_style['left_right'] ) )
		$classes .= ' text-right';
	if ( $type == 'button_simple' && ! empty( $button_style['left_right'] ) && $position != 'md_hook_content' )
		$classes .= ' aligncontent';

	return $classes;
}