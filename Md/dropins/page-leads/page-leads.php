<?php
/**
 * Dropin Name: Page Leads
 * Dropin Author: Alex Mangini
 * Dropin Description: Continue using the deprecated Page Leads features with this Dropin.
 * Dropin Version: 2.0
 *
 * PAGE LEADS HAVE BEEN DEPRECATED SINCE MD5.0.
 *
 * Install the Page Leads Dropin to your child theme to add
 * backwards compatibility. Your site running MD5.0+ will keep
 * Page Leads on your site, but it is recommended to move
 * your site away from this deprecated feature. Only maintained
 * for bug fixes.
 */

// Constants
define( 'PAGE_LEADS_DIR', trailingslashit( get_stylesheet_directory() ) . 'dropins/page-leads/' );
define( 'PAGE_LEADS_URL', trailingslashit( get_stylesheet_directory_uri() ) . 'dropins/page-leads/' );

// Required files
require_once( PAGE_LEADS_DIR . 'lib/admin-page.php' );
require_once( PAGE_LEADS_DIR . 'lib/template-functions.php' );
require_once( PAGE_LEADS_DIR . 'lib/design-fields.php' );
require_once( PAGE_LEADS_DIR . 'lib/button-fields.php' );
require_once( PAGE_LEADS_DIR . 'lib/email-fields.php' );
require_once( PAGE_LEADS_DIR . 'lib/after-post.php' );

$leads = apply_filters( 'page_leads_load', array( 'email', 'video', 'funnel', 'table', 'action' ) );
foreach ( $leads as $lead )
	require_once( PAGE_LEADS_DIR . "$lead-lead/$lead-lead.php" );

/**
 * Build common data for Page Leads.
 *
 * @since 4.7
 */

function md_page_leads_data() {
	return array(
		'leads' => array(
			'funnel_lead' => __( 'Funnel Lead', 'md' ),
			'action_lead' => __( 'Action Lead', 'md' ),
			'table_lead'  => __( 'Table Lead', 'md' ),
			'email_lead'  => __( 'Email Lead', 'md' ),
			'video_lead'  => __( 'Video Lead', 'md' )
		),
		'positions' => array(
			'md_hook_before_content_box' => __( 'After Header (default)', 'md' ),
			'md_hook_before_html'   => __( 'Before Header', 'md' ),
			'md_hook_content'       => __( 'After Post', 'md' ),
			'md_hook_before_footer' => __( 'Before Footer', 'md' ),
			'md_hook_after_footer'  => __( 'After Footer', 'md' )
		),
		'hooks' => array(
			'md_hook_before_content_box',
			'md_hook_before_html',
			'md_hook_content',
			'md_hook_before_footer',
			'md_hook_after_footer'
		)
	);
}

/**
 * Load CSS template to style.css.
 *
 * @since 4.9.4
 */

function page_leads_css( $templates ) {
	$templates['page_leads'] = PAGE_LEADS_DIR . 'css.php';
	return $templates;
}
add_filter( 'md_dropins_css_templates', 'page_leads_css' );