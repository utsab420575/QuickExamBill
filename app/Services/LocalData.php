<?php

namespace App\Services;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocalData
{
    public static function getOrCreateRegularSession($sessionId,$exam_type)
    {
        $session_info = Session::where('ugr_id', $sessionId)
            ->where('exam_type_id',$exam_type)->first();

        if (!$session_info) {
            $session_info_data = ApiData::getSessionInfo($sessionId);

            if ($session_info_data && isset($session_info_data['session'])) {
                $session_info = new Session();
                $session_info->ugr_id = $sessionId;
                $session_info->session = $session_info_data['session'];
                $session_info->year = $session_info_data['year'];
                $session_info->semester = $session_info_data['semester'];
                $session_info->exam_type_id = $exam_type;
                $session_info->created_at = now();
                $session_info->updated_at = now();
                $session_info->save();

                Log::info('✅ New session created from API', $session_info->toArray());
            } else {
                Log::warning('Session info missing or invalid in API response for sessionId: ' . $sessionId);
                return null; // Or throw exception
            }
        }

        return $session_info;
    }


    public static function getOrCreateReviewSession($sessionId,$exam_type)
    {
        $session_info = Session::where('ugr_id', $sessionId)
            ->where('exam_type_id',$exam_type)->first();

        if (!$session_info) {
            $session_info_data = ApiData::getSessionInfo($sessionId);

            if ($session_info_data && isset($session_info_data['session'])) {
                $session_info = new Session();
                $session_info->ugr_id = $sessionId;
                $session_info->session = $session_info_data['session'];
                $session_info->year = $session_info_data['year'];
                $session_info->semester = $session_info_data['semester'];
                $session_info->exam_type = 'Review';
                $session_info->created_at = now();
                $session_info->updated_at = now();
                $session_info->save();

                Log::info('✅ New session created from API', $session_info->toArray());
            } else {
                Log::warning('Session info missing or invalid in API response for sessionId: ' . $sessionId);
                return null; // Or throw exception
            }
        }

        return $session_info;
    }
}
