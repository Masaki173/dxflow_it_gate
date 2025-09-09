<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItDepartment extends Model
{
    use HasFactory;

    protected $table = 'it_departments';



    protected $fillable = ['name'];
    
public function getNameJaAttribute()
    {
        return match($this->name) {
            'Hardware' => 'ハードウェア',
            'Software' => 'ソフトウェア',
            'Network'  => 'ネットワーク',
        };
    }
// 関連テーブル設定
    public function inquiryAssignments()
    {
        return $this->hasMany(InquiryAssignment::class, 'department_id');
    }

}
