@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <!-- Page Title -->
    <h1 class="mb-4">View Attendance</h1>
    @if(Auth::user()->roles->contains('name', 'Teacher'))
    @php
    // Initialize an empty array to store unique grades
    $grades = [];

    // Loop through each lecture and store grades
    foreach ($lectures as $lecture) {
    if (!in_array($lecture->grade, $grades)) {
    $grades[] = $lecture->grade; // Add unique grade to the array
    }
    }
    @endphp
    @endif

    <!-- Two-Column Layout -->
    <div class="row">
        <!-- Main Content Column (70%) -->
        <div class="col-md-8">
            <!-- Grade Selection Section -->
            <div class="mb-4">
                @if(Auth::user()->roles->contains('name', 'Admin'))
                <button onclick="selectGrade('9th')" class="btn btn-primary">9th Grade</button>
                <button onclick="selectGrade('10th')" class="btn btn-primary">10th Grade</button>
                <button onclick="selectGrade('11th')" class="btn btn-primary">11th Grade</button>
                @elseif(Auth::user()->roles->contains('name', 'Teacher'))
                @foreach ($grades as $grade)
                <button class="btn btn-primary" onclick="selectGrade('{{ $grade }}')">{{ $grade }}</button>
                @endforeach
                @endif
            </div>

            <!-- Date Picker and Show Attendance Button -->
            <div class="d-flex flex-column">
                <form action="{{ route('attendance.show') }}" method="GET" id="attendanceForm">
                    @csrf
                    <input type="hidden" name="grade" id="gradeInput">

                    <!-- Date Picker -->
                    <label for="dateInput" class="form-label">Select Date:</label>
                    <input type="date" name="date" id="dateInput" class="form-control mb-3" style="max-width: 300px;" required>

                    <!-- Show Attendance Button -->
                    <button type="submit" class="btn btn-success">Show Attendance</button>
                </form>
            </div>
        </div>

        <!-- Sidebar Column (30%) -->
        <div class="col-md-4">
            <!-- Mark Attendance Button -->
            @if(Auth::user()->roles->contains('name', 'Teacher'))
            <a href="{{route('attendance.select')}}" class="btn btn-warning mt-4">Mark Attendance</a>
            @endif
        </div>
    </div>
</div>
@endsection
<!-- JavaScript for Grade Selection -->
<script>
    function selectGrade(grade) {
        document.getElementById('gradeInput').value = grade;
        const selectedButton = document.querySelector(`button[onclick="selectGrade('${grade}')"]`);
        if (selectedButton) {
            selectedButton.classList.add('btn-grade');
        }
    }
</script>