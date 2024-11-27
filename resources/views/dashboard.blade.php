@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main" id="page_content">
        <main class="content px-3">
            <div class="container-fluid">
                @if(Auth::user()->roles->contains('name', 'Admin'))
                <div class="mb-3">
                    <h3 class="fw-bold fs-4 mb-3">Admin Dashboard</h3>
                    <div class="row">
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Total Students
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        {{$students->count()}}
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card  border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Total Teachers
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        {{$teachers->count()}}
                                    </p>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 ">
                            <div class="card border-0">
                                <div class="card-body py-4">
                                    <h5 class="mb-2 fw-bold">
                                        Total Grades
                                    </h5>
                                    <p class="mb-2 fw-bold">
                                        2(9th, 10th)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif (Auth::user()->roles->contains('name', 'Teacher'))
                <div class="mb-3">
                    <div>
                        <h3 class="fw-bold fs-4 mb-3">Welcome {{$user->name}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Lecture::exists())
                                <tr>
                                    <th>Lecture Id</th>
                                    <th>Lecture Name</th>
                                    <th>Grade</th>
                                    <th>Teacher Name</th>
                                </tr>
                                @endif
                                @foreach ($lectures as $lecture)
                                <tr>
                                    <td>{{$lecture->id}}</td>
                                    <td>
                                        @foreach($lecture->subjects as $subject)
                                        {{ $subject->name }}
                                        @if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>{{$lecture->grade}}</td>
                                    <td>{{$lecture->teacher->name}}</td>
                                </tr>
                                @endforeach
                            </table><br>
                        </div>
                    </div>
                </div>
                @elseif (Auth::user()->roles->contains('name', 'Student'))
                <div class="mb-3">
                    <div>
                        <h3 class="fw-bold fs-4 mb-3">Welcome {{$user->name}}</h3>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Lecture::exists())
                                <tr>
                                    <th>Lecture Id</th>
                                    <th>Lecture Name</th>
                                    <th>Grade</th>
                                    <th>Teacher Name</th>
                                </tr>
                                @endif
                                @foreach ($lectures as $lecture)
                                <tr>
                                    <td>{{$lecture->id}}</td>
                                    <td>
                                        @foreach($lecture->subjects as $subject)
                                        {{ $subject->name }}
                                        @if(!$loop->last), @endif
                                        @endforeach
                                    </td>
                                    <td>{{$lecture->grade}}</td>
                                    <td>{{$lecture->teacher->name}}</td>
                                </tr>
                                @endforeach
                            </table><br>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </main>

    </div>
</div>
@endsection