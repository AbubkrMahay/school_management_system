@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Add New Lecture</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('lecture.store') }}" method="post">
                                @csrf
                                <label for="name">Subject Name:</label><br>
                                <select id="subject_id" name="subject_id">
                                    <option value="">Select the subject</option>
                                    @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                    @endforeach
                                </select><br>
                                <label for="grade">Grade:</label><br>
                                <input type="text" id="grade" name="grade"><br>
                                <label for="teacher_id">Associated Teacher:</label><br>
                                <select id="teacher_id" name="teacher_id">
                                    <option value="">Select a teacher</option>
                                    @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select><br>
                                <input type="submit" value="Submit">
                            </form>
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
@endsection