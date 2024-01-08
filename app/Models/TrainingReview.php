<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TrainingReview extends Model
{
    use HasFactory;
    //以下の宣言をすることで、このモデルを経由してデータを取得する際は、
    //論理削除モデルに自動的になってくれる。（nullの行だけ取得）
    use SoftDeletes;
    
}
