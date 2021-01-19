<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Users;

class userTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Users::create([
        	'username'=>'dikaeka@ymail.com',
        	'password'=>app('hash')->make('secret'),
        	'id_user_group'=>1
        ]);
    }
}
