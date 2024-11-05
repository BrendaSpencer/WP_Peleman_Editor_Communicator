<?php

declare(strict_types=1);

namespace WSPBPE\adminPage\Models;

class Editor_Custom_Meta{
    private bool $customizable;
    private string $customAddToCartLabel;
    private float $cover_price_per_page; // price per page added to the product in the editor
    private string $projectReference;
    private bool $useProjectReference;
    private bool $overrideThumb;

    public string $templateId;
    public string $designId;
    public string $designProjectId;
    public string $colorCode;
    public string $backgroundId;
    private  $editorInstructions;

    public bool $usesImageUpload;
    public int $minImages;
    public int $maxImages;
    public string $f2dPersonalisation;

	
    public int $numPages;
    public bool $autofill;
    public string $formatId;

    public float $coverPricePerPage;
    public float $basePrice;
    private int $default_page_amount;

    private string $variantId;
    private string $editorId;

}