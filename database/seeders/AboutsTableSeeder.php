<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AboutsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('abouts')->delete();
        
        \DB::table('abouts')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Tentang Simplo',
                'description' => '<p>Lumbatech adalah perusahaan security system yang berlokasi di Bekasi dan Jakarta, Lumbatech memiliki komitmen untuk meningkatkan mutu pelayanan dengan mendistribusikan produk berkualitas, after sales terbaik, tim instalasi handal dan pelayanan profesional. Seluruh produk yang kami tawarkan kepada pelanggan kami adalah produk yang telah memenuhi ISO 9001 = Standar Kualitas / Mutu, ISO 14001 = Standar Lingkungan. Produk asli ada di lumba technologies. Kunci Digital adalah spesialis kami, konsultasi dan instalasi serta pelayanan purna jual kami jadikan hal utama bagi setiap pelanggan lumbatech.com.</p>

<p>Didirikan dengan nama PT. Lumba Karya Asia (Lumbatech) menjadi distributor dan supplier yang sudah terdaftar resmi sebagai penyedia produk dengan brand ternama dan sudah teruji di security system untuk kebutuhan sistem keamanan perumahan, kantor, pabrik, apartement, mobile smart key system seperti : Mesin absensi sidik jari, mesin absensi karyawan, Mesin Absensi Wajah, vena fingerprint dan akses kontrol sistem yang dapat digunakan indoor maupun outdoor baik standalone sampai terhubung dengan IP/LAN System, jual kunci pintu digital, alarm kendaraan, alarm motor, alarm mobil, kunci rahasia kendaraan, kunci anti maling, kunci anti maling.</p>

<p>Khusus untuk melengkapi permintaan pelanggan, pertama di indonesia Lumbatech menyediakan wireless call system (Tombol pemanggil tanpa kabel) untuk meningkatkan pelayanan dan efisiensi bisnis Anda seperti : bell restoran, nurse call system untuk rumah sakit dan klinik, terapis call, emergency call, Queue system (sistem antrian tanpa kabel), supervisor/manager call, dengan teknologi Korea.Sensor Saklar Lampu AR 003 , Eco saver juga tersedia dan melayani Cetak Kartu RFID / kartu proximity EM 125kHz -0.8(Tipis), 1.8 (Tebal),Mifare, HID ISO PROX II,HID PROXCARD II.</p>

<p>Jujur, ramah dan profesional dalam pelayanan adalah yang utama bagi Lumbatech.</p>',
                'vision' => '<p>Visi kami adalah menjadi pemimpin dalam solusi sistem keamanan terintegrasi yang inovatif dan andal, memberdayakan bisnis di seluruh Indonesia.</p>',
                'mission' => '<p>Misi kami adalah menyediakan solusi keamanan yang efisien, aman dan fleksibel, bersamanan dengan mendukung karya anak bangsa dan memastikan kedaulatan data untuk setiap bisnis.</p>',
                'history' => '<p>Berawal dari pengalaman kami dalam sistem keamanan fisik, kami telah berkembang menjadi solusi&nbsp;<i>Smart Building Ecosystem</i>&nbsp;yang lengkap.</p>',
                'image' => 'Rr46dTwgY74b15Ekqew0IPbt3pbEsT2RVCQ3x5wl.jpg',
                'meta_tag' => 'Tentang Simplo',
                'meta_title' => 'Tentang Simplo',
                'meta_description' => 'Lumbatech adalah perusahaan security system yang berlokasi di Bekasi dan Jakarta, Lumbatech memiliki komitmen untuk meningkatkan mutu pelayanan dengan...',
                'meta_keywords' => 'tentang,simplo',
                'meta_author' => 'Admin',
                'meta_image' => 'Rr46dTwgY74b15Ekqew0IPbt3pbEsT2RVCQ3x5wl.jpg',
                'meta_canonical' => 'http://192.168.56.3:8003/about',
                'meta_robots' => 'index, follow',
                'slug' => 'tentang-simplo',
                'is_active' => 1,
                'created_at' => '2025-06-26 15:47:46',
                'updated_at' => '2025-06-26 17:46:18',
            ),
        ));
        
        
    }
}