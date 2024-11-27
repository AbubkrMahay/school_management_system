@extends('layouts.app')
@section('content')

<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Mark Attendance Here</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('attendance.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="date" value="{{ $date }}">

                                <table style="width: 80%;">
                                    <tr>
                                        <th>Student Id</th>
                                        <th>Student Name</th>
                                        <th>Grade</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->grade }}</td>
                                        <td>
                                            <!-- Dropdown for Attendance Status -->
                                            <select name="attendance[{{ $student->id }}][status]" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                            </select>
                                            <!-- Hidden input for grade -->
                                            <input type="hidden" name="attendance[{{ $student->id }}][grade]" value="{{ $student->grade }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </table><br>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Submit Attendance</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>

@endsection