<?php
$data        = email_lead_email_data();
$id          = get_the_ID();
$position    = email_lead_field( 'position' );
$style       = email_lead_field( 'style' );
$style_class = ! empty( $style['left-right'] ) ? 'email-lead-left-right' : 'text-center';
md_email_form( $data, array(
	'classes'       => "email-lead email-lead-$id $style_class",
	'block_classes' => ! empty( $style['left-right'] ) ? 'block-double' : md_design_block( $position )
) );