<?php

declare(strict_types=1);

namespace WSPEC\includes;

use WSPEC\adminPage\classes\Peleman_Editor_Menu;
use WSPEC\includes\Enqueue_Scripts;
use WSPEC\includes\Enqueue_Styles;

class Plugin {

    public function __construct() {
        // Hook to initialize plugin when WordPress is ready
        add_action('plugins_loaded', [$this, 'initialize_plugin']);
    }

    public function initialize_plugin() {
        if (is_admin()) {
            $this->create_editor_communicator_admin_classes();
        }
    }

    public function activate() {
        // Called once when the plugin is activated
        $this->enqueue_extender_scripts();
        $this->enqueue_extender_styles();
    }

    private function enqueue_extender_scripts() {
        new Enqueue_Scripts();
    }

    private function enqueue_extender_styles() {
        new Enqueue_Styles();
    }

    public function create_editor_communicator_admin_classes() {
        
        new Peleman_Editor_Menu();
    }
}
