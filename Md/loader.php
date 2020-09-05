<?php
/**
 * Manipulate page templates and load content based on
 * WordPress conditionals.
 */

function md_child_templates() {

}
add_action( 'template_redirect', 'md_child_templates' );