<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingArea extends Model
{
    use HasFactory;
    
    public function result(){
        //部位は、多数のトレーニング実績を持っている。
        return $this->hasMany(TrainingResult::class);
    }


}
