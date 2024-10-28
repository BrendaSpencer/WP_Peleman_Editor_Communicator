<?php 
declare(strict_types=1);
namespace WSPEC\adminPage\classes;

use WSPBPE\includes\Admin_Menu;

class Peleman_Editor_Menu {

    private string $page_slug;
	private string $title;
	private string $option_group;

    public function __construct(){
		
        $this->page_slug = 'peleman-control-panel';
        $this->title = 'Peleman Editor Credentials';
        $this->option_group = 'WSPEC-editor-options-group';
			
        
    }
	
	public function get_title(){
		return $this->title;
	}

	public function render_menu(): void
    {
        settings_fields($this->option_group);
        do_settings_sections($this->page_slug);
        submit_button();
    }

    // Method to add the control panel menu

    public function register_settings(): void
    {	

			
        register_setting(
			$this->option_group, 
			'wspie_domain', array(
				'type' => 'string',
				'description' => 'base Site Address of the PIE editor',
				'sanitize_callback' => 'esc_url_raw',
				'show_in_rest' => false,
				'default' => ''
        	)
		);
        register_setting($this->option_group, 'wspie_customer_id', array(
            'type' => 'string',
            'description' => 'customer id for the PIE Editor',
            'sanitize_callback' => 'wp_filter_nohtml_kses',
            'show_in_rest' => false,
            'default' => ''
        ));
        register_setting($this->option_group, 'wspie_api_key', array(
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
      	$this->option_group,
            __("Editor", 'Peleman-Base-Products-Extender'),
            null,
            $this->page_slug,
        );
        add_settings_field(
            'wspie_domain',
            __("PIE domain (URL)", 'Peleman-Base-Products-Extender'),
            array($this, 'text_property_callback'),
            $this->page_slug,
            $this->option_group,
            array(
                'option' => 'wspie_domain',
                'placeholder' => "https://deveditor.peleman.com",
                'description' => __("base Site Address of the PIE editor", 'Peleman-Webshop-Package'),
            )
        );
        add_settings_field(
            'wspie_customer_id',
            __("PIE Customer ID", 'Peleman-Base-Products-Extender'),
            array($this, 'text_property_callback'),
            $this->page_slug,
           $this->option_group,
            array(
                'option' => 'wspie_customer_id',
            )
        );
        add_settings_field(
            'wspie_api_key',
            __("PIE API key", 'Peleman-Base-Products-Extender'),
            array($this, 'text_property_callback'),
            $this->page_slug,
            $this->option_group,
            array(
                'option' => 'wspie_api_key',
            )
        );
//         add_settings_field(
//             'wspie_api_test',
//             __("PIE API test", 'Peleman-Base-Products-Extender'),
//             array($this, 'add_api_test_button'),
//             $this->page_slug,
//             $this->option_group,
//             array(
//                 'id' => 'wspie_api_test',
//                 'type' => 'button',
//                 'title' => __('test credentials', 'Peleman-Base-Products-Extender')
//             )
//         );

    }
	     public  function text_property_callback(array $args): void
    {
        $option = $args['option'];
        $value = get_option($option);
        $placeholder = isset($args['placeholder']) ? $args['placeholder'] : '';
        $description = isset($args['description']) ? $args['description'] : '';

        $classArray = isset($args['classes']) ? $args['classes'] : [];
        $classArray[] = 'regular-text';
        $classes = implode(" ", $classArray);
?>
        <input type="text" id="<?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="<?php echo esc_html($value); ?>" placeholder="<?php echo esc_html($placeholder); ?>" class="<?php esc_attr($classes); ?>" size=40 />
        <?php
        if ($description) {
            echo wp_kses_post("<p class='description'>{$description}</p>");
        }
    }

     public  function bool_property_callback(array $args): void
    {
        $option = $args['option'];
        $description = $args['description'] ?: '';
        $value = get_option($option);

        $classArray = isset($args['classes']) ? $args['classes'] : [];
        $classArray[] = 'regular-text';
        $classes = implode(" ", $classArray);

        ?>
        <input type='checkbox' id=" <?php echo esc_attr($option); ?>" name="<?php echo esc_attr($option); ?>" value="1" class="<?php esc_attr($classes); ?>" <?php checked(1, (int)$value, true); ?> />
<?php
        if ($description) {
            echo wp_kses_post("<p class='description'>{$description}</p>");
        }
    }
}
