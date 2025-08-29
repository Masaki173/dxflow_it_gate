<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItDepartment extends Model
{
    use HasFactory;

    protected $table = 'it_departments';


    // const HARDWARE = 1;
    // const SOFTWARE = 2;
    // const NETWORK = 3;

    protected $fillable = ['name'];


    public function inquiryAssignments()
    {
        return $this->hasMany(InquiryAssignment::class, 'department_id');
    }

}
