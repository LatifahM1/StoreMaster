<?php
namespace Database\Seeders;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'iPhone 15 Pro', 'category' => 'Smartphones', 'price' => 4999, 'description' => 'Latest iPhone', 'image_url' => 'https://store.storeimages.cdn-apple.com/4982/as-images.apple.com/is/iphone-15-pro-finish-select-202309-6-1inch?wid=5120&hei=2880&fmt=webp&qlt=70&.v=1693009279096'],
            ['name' => 'Samsung Galaxy S24', 'category' => 'Smartphones', 'price' => 4299, 'description' => 'Samsung flagship', 'image_url' => 'https://images.samsung.com/is/image/samsung/p6pim/ar/2401/gallery/ar-galaxy-s24-s928-531361-sm-s928blbqaro-539030052'],
            ['name' => 'MacBook Pro M3', 'category' => 'Laptops', 'price' => 8999, 'description' => 'Apple laptop', 'image_url' => 'https://www.apple.com/v/macbook-pro-14-and-16/b/images/overview/hero/hero_intro__k7a6m2mopwym_large.jpg'],
            // أضف 20-30 منتج هنا...
        ];
        
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}