<?php

namespace Tests\Feature;

use App\Memo;
use App\MemoItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MemoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp():void
   {
       parent::setUp();
   }

    /**
     * A basic feature test example.
     *
     * @return void
     */


     /**
    * @test
    */
    public function メモ一覧のURLにアクセスしてデータが受け取れる()
    {
      // シーダ(5件分)を実行
      $this->seed([
        'TestMemosTableSeeder',
        'TestMemoItemsTableSeeder',
    ]);

      //メモ一覧表示
      $response = $this->get('/api/memos');


      $response->assertStatus(200) // スタータス200
        ->dump(); //シーダのデータが返ってきている
    }

     /**
    * @test
    */
    public function メモを削除できる()
    {
      
      // メモを1件と
      $memo = factory(Memo::class)->create([
            'name' => 'サンプル',
        ]);

      //メモ項目1件のデータを作成
      factory(MemoItem::class)->create([
            'memo_id' => 1,
            'comic_title' => 'サンプルコミック',
            'comic_number' => 1,
            'order' => 1,
        ]);

      // メモ削除機能
      $response = $this->delete('/api/memos/memo/'.$memo->id);

      // ステータスコードが200
      $response->assertStatus(200);

      // memosテーブルと
      $this->assertEquals(0, Memo::count());

      //memo_itemsテーブルが0件になっている
      $this->assertEquals(0, MemoItem::count());
    }

    /**
   * @test
   */
   public function メモ詳細ページを表示できる()
   {
     // メモ1件と
     $memo = factory(Memo::class)->create([
           'name' => 'サンプル',
       ]);

    // それに紐づくメモ項目を3件作成
      factory(MemoItem::class)->create([
            'comic_title' => 'サンプルコミック1',
        ]);


     // メモ詳細表示機能
     $response = $this->get('/api/memos/memo/'.$memo->id);

     $response->assertStatus(200) //ステータス200
      ->assertJsonCount(5); //レスポンス配列の件数が1件
      // ->assertJsonFragment(['comic_title' => 'サンプルコミック1']); //レスポンスに以下の値を含む

   }





}
