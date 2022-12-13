<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('super_admins')->insert([
            'name' => 'Super Admin',
            'email' => 'alekhya1512@gmail.com',
            'email_verified_at' => Carbon::now(),
            'phone_number' => '+21436446021',
            'profile_picture' => 'profile.png',
            'password' => Hash::make('test@2022'),
        ]);

    }
}


