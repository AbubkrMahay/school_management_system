<?php

use App\Models\Student;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttendanceController;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use App\Models\Lecture;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teacher;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth'])->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('student.dashboard')->middleware(['role:Admin,Student,Teacher']);

    Route::get('/students', [StudentController::class, 'index'])->name('student.display')->middleware(['role:Admin,Teacher']);
    Route::get('/create-student', [StudentController::class, 'create'])->name('student.create')->middleware(['role:Admin,Teacher']);
    Route::post('/create-student', [StudentController::class, 'store'])->name('student.store')->middleware(['role:Admin']);
    Route::get('/editstudent/{id}', [StudentController::class, 'edit'])->name('student.edit')->middleware(['role:Admin']);
    Route::put('/editstudent/{id}', [StudentController::class, 'update'])->name('student.update')->middleware(['role:Admin']);
    Route::delete('/studentdelete/{id}', [StudentController::class, 'destroy'])->name('student.destroy')->middleware(['role:Admin']);

    Route::get('/teachers', [TeacherController::class, 'index'])->name('teacher.display')->middleware(['role:Admin']);
    Route::get('/create-teacher', [TeacherController::class, 'create'])->name('teacher.create')->middleware(['role:Admin']);
    Route::post('/create-teacher', [TeacherController::class, 'store'])->name('teacher.store')->middleware(['role:Admin']);
    Route::get('/editteacher/{id}', [TeacherController::class, 'edit'])->name('teacher.edit')->middleware(['role:Admin']);
    Route::put('/editteacher/{id}', [TeacherController::class, 'update'])->name('teacher.update')->middleware(['role:Admin']);
    Route::delete('/teacherdelete/{id}', [TeacherController::class, 'destroy'])->name('teacher.destroy')->middleware(['role:Admin']);

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subject.display')->middleware(['role:Admin,Teacher']);
    Route::get('/create-subject', [SubjectController::class, 'create'])->name('subject.create')->middleware(['role:Admin']);
    Route::post('/create-subject', [SubjectController::class, 'store'])->name('subject.store')->middleware(['role:Admin']);
    Route::get('/editsubject/{id}', [SubjectController::class, 'edit'])->name('subject.edit')->middleware(['role:Admin']);
    Route::put('/editsubject/{id}', [SubjectController::class, 'update'])->name('subject.update')->middleware(['role:Admin']);
    Route::delete('/subjectdelete/{id}', [SubjectController::class, 'destroy'])->name('subject.destroy')->middleware(['role:Admin']);

    Route::get('/lectures', [LectureController::class, 'index'])->name('lecture.display')->middleware(['role:Admin,Teacher,Student']);
    Route::get('/create-lecture', [LectureController::class, 'create'])->name('lecture.create')->middleware(['role:Admin']);
    Route::post('/create-lecture', [LectureController::class, 'store'])->name('lecture.store')->middleware(['role:Admin']);
    Route::get('/editlecture/{id}', [LectureController::class, 'edit'])->name('lecture.edit')->middleware(['role:Admin']);
    Route::put('/editlecture/{id}', [LectureController::class, 'update'])->name('lecture.update')->middleware(['role:Admin']);
    Route::delete('/lecturedelete/{id}', [LectureController::class, 'destroy'])->name('lecture.destroy')->middleware(['role:Admin']);

    Route::get('/roles', [RoleController::class, 'index'])->name('role.display')->middleware(['role:Admin']);
    Route::get('/create-role', [RoleController::class, 'create'])->name('role.create')->middleware(['role:Admin']);
    Route::post('/create-role', [RoleController::class, 'store'])->name('role.store')->middleware(['role:Admin']);
    Route::get('/editrole/{id}', [RoleController::class, 'edit'])->name('role.edit')->middleware(['role:Admin']);
    Route::put('/editrole/{id}', [RoleController::class, 'update'])->name('role.update')->middleware(['role:Admin']);
    Route::delete('/roledelete/{id}', [RoleController::class, 'destroy'])->name('role.destroy')->middleware(['role:Admin']);

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.display')->middleware(['role:Admin']);
    Route::get('/create-permission', [PermissionController::class, 'create'])->name('permission.create')->middleware(['role:Admin']);
    Route::post('/create-permission', [PermissionController::class, 'store'])->name('permission.store')->middleware(['role:Admin']);
    Route::get('/editpermission/{id}', [PermissionController::class, 'edit'])->name('permission.edit')->middleware(['role:Admin']);
    Route::put('/editpermission/{id}', [PermissionController::class, 'update'])->name('permission.update')->middleware(['role:Admin']);
    Route::delete('/permissiondelete/{id}', [PermissionController::class, 'destroy'])->name('permission.destroy')->middleware(['role:Admin']);

    Route::get('/users', [UserController::class, 'index'])->name('user.display')->middleware(['role:Admin']);
    Route::get('/create-user', [UserController::class, 'create'])->name('user.create')->middleware(['role:Admin']);
    Route::post('/create-user', [UserController::class, 'store'])->name('user.store')->middleware(['role:Admin']);
    Route::get('/edituser/{id}', [UserController::class, 'edit'])->name('user.edit')->middleware(['role:Admin']);
    Route::put('/edituser/{id}', [UserController::class, 'update'])->name('user.update')->middleware(['role:Admin']);
    Route::delete('/studentuser/{id}', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['role:Admin']);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/attendance', [AttendanceController::class, 'main'])->name('attendance.display')->middleware(['role:Admin,Teacher,Student']);
    Route::get('/attendanceshow', [AttendanceController::class, 'index'])->name('attendance.show')->middleware(['role:Admin,Teacher,Student']);
    Route::get('/attendanceselect', [AttendanceController::class, 'select'])->name('attendance.select')->middleware(['role:Teacher']);
    Route::get('/attendancecreate', [AttendanceController::class, 'create'])->name('attendance.create')->middleware(['role:Teacher']);
    Route::post('/attendanceupdate', [AttendanceController::class, 'store'])->name('attendance.store')->middleware(['role:Teacher']);
});
