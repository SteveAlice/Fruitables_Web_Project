<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = "admin";
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'picture'
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
    ];

    //Phương thức getPictureAttribute trong đoạn mã là một trường tính ảo (accessor) của model Admin
    // Truy cập thuộc tính picture của một đối tượng Admin, phương thức này sẽ được tự động gọi để xử lý giá trị trước khi nó được trả về.
    public function getPictureAttribute($value){
        if( $value){
            return asset('/images/users/admins'.$value);
        }else{
            return asset('/images/users/default-avatar.png');
        }
    }
}

