<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "Salman Khalid",
                "email" => "admin@web.com",
                "address" => "568-2875 Et Avenue",
                "phone" => "(837) 890-1184",
                "role_id" => Role::firstWhere("code", "admin")->id,
                "password" => Hash::make(123456)
            ],
            [
                "name" => "School",
                "email" => "school@web.com",
                "address" => "568-2875 Et Avenue",
                "phone" => "(837) 890-1184",
                "role_id" => Role::firstWhere("code", "school")->id,
                "password" => Hash::make(123456)
            ],
        ];

        User::insert($data);
    }
}
