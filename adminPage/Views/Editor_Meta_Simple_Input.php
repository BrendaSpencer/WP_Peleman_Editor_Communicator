<?php

declare(strict_types=1);

namespace WSPEC\adminPage\Views;

use WSPEC\adminPage\Models\Editor_Custom_Meta;

class Editor_Meta_Simple_Input{ 
    
    public function __construct(){
        add_action('woocommerce_product_options_general_product_data', [$this,'render_Simple_fields'], 11, 3);   
     }
	public function save_variables(int $id,  $post){
		$product = wc_get_product($id);
		$Base_Meta = new Editor_Custom_Meta($product);
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		
			
			$Base_Meta->set_CustomAddToCartLabel(esc_attr(sanitize_text_field($post[Base_Custom_Meta::CUSTOM_LABEL_KEY])));
			$Base_Meta->set_cartUnits((int)$post[Base_Custom_Meta::UNIT_AMOUNT] ?: 1);
            $Base_Meta->set_cartPrice((float)$post[Base_Custom_Meta::UNIT_PRICE] ?: 0.0);
            $Base_Meta->set_unitCode($post[Base_Custom_Meta::UNIT_CODE][$loop] ?: '');
		
		$Base_Meta->update_meta_data($product);

		
	}
	
	public function render_Simple_fields(){
	
        $required = 'pie_req_';
		$id = get_the_ID();
		
		$product = wc_get_product($id);
		
		if(!$product->is_type('simple')){
			return;
		}
		
		 $currencySuffix =  ' (' . get_woocommerce_currency_symbol() . ')';
		$Base_Meta = new Editor_Custom_Meta($product);
		?>
        
        <h1 class="<?php echo esc_attr('wsppe-options-group-title'); ?>"><?php echo esc_attr('Product Editor Settings'); ?></h1>
		<div class="<?php echo esc_attr('wsppe-options-group'); ?>"  >
<?php
	        

        woocommerce_wp_select(array(
            'id'                => Editor_Custom_Meta::PIE_EDITOR_ID_KEY,
            'name'              => Editor_Custom_Meta::PIE_EDITOR_ID_KEY,
            'label'             => __("Editor", 'Peleman-Webshop-Package'),
            'desc_tip'          => true,
            'description'       => __('Enable/disable the editor for this product/variation. Ensure the template ID is at least filled in.', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_editorId() ?: 'none',
            'wrapper_class'     => 'form-row form-row-full wsppe-form-row-padding-5',
            'custom_attributes' => array(
                'foldout'           => 'editor_',
                'requires'          => 'pie_req_'
            ),
            'options'           => [
                ''                          => 'No customization',
                Editor_Custom_Meta::MY_EDITOR => 'Peleman Image Editor'
            ],
        ));
		?>
 			<div id="<?php echo esc_attr('editor_'); ?>" class="<?php echo $Base_Meta->get_editorId() == 'PIE' ? '' : 'wsppe-hidden'?>">
		<?php
		
           woocommerce_wp_checkbox(array(
             'id'                => Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY,
             'name'              =>  Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY,
             'label'             => __('Use Reference Field', 'Peleman-Webshop-Package'),
             'value'             => $Base_Meta->get_useProjectReference() ? 'true' : 'false',
             'desc_tip'          => true,
             'description'       => __('Enable/disable reference for this product/variation', 'Peleman-Webshop-Package'),
             'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
   
         ));	
		        woocommerce_wp_checkbox(array(
            'id'            => Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY,
            'name'          => Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY,
            'label'         => __('Use project preview thumbnail in cart', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_overrideThumb() ? 'yes' : 'no',
            'desc_tip'      => true,
            'description'   => __('Show a preview of the project when the product is added to the cart', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
        ));
			woocommerce_wp_text_input(array(
            'id'            => Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY,
            'name'          => Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY,
            'label'         => __('Peleman Personalisation', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_peleman_personalisation(),
            'desc_tip'      => true,
            'description'   =>  __('You can add your personalisation codes to here to sent to editor', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Peleman Personalisation'
        ));
			woocommerce_wp_text_input(array(
		'id'            => Editor_Custom_Meta::PAGE_AMOUNT_KEY,
		'name'          => Editor_Custom_Meta::PAGE_AMOUNT_KEY,
		'label'         => __('Default number of pages', 'Peleman-Webshop-Package'),
    	'value'         => $Base_Meta->get_default_page_amount() !== '' ? $Base_Meta->get_default_page_amount() : '',
        'desc_tip'          => true,
		'description'   => __('Base number of pages for project. Image Editor will start with that amount of pages', 'Peleman-Webshop-Package'),
        'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
		'type'          => 'number',
		'custom_attributes' => array(
			'step'  => 1,
			'min'   => 0,
		)
	));

		
	woocommerce_wp_text_input(array(
            'id'                => Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY,
            'name'              => Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY,
            'label'             => __('Add price/page (Excl. VAT)', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_price_per_extra_page(),
            'desc_tip'          => true,
            'description'       => __('Add price per page that will be added to product/variation price', 'Peleman-Webshop-Package'),
            'class'             => "{$required}",
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'data_type'         => 'price',
            'placeholder' 		=> wc_format_localized_decimal(0.00),
        ));

        woocommerce_wp_text_input(array(
            'id'            => Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY,
            'name'          => Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY,
            'label'         => __('Template ID', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_templateId(),
            'desc_tip'      => true,
            'description'   =>  __('ID of the template that will be used in the editor. This needs to correspond with the template ID defined in the editor dashboard', 'Peleman-Webshop-Package'),
            'class'         => $required,
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
            'placeholder'   => 'REQUIRED'
        ));

        woocommerce_wp_text_input(array(
            'id'            => Editor_Custom_Meta::PIE_DESIGN_ID_KEY ,
            'name'          => Editor_Custom_Meta::PIE_DESIGN_ID_KEY ,
            'label'         => __('Design ID', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_designId(),
            'desc_tip'      => true,
            'description'   =>  __('The design theme that can be used in the webshop, ie. Funeral, Copyshop, ...', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Design ID'
        ));

        woocommerce_wp_text_input(array(
            'id'            => Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY,
            'name'          => Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY,
            'label'         => __('Background ID', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_backgroundId(),
            'desc_tip'      => true,
            'description'   =>  __('The background that will be displayed in the editor. This needs to correspond with the background ID defined in the format', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
            'placeholder'   => 'Background ID'
        ));
		
		
		        woocommerce_wp_text_input(array(
            'id'            => Editor_Custom_Meta::PIE_COLOR_CODE_KEY  ,
            'name'          => Editor_Custom_Meta::PIE_COLOR_CODE_KEY ,
            'label'         => __('Color code', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_colorCode(),
            'desc_tip'      => true,
            'description'   =>  __('The color code of this product/variation to use the corresponding background inside the editor. This needs to correspond with the color code defined in the format', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Color code'
        ));

        woocommerce_wp_checkbox(array(
            'id'                => Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY,
            'name'              =>  Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY,
            'label'             => __('Use Image Uploads', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_usesImageUpload() ? 'yes' : 'no',
            'desc_tip'          => true,
            'description'       => __('Require image uploads before you enter the editor. These images will be used to fill in placeholders, ie. a photobook', 'Peleman-Webshop-Package'),
            'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
            'custom_attributes' => array('foldout' => 'upload_'),
        ));
		
		
		?>
 			<div id="<?php echo esc_attr('upload_'); ?>" class="<?php echo $Base_Meta->get_usesImageUpload() ? '' : 'wsppe-hidden'?>">
		<?php


        woocommerce_wp_text_input(array(
            'id'                => Editor_Custom_Meta::NUM_PAGES_KEY,
            'name'              => Editor_Custom_Meta::NUM_PAGES_KEY,
            'label'             => __('Pages to Fill', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_numPages(),
            'desc_tip'          => true,
            'description'       =>  __('Number of pages to fill in, this will be used for templates that have multiple pages, ie. a photobook', 'Peleman-Webshop-Package'),
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => array(
                'step'              => 1,
                'min'               => 0
            ),
            'placeholder'       => 0
        ));

        woocommerce_wp_text_input(array(
            'id'                => Editor_Custom_Meta::MIN_IMAGES_KEY,
            'name'              => Editor_Custom_Meta::MIN_IMAGES_KEY,
            'label'             => __('Min Images for upload', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_minImages(),
            'desc_tip'          => true,
            'description'       =>  __('Minimum images that users are required to upload', 'Peleman-Webshop-Package'),
            'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => array(
                'step'              => 1,
                'min'               => 0
            ),
            'placeholder'       => 0
        ));

        woocommerce_wp_text_input(array(
            'id'                => Editor_Custom_Meta::MAX_IMAGES_KEY,
            'name'              => Editor_Custom_Meta::MAX_IMAGES_KEY,
            'label'             => __('Max images for upload', 'Peleman-Webshop-Package'),
            'value'             => $Base_Meta->get_maxImages(),
            'desc_tip'          => true,
            'description'       =>  __('Maximum images that users are required to upload', 'Peleman-Webshop-Package'),
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => array(
                'step'              => 1,
                'min'               => 0
            ),
            'placeholder'       => 0
        ));

        woocommerce_wp_checkbox(array(
            'id'            => Editor_Custom_Meta::AUTOFILL_KEY,
            'name'          => Editor_Custom_Meta::AUTOFILL_KEY,
            'label'         => __('Autofill template pages in editor', 'Peleman-Webshop-Package'),
            'value'         => $Base_Meta->get_autofill() ? 'yes' : 'no',
            'desc_tip'      => true,
            'description'   => __('Autofill the template pages inside the editor', 'Peleman-Webshop-Package'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
        ));
		


	?>
			 			  
		</div>
        <div class="wsppe-options-header">Editor Instructions</div>
		<div >
			<?php 
        	$instructions = $Base_Meta->get_editor_instructions();
        	$index = 0;
        	foreach ($instructions as $key => $instruction) {
            	woocommerce_wp_checkbox(array(
                	'id'            => $key ,
                	'name'          => $key ,
                	'label'         => $instruction->get_label(),
                	'value'         => $instruction->is_enabled() ? 'yes' : 'no',
                	'desc_tip'      => true,
                	'description'   => $instruction->get_description(),
                	'wrapper_class' => 'form-row-multi-3 wsppe-form-row-padding-5',
            	));
            $index++;
        	}
			 ?>	
					</div> 
						</div> 
							</div> 
			
		  
  	<?php

    }
 } 