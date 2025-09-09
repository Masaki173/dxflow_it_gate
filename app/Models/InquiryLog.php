<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryLog extends Model
{
 protected $fillable = [
        'inquiry_id',
        'user_id',
        'can_handle',
        'content' ,
        'details',
    ];
    public function user() {
    return $this->belongsTo(User::class);
}
// 問い合わせとのリレーション
    public function inquiry()
{
    return $this->belongsTo(Inquiry::class, 'inquiry_id');
}
}