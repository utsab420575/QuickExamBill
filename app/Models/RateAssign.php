<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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

    public static function getModerationCommitteeData($sessionId, $examTypeId, $rateHeadId)
    {
        // Log the input parameters for clarity
        Log::info("Fetching teachers for moderation committee with parameters:", [
            'session_id' => $sessionId,
            'exam_type_id' => $examTypeId,
            'rate_head_id' => $rateHeadId,
        ]);


        return self::with([
            'teacher.user',
            'teacher.designation',
            'teacher.department'
        ])
            ->where('session_id', $sessionId)
            ->where('exam_type_id', $examTypeId)
            ->where('rate_head_id', $rateHeadId)
            ->get();
    }

    public static function getTeachersFromCommittee($sessionId, $examTypeId, $rateHeadId)
    {

        // Log the input parameters for clarity
        Log::info("Fetching teachers for committee with parameters:", [
            'session_id' => $sessionId,
            'exam_type_id' => $examTypeId,
            'rate_head_id' => $rateHeadId,
        ]);

        $data =  self::with([
            'teacher.user',
            'teacher.designation',
            'teacher.department'
        ])
            ->where('session_id', $sessionId)
            ->where('exam_type_id', $examTypeId)
            ->where('rate_head_id', $rateHeadId)
            ->get();


        // Log the data fetched in pretty-printed JSON format
        Log::info("📘 Teachers fetched from committee:", ['data' => json_encode($data->toArray(), JSON_PRETTY_PRINT)]);


        return $data;
    }

    public static function getTeacherWithCourse($sessionId, $examTypeId, $rateHeadId)
    {
        Log::info('📥 getTeacherWithCourse() input received', [
            'session_id' => $sessionId,
            'exam_type_id' => $examTypeId,
            'rate_head_id' => $rateHeadId,
        ]);
        $data = self::where('session_id', $sessionId)
            ->where('exam_type_id', $examTypeId)
            ->where('rate_head_id', $rateHeadId)
            ->get()
            ->groupBy('course_code');

        Log::info("📘 getTeacherWithCourse() grouped results:\n" . json_encode([
                'session_id' => $sessionId,
                'exam_type_id' => $examTypeId,
                'rate_head_id' => $rateHeadId,
                'grouped_keys' => $data->keys()->toArray(),
                'full_grouped_data' => $data->map->toArray(),
            ], JSON_PRETTY_PRINT));

        return $data;
    }
}
