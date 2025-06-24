<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'parent_id' => 0,
                'name' => 'Sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:21',
                'updated_at' => '2025-05-29 08:02:21',
            ),
            1 => 
            array (
                'id' => 2,
                'parent_id' => 1,
                'name' => 'Can add sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:34',
                'updated_at' => '2025-05-29 08:02:34',
            ),
            2 => 
            array (
                'id' => 3,
                'parent_id' => 1,
                'name' => 'Can edit sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:02:47',
                'updated_at' => '2025-05-29 08:02:47',
            ),
            3 => 
            array (
                'id' => 4,
                'parent_id' => 1,
                'name' => 'Can delete sysparam',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:01',
                'updated_at' => '2025-05-29 08:03:01',
            ),
            4 => 
            array (
                'id' => 5,
                'parent_id' => 0,
                'name' => 'Role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:26',
                'updated_at' => '2025-05-29 08:03:26',
            ),
            5 => 
            array (
                'id' => 6,
                'parent_id' => 5,
                'name' => 'Can add role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:03:47',
                'updated_at' => '2025-05-29 08:03:47',
            ),
            6 => 
            array (
                'id' => 7,
                'parent_id' => 5,
                'name' => 'Can edit role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:02',
                'updated_at' => '2025-05-29 08:04:02',
            ),
            7 => 
            array (
                'id' => 8,
                'parent_id' => 5,
                'name' => 'Can delete role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:24',
                'updated_at' => '2025-05-29 08:04:24',
            ),
            8 => 
            array (
                'id' => 9,
                'parent_id' => 5,
                'name' => 'Can show role permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:43',
                'updated_at' => '2025-05-29 08:04:43',
            ),
            9 => 
            array (
                'id' => 10,
                'parent_id' => 5,
                'name' => 'Can add role permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:04:53',
                'updated_at' => '2025-05-29 08:04:53',
            ),
            10 => 
            array (
                'id' => 11,
                'parent_id' => 0,
                'name' => 'Permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:04',
                'updated_at' => '2025-05-29 08:05:04',
            ),
            11 => 
            array (
                'id' => 12,
                'parent_id' => 11,
                'name' => 'Can add permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:16',
                'updated_at' => '2025-05-29 08:05:16',
            ),
            12 => 
            array (
                'id' => 13,
                'parent_id' => 11,
                'name' => 'Can edit permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:28',
                'updated_at' => '2025-05-29 08:05:28',
            ),
            13 => 
            array (
                'id' => 14,
                'parent_id' => 11,
                'name' => 'Can delete permission',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:41',
                'updated_at' => '2025-05-29 08:05:41',
            ),
            14 => 
            array (
                'id' => 15,
                'parent_id' => 0,
                'name' => 'User',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:05:55',
                'updated_at' => '2025-05-29 08:05:55',
            ),
            15 => 
            array (
                'id' => 16,
                'parent_id' => 15,
                'name' => 'Can add user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:06',
                'updated_at' => '2025-05-29 08:06:06',
            ),
            16 => 
            array (
                'id' => 17,
                'parent_id' => 15,
                'name' => 'Can show user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:16',
                'updated_at' => '2025-05-29 08:06:16',
            ),
            17 => 
            array (
                'id' => 18,
                'parent_id' => 15,
                'name' => 'Can edit user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:27',
                'updated_at' => '2025-05-29 08:06:27',
            ),
            18 => 
            array (
                'id' => 19,
                'parent_id' => 15,
                'name' => 'Can delete user',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:39',
                'updated_at' => '2025-05-29 08:06:39',
            ),
            19 => 
            array (
                'id' => 20,
                'parent_id' => 15,
                'name' => 'Can edit user role',
                'guard_name' => 'web',
                'created_at' => '2025-05-29 08:06:51',
                'updated_at' => '2025-05-29 08:06:51',
            ),
        ));
        
        
    }
}