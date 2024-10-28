<?php 
declare(strict_types=1);
namespace WSPBPE\publicPage\Models;
require plugin_dir_path(__FILE__) . '/vendor/autoload.php';


class Product {
    private string $name;
    private float $price;
    private string $description;
    public function __construct(){
        $this->name = 'TESTER';
        $this->price = 12.50;
        $this->description = 'Just a testing sample';

    }
}