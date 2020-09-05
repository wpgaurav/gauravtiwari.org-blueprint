<?php

/**
 * This is the base of the Page Leads admin screen. All Page Leads hook their
 * content back to this class, including other fields.
 *
 * @since 4.2
 */

class md_page_leads_settings extends md_api {

	/**
	 * Pesuedo constructor, registers the admin page and tab.
	 *
	 * @since 4.2
	 */

	public function register() {
		return array(
			'admin_page' => array(
				'name' => __( 'Page Leads', 'md' ),
				'admin_header' => true
			)
		);
	}

	/**
	 * Page Leads admin pagel callback function. This is
	 * where admin tabs and content are hooked to.
	 *
	 * @since 4.2
	 */

	public function admin_page() {
		if ( ! isset( $_GET['tab'] ) )
			echo __( 'Select a Page Lead from the navigation menu above to create.', 'md' );
	}

}
new md_page_leads_settings;