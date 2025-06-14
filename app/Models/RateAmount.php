<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateAmount extends Model
{
    use HasFactory;
    protected $guarded=[];
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
