<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Inquiry extends Model
{
protected $fillable = [
    'user_id',
    'department',
    'detail',
    'issue_type',
    'hardware_option',
    'software_option',
    'network_option',
    'it_can_handle',
    'software_can_handle', 
    'hardware_can_handle', 
    'network_can_handle',
    'attachment',
];
const ISSUE_TYPES = [
        1 => 'ハードウェア',
        2 => 'ソフトウェア',
        3 => 'ネットワーク',
    ];
const HARDWARE_OPTIONS = [
        1 => 'PC',
        2 => 'プリンタ',
        3 => 'その他',
    ];
const SOFTWARE_OPTIONS = [
        1 => 'オフィスソフト',
        2 => 'メールソフト',
        3 => 'その他',
    ];
const NETWORK_OPTIONS = [
        1 => 'Wi-Fi',
        2 => 'VPN',
        3 => 'その他',
    ];

    // 問題発生箇所を返す
    public function issueTypeName()
    {
        return self::ISSUE_TYPES[$this->issue_type] ?? 'unknown';
    }
    // ハードウェアの問題個所
    public function hardwareOptionName()
    {
        return self::HARDWARE_OPION[$this->hardware_option] ?? 'unknown';
    }

    // ソフトウェアの問題個所
    public function softwareOptionName()
    {
        return self::SOFTWARE_OPTION[$this->software_option] ?? 'unknown';
    }
    // ネットワークの問題個所
     public function networkOptionName()
    {
        return self::NETWORK_OPTION[$this->network_option] ?? 'unknown';
    }
    
    // リレーション
    public function user() {
    return $this->belongsTo(User::class);
}
    public function assignments()
{
    return $this->hasMany(InquiryAssignment::class, 'inquiry_id');
}
public function departments()
{
    return $this->belongsToMany(ItDepartment::class, 'inquiry_assignments', 'inquiry_id', 'department_id');
}
public function logs()
{
    return $this->hasMany(InquiryLog::class, 'inquiry_id');
}
}