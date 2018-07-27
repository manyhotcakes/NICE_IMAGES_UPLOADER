<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
          'name' => env('API_DUMMY_USER_NAME'),
          'email' => env('API_DUMMY_USER_EMAIL'),
          'password' => bcrypt(env('API_DUMMY_USER_PW'))
        ]);
    }
}
