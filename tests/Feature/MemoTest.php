<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use OrderStatusesTableSeeder;
use Tests\TestCase;
use App\Memo;
use App\MemoItem;

class MemoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp():void
   {
       parent::setUp();

       // データベースマイグレーション
       $this->artisan('migrate');

       // 必要に応じてテストデータ挿入
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
      $this->seed([
        'TestMemosTableSeeder',
        'TestMemoItemsTableSeeder',
    ]);

      $response = $this->getJson('/api/memos');
      $response->assertStatus(200)->dump();
    }

     /**
    * @test
    */
    public function 新しいメモを作成して返却する()
    {
      $data = [
            'name' => '新しいメモ',
            'comic' => "コミック1\nコミック2\nコミック3\nコミック4\nコミック5"
        ];

        $response = $this->postJson('/api/memos/memo', $data);

        $response->assertStatus(201);
    }







    // public function ホーム画面のヘッダーリンクをクリックして画面が表示される()
    // {
    //   $response = $this->get('/memos');
    //
    //   $response->assertStatus(200)
    //     ->assertSee('コミメモ');
    // }
}
