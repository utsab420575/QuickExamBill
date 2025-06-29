<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function designation(){
        return $this->belongsTo(Designation::class);
    }
    public function rateAssigns()
    {
        return $this->hasMany(RateAssign::class);
    }
}
