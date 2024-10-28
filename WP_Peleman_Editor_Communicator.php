<?php

declare(strict_types=1);

namespace WSPEC;

use WSPEC\includes\Plugin;

require plugin_dir_path(__FILE__) . '/vendor/autoload.php';

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Plugin Name:     Peleman Editor Communicator
 * Description:     Communicates with the editor for creating, editing of Personalizable products .
 * Requires PHP:    8.2
 * Version:         1.0
 * Author:          Peleman nv
 */

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if (!is_plugin_active('woocommerce/woocommerce.php')) {
    $site_domain = home_url();
    wp_die(esc_html('The "WooCommerce" plugin has not been activated. ← <a href="' . $site_domain . '/wp-admin/plugins.php"> Please activate it first.</a>'));
}

// Register activation hook. Called once when the plugin is activated
register_activation_hook(__FILE__, function () {
    $plugin = new Plugin();
    $plugin->activate();
});

// Initialize the plugin on every page load
$plugin = new Plugin();  // This will initialize the admin menu on every page load.
