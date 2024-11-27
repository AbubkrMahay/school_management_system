<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LectureController extends Controller
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
        if ($roleName == 'Admin') {
            $lectures = Lecture::with(['teacher', 'subjects'])->get();
            return view('lecture', [
                'lectures' => $lectures,
                'user' => $user,
                'rolename' => $roleName
            ]);
        } elseif ($roleName == 'Teacher') {
            $user = User::find($user_id);
            $teacher = $user->teachers->first();
            if ($teacher) {
                // Fetch lectures associated with this specific teacher
                $lectures = Lecture::with(['subjects'])->where('teacher_id', $teacher->id)->get();
                //dd($lectures->toArray());
                return view('lecture', [
                    'lectures' => $lectures,
                    'user' => $user,
                    'rolename' => $roleName
                ]);
            }
        } elseif ($roleName == 'Student') {
            $student = $user->students->first();
            $grade = $student->grade;
            $lectures = Lecture::with(['subjects'])->where('grade', $grade)->get();
            //dd($lectures->all());
            return view('lecture', [
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

        $teachers = Teacher::get();
        $subjects = Subject::get();
        return view('createlecture', [
            'teachers' => $teachers,
            'subjects' => $subjects,
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
            'grade' => 'required|max:255',
            'teacher_id' => 'required|exists:teachers,id',
            'teacher_id' => 'required|exists:subjects,id',
        ]);
        //dd($validatedData);
        $lecture = Lecture::create([
            'grade' => $request->input('grade'),
            'teacher_id' => $request->input('teacher_id'),
        ]);
        $lecture->subjects()->attach($request->input('subject_id'));
        return redirect()->route('lecture.create')
            ->with('success', 'Lecture created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecture $lecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $teachers = Teacher::get();
        $subjects = Subject::get();
        return view('editlecture', [
            'lecture' => $id,
            'teachers' => $teachers,
            'subjects' => $subjects,
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
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|max:255',
            'teacher_id' => 'required|exists:teachers,id',
        ]);
        $lecture = Lecture::findOrFail($id);
        $lecture->update([
            'grade' => $validatedData['grade'],
            'teacher_id' => $validatedData['teacher_id'],
        ]);
        $lecture->subjects()->sync([$validatedData['subject_id']]);

        return redirect()->route('lecture.display')
            ->with('success', 'Lecture updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lecture = Lecture::findOrFail($id);
        $lecture->subjects()->detach();
        $lecture->delete();

        return redirect()->route('lecture.display')
            ->with('success', 'Lecture deleted successfully.');
    }
}
