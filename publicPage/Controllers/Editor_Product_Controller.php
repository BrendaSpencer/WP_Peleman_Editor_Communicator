<?php 
declare(strict_types=1);
namespace WSPEC\publicPage\Controllers;

use WSPEC\publicPage\Views\Display_Reference_Field;
use WSPEC\adminPage\Models\Editor_Custom_Meta;
use WC_Product_Variation;
use WC;

class Editor_Product_Controller{
    private $product;
    private $Editor_Custom_Meta;

    public function __construct() {
		add_action('wspbpe_product_page_variation', [$this, 'modify_product_page'], 10, 5);
        add_action('wspbpe_variation_update', [$this, 'modify_variation_update'], 10, 5);
		add_action('woocommerce_before_add_to_cart_button', [$this,'render_project_reference_input'], 10, 1);
		add_filter('woocommerce_product_single_add_to_cart_text', [$this,'change_add_to_cart_button_label'],10,2);
        add_filter('woocommerce_product_add_to_cart_text', [$this,'change_add_to_cart_button_label'], 10,2); 
    }

    public function modify_product_page($product, $variation, $meta_html, $price_html){
		$meta_html .= '<p>Custom Meta Information</p>';
        $price_html .= '<p>Custom Price Information</p>';
		return [$meta_html, $price_html];
		
    }
	
	public function change_add_to_cart_button_label( $default, $product){
		$variation_id = WC()->session->get('current_variation_id');

		$variation = new WC_Product_Variation($variation_id);
		//error_log('add to cart label ' . print_r($variation, true));
		if($variation->get_meta('pie_editor_id') === 'PIE'){
						return 'Design your product!!';
		}else{
			return $default;
		}
	}
	
	    public function modify_variation_update($product, $variation, $meta_html, $price_html){
        $meta_html .= '<p>Updated Meta for Variation</p>';
        $price_html .= '<p>Updated Price for Variation</p>';
		return [$meta_html, $price_html];

    }

    public function render_project_reference_input(){
		$variation_id = WC()->session->get('current_variation_id');
		$variation = new WC_Product_Variation($variation_id);
		error_log('add project reference ' . print_r($variation->get_meta('pie_editor_id'), true));
		if($variation->get_meta('pie_editor_id') == 'PIE'){

		      ?>
        <p id='project_reference'>
            <label for='project_reference'><?php esc_html_e( 'Project reference:', 'Peleman_Editor_Communicator' ); ?> </label>
            <input class='form-control' type='text' id='project_reference' name='project_reference'
            placeholder='<?php esc_html_e( 'Name Your Project', 'Peleman_Editor_Communicator' ); ?>' />
        <?php
    }
	}

}




