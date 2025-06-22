<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class TeacherController extends Controller
{
    public function AddTeacher(){
        $designations=Designation::all();
        $departments=Department::all();
        return view('teacher.add_teacher',compact('designations','departments'));
    }

    public function StoreTeacher(Request $request)
    {
        Log::info('StoreTeacher called', ['user_id' => auth()->id()]);

        // Validate request
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'phone' => [
                'required',
                'regex:/^(\+8801|8801|01)[0-9]{9}$/',
                Rule::unique('users', 'phone'),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'address' => 'nullable|string|max:500',
            'designation' => 'required|exists:designations,id',
            'department' => 'required|exists:departments,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Create user
        $user = new User();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password= Hash::make('12345678');

        // Handle image
        if ($request->file('photo')) {
            $recive_image = $request->file('photo');
            $name_gen = hexdec(uniqid()) . '.' . $recive_image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($recive_image)->resize(300, 300);

            $path = public_path('upload/user_image/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image->toJpeg()->save($path . $name_gen);
            $user->photo = 'upload/user_image/' . $name_gen;
        }

        $user->save();
        Log::info('User saved', ['user_id' => $user->id]);

        // Create teacher
        $teacher = new Teacher();
        $teacher->teachername = $request->name;
        $teacher->phoneno = $request->phone;
        $teacher->preaddress = $request->address ?? null;
        $teacher->designation_id = $request->designation;
        $teacher->department_id = $request->department;
        $teacher->user_id = $user->id;
        $teacher->photo = $user->photo ?? null;

        $teacher->save();

        Log::info('Teacher saved', ['teacher_id' => $teacher->id]);
        $notifications=array(
            "message"=>'Teacher Added Successfully',
            "alert-type"=>'success'
        );


        return redirect()->route('dashboard')->with($notifications);
    }

    public function AllTeacher(){
        $teachers=Teacher::all();
        return view('teacher.all_teacher',compact('teachers'));
    }

    public function EditTeacher($id){
        $teacher=Teacher::find($id);
        $designations=Designation::all();
        $departments=Department::all();
        return view('teacher.edit_teacher',compact('teacher','designations','departments'));
    }

}
