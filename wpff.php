<?php
/**
 * Plugin Name: WordPress Feature Flags
 * Description: Feature Flag System for WordPress
 * Version:     1.0.0
 * Author:      Drew Poland
 * Text Domain: wp-feature-flags
 */

declare(strict_types=1);

namespace WPFeatureFlags;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define plugin constants
define( 'WPFF_VERSION', '1.0.0' );
define( 'WPFF_PLUGIN_FILE', __FILE__ );
define( 'WPFF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPFF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Require our classes
require_once WPFF_PLUGIN_PATH . 'inc/class-loader.php';
require_once WPFF_PLUGIN_PATH . 'inc/class-admin.php';
require_once WPFF_PLUGIN_PATH . 'inc/class-utils.php';

/**
 * Main plugin bootstrap function.
 */
function wpff_init(): void {
    // Instantiate the plugin classes
    $loader     = new Loader();
    $wpff_admin = new Admin();

    // Register the admin actions
    $loader->add_action( 'acf/init', $wpff_admin, 'register_acf_feature_flags_page' );

    // Run loader to hook everything
    $loader->run();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\wpff_init' );
