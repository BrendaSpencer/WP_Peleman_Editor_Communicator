<?php

declare(strict_types=1);

namespace WSPEC\adminPage\Views;

use WSPEC\adminPage\Models\Editor_Custom_Meta;

class Editor_Meta_Variable_Input { 
	

    public function render_Variable_fields($loop, $variation_data, $variation) {
		?>
			<div  class="<?php echo esc_attr('wsppe-options-group'); ?>">
				<h1 class="<?php echo esc_attr('wsppe-options-group-title'); ?>"><?php echo esc_attr('Product Editor Settings'); ?></h1>
				<div  class="<?php echo esc_attr('wsppe-options-group'); ?>">
		<?php
        $currencySuffix =  ' (' . get_woocommerce_currency_symbol() . ')';
		$variationId = $variation->ID;
		$product = wc_get_product($variationId);
		$Base_Meta = new Editor_Custom_Meta($product);
		
		

        $required = 'pie_req_' . $loop;

        woocommerce_wp_select([
            'id'                => Editor_Custom_Meta::PIE_EDITOR_ID_KEY . "[{$loop}]",
            'name'              => Editor_Custom_Meta::PIE_EDITOR_ID_KEY . "[{$loop}]",
            'label'             => __("Editor", 'Peleman_Editor_Communicator'),
            'desc_tip'          => true,
            'description'       => __('Enable/disable the editor for this product/variation. Ensure the template ID is at least filled in.', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_editorId() ?: 'none',
            'wrapper_class'     => 'form-row form-row-full wsppe-form-row-padding-5',
            'custom_attributes' => [
                'foldout'           => 'editor_' . $loop,
                'requires'          => 'pie_req_' . $loop
            ],
            'options'           => [
                ''                          => 'No customization',
                Editor_Custom_Meta::MY_EDITOR => 'Peleman Image Editor'
            ],
        ]);
		?>
            <div id="<?php echo esc_attr('editor_' . $loop); ?>" class="<?php echo $Base_Meta->get_editorId() == 'PIE' ? '' : 'wsppe-hidden'?>">
		<?php
		
        woocommerce_wp_checkbox([
            'id'                => Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY . "[{$loop}]",
            'name'              =>  Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY . "[{$loop}]",
            'label'             => __('Use Reference Field', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_useProjectReference() ? 'yes' : 'no',
            'desc_tip'          => true,
            'description'       => __('Enable/disable reference for this product/variation', 'Peleman_Editor_Communicator'),
            'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
        ]);	
		woocommerce_wp_checkbox([
            'id'            => Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY  . "[{$loop}]",
            'name'          => Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY . "[{$loop}]",
            'label'         => __('Use project preview thumbnail in cart', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_overrideThumb() ? 'yes' : 'no',
            'desc_tip'      => true,
            'description'   => __('Show a preview of the project when the product is added to the cart', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
        ]);
		woocommerce_wp_text_input([
            'id'            => Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY  . "[{$loop}]",
            'name'          => Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY  . "[{$loop}]",
            'label'         => __('Peleman Personalisation', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_peleman_personalisation(),
            'desc_tip'      => true,
            'description'   =>  __('You can add your personalisation codes to here to sent to editor', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Peleman Personalisation'
        ]);
		woocommerce_wp_text_input([
		'id'            => Editor_Custom_Meta::PAGE_AMOUNT_KEY . "[{$loop}]",
		'name'          => Editor_Custom_Meta::PAGE_AMOUNT_KEY  . "[{$loop}]",
		'label'         => __('Default number of pages', 'Peleman_Editor_Communicator'),
    	'value'         => $Base_Meta->get_default_page_amount() !== '' ? $Base_Meta->get_default_page_amount() : '',
        'desc_tip'          => true,
		'description'   => __('Base number of pages for project. Image Editor will start with that amount of pages', 'Peleman_Editor_Communicator'),
        'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
		'type'          => 'number',
		'custom_attributes' => [
			'step'  => 1,
			'min'   => 0,
        ]
	    ]);

		
	    woocommerce_wp_text_input([
            'id'                => Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY . "[{$loop}]",
            'name'              => Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY  . "[{$loop}]",
            'label'             => __('Add price/page (Excl. VAT)', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_price_per_extra_page(),
            'desc_tip'          => true,
            'description'       => __('Add price per page that will be added to product/variation price', 'Peleman_Editor_Communicator'),
            'class'             => "{$required}",
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'data_type'         => 'price',
            'placeholder' 		=> wc_format_localized_decimal(0.00),
        ]);

        woocommerce_wp_text_input([
            'id'            => Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY  . "[{$loop}]",
            'name'          => Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY  . "[{$loop}]",
            'label'         => __('Template ID', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_templateId(),
            'desc_tip'      => true,
            'description'   =>  __('ID of the template that will be used in the editor. This needs to correspond with the template ID defined in the editor dashboard', 'Peleman_Editor_Communicator'),
            'class'         => $required,
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
            'placeholder'   => 'REQUIRED'
        ]);

        woocommerce_wp_text_input([
            'id'            => Editor_Custom_Meta::PIE_DESIGN_ID_KEY  . "[{$loop}]",
            'name'          => Editor_Custom_Meta::PIE_DESIGN_ID_KEY  . "[{$loop}]",
            'label'         => __('Design ID', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_designId(),
            'desc_tip'      => true,
            'description'   =>  __('The design theme that can be used in the webshop, ie. Funeral, Copyshop, ...', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Design ID'
        ]);

        woocommerce_wp_text_input([
            'id'            => Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY . "[{$loop}]",
            'name'          => Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY  . "[{$loop}]",
            'label'         => __('Background ID', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_backgroundId(),
            'desc_tip'      => true,
            'description'   =>  __('The background that will be displayed in the editor. This needs to correspond with the background ID defined in the format', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
            'placeholder'   => 'Background ID'
        ]);
		
		woocommerce_wp_text_input([
            'id'            => Editor_Custom_Meta::PIE_COLOR_CODE_KEY . "[{$loop}]" ,
            'name'          => Editor_Custom_Meta::PIE_COLOR_CODE_KEY  . "[{$loop}]",
            'label'         => __('Color code', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_colorCode(),
            'desc_tip'      => true,
            'description'   =>  __('The color code of this product/variation to use the corresponding background inside the editor. This needs to correspond with the color code defined in the format', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-last wsppe-form-row-padding-5',
            'placeholder'   => 'Color code'
        ]);

        woocommerce_wp_checkbox([
            'id'                => Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY  . "[{$loop}]",
            'name'              =>  Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY  . "[{$loop}]",
            'label'             => __('Use Image Uploads', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_usesImageUpload() ? 'yes' : 'no',
            'desc_tip'          => true,
            'description'       => __('Require image uploads before you enter the editor. These images will be used to fill in placeholders, ie. a photobook', 'Peleman_Editor_Communicator'),
            'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
            'custom_attributes' => ['foldout' => 'upload_' . $loop],
        ]);
		
		
		?>
            <div id="<?php echo esc_attr('upload_' . $loop); ?>" class="<?php echo $Base_Meta->get_usesImageUpload() ? '' : 'wsppe-hidden'?>">
		<?php


        woocommerce_wp_text_input([
            'id'                => Editor_Custom_Meta::NUM_PAGES_KEY  . "[{$loop}]",
            'name'              => Editor_Custom_Meta::NUM_PAGES_KEY  . "[{$loop}]",
            'label'             => __('Pages to Fill', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_numPages(),
            'desc_tip'          => true,
            'description'       =>  __('Number of pages to fill in, this will be used for templates that have multiple pages, ie. a photobook', 'Peleman_Editor_Communicator'),
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => [
                'step'              => 1,
                'min'               => 0
            ],
            'placeholder'       => 0
        ]);

        woocommerce_wp_text_input([
            'id'                => Editor_Custom_Meta::MIN_IMAGES_KEY  . "[{$loop}]",
            'name'              => Editor_Custom_Meta::MIN_IMAGES_KEY  . "[{$loop}]",
            'label'             => __('Min Images for upload', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_minImages(),
            'desc_tip'          => true,
            'description'       =>  __('Minimum images that users are required to upload', 'Peleman_Editor_Communicator'),
            'wrapper_class'     => 'form-row form-row-first wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => [
                'step'              => 1,
                'min'               => 0
            ],
            'placeholder'       => 0
        ]);

        woocommerce_wp_text_input([
            'id'                => Editor_Custom_Meta::MAX_IMAGES_KEY  . "[{$loop}]",
            'name'              => Editor_Custom_Meta::MAX_IMAGES_KEY  . "[{$loop}]",
            'label'             => __('Max images for upload', 'Peleman_Editor_Communicator'),
            'value'             => $Base_Meta->get_maxImages(),
            'desc_tip'          => true,
            'description'       =>  __('Maximum images that users are required to upload', 'Peleman_Editor_Communicator'),
            'wrapper_class'     => 'form-row form-row-last wsppe-form-row-padding-5',
            'type'              => 'number',
            'custom_attributes' => [
                'step'              => 1,
                'min'               => 0
            ],
            'placeholder'       => 0
        ]);

        woocommerce_wp_checkbox([
            'id'            => Editor_Custom_Meta::AUTOFILL_KEY  . "[{$loop}]",
            'name'          => Editor_Custom_Meta::AUTOFILL_KEY  . "[{$loop}]",
            'label'         => __('Autofill template pages in editor', 'Peleman_Editor_Communicator'),
            'value'         => $Base_Meta->get_autofill() ? 'yes' : 'no',
            'desc_tip'      => true,
            'description'   => __('Autofill the template pages inside the editor', 'Peleman_Editor_Communicator'),
            'wrapper_class' => 'form-row form-row-first wsppe-form-row-padding-5',
        ]);
		
	?>
		
		</div>
        <div class="wsppe-options-header">Editor Instructions</div>
		<div >
			<?php 
        	$instructions = $Base_Meta->get_editor_instructions();
   
        	$index = 0;
        	foreach ($instructions as $key => $instruction) {
            	woocommerce_wp_checkbox([
                	'id'            => $instruction->get_key() . "[{$loop}]",
                	'name'          => "instructions[" . $instruction->get_key()."]" . "[{$loop}]",
                	'label'         => $instruction->get_label(),
                	'value'         => $instruction->is_enabled() ? 'yes' : 'no',
                	'desc_tip'      => true,
                	'description'   => $instruction->get_description(),
                	'wrapper_class' => 'form-row-multi-3 wsppe-form-row-padding-5',
            ]);
            $index++;
        }
			?>	
				</div> 
			</div> 
		</div> 
			
	</div>   
<?php

    }

	public function save_variables(int $variation_id, int $loop){
		$product = wc_get_product($variation_id);
		
		$Base_Meta = new Editor_Custom_Meta($product);
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			
		//$Base_Meta->set_customizable((bool)$post[Editor_Custom_Meta::PIE_EDITOR_ID_KEY][$loop] ?? '');

		$Base_Meta->set_editorId($post[Editor_Custom_Meta::PIE_EDITOR_ID_KEY][$loop] ?? '');
		$Base_Meta->set_templateId((string)$post[Editor_Custom_Meta::PIE_TEMPLATE_ID_KEY][$loop] ?? '');
    	$Base_Meta->set_designId((string)$post[Editor_Custom_Meta::PIE_DESIGN_ID_KEY][$loop] ?? '');
    	$Base_Meta->set_designProjectId((string)$post[Editor_Custom_Meta::PIE_DESIGN_PROJECT_ID_KEY][$loop] ?? '');
        $Base_Meta->set_colorCode((string)$post[Editor_Custom_Meta::PIE_COLOR_CODE_KEY][$loop] ??'');
        $Base_Meta->set_backgroundId((string)$post[Editor_Custom_Meta::PIE_BACKGROUND_ID_KEY][$loop] ?? '');

        $Base_Meta->set_price_per_extra_page((float)$post[Editor_Custom_Meta::PRICE_PER_EXTRA_PAGE_KEY][$loop] ?? 0.0);
		$Base_Meta->set_basePrice((float)$post[Editor_Custom_Meta::BASE_PRICE_KEY][$loop] ?? 1);
    	$Base_Meta->set_default_page_amount((int)$post[Editor_Custom_Meta::PAGE_AMOUNT_KEY][$loop] ?? 1);
    	$Base_Meta->set_numPages((int)$post[Editor_Custom_Meta::NUM_PAGES_KEY][$loop] ?? 1);
            
        $Base_Meta->set_usesImageUpload((bool)$post[Editor_Custom_Meta::USE_IMAGE_UPLOAD_KEY][$loop] ?? false);
        $Base_Meta->set_minImages((int)$post[Editor_Custom_Meta::MIN_IMAGES_KEY][$loop] ?? 1);
        $Base_Meta->set_maxImages((int)$post[Editor_Custom_Meta::MAX_IMAGES_KEY][$loop] ?? 1);
        $Base_Meta->set_autofill((bool) $post[Editor_Custom_Meta::AUTOFILL_KEY][$loop] ?? false);

        $Base_Meta->set_useProjectReference((bool)$post[Editor_Custom_Meta::USE_PROJECT_REFERENCE_KEY][$loop] ?? false);
        $Base_Meta->set_overrideThumb((bool)$post[Editor_Custom_Meta::OVERRIDE_CART_THUMB_KEY][$loop] ?? false);
        $Base_Meta->set_peleman_personalisation((string)$post[Editor_Custom_Meta::PELEMAN_PERSONALISATION_KEY][$loop] ?? '');
		error_log('POST in variable input === ' . $post['instructions']);
        $Base_Meta->set_editor_instructions($post['instructions'] ??  null);

		$Base_Meta->update_meta_data($product);
	}
    
}