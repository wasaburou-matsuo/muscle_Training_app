<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingResult extends Model
{
    use HasFactory;
    //以下の宣言をすることで、このモデルを経由してデータを取得する際は、
    //論理削除モデルに自動的になってくれる。（nullの行だけ取得）
    use SoftDeletes;

    protected $casts = [
        'id' => 'string'

    ];

    //リレーションを設定する
    //部位
    public function area(){
        //今回は１つのトレーニング実績は、１つの部員を持っている。
        //１対１のリレーションのときは、hasOneを使う。
        // return $this->hasOne(TrainingArea::class);
        //belongsToでも可能。
        return $this->belongsTo(TrainingArea::class);
    }

    //器具
    public function equipments(){
        //トレーニング実績は、複数の器具を持っている。
        return $this->hasmany(TrainingEquipment::class);
    }
    public function events(){
        //トレーニング実績は、複数の種目を持っている。
        return $this->hasmany(TrainingEvent::class);
    }

    //評価
    public fucntion reviews(){
        //トレーニング実績は、複数のレビューを持っている。
        return $this->hasmany(TrainingReview::class);
    }

    //ユーザー
    public function user(){
        return $this->belongTo(User::class);
    }
}
