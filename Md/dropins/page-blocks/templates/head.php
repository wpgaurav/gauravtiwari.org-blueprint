<?php
/**
 * This file prints inline CSS to the top of each page
 * that has Page Blocks enabled. Each Block has its own
 * unique CSS selector and is generated based on user
 * design options from the Page Blocks interface.
 */
echo "\n<style type=\"text/css\">\n";
foreach ( $page_blocks as $block => $fields ) {
	$css = ! empty( $fields['css'] ) ? $fields['css'] : '';
	$styles = array_filter( array(
		'bg_color' => ( ! empty( $fields['bg_color'] ) ? $fields['bg_color'] : '' ),
		'color' => ( ! empty( $fields['color'] ) ? $fields['color'] : '' ),
		'links' => ( ! empty( $fields['links'] ) ? $fields['links'] : ''),
	) );
	if ( ! empty( $styles ) ) {
		echo "\t.page-block-" . esc_attr( $block ) . ' { '.
			( isset( $styles['bg_color'] ) ? 'background-color: ' . esc_attr( $styles['bg_color'] ) . '; ' : '' ).
			( isset( $styles['color'] ) ? 'color: ' . esc_attr( $styles['color'] ) . '; ' : '' ).
		"}\n";
		if ( isset( $styles['links'] ) )
			echo "\t.page-block-" . esc_attr( $block ) . ' a { '.
				'border-bottom-color: ' . esc_attr( $styles['links'] ) . '; '.
				'color: ' . esc_attr( $styles['links'] ) . '; '.
			"}\n";
	}
	if ( ! empty( $css ) )
		echo "\t" . esc_html( $css ) . "\n";
}
echo "</style>\n";