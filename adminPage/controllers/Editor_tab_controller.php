<?php 
declare(strict_types=1);
namespace WSPEC\adminPage\controllers;

use WSPBPE\includes\Admin_Menu;
use WSPEC\adminPage\classes\Peleman_Editor_Menu;

class Editor_tab_controller{
    public function __construct() {
        if (is_admin()) {
            add_filter(
                'WSPBPE_get_admin_menu_tabs',
                array($this, 'add_Peleman_editor_panel'),
                10,
                1
            );
		

        }
    }
	

    
    public function add_Peleman_editor_panel(array $tabs) {
		$tabs['Editor'] = new Peleman_Editor_Menu;
		$tabs['Editor']->register_settings();
		return $tabs;
    }
	
	
}