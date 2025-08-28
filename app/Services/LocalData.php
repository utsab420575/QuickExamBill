<?php

namespace App\Services;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LocalData
{

    public static function getOrCreateRegularSession($sid, $exam_type)
    {
        // 1) Try to find session where id = sid and ugr_id is NULL
        $session_info = Session::whereNull('ugr_id')
            ->where('exam_type_id', $exam_type)
            ->where('id', $sid)
            ->first();

        // 2) If not found, try to find session where ugr_id = sid
        if (!$session_info) {
            $session_info = Session::where('ugr_id', $sid)
                ->where('exam_type_id', $exam_type)
                ->first();
        }

        // 3) If still not found, pull from API and create new
        if (!$session_info) {
            $session_info_data = ApiData::getSessionInfo($sid);

            if ($session_info_data && isset($session_info_data['session'])) {
                $session_info = new Session();
                $session_info->ugr_id       = $sid;
                $session_info->session      = $session_info_data['session'];
                $session_info->year         = $session_info_data['year'];
                $session_info->semester     = $session_info_data['semester'];
                $session_info->exam_type_id = $exam_type; // ✅ corrected: use exam_type_id, not string
                $session_info->created_at   = now();
                $session_info->updated_at   = now();
                $session_info->save();

                Log::info('✅ New review session created from API', $session_info->toArray());
            } else {
                Log::warning('⚠️ Session info missing or invalid in API response for sid: ' . $sid);
                return null; // or throw exception
            }
        }

        return $session_info;
    }
    /*public static function getOrCreateRegularSession($sessionId,$exam_type)
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
    }*/


    /*public static function getOrCreateRegularSession($sessionId,$exam_type)
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
    }*/
    public static function getOrCreateReviewSession($sid, $exam_type)
    {
        // 1) Try to find session where id = sid and ugr_id is NULL
        $session_info = Session::whereNull('ugr_id')
            ->where('exam_type_id', $exam_type)
            ->where('id', $sid)
            ->first();

        // 2) If not found, try to find session where ugr_id = sid
        if (!$session_info) {
            $session_info = Session::where('ugr_id', $sid)
                ->where('exam_type_id', $exam_type)
                ->first();
        }

        // 3) If still not found, pull from API and create new
        if (!$session_info) {
            $session_info_data = ApiData::getSessionInfo($sid);

            if ($session_info_data && isset($session_info_data['session'])) {
                $session_info = new Session();
                $session_info->ugr_id       = $sid;
                $session_info->session      = $session_info_data['session'];
                $session_info->year         = $session_info_data['year'];
                $session_info->semester     = $session_info_data['semester'];
                $session_info->exam_type_id = $exam_type; // ✅ corrected: use exam_type_id, not string
                $session_info->created_at   = now();
                $session_info->updated_at   = now();
                $session_info->save();

                Log::info('✅ New review session created from API', $session_info->toArray());
            } else {
                Log::warning('⚠️ Session info missing or invalid in API response for sid: ' . $sid);
                return null; // or throw exception
            }
        }

        return $session_info;
    }

}
