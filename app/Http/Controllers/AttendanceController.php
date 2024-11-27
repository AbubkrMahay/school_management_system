<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function main()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        if ($roleName == 'Admin') {
            return view('attendance', [
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
        if ($roleName == 'Teacher') {
            $teacher = $user->teachers->first();
            $lectures = Lecture::with(['subjects'])->where('teacher_id', $teacher->id)->get();
            return view('attendance', [
                'lectures' => $lectures,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
        if ($roleName == 'Student') {
            $student = $user->students->first();
            // dd($student);
            // $lectures = Lecture::with(['subjects'])->where('teacher_id', $teacher->id)->get();
            return view('attendance', [
                // 'lectures' => $lectures,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
    }
    public function index(Request $request)
    {
        //dd($request->all());
        $user = Auth::user();
        $user_id = $user->id;
        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';

        $date = $request->input('date');
        $grade = $request->input('grade');

        $attendanceRecords = Attendance::where('date', $date)
            ->where('grade', $grade)
            ->with('student') // Assuming 'student' relationship exists in the Attendance model
            ->get();
        if ($roleName == 'Admin' || $roleName == 'Teacher') {
            return view('showattendance', [
                'attendanceRecords' => $attendanceRecords,
                'date' => $date,
                'grade' => $grade,
                'user' => $user,
                'rolename' => $roleName
            ]);
        } elseif ($roleName == 'Student') {
            $student = $user->students->first();
            $grade = $student->grade;
            $std_id=$student->id;
            $attendanceRecords = Attendance::where('date', $date)
                ->where('grade', $grade)
                ->where('student_id', $std_id) // Filter for the specific student_id
                ->with('student') // Assuming 'student' relationship exists in the Attendance model
                ->get();
            return view('showattendance', [
                'attendanceRecords' => $attendanceRecords,
                'date' => $date,
                'grade' => $grade,
                'user' => $user,
                'rolename' => $roleName
            ]);
        }
    }
    public function select(Request $request)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        $user = User::find($user_id);
        $teacher = $user->teachers->first();
        $lectures = Lecture::with(['subjects'])->where('teacher_id', $teacher->id)->get();
        return view('selectattendance', [
            'lectures' => $lectures,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function create(Request $request)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $userrole = User::where('id', $user_id)->with('roles')->first();
        $roleName = $userrole->roles->isNotEmpty() ? $userrole->roles->first()->name : 'No role assigned';
        // Retrieve the grade and date from the request
        $grade = $request->input('grade');
        $date = $request->input('date');

        // Fetch students of the specified grade
        $students = Student::where('grade', $grade)->get();

        // Pass the students and date to the next view
        return view('attendancecreate', [
            'students' => $students,
            'date' => $date,
            'user' => $user,
            'rolename' => $roleName
        ]);
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $date = $request->input('date');
        $attendanceData = $request->input('attendance');

        foreach ($attendanceData as $studentId => $data) {
            $status = $data['status'];
            $grade = $data['grade'];

            // Here you can save each student's attendance to the database
            Attendance::create([
                'student_id' => $studentId,
                'date' => $date,
                'status' => $status,
                'grade' => $grade,
            ]);
        }

        return redirect()->route('attendance.display')
            ->with('success', 'Lecture created successfully.');
    }
}
