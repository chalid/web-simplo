<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banners')->delete();
        
        \DB::table('banners')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'One Gateway Controller for Total Security',
                'description' => 'Seamlessly connect CCTV, access control, and visitor management into a single, powerful platform for enhanced security and efficiency.',
                'image' => '9gYsLApegIUz2CQnqed8xqeaYUjgZvxZiQho8AE0.jpg',
                'link' => NULL,
                'meta_title' => 'One Gateway Controller for Total Security',
                'meta_tag' => NULL,
                'meta_description' => 'Seamlessly connect CCTV, access control, and visitor management into a single, powerful platform for enhanced security and efficiency.',
                'meta_keywords' => 'one,gateway,controller,for,total,security',
                'meta_author' => 'Admin',
                'meta_image' => '9gYsLApegIUz2CQnqed8xqeaYUjgZvxZiQho8AE0.jpg',
                'meta_canonical' => 'http://192.168.56.3:8003',
                'meta_robots' => 'index, follow',
                'slug' => 'one-gateway-controller-for-total-security',
                'is_active' => 1,
                'created_at' => '2025-06-30 00:15:37',
                'updated_at' => '2025-06-30 00:15:38',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Simplo, Pioner on tech',
                'description' => 'Seamlessly connect CCTV, access control, and visitor management into a single, powerful platform for enhanced security and efficiency',
                'image' => '50qAe0I0DnjmY0nvcVAlouOvhKNejeZU0agtqkh2.jpg',
                'link' => NULL,
                'meta_title' => 'Simplo, Pioner on tech',
                'meta_tag' => NULL,
                'meta_description' => 'Seamlessly connect CCTV, access control, and visitor management into a single, powerful platform for enhanced security and efficiency',
                'meta_keywords' => 'simplo,,pioner,on,tech',
                'meta_author' => 'Admin',
                'meta_image' => '50qAe0I0DnjmY0nvcVAlouOvhKNejeZU0agtqkh2.jpg',
                'meta_canonical' => 'http://192.168.56.3:8003',
                'meta_robots' => 'index, follow',
                'slug' => 'simplo-pioner-on-tech',
                'is_active' => 1,
                'created_at' => '2025-06-30 00:16:36',
                'updated_at' => '2025-06-30 00:16:37',
            ),
        ));
        
        
    }
}