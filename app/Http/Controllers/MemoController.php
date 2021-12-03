<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CreateMemoRequest;
use App\Http\Requests\ChangeMemoNameRequest;
use App\Http\Requests\MakeMemoRequest;
use App\Memo;
use App\MemoItem;

class MemoController extends Controller
{
    // メモ一覧表示
    public function index()
    {
      // メモとそれに紐づくメモ項目の情報を返す
      return Memo::with('memoItems')->get();

    }

    //メモ新規作成
    public function store(CreateMemoRequest $request)
    {
      // memosテーブルにメモタイトルを保存
      $memo = new Memo;
      $memo->name = $request->name;
      $memo->save();

      // 直前の$memo->save()で保存されたmemosテーブルの最新idを取得
      $id = $memo->id;
      // textareaに入力された値を取得
      $input = $request->comic;
      /*
       改行ごとに配列を生成
       1要素 = 1段落の情報（コミックタイトル+巻数）が値になっている
      */
      $array_comics = explode( "\n" , str_replace(array("\r\n", "\r", "\n"), "\n", $input));

      // orderカラムの値にする変数
      $n = 1;

      // 要素の数だけmemo_itemsテーブルに保存する
      foreach ($array_comics as $comic) {
        $memo_item = new MemoItem;
        $memo_item->memo_id = $id;
        /*
        コミックタイトルには巻数ごとに保存
        */
        $memo_item->comic_title = $comic;
        /*
        コミック巻数のみを値から抽出する処理
        末尾3文字を抽出してその中の数字だけを取り出す
        */
        $comic_number = preg_replace('/[^0-9]/', '', substr($comic, -3));
        // 巻数未入力のものについては1とする
        $comic_number = $comic_number === '' ? 1 : $comic_number;
        $memo_item->comic_number = $comic_number;
        $memo_item->order = $n;
        $memo_item->save();

        $n++;
      }

    }

    // メモ名編集
    public function update(ChangeMemoNameRequest $request, $memo_id)
    {
        // memosテーブルにある任意のメモタイトルを変更
        $memo = Memo::find($memo_id);
        $memo->name = $request->name;
        $memo->save();
    }

    // メモ削除機能
    public function destroy($memo_id)
    {

      // if ($request->has('delete-memo')) {
        // $memoを元にしてmemo_itemsテーブルのレコードを先に削除する
        MemoItem::where('memo_id', $memo_id)->delete();

        // 次に大元のmemosテーブルのレコードを削除する
        Memo::destroy($memo_id);

      // }
    }

    //メモ詳細表示
    public function show($memo_id)
    {
        return  Memo::with('memoItems')->find($memo_id);
    }

    // 別メモ作成
    public function create(MakeMemoRequest $request)
    {

        // memosテーブルにメモタイトルを保存
        $memo = new Memo;
        $memo->name = $request->secondaryName;
        $memo->save();

        // 直前の$memo->save()で保存されたmemosテーブルの最新idを取得
        $memo_id = $memo->id;

        /*
        チェックボックスがオンのメモ項目からidを受け取る
        */
        $item_id_arr = $request->itemId;
        // orderカラム用の変数
        $n = 1;

        // $item_id_arrの要素数だけ処理を繰り返す
        foreach ($item_id_arr as $item_id) {
          // item_idを元にmemo_itemsテーブルから該当するレコードを取得
          $memo_item = MemoItem::find($item_id);
          // メモ項目を新規作成
          $new_memo_item = new MemoItem;
          $new_memo_item->memo_id = $memo_id;
          $new_memo_item->comic_title = $memo_item->comic_title;
          $new_memo_item->comic_number = $memo_item->comic_number;
          $new_memo_item->order = $n;
          $new_memo_item->save();

          $n++;
        }
    }

}
