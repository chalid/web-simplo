<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        $this->call(SysparamsTableSeeder::class);
        // User::factory(10)->create();
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'chalid.alys@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('Super Admin');
        $this->call(PermissionsTableSeeder::class);
        $this->call(ProductCategoriesTableSeeder::class);
        $this->call(ProjectCategoriesTableSeeder::class);
        $this->call(AboutsTableSeeder::class);
        $this->call(BannersTableSeeder::class);
        $this->call(MottoesTableSeeder::class);
        $this->call(VisionsTableSeeder::class);
        $this->call(FacilitiesTableSeeder::class);
        $this->call(FacilityImagesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductImagesTableSeeder::class);
        $this->call(ExVesselsTableSeeder::class);
        $this->call(ExVesselImagesTableSeeder::class);
    }
}
