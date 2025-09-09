<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'inquiry_id',
        'department_id',
    ];
// 関連テーブル設定
    public function inquiry()
{
    return $this->belongsTo(Inquiry::class, 'inquiry_id');
}


    public function departments()
{
    return $this->belongsTo(ItDepartment::class, 'department_id');
}

}
