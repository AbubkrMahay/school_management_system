@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Add New User</h3>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('user.store') }}" method="post">
                                @csrf

                                <!-- Role selection -->
                                <label for="role_id">Role:</label><br>
                                <select id="role_id" name="role_id" onchange="showFields()">
                                    <option value="">Select the Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select><br>

                                <!-- Other Fields for Admin (Hidden Initially) -->
                                <div id="admin_fields" style="display: none; margin-top: 10px;">

                                    <label for="admin_name">Name:</label><br>
                                    <input type="text" id="admin_name" name="admin_name"><br>

                                    <label for="admin_email">Email:</label><br>
                                    <input type="email" id="admin_email" name="admin_email"><br>

                                    <label for="admin_password">Password:</label><br>
                                    <input type="password" id="admin_password" name="admin_password"><br>

                                    <label for="admin_password_confirmation">Confirm Password:</label><br>
                                    <input type="password" id="admin_password_confirmation" name="admin_password_confirmation"><br>
                                </div>

                                <!-- Teacher Field (Hidden Initially) -->
                                <div id="teacher_fields" style="display: none; margin-top: 10px;">
                                    <label for="teacher_id">Select Teacher:</label><br>
                                    <select id="teacher_id" name="teacher_id" onchange="populateTeacherEmail()">
                                        <option value="">Select a Teacher</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" data-email="{{ $teacher->email }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select><br>
                                </div>

                                <!-- Student Field (Hidden Initially) -->
                                <div id="student_fields" style="display: none; margin-top: 10px;">
                                    <label for="student_id">Select Student:</label><br>
                                    <select id="student_id" name="student_id" onchange="populateTeacherEmail()">
                                        <option value="">Select a Student</option>
                                        @foreach($students as $student)
                                        <option value="{{ $student->id }}" data-email="{{ $student->email }}">{{ $student->name }}</option>
                                        @endforeach
                                    </select><br>
                                </div>

                                <!-- Other Fields for Teacher (Hidden Initially) -->
                                <div id="teacher_other_fields" style="display: none; margin-top: 10px;">
                                    <label for="teacher_email">Email:</label><br>
                                    <input type="teacher_email" id="teacher_email" name="teacher_email" readonly><br>

                                    <label for="teacher_password">Password:</label><br>
                                    <input type="teacher_password" id="teacher_password" name="teacher_password"><br>

                                    <label for="teacher_password_confirmation">Confirm Password:</label><br>
                                    <input type="teacher_password" id="teacher_password_confirmation" name="teacher_password_confirmation"><br>
                                </div>

                                <!-- Other Fields for Student (Hidden Initially) -->
                                <div id="student_other_fields" style="display: none; margin-top: 10px;">
                                    <label for="student_email">Email:</label><br>
                                    <input type="student_email" id="student_email" name="student_email" readonly><br>

                                    <label for="student_password">Password:</label><br>
                                    <input type="student_password" id="student_password" name="student_password"><br>

                                    <label for="student_password_confirmation">Confirm Password:</label><br>
                                    <input type="student_password" id="student_password_confirmation" name="student_password_confirmation"><br>
                                </div>

                                <input type="submit" id="submitBtn" value="Submit" disabled>
                            </form>

                            <!-- Display errors if any -->
                            @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- JavaScript to show/hide fields based on role -->
<script>
    function showFields() {
        var roleSelect = document.getElementById('role_id');
        var selectedRole = roleSelect.options[roleSelect.selectedIndex].text.toLowerCase();

        // Hide the teacher fields initially
        document.getElementById('teacher_fields').style.display = 'none';
        document.getElementById('teacher_id').disabled = true;
        document.getElementById('teacher_email').disabled = true;
        document.getElementById('teacher_password').disabled = true;
        document.getElementById('teacher_password_confirmation').disabled = true;
        document.getElementById('admin_name').disabled = true;
        document.getElementById('admin_email').disabled = true;
        document.getElementById('admin_password').disabled = true;
        document.getElementById('admin_password_confirmation').disabled = true;
        document.getElementById('student_id').disabled = true;
        document.getElementById('student_email').disabled = true;
        document.getElementById('student_password').disabled = true;
        document.getElementById('student_password_confirmation').disabled = true;

        // Show relevant fields based on the selected role
        if (selectedRole === 'admin') {
            document.getElementById('admin_name').disabled = false;
            document.getElementById('admin_email').disabled = false;
            document.getElementById('admin_password').disabled = false;
            document.getElementById('admin_password_confirmation').disabled = false;
            document.getElementById('admin_fields').style.display = 'block';
            document.getElementById('submitBtn').disabled = false;
        } else if (selectedRole === 'teacher') {
            document.getElementById('teacher_id').disabled = false;
            document.getElementById('teacher_email').disabled = false;
            document.getElementById('teacher_password').disabled = false;
            document.getElementById('teacher_password_confirmation').disabled = false;
            document.getElementById('teacher_fields').style.display = 'block';
        } else if (selectedRole === 'student') {
            document.getElementById('student_id').disabled = false;
            document.getElementById('student_email').disabled = false;
            document.getElementById('student_password').disabled = false;
            document.getElementById('student_password_confirmation').disabled = false;
            document.getElementById('student_fields').style.display = 'block';
            document.getElementById('submitBtn').disabled = false;
        }
    }

    function populateTeacherEmail() {
        var teacherSelect = document.getElementById('teacher_id');
        var selectedTeacher = teacherSelect.value;
        var studentSelect = document.getElementById('student_id');
        var selectedStudent = studentSelect.value;
        // Show the other fields only when a teacher is selected
        if (selectedTeacher !== '') {
            document.getElementById('teacher_other_fields').style.display = 'block';

            // Assuming you will fetch the teacher's email dynamically, or from the teacher options
            var selectedOption = teacherSelect.options[teacherSelect.selectedIndex];
            var teacher_email = selectedOption.getAttribute('data-email') || ''; // You may set the email in the teacher option
            document.getElementById('teacher_email').value = email || '';
            // Set the email in the email input field
            document.getElementById('teacher_email').value = teacher_email;
            console.log(email);
            document.getElementById('submitBtn').disabled = false;
        } else if (selectedStudent !== '') {
            document.getElementById('student_other_fields').style.display = 'block';

            // Assuming you will fetch the teacher's email dynamically, or from the teacher options
            var selectedOption = studentSelect.options[studentSelect.selectedIndex];
            var email = selectedOption.getAttribute('data-email') || ''; // You may set the email in the teacher option
            document.getElementById('student_email').value = email || '';

            // Set the email in the email input field
            document.getElementById('studentemail').value = email;
            console.log(email);
            document.getElementById('submitBtn').disabled = false;
        } else {
            document.getElementById('teacher_other_fields').style.display = 'none';
        }
    }
</script>
@endsection