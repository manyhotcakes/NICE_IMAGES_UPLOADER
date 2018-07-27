<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    /**
     * モデルと関連しているテーブル
     */
    protected $table = 'images';
    protected $primaryKey = 'id';

    public function getNextAutoIncrementId () {
      $statement = DB::select("SHOW TABLE STATUS LIKE '{$this->table}'");
      return $statement[0]->Auto_increment;
    }
}
