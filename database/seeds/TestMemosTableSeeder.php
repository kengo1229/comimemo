<?php

use Illuminate\Database\Seeder;

class TestMemosTableSeeder extends Seeder
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
          'name' => 'サンプルメモ'.$i,
          'created_at' => new DateTime(),
          'updated_at' => new DateTime(),
        ];
        DB::table('memos')->insert($param);
      }

    }
}
