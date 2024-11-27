@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <!-- Page Title -->
    <h1 class="mb-4">Select Relevant fields to Mark Attandence</h1>
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

    <!-- Two-Column Layout -->
    <div class="row">
        <!-- Main Content Column (70%) -->
        <div class="col-md-8">
            <!-- Grade Selection Section -->
            <div class="mb-4">
                @foreach ($grades as $grade)
                <button class="btn btn-primary" onclick="selectGrade('{{ $grade }}')">{{ $grade }}</button>
                @endforeach
            </div>

            <!-- Date Picker and Show Attendance Button -->
            <div class="d-flex flex-column">
                <form action="{{ route('attendance.create') }}" method="GET" id="attendanceForm">
                    @csrf
                    <input type="hidden" name="grade" id="gradeInput">

                    <!-- Date Picker -->
                    <label for="dateInput" class="form-label">Select Date:</label>
                    <input type="date" name="date" id="dateInput" class="form-control mb-3" style="max-width: 300px;" required>

                    <!-- Show Attendance Button -->
                    <button type="submit" class="btn btn-success">Mark Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<!-- JavaScript for Grade Selection -->
<script>
    function selectGrade(grade) {
        document.getElementById('gradeInput').value = grade;
        console.log("Selected grade: " + grade);
        const selectedButton = document.querySelector(`button[onclick="selectGrade('${grade}')"]`);
        if (selectedButton) {
            selectedButton.classList.add('btn-grade');
        }
    }
</script>