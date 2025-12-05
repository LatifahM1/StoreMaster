<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name' => 'iPhone 14',
                'category' => 'Smartphones',
                'price' => 3999.00,
                'description' => 'Latest Apple smartphone.',
                'image_url' => 'https://example.com/iphone14.jpg',
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'category' => 'Smartphones',
                'price' => 3599.00,
                'description' => 'High-end Samsung smartphone.',
                'image_url' => 'https://example.com/s23.jpg',
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'category' => 'Headphones',
                'price' => 1499.00,
                'description' => 'Noise-canceling premium headphones.',
                'image_url' => 'https://example.com/sony.jpg',
            ],
            [
                'name' => 'MacBook Air M2',
                'category' => 'Laptops',
                'price' => 4999.00,
                'description' => 'Apple MacBook with M2 chip.',
                'image_url' => 'https://example.com/macbook.jpg',
            ],
            [
                'name' => 'Lenovo IdeaPad 3',
                'category' => 'Laptops',
                'price' => 2299.00,
                'description' => 'Affordable and powerful laptop.',
                'image_url' => 'https://example.com/lenovo.jpg',
            ],
            [
                'name' => 'Canon EOS 250D',
                'category' => 'Cameras',
                'price' => 2899.00,
                'description' => 'DSLR camera for beginners.',
                'image_url' => 'https://example.com/canon.jpg',
            ],
            [
                'name' => 'Apple AirPods Pro',
                'category' => 'Earbuds',
                'price' => 899.00,
                'description' => 'Noise-canceling wireless earbuds.',
                'image_url' => 'https://example.com/airpods.jpg',
            ],
            [
                'name' => 'Samsung 55\" 4K TV',
                'category' => 'Televisions',
                'price' => 2499.00,
                'description' => 'Smart 4K UHD TV.',
                'image_url' => 'https://example.com/samsungtv.jpg',
            ],
            [
                'name' => 'JBL Charge 5',
                'category' => 'Speakers',
                'price' => 699.00,
                'description' => 'Portable Bluetooth speaker.',
                'image_url' => 'https://example.com/jbl.jpg',
            ],
            [
                'name' => 'Dell UltraSharp Monitor',
                'category' => 'Monitors',
                'price' => 1599.00,
                'description' => '27-inch professional display.',
                'image_url' => 'https://example.com/dell.jpg',
            ],
            [
                'name' => 'Logitech MX Master 3',
                'category' => 'Accessories',
                'price' => 399.00,
                'description' => 'Advanced wireless mouse.',
                'image_url' => 'https://example.com/logitech.jpg',
            ],
            [
                'name' => 'Razer BlackWidow V3',
                'category' => 'Keyboards',
                'price' => 599.00,
                'description' => 'Mechanical gaming keyboard.',
                'image_url' => 'https://example.com/razer.jpg',
            ],
            [
                'name' => 'Huawei Watch GT 3',
                'category' => 'Wearables',
                'price' => 899.00,
                'description' => 'Smart watch with health tracking.',
                'image_url' => 'https://example.com/huawei.jpg',
            ],
            [
                'name' => 'Xiaomi Mi Band 7',
                'category' => 'Wearables',
                'price' => 199.00,
                'description' => 'Affordable fitness tracker.',
                'image_url' => 'https://example.com/miband.jpg',
            ],
            [
                'name' => 'HP Smart Printer',
                'category' => 'Printers',
                'price' => 499.00,
                'description' => 'Wireless home printer.',
                'image_url' => 'https://example.com/hp.jpg',
            ],
            [
                'name' => 'PlayStation 5',
                'category' => 'Gaming',
                'price' => 2499.00,
                'description' => 'Sony next-gen gaming console.',
                'image_url' => 'https://example.com/ps5.jpg',
            ],
            [
                'name' => 'Xbox Series X',
                'category' => 'Gaming',
                'price' => 2399.00,
                'description' => 'Powerful Microsoft gaming console.',
                'image_url' => 'https://example.com/xbox.jpg',
            ],
            [
                'name' => 'Nintendo Switch',
                'category' => 'Gaming',
                'price' => 1599.00,
                'description' => 'Portable + home gaming console.',
                'image_url' => 'https://example.com/switch.jpg',
            ],
            [
                'name' => 'GoPro HERO 10',
                'category' => 'Cameras',
                'price' => 1699.00,
                'description' => 'Action camera for adventures.',
                'image_url' => 'https://example.com/gopro.jpg',
            ],
            [
                'name' => 'Dyson V11 Vacuum',
                'category' => 'Home Appliances',
                'price' => 2199.00,
                'description' => 'Premium cordless vacuum cleaner.',
                'image_url' => 'https://example.com/dyson.jpg',
            ],
        ]);
    }
}
