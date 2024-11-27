<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TeacherController extends Controller
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

        $teachers = Teacher::get();
        return view('teacher', [
            'teachers' => $teachers,
            'user' => $user,
            'rolename' => $roleName
        ]);
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
        return view('createteacher', [
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
        ]);
        //dd($validatedData);
        Teacher::create($validatedData);
        return redirect()->route('teacher.create')
            ->with('success', 'Teacher created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $id)
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('editteacher', [
            'teacher' => $id,
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
        ]);
        $teacher = Teacher::findOrFail($id);
        $teacher->update($validatedData);
        return redirect()->route('teacher.display')
            ->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('teacher.display')
            ->with('success', 'Teacher deleted successfully.');
    }
}
