<?php

/**
 * Shorthand way to display an Email Lead field.
 *
 * @since 1.0
 */

function email_lead_field( $field ) {
	return page_lead_field( 'email_lead', $field );
}

/**
 * Check if page has the Email Lead. This function can be used
 * like any WordPress conditional (like is_page(), is_single(), etc.)
 * and is used in this plugin to load styles.
 *
 * @since 1.0
 */

function has_email_lead() {
	if (
	 	email_lead_field( 'headline' )   ||
	 	email_lead_field( 'desc' )       ||
	 	email_lead_field( 'email_list' ) ||
	 	email_lead_field( 'email_code' )
	)
		return true;
}

/**
 * Create options array to feed to md_email_form().
 *
 * @since 1.0
 */

function email_lead_email_data() {
	$input  = email_lead_field( 'email_input' );
	$style  = email_lead_field( 'email_form_style' );
	$bg_image = email_lead_field( 'bg_image' );
	$url = ! empty( $bg_image['url'] ) ? $bg_image['url'] : '';
	$fields = array(
		'email_title'        => email_lead_field( 'email_title' ),
		'email_desc'         => email_lead_field( 'email_desc' ),
		'email_list'         => email_lead_field( 'email_list' ),
		'email_input'        => array(
			'name' => isset( $input['name'] ) ? $input['name'] : ''
		),
		'email_name_label'   => email_lead_field( 'email_name_label' ),
		'email_email_label'  => email_lead_field( 'email_email_label' ),
		'email_submit_text'  => email_lead_field( 'email_submit_text' ),
		'email_form_style'   => array(
			'attached' => isset( $style['attached'] ) ? $style['attached'] : ''
		),
		'email_form_title'   => email_lead_field( 'email_form_title' ),
		'email_form_footer'  => email_lead_field( 'email_form_footer' ),
		'email_image'        => $url,
		'email_classes'      => email_lead_field( 'email_classes' ),
		'email_bg_color'     => email_lead_field( 'bg_color' ),
		'email_text_color'   => email_lead_field( 'text_color_scheme' ),
		'email_thank_you'    => email_lead_field( 'email_thank_you' ),
		'email_code'         => email_lead_field( 'email_code' )
	);
	return $fields;
}