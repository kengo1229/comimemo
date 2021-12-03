<?php

use Illuminate\Database\Seeder;

class TestMemoItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i=1; $i <=5 ; $i++) {
        $param = [
          'memo_id' => $i,
          'comic_title' => 'サンプル項目'.$i,
          'comic_number' => $i,
          'order' => $i,
          'created_at' => new DateTime(),
          'updated_at' => new DateTime(),
        ];
        DB::table('memo_items')->insert($param);
      }
    }
}
