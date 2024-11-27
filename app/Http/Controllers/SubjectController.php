<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SubjectController extends Controller
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
        $subjects = Subject::get();
        return view('subject', [
            'subjects' => $subjects,
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
        return view('createsubject', [
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
        ]);
        //dd($validatedData);
        Subject::create($validatedData);
        return redirect()->route('subject.create')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $id)
    {
        $user = Auth::user();

        $user_id = $user->id;
        
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        return view('editsubject', [
            'subject' => $id,
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
        ]);
        $subject = Subject::findOrFail($id);
        $subject->update($validatedData);
        return redirect()->route('subject.display')
            ->with('success', 'Subject Edited successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('subject.display')
            ->with('success', 'Subject deleted successfully.');
    }
}
