<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MottoesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mottoes')->delete();
        
        \DB::table('mottoes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'LAHAN',
                'description' => 'Arjaya Berkah Marine menggunakan lahan yang keras / bukan tanah reklamasi dan kontur tanah datar merupakan salah satu keunggulan fasilitas area docking dan pembangunan kapal baru.',
                'image' => '9rfrXz1iH5Y5lSAkSkgD2r1JZB9ejGleYLjFt82A.jpg',
                'meta_title' => 'LAHAN',
                'meta_description' => 'Arjaya Berkah Marine menggunakan lahan yang keras / bukan tanah reklamasi dan kontur tanah datar merupakan salah satu keunggulan fasilitas area dockin...',
                'meta_keywords' => 'lahan',
                'meta_author' => 'Admin',
                'meta_image' => '9rfrXz1iH5Y5lSAkSkgD2r1JZB9ejGleYLjFt82A.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/motto/store',
                'meta_robots' => 'index, follow',
                'slug' => 'lahan',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:57:44',
                'updated_at' => '2025-06-09 16:57:45',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'KEDALAMAN',
                'description' => 'Kedalaman pantai yang memadai untuk docking / undocking Tug Boat, Barge serta kapal sampai dengan 5000 Dwt.',
                'image' => 'Lj1ojT8pfiFwV6xZIs3Atik1GaiJjxe0rwEYFXiL.jpg',
                'meta_title' => 'KEDALAMAN',
                'meta_description' => 'Kedalaman pantai yang memadai untuk docking / undocking Tug Boat, Barge serta kapal sampai dengan 5000 Dwt.',
                'meta_keywords' => 'kedalaman',
                'meta_author' => 'Admin',
                'meta_image' => 'Lj1ojT8pfiFwV6xZIs3Atik1GaiJjxe0rwEYFXiL.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/motto/store',
                'meta_robots' => 'index, follow',
                'slug' => 'kedalaman',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:58:17',
                'updated_at' => '2025-06-09 16:58:17',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'LOKASI',
                'description' => 'Arjaya Berkah Marine menempati lokasi yang strategis di perairan Selat Sunda bagian utara, berdekatan dengan kawasan industri Bojonegara.',
                'image' => 'Wse6ZGigqLmGQyAs2a1i2ZNeki9avj74rPVnuecc.jpg',
                'meta_title' => 'LOKASI',
                'meta_description' => 'Arjaya Berkah Marine menempati lokasi yang strategis di perairan Selat Sunda bagian utara, berdekatan dengan kawasan industri Bojonegara.',
                'meta_keywords' => 'lokasi',
                'meta_author' => 'Admin',
                'meta_image' => 'Wse6ZGigqLmGQyAs2a1i2ZNeki9avj74rPVnuecc.jpg',
                'meta_canonical' => 'http://192.168.56.3:8012/admin/motto/store',
                'meta_robots' => 'index, follow',
                'slug' => 'lokasi',
                'is_active' => 1,
                'created_at' => '2025-06-09 16:58:44',
                'updated_at' => '2025-06-09 16:58:46',
            ),
        ));
        
        
    }
}