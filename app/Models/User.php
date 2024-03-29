<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
//このモデルは、UUIDを使用するという事を定義。
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        //idはuuidの為、文字列型にキャストしてあげなければuuidが使えず、ルーティングがうまく行かなくなってしまう。
        'id' => 'string'
    ];

    public function result(){
        //１人のユーザーが、多数のトレーニング実績を持っている。
        return $this->hasMany(TrainingResult::class);
    }

    public function reviews(){
        //１人のユーザーが、多数のレビューを持っている。
        return $this->hasMany(TrainingReview::class);
    }
}
