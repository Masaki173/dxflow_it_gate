<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
     
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    // 部署の設定
      const ROLES = [
        1 => 'admin',
        2 => 'employee',
        3 => 'it',
        4 => 'software',
        5 => 'hardware',
        6 => 'network'
    ];
    // 部署名を返す
    public function roleName()
    {
        return self::ROLES[$this->role_id] ?? 'unknown';
    }
    // 管理者判定(必要になった場合)
    public function isAdmin()
    {
        return $this->role_id === 1;
    }
    // リレーション
     public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'user_id');
    }
}
