<?php

declare(strict_types=1);

namespace WSPEC\adminPage\Models;

class Editor_Custom_Meta{
	// Editor data constants and variables for editor
    public const MY_EDITOR              = 'PIE';
	private bool $customizable;
	private string $editorId;
    private string $templateId;
    private string $designId;
    private string $designProjectId;
    private string $colorCode;
    private string $backgroundId;
	
	public const PIE_EDITOR_ID_KEY          = 'pwp_editor_id';
    public const PIE_TEMPLATE_ID_KEY        = 'pie_template_id'; 
	public const PIE_DESIGN_ID_KEY		    = 'pie_design_id';
	public const PIE_DESIGN_PROJECT_ID_KEY  = 'pie_design_project_id';
    public const PIE_COLOR_CODE_KEY         = 'pie_color_code';
    public const PIE_BACKGROUND_ID_KEY      = 'pie_background_id';

     // Product data constants and variables for editor
	
	private float $price_per_extra_page; 
    private float $basePrice;
    private int $default_page_amount;
	private int $numPages;
	
    public const PRICE_PER_EXTRA_PAGE_KEY 	= 'price_per_extra_page';
    public const BASE_PRICE_KEY			    = 'pie_base_price';
    public const PAGE_AMOUNT_KEY 		    = 'default_page_amount';
	public const NUM_PAGES_KEY              = 'pie_num_pages';

    // images data constants and variables for editor
	
	private bool $usesImageUpload;
	private bool $autofill;
    private int $minImages;
    private int $maxImages;
	
    public const USE_IMAGE_UPLOAD_KEY   = 'pie_image_upload';
	public const AUTOFILL_KEY           = 'pie_autofill';
    public const MAX_IMAGES_KEY         = 'pie_max_images';
    public const MIN_IMAGES_KEY         = 'pie_min_images';

        // extra data constants and variables for editor
    private bool $useProjectReference;
    private bool $overrideThumb;

    public const USE_PROJECT_REFERENCE_KEY  =  'use_project_reference';
    public const OVERRIDE_CART_THUMB_KEY    = 'pwp_override_cart_thumb';
	
    private  $editorInstructions;
    private string $PelemanPersonalisation;

    public const PELEMAN_PERSONALISATION_KEY    = 'peleman_personalisations';
    public const EDITOR_INSTRUCTIONS_KEY        = 'editor_instructions';
	
	public function __construct($product){
        $this->editorId             = (string)$product->get_meta(SELF::PIE_EDITOR_ID_KEY) ?: '';
        $this->customizable         = !empty($this->editorId);
        $this->templateId           = $product->get_meta(self::PIE_TEMPLATE_ID_KEY) ?? '';
        $this->designId             = $product->get_meta(self::PIE_DESIGN_ID_KEY) ?? '';
        $this->designProjectId      = $product->get_meta(self::PIE_DESIGN_PROJECT_ID_KEY) ?? '';
        $this->colorCode            = $product->get_meta(self::PIE_COLOR_CODE_KEY) ?? '';
        $this->backgroundId         = $product->get_meta(self::PIE_BACKGROUND_ID_KEY) ?? '';
    
        $this->price_per_extra_page = (float)$product->get_meta(self::PRICE_PER_EXTRA_PAGE_KEY) ?? 0.0;
        $this->basePrice            = (float)$product->get_meta(self::BASE_PRICE_KEY) ?? 0.0;
        $this->default_page_amount  = (int)$product->get_meta(self::PAGE_AMOUNT_KEY) ?? 1 ;
        $this->numPages             = (int)$product->get_meta(self::NUM_PAGES_KEY) ?? -1;

        $this->usesImageUpload      = (bool)$product->get_meta(self::USE_IMAGE_UPLOAD_KEY);
        $this->minImages            = (int)$product->get_meta(self::MIN_IMAGES_KEY) ?? 0;
        $this->maxImages            = (int)$product->get_meta(self::MAX_IMAGES_KEY) ?? 0;
        $this->autofill             = (bool)$product->get_meta(self::AUTOFILL_KEY);

        $this->useProjectReference  = (bool)$product->get_meta(self::USE_PROJECT_REFERENCE_KEY) ?: false;
        $this->overrideThumb        = (bool)$product->get_meta(self::OVERRIDE_CART_THUMB_KEY) ?: false;
        
		$this->PelemanPersonalisation   = $product->get_meta(self::PELEMAN_PERSONALISATION_KEY) ?? '' ;
        $this->editorInstructions   = $product->get_meta(self::EDITOR_INSTRUCTIONS_KEY) ?? [] ;
    }
    public function update_meta_data($product){

        $product->update_meta_data(self::PIE_EDITOR_ID_KEY, $this->editorId);
        $product->update_meta_data(self::PIE_TEMPLATE_ID_KEY, $this->designId);
        $product->update_meta_data(self::PIE_DESIGN_ID_KEY, $this->designId);
		$product->update_meta_data(self::PIE_DESIGN_PROJECT_ID_KEY, $this->designProjectId);
		$product->update_meta_data(self::PIE_COLOR_CODE_KEY, $this->colorCode); 
		$product->update_meta_data(self::PIE_BACKGROUND_ID_KEY, $this->backgroundId);
		
		$product->update_meta_data(self::PRICE_PER_EXTRA_PAGE_KEY, $this->price_per_extra_page);
		$product->update_meta_data(self::BASE_PRICE_KEY, $this->basePrice);
		$product->update_meta_data(self::PAGE_AMOUNT_KEY, $this->default_page_amount); 
		$product->update_meta_data(self::NUM_PAGES_KEY, $this->numPages);

		$product->update_meta_data(self::USE_IMAGE_UPLOAD_KEY, $this->usesImageUpload);
		$product->update_meta_data(self::MIN_IMAGES_KEY, $this->minImages);
		$product->update_meta_data(self::MAX_IMAGES_KEY, $this->maxImages);
		$product->update_meta_data(self::AUTOFILL_KEY, $this->autofill);

        $product->update_meta_data(self::OVERRIDE_CART_THUMB_KEY, $this->overrideThumb); 
		$product->update_meta_data(self::USE_PROJECT_REFERENCE_KEY, $this->useProjectReference);

        $product->update_meta_data(self::EDITOR_INSTRUCTIONS_KEY, $this->editorInstructions);
		$product->update_meta_data(self::PELEMAN_PERSONALISATION_KEY, $this->PelemanPersonalisation);
		
		$product->save();

		
	}
	
}