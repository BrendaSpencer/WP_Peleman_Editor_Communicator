<?php

declare(strict_types=1);

namespace WSPEC\adminPage\Views;

use WSPEC\adminPage\Models\Editor_Custom_Meta;

class Editor_Meta_Variable_Input { 
	
	public function save_variables(int $variation_id, int $loop){
		$product = wc_get_product($variation_id);
		$Base_Meta = new Editor_Custom_Meta($product);
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
		
			$Base_Meta->set_customizable((bool)$post[Editor_Custom_Meta::PIE_EDITOR_ID_KEY][$loop] ?: false );
			$Base_Meta->set_templateId((string)$post[Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY][$loop] ?: '');
    	    $Base_Meta->set_designId((string)$post[Editor_Custom_Meta::PIE_DESIGN_ID_KEY][$loop] ?: '');
    	    $Base_Meta->set_designProjectId((string)$post[Editor_Custom_Meta::PIE_DESIGN_PROJECT_ID_KEY][$loop] ?: '');
            $Base_Meta->set_colorCode((string)$post[Editor_Custom_Meta::PIE_COLOR_CODE_KEY][$loop] ?: '');
            $Base_Meta->set_backgroundId((string)$post[Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY][$loop] ?: '');

            $Base_Meta->set_price_per_extra_page((float)$post[Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY][$loop]?: 0.0);
			$Base_Meta->set_basePrice((float)$post[Editor_Custom_Meta::BASE_PRICE_KEY][$loop] ?: 1);
    	    $Base_Meta->set_default_page_amount((int)$post[Editor_Custom_Meta::PAGE_AMOUNT_KEY][$loop] ?: 1);
    	    $Base_Meta->set_numPages((int)$post[Editor_Custom_Meta::NUM_PAGES_KEY][$loop] ?: 1);
            
            $Base_Meta->set_usesImageUpload((bool)$post[Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY][$loop] ?: false);
            $Base_Meta->set_minImages((int)$post[Editor_Custom_Meta::AUTOFILL_KEY][$loop] ?: 1);
            $Base_Meta->set_maxImages((int)$post[Editor_Custom_Meta::MAX_IMAGES_KEY][$loop] ?: 1);
            $Base_Meta->set_autofill((bool) $post[Editor_Custom_Meta::MIN_IMAGES_KEY][$loop] ?: false);
  
            $Base_Meta->set_useProjectReference((bool)$post[Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY][$loop] ?: false);
            $Base_Meta->set_overrideThumb((bool)$post[Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY][$loop] ?:false);

            $Base_Meta->set_peleman_personalisation((string)$post[Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY][$loop] ?: '');
            $Base_Meta->set_editor_instructions((array)$post[Editor_Custom_Meta::EDITOR_INSTRUCTIONS_KEY][$loop] ?: []);

		$Base_Meta->update_meta_data($product);
	}
    
    public function render_Variable_fields($loop, $variation_data, $variation) {
		error_log('In Variable Input ');
		?>
        <div  class="<?php echo esc_attr('wsppe-options-group'); ?>">
        <h1 class="<?php echo esc_attr('wsppe-options-group-title'); ?>"><?php echo esc_attr('Product Editor Settings'); ?></h1>
		<div  class="<?php echo esc_attr('wsppe-options-group'); ?>">
        <?php
        $currencySuffix =  ' (' . get_woocommerce_currency_symbol() . ')';
		$variationId = $variation->ID;
		$product = wc_get_product($variationId);
		$Base_Meta = new Editor_Custom_Meta($product);
		
           woocommerce_wp_checkbox(array(
             'id'                => Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY . "[{$loop}]",
             'name'              =>  Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY . "[{$loop}]",
             'label'             => __('Use Reference Field', 'Peleman-Webshop-Package'),
             'value'             => $Base_Meta->get_useProjectReference() ? 'true' : 'false',
             'desc_tip'          => true,
             'description'       => __('Enable/disable reference for this product/variation', 'Peleman-Webshop-Package'),
             'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
   
         ));	
					        ?>
			       </div>
        </div>
    <?php
    }
}