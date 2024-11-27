@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                @if(Auth::user()->roles->contains('name', 'Admin'))
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Students</h3>
                        </div>
                        @if(Auth::user()->roles->contains('name', 'Admin'))
                        <div class="flex-2">
                            <a href="{{ route('student.create') }}"><button>Add New Student</button></a>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Student::exists())
                                <tr>
                                    <th>Student Id</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Grade</th>
                                    @if(Auth::user()->roles->contains('name', 'Admin'))
                                    <th></th>
                                    <th></th>
                                    @endif
                                </tr>
                                @endif
                                @foreach ($students as $student)
                                <tr>
                                    <td>{{$student->id}}</td>
                                    <td>{{$student->name}}</td>
                                    <td>{{$student->email}}</td>
                                    <td>{{$student->date_of_birth}}</td>
                                    <td>{{$student->grade}}</td>
                                    @if(Auth::user()->roles->contains('name', 'Admin'))
                                    <td><a href="{{ route('student.edit', $student->id) }}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('student.destroy', $student->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; color: red; border: none;">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table><br>
                        </div>
                    </div>
                </div>
                @elseif(Auth::user()->roles->contains('name', 'Teacher'))
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Your Students</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @if (App\Models\Lecture::exists())
                            @php
                            $allowedGrades = [];
                            @endphp
                            @endif
                            @foreach ($lectures as $lecture)
                            @if (!in_array($lecture->grade, $allowedGrades))
                            @php
                            $allowedGrades[] = $lecture->grade;
                            @endphp
                            @endif
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            @foreach ($allowedGrades as $grade)
                            <h4>Grade: {{ $grade }}</h4>
                            <table style="width: 80%; margin-bottom: 20px;">
                                <tr>
                                    <th>Student Id</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Date of Birth</th>
                                    <th>Grade</th>
                                </tr>

                                @php $gradeStudents = $students->where('grade', $grade); @endphp

                                @foreach ($gradeStudents as $student)
                                <tr>
                                    <td>{{ $student->id }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>{{ $student->date_of_birth }}</td>
                                    <td>{{ $student->grade }}</td>
                                </tr>
                                @endforeach

                                @if ($gradeStudents->isEmpty())
                                <tr>
                                    <td colspan="5">No students in grade {{ $grade }}</td>
                                </tr>
                                @endif
                            </table>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </main>

    </div>
</div>
@endsection