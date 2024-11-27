<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        //dd($roleName);
        $students = Student::get();
        $teachers = Teacher::get();
        //dd($roleName);
        if ($roleName == 'Admin') {
            return view('dashboard', [
                'students' => $students,
                'teachers' => $teachers,
                'user' => $user,
                'rolename' => $roleName
            ]); 
        }
        elseif ($roleName == 'Teacher') {
            $user = User::find($user_id);
            $teacher = $user->teachers->first();
            if ($teacher) {
                // Fetch lectures associated with this specific teacher
                $lectures = Lecture::with(['subjects'])->where('teacher_id', 2)->get();
                //dd($lectures->toArray());
                return view('dashboard', [
                    'lectures' => $lectures,
                    'user' => $user,
                    'rolename' => $roleName
                ]);
            }
        }
        elseif ($roleName == 'Student') {
            $student = $user->students->first();
            $grade = $student->grade;
            $lectures = Lecture::with(['subjects'])->where('grade', $grade)->get();
            return view('dashboard', [
                'lectures' => $lectures,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
