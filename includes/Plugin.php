<?php

declare(strict_types=1);

namespace WSPEC\includes;

use WSPEC\adminPage\Controllers\Editor_Tab_Controller;
use WSPEC\adminPage\Controllers\Editor_Meta_Controller;
use WSPEC\includes\Enqueue_Scripts;
use WSPEC\includes\Enqueue_Styles;

class Plugin {

    public function __construct() {
     
        add_action('plugins_loaded', [$this, 'initialize_plugin']);
    }

    public function initialize_plugin() {
		$this->enqueue_editor_styles();
        if (is_admin()) {
            $this->create_editor_communicator_admin_classes();
        }
    }

    public function activate() {
        

    }

    private function enqueue_extender_scripts() {
        new Enqueue_Scripts();
    }

    private function enqueue_editor_styles() {
        new Enqueue_Styles();
    }

    public function create_editor_communicator_admin_classes() {
		new Editor_Meta_Controller();
        new Editor_Tab_Controller();
    }
}
