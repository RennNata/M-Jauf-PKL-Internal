<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Sri Rejeki (Aglaonema)',
                'slug' => 'sri-rejeki-aglaonema',
                'description' => 'Dikenal Ratu Daun karena corak warna yang khas dan beragam.',
                'price' => 75000.00,
                'discount_price' => 60000.00,
                'stock' => 50,
                'weight' => 500,
                'category_id' => 1,
                'is_active' => true,
                'image_path' => 'products/sri_rejeki.jpg'
            ],
            [
                'name' => 'Lidah Mertua (Sanseivieria)',
                'slug' => 'lidah-mertua-sanseivieria',
                'description' => 'Tahan banting, mudah dirawat, dan mampu membersihkan udara..',
                'price' => 75000.00,
                'discount_price' => 60000.00,
                'stock' => 50,
                'weight' => 500,
                'category_id' => 1,
                'is_active' => true,
                'image_path' => 'products/lidah_mertua.jpg'
            ],
            [
                'name' => 'Mawar (Red Rose)',
                'slug' => 'mawar-red-rose',
                'description' => 'Bunga klasik yang melambangkan cinta dan keindahan abadi.',
                'price' => 50000.00,
                'discount_price' => 45000.00,
                'stock' => 100,
                'weight' => 300,
                'category_id' => 2,
                'is_active' => true,
                'image_path' => 'products/mawar.jpg'
            ],
            [
                'name' => 'Tulip (Yellow Tulip)',
                'slug' => 'tulip-yellow-tulip',
                'description' => 'Bunga musim semi yang ceria dengan warna kuning cerah.',
                'price' => 60000.00,
                'discount_price' => null,
                'stock' => 80,
                'weight' => 250,
                'category_id' => 2,
                'is_active' => true,
                'image_path' => 'products/yellow_tulip.jpg'
            ],
            [
                'name' => 'Bambu Hias (Lucky Bamboo)',
                'slug' => 'bambu-hias-lucky-bamboo',
                'description' => 'Simbol keberuntungan dan kemakmuran dalam budaya Asia.',
                'price' => 40000.00,
                'discount_price' => 35000.00,
                'stock' => 70,
                'weight' => 400,
                'category_id' => 3,
                'is_active' => true,
                'image_path' => 'products/bambu_hias.jpg'
            ],
            [
                'name' => 'Kaktus Mini (Mini Cactus)',
                'slug' => 'kaktus-mini-mini-cactus',
                'description' => 'Tanaman sukulen yang unik dan mudah dirawat untuk dekorasi meja.',
                'price' => 30000.00,
                'discount_price' => null,
                'stock' => 120,
                'weight' => 150,
                'category_id' => 3,
                'is_active' => true,
                'image_path' => 'products/kaktus_mini.jpg'
            ]
        ];

        foreach ($products as $product) {
            $image = $product['image_path'];
            unset($product['image_path']);
            
            $product = Product::create($product);

            // product image
            $product->images()->create([
            'image_path' => $image,
            'is_primary' => true,
            'sort_order' => 1
    ]);
        }

        $this->command->info('✅ Products seeded successfully!');
    }
}
