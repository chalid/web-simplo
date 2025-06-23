<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('visions')->delete();
        
        \DB::table('visions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'SESUAI ANGGARAN',
                'description' => 'Kami menyelesaikan pekerjaan sesuai dengan anggaran yang disepakati.',
                'image' => 'Pka8gMq23014iBDQKRlsW3FF9Cvoy5kcFQfpeeGX.png',
                'meta_title' => 'SESUAI ANGGARAN',
                'meta_description' => 'Kami menyelesaikan pekerjaan sesuai dengan anggaran yang disepakati.',
                'meta_keywords' => 'sesuai,anggaran',
                'meta_author' => 'Admin',
                'meta_image' => 'Pka8gMq23014iBDQKRlsW3FF9Cvoy5kcFQfpeeGX.png',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/vision/store',
                'meta_robots' => 'index, follow',
                'slug' => 'sesuai-anggaran',
                'is_active' => 1,
                'created_at' => '2025-06-09 17:00:37',
                'updated_at' => '2025-06-09 17:00:41',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'JAMINAN KUALITAS',
                'description' => 'Kami tetap menjaga kualitas pekerjaan.',
                'image' => 'mnYnpU5L1tRNJUC0jccGaKYDULeoHHHuMnF5tDIU.png',
                'meta_title' => 'JAMINAN KUALITAS',
                'meta_description' => 'Kami tetap menjaga kualitas pekerjaan.',
                'meta_keywords' => 'jaminan,kualitas',
                'meta_author' => 'Admin',
                'meta_image' => 'mnYnpU5L1tRNJUC0jccGaKYDULeoHHHuMnF5tDIU.png',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/vision/store',
                'meta_robots' => 'index, follow',
                'slug' => 'jaminan-kualitas',
                'is_active' => 1,
                'created_at' => '2025-06-09 17:01:23',
                'updated_at' => '2025-06-09 17:01:24',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'TEPAT WAKTU',
                'description' => 'Kami siap menyelesaikan pekerjaan sesuai waktu perencanaan.',
                'image' => '7kSqcGk3JqKZHkWu1ApbEMtvLVDrZlQYV4nKsWrf.png',
                'meta_title' => 'TEPAT WAKTU',
                'meta_description' => 'Kami siap menyelesaikan pekerjaan sesuai waktu perencanaan.',
                'meta_keywords' => 'tepat,waktu',
                'meta_author' => 'Admin',
                'meta_image' => '7kSqcGk3JqKZHkWu1ApbEMtvLVDrZlQYV4nKsWrf.png',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/vision/store',
                'meta_robots' => 'index, follow',
                'slug' => 'tepat-waktu',
                'is_active' => 1,
                'created_at' => '2025-06-09 17:01:53',
                'updated_at' => '2025-06-09 17:01:54',
            ),
        ));
        
        
    }
}