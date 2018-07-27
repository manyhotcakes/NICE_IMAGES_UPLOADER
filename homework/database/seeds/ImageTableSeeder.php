<?php

use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('images')->insert([
        [
          'name' => '暗い空',
          'path' => '/1.jpeg',
          'author_id' => 1
        ],
        [
          'name' => 'Dark Forest',
          'path' => '/2.jpeg',
          'author_id' => 1
        ],
        [
          'name' => 'a wooden wheel',
          'path' => '/3.jpeg',
          'author_id' => 1
        ],
        [
          'name' => 'edge of the sea',
          'path' => '/4.jpeg',
          'author_id' => 1
        ],
        [
          'name' => 'さくらさくらさくらさくらさくら',
          'path' => '/5.jpeg',
          'author_id' => 1
        ],
      ]);
    }
}
