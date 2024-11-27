@extends('layouts.app')
@section('content')

<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Here is the Attendance</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                        
                                <table style="width: 80%;">
                                    <tr>
                                        <th>Student Id</th>
                                        <th>Student Name</th>
                                        <th>Grade</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($attendanceRecords as $attendance)
                                    <tr>
                                        <td>{{ $attendance->student->id }}</td>
                                        <td>{{ $attendance->student->name }}</td>
                                        <td>{{ $grade }}</td>
                                        <td>{{ $date}}</td>
                                        <td>{{ $attendance->status }}</td>
                                    </tr>
                                    @endforeach
                                </table><br>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

@endsection