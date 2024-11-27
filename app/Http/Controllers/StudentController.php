<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lecture;

class StudentController extends Controller
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
        $students = Student::get();
        if ($roleName == 'Admin') {
            return view('student', [
                'students' => $students,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
        if ($roleName == 'Teacher') {
            $user = User::find($user_id);
            $teacher = $user->teachers->first();
            $lectures = Lecture::with(['subjects'])->where('teacher_id', $teacher->id)->get();
            //dd($lectures);
            return view('student', [
                'students' => $students,
                'lectures' => $lectures,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('createstudent', [
            'user' => $user,
            'rolename' => $roleName
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'date_of_birth' => 'required|date',
            'grade' => 'required|max:255',
        ]);
        //dd($validatedData);
        Student::create($validatedData);
        return redirect()->route('student.create')
            ->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('editstudent', [
            'student' => $id,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email',
            'date_of_birth' => 'required|date',
            'grade' => 'required|max:255',
        ]);
        $student = Student::findOrFail($id);
        $student->update($validatedData);

        return redirect()->route('student.display')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('student.display')
            ->with('success', 'Student deleted successfully.');
    }
}
