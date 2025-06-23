<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_images')->delete();
        
        \DB::table('product_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'product_id' => 1,
                'uri' => 'KNoVYndTGYsXdMfH9ZCYQkgKxp5FAyW50aHz2UtK.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 02:19:12',
                'updated_at' => '2025-06-12 02:19:26',
            ),
            1 => 
            array (
                'id' => 2,
                'product_id' => 1,
                'uri' => 'szwbmxg5YOCOXi1zZ316PFPz8EyX76dQyGUt5CUm.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:19:26',
                'updated_at' => '2025-06-12 02:19:26',
            ),
            2 => 
            array (
                'id' => 3,
                'product_id' => 2,
                'uri' => 'QU8b3xyAI8OTyBGcopeNf4Aru8x8yMS9UF5Z7Uqx.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:23:23',
                'updated_at' => '2025-06-12 02:23:23',
            ),
            3 => 
            array (
                'id' => 4,
                'product_id' => 3,
                'uri' => 'KIRR5HZ0fR1RYhS4h3mWd5l4WHXTamT9kxAKozzY.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 02:24:58',
                'updated_at' => '2025-06-12 02:25:24',
            ),
            4 => 
            array (
                'id' => 5,
                'product_id' => 3,
                'uri' => 'AQENSt8mCP14ZI5Msn7lFQneX4AGnkmRyivIFpX6.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:25:24',
                'updated_at' => '2025-06-12 02:25:24',
            ),
            5 => 
            array (
                'id' => 6,
                'product_id' => 4,
                'uri' => 'D5hsIgUx8io6swhwYs4GVzPytXl1lPiLDeOVb9xL.jpg',
                'is_default' => 0,
                'created_at' => '2025-06-12 02:30:05',
                'updated_at' => '2025-06-12 02:30:33',
            ),
            6 => 
            array (
                'id' => 7,
                'product_id' => 4,
                'uri' => 'K8U2ZXneMurm9VQIjR0rXrzFI5zBPcSMbH971wlj.jpg',
                'is_default' => 1,
                'created_at' => '2025-06-12 02:30:33',
                'updated_at' => '2025-06-12 02:30:33',
            ),
        ));
        
        
    }
}