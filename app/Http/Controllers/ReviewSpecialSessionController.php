<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class ReviewSpecialSessionController extends Controller
{
    // Show the create form
    public function create()
    {
        $examTypes = [
            1 => 'Regular',
            2 => 'Review',
            3 => 'Special',
        ];

        return view('review_special.session_create', compact('examTypes'));
    }

    // Store the form
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'session'      => ['required', 'string', 'max:255'],
                'year'         => ['required', 'string', 'max:255'],
                'semester'     => ['required', 'string', 'max:255'],
                'exam_type_id' => ['required', 'integer', 'in:1,2,3'],
            ]);

            // check if already exists
            $exists = Session::where('session', $validated['session'])
                ->where('year', $validated['year'])
                ->where('semester', $validated['semester'])
                ->where('exam_type_id', $validated['exam_type_id'])
                ->exists();

            if ($exists) {
                $notification = [
                    'message' => 'This Session already exists (session + year + semester + exam type).',
                    'alert-type' => 'error'
                ];
                return redirect()->back()->withInput()->with($notification);
            }

            $validated['ugr_id'] = null;

            Session::create($validated);

            $notification = [
                'message' => 'Session created successfully!',
                'alert-type' => 'success'
            ];

            return redirect()->route('session.add')->with($notification);

        } catch (\Exception $e) {
            $notification = [
                'message' => 'Error Creating Session: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
            return redirect()->back()->withInput()->with($notification);
        }
    }

}
