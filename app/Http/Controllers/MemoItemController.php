<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MemoItem;
use App\Http\Requests\AddMemoItemRequest;

class MemoItemController extends Controller
{
  // メモ項目追加
  public function store(AddMemoItemRequest $request, $memo_id)
  {
      //メモ項目の中で一番最後のメモ項目の順番(order)を取得する
      $last_order = MemoItem::where('memo_id', $memo_id)->latest('order')
      ->first();

      // メモ自体は作成されているがメモ項目がない場合に対応
      if (is_null($last_order)) {
        $last_order = 0;
      }

      // memo_itemsテーブルに追加する
      $memo_item = new MemoItem;
      $memo_item->memo_id = $memo_id;
      $memo_item->comic_title = $request->secondaryTitle;
      $memo_item->comic_number = $request->secondaryNumber;

      // $last_orderの値に応じてorderカラムの値を変える
      if ($last_order === 0) {
        $memo_item->order = 1;
      }else {
        // 最新のorderに +1する
        $memo_item->order = $last_order->order + 1;
      }

      $memo_item->save();
  }

  // メモ項目編集
  public function update(Request $request ,$memo_id)
  {
          // メモ詳細ページから渡ってきたメモ項目の情報を全て詰める
          $memo_items = $request->all();
          // メモ項目の個数を数える
          $arr_num = count($memo_items);

          // 個数分だけ更新処理を繰り返す
          for ($i=0; $i < $arr_num ; $i++) {
            $memo_item = MemoItem::find($memo_items[$i]['id']);
            $memo_item->comic_title = $memo_items[$i]['comic_title'];
            $memo_item->comic_number = $memo_items[$i]['comic_number'];
            $memo_item->order = $i + 1;
            $memo_item->is_colored = $memo_items[$i]['is_colored'];
            $memo_item->save();
          }
  }

  // メモ項目削除
  public function destroy($item_id)
  {
      MemoItem::destroy($item_id);
  }
}
