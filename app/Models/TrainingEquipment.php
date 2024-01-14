<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEquipment extends Model
{
    use HasFactory;
    //$table変数はLaravelのEloquentモデルで元々定義されている変数
    protected $table = 'training_equipments';
    
    public function result(){
        //器具は、１つのトレーニング実績を持っている。
        return $this->belongsTo(TrainingResult::class);
    }
}
