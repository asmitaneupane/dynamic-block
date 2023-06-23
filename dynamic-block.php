<?php
/**
 * Plugin Name:       Dynamic Block
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       dynamic-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */

function dynamic_block_render_callback( $block_attributes, $content ) {
    $recent_posts = wp_get_recent_posts( array(
        'numberposts' => 10,
        'post_status' => 'publish',
    ) );
    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }

    $output = '';

    foreach( $recent_posts as $post ) {
    
        $post_id = $post['ID'];
        $styles = '';

        if( !empty($block_attributes['bgColor'])) {
            $styles .= "background-color:{$block_attributes['bgColor']};";
        }
        if ( !empty($block_attributes['textColor'])) {
            $styles .= "color:{$block_attributes['textColor']};";
        }
        $wrapper_attributes = get_block_wrapper_attributes();

        $output .= sprintf(
            '<div %s href="%s">
                <h3 style="%s">%s<h3>
                <p>%s<p>
            <div>',

            $wrapper_attributes,
            esc_url( get_permalink( $post_id ) ),
            esc_attr( $styles ),
            esc_html( get_the_title( $post_id ) ),
            esc_html(sanitize_title(get_the_title($post_id)))
        );
    }
    return $output;
}

function dynamic_block() {

	// automatically load dependencies and version
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/blocks/columns/index.asset.php');
    $asset_file = include( plugin_dir_path( __FILE__ ) . 'build/blocks/column/index.asset.php');

	wp_register_script(
        'dynamic_block',
        plugins_url( 'build/blocks/columns/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_register_script(
        'column_block',
        plugins_url( 'build/blocks/column/index.js', __FILE__ ),
        $asset_file['dependencies'],
        $asset_file['version']
    );

	register_block_type(
        'create-block/dynamic-block',
        array(
        'api_version' => 3,
        'category' => 'widgets',
        'attributes' => array(
            'bgColor' => array( 'type' => 'string' ),
            'textColor' => array('type' => 'string' ),
        ),
        'render_callback' => 'dynamic_block_render_callback',
        'skip_inner_blocks' => true,
        'editor_script' =>  'dynamic_block',
    ) );

    register_block_type(
        'create-block/column',
        array(
        'api_version' => 3,
        'category' => 'Dynamic Blocks',
        'attributes' => array(
            'bgColor' => array( 'type' => 'string' ),
            'textColor' => array('type' => 'string' ),
        ),
        'render_callback' => 'dynamic_block_render_callback',
        'skip_inner_blocks' => true,
        'editor_script' =>  'column_block',
    ) );

}
add_action( 'init', 'dynamic_block' );

//create dynamic category

function custom_category( $categories ) {
	
	$categories[] = array(
		'slug'  => 'custom-block-category',
		'title' => 'Dynamic Blocks'
	);

	return $categories;
}

if ( version_compare( get_bloginfo( 'version' ), '5.8', '>=' ) ) {
	add_filter( 'block_categories_all', 'custom_category' );
} else {
	add_filter( 'block_categories', 'custom_category' );
}