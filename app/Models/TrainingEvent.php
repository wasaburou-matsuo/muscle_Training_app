<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvent extends Model
{
    use HasFactory;
    
    public function result(){
        //器具は、１つのトレーニング実績を持っている。
        return $this->belongsTo(TrainingResult::class);
    }
}
