<?php

declare(strict_types=1);

namespace WSPEC\includes;

use WSPEC\adminPage\controllers\Editor_tab_controller;
use WSPEC\includes\Enqueue_Scripts;
use WSPEC\includes\Enqueue_Styles;

class Plugin {

    public function __construct() {
       
        add_action('plugins_loaded', [$this, 'initialize_plugin']);
    }

    public function initialize_plugin() {
        if (is_admin()) {
            $this->create_editor_communicator_admin_classes();
        }
    }

    public function activate() {
  
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
        
        new Editor_tab_controller();
    }
}
