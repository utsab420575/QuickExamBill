<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateAssign extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function rateHead()
    {
        return $this->belongsTo(RateHead::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }
}
