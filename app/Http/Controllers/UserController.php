<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\Student;

class UserController extends Controller
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

        $roles = Role::get();
        $useers = User::with('roles')->get();
        //dd($users->role->name);
        return view('user', [
            'useers' => $useers,
            'user' => $user,
            'rolename' => $roleName,
            'roles' => $roles
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
        $roles = Role::get();
        $teachers = Teacher::get();
        $students = Student::get();
        return view('createuser', [
            'roles' => $roles,
            'teachers' => $teachers,
            'students' => $students,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->name,$request->role_id,$request->email,$request->password);
      // dd($request->all());
        $roleId = $request->input('role_id');
        if ($roleId == 1) {
           // dd("it's a admin");
            $validatedData = $request->validate([
                'admin_name' => 'required|string|max:255',
                'admin_email' => 'required|string|email|max:255|unique:users',
                'admin_password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);
            $hashedPassword = bcrypt($validatedData['admin_password']);
            $useer = User::create([
                'name' => $validatedData['admin_name'],
                'email' => $validatedData['admin_email'],
                'password' => $hashedPassword,
            ]);
            // Attach the role to the user
            $useer->roles()->attach($validatedData['role_id']);
        }
        else if ($roleId == 2){
            $teacher_name = Teacher::where('id', $request->teacher_id)->pluck('name')->first();
            //dd($request->all());
            $validatedData = $request->validate([
                'teacher_email' => 'required|string|email|max:255|unique:users,email',
                'teacher_password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);
            $hashedPassword = bcrypt($validatedData['teacher_password']);
            $useer = User::create([
                'name' => $teacher_name,
                'email' => $validatedData['teacher_email'],
                'password' => $hashedPassword,
            ]);
            $useer->roles()->attach($validatedData['role_id']);
            $useer->teachers()->attach($request->teacher_id);

        }
        else if ($roleId == 3){
            $student_name = Student::where('id', $request->student_id)->pluck('name')->first();
            //dd($request->all());
            $validatedData = $request->validate([
                'student_email' => 'required|string|email|max:255|unique:users,email',
                'student_password' => 'required|string|min:8|confirmed',
                'role_id' => 'required|exists:roles,id',
            ]);
            $hashedPassword = bcrypt($validatedData['student_password']);
            $useer = User::create([
                'name' => $student_name,
                'email' => $validatedData['student_email'],
                'password' => $hashedPassword,
            ]);
            $useer->roles()->attach($validatedData['role_id']);
            $useer->students()->attach($request->student_id);

        }

        return redirect()->route('user.create')
            ->with('success', 'User created successfully.');
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
    public function edit(String $id)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $roles = Role::get();
        $userr = User::with('roles')->findOrFail($id);
        //dd($id);
        return view('edituser', [
            'userr' => $userr,
            'roles' => $roles,
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);
        //dd($validatedData);
        $validatedData['password'] = bcrypt($validatedData['password']);
        $user = User::findOrFail($id);
        $user->update($validatedData);
        $user->roles()->sync([$validatedData['role_id']]);

        return redirect()->route('user.display')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.display')
            ->with('success', 'User deleted successfully.');
    }
}
