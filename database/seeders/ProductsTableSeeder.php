<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('products')->delete();
        
        \DB::table('products')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_category_id' => 6,
                'title' => 'Kapal Tug Boat',
                'code_no' => 'KBB00001',
                'description' => '<p>Kapal Tug Boat</p>',
                'image' => 'szwbmxg5YOCOXi1zZ316PFPz8EyX76dQyGUt5CUm.jpg',
                'meta_title' => 'Kapal Tug Boat',
                'meta_description' => 'Kapal Tug Boat',
                'meta_keywords' => 'kapal,tug,boat',
                'meta_author' => 'Admin',
                'meta_image' => 'szwbmxg5YOCOXi1zZ316PFPz8EyX76dQyGUt5CUm.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/product/1/update',
                'meta_robots' => 'index, follow',
                'slug' => 'kapal-tug-boat',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:19:12',
                'updated_at' => '2025-06-12 02:20:25',
            ),
            1 => 
            array (
                'id' => 2,
                'product_category_id' => 8,
                'title' => 'Produksi Mooring Buoy',
                'code_no' => 'MB00001',
                'description' => '<p>Mooring buoy adalah tambat apung yang digunakan untuk tambatan kapal sementara, dirancang agar dapat dikenali dengan mudah. Mooring buoy dilengkapi dengan beban yang lebih berat untuk diletakkan di dasar laut, dihubungkan dengan menggunakan rantai.</p>',
                'image' => 'QU8b3xyAI8OTyBGcopeNf4Aru8x8yMS9UF5Z7Uqx.jpg',
                'meta_title' => 'Produksi Mooring Buoy',
                'meta_description' => 'Mooring buoy adalah tambat apung yang digunakan untuk tambatan kapal sementara, dirancang agar dapat dikenali dengan mudah. Mooring buoy dilengkapi de...',
                'meta_keywords' => 'produksi,mooring,buoy',
                'meta_author' => 'Admin',
                'meta_image' => 'QU8b3xyAI8OTyBGcopeNf4Aru8x8yMS9UF5Z7Uqx.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/product/store',
                'meta_robots' => 'index, follow',
                'slug' => 'produksi-mooring-buoy',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:23:21',
                'updated_at' => '2025-06-12 02:23:23',
            ),
            2 => 
            array (
                'id' => 3,
                'product_category_id' => 7,
                'title' => 'Rubber Airbag Peluncuran Kapal',
                'code_no' => 'RA00001',
                'description' => '<p>Airbag dapat digunakan untuk meluncurkan dan mengangkat kapal hingga 100.000DWT, dibandingkan dengan metode peluncuran slipway tradisional dan lebih ramah lingkungan, Airbag dapat meluncurkan sebuah kapal di pantai apa pun, sehingga tidak perlu khawatir tentang pembangunan fasilitas peluncuran, selain itu Airbag hanya membutuhkan sedikit perawatan serta dapat digunakan berulang kali.</p>',
                'image' => 'AQENSt8mCP14ZI5Msn7lFQneX4AGnkmRyivIFpX6.jpg',
                'meta_title' => 'Rubber Airbag Peluncuran Kapal',
                'meta_description' => 'Airbag dapat digunakan untuk meluncurkan dan mengangkat kapal hingga 100.000DWT, dibandingkan dengan metode peluncuran slipway tradisional dan lebih r...',
                'meta_keywords' => 'rubber,airbag,peluncuran,kapal',
                'meta_author' => 'Admin',
                'meta_image' => 'AQENSt8mCP14ZI5Msn7lFQneX4AGnkmRyivIFpX6.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/product/store',
                'meta_robots' => 'index, follow',
                'slug' => 'rubber-airbag-peluncuran-kapal',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:24:57',
                'updated_at' => '2025-06-12 02:25:24',
            ),
            3 => 
            array (
                'id' => 4,
                'product_category_id' => 10,
                'title' => 'Crane Link Bell 35 Ton',
                'code_no' => 'CR00001',
                'description' => '<p>Dijual Crane Link Bell 35 Ton</p>',
                'image' => 'K8U2ZXneMurm9VQIjR0rXrzFI5zBPcSMbH971wlj.jpg',
                'meta_title' => 'Crane Link Bell 35 Ton',
                'meta_description' => 'Dijual Crane Link Bell 35 Ton',
                'meta_keywords' => 'crane,link,bell,35,ton',
                'meta_author' => 'Admin',
                'meta_image' => 'K8U2ZXneMurm9VQIjR0rXrzFI5zBPcSMbH971wlj.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/product/store',
                'meta_robots' => 'index, follow',
                'slug' => 'crane-link-bell-35-ton',
                'is_active' => 1,
                'created_at' => '2025-06-12 02:30:04',
                'updated_at' => '2025-06-12 02:30:33',
            ),
        ));
        
        
    }
}