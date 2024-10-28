<?php 
declare(strict_types=1);
namespace WSPEC\adminPage\classes;

class Peleman_Editor_Menu {
    public const PAGE_SLUG = 'peleman-control-panel';

    public function __construct() {
        // Only hook the menu setup when the admin area is being viewed
        if (is_admin()) {
            add_filter(
                'WSPBPE_get_admin_menu_tabs',
                array($this, 'add_Peleman_editor_panel'),
                10,
                1
            );
        }
    }

    // Method to add the control panel menu
    public function add_Peleman_editor_panel(): void {

        echo "<p> HELLO </p>";

    }

    public function register_settings(): void
    {	

			
        register_setting('peleman-control-panel', 'wspie_domain', array(
            'type' => 'string',
            'description' => 'base Site Address of the PIE editor',
            'sanitize_callback' => 'esc_url_raw',
            'show_in_rest' => false,
            'default' => ''
        ));
        register_setting('peleman-control-panel', 'wspie_customer_id', array(
            'type' => 'string',
            'description' => 'customer id for the PIE Editor',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'show_in_rest' => false,
            'default' => ''
        ));
        register_setting('peleman-control-panel', 'wspie_api_key', array(
            'type' => 'string',
            'description' => 'customer api key for PIE Editor',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'show_in_rest' => false,
            'default' => ''
        ));



        $this->add_menu_components();

        
    }
	

    private function add_menu_components(): void
    {
        add_settings_section(
            'wsppe_settings_editors',
            __("Editor", 'Peleman-Webshop-Package'),
            null,
            'peleman-control-panel',
        );
        add_settings_field(
            'wspie_domain',
            __("PIE domain (URL)", 'Peleman-Webshop-Package'),
            array($this, 'text_property_callback'),
            'peleman-control-panel',
            "wsppe_settings_editors",
            array(
                'option' => 'wspie_domain',
                'placeholder' => "https://deveditor.peleman.com",
                'description' => __("base Site Address of the PIE editor", 'Peleman-Webshop-Package'),
            )
        );
        add_settings_field(
            'wspie_customer_id',
            __("PIE Customer ID", 'Peleman-Webshop-Package'),
            array($this, 'text_property_callback'),
            'peleman-control-panel',
            "wsppe_settings_editors",
            array(
                'option' => 'wspie_customer_id',
            )
        );
        add_settings_field(
            'wspie_api_key',
            __("PIE API key", 'Peleman-Webshop-Package'),
            array($this, 'text_property_callback'),
            'peleman-control-panel',
            "wsppe_settings_editors",
            array(
                'option' => 'wspie_api_key',
            )
        );
        add_settings_field(
            'wspie_api_test',
            __("PIE API test", 'Peleman-Webshop-Package'),
            array($this, 'add_api_test_button'),
            'peleman-control-panel',
            "wsppe_settings_editors",
            array(
                'id' => 'wspie_api_test',
                'type' => 'button',
                'title' => __('test credentials', 'PelemanWebshopPackage')
            )
        );

    }
}
