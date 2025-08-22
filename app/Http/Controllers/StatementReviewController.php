<?php

namespace App\Http\Controllers;

use App\Services\ApiData;
use Illuminate\Http\Request;

class StatementReviewController extends Controller
{
    public function reviewSessionShow(){
        $sessions=ApiData::getReviewSessions();
        if($sessions === null) {
            return redirect()->back()->with([
                'message' => 'Session Import Failed',
                'alert-type' => 'error',
            ]);
        }
        return view('statement.session_view.review_session_list',compact('sessions'));
    }
}
