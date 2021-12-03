<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
  protected $guarded = array('id');

  // memo_itemsテーブルとのリレーション
  public function memoItems()
  {
    return $this->hasMany('App\MemoItem')->orderBy('order', 'asc');
  }
}
