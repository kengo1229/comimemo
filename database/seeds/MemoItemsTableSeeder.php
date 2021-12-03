<?php

use Illuminate\Database\Seeder;

class MemoItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $param = [
        'memo_id' => 1,
        'comic_title' => 'サンプル1',
        'comic_number' => 1,
        'order' => 1,
      ];
      DB::table('memo_items')->insert($param);
      $param = [
        'memo_id' => 1,
        'comic_title' => 'サンプル2',
        'comic_number' => 2,
        'order' => 2,
      ];
      DB::table('memo_items')->insert($param);
      $param = [
        'memo_id' => 1,
        'comic_title' => 'サンプル3',
        'comic_number' => 3,
        'order' => 3,
      ];
      DB::table('memo_items')->insert($param);
      $param = [
        'memo_id' => 1,
        'comic_title' => 'サンプル4',
        'comic_number' => 4,
        'order' => 4,
      ];
      DB::table('memo_items')->insert($param);
      $param = [
        'memo_id' => 1,
        'comic_title' => 'サンプル5',
        'comic_number' => 5,
        'order' => 5,
      ];
      DB::table('memo_items')->insert($param);
    }
}
