@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Add New Student</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('student.store') }}" method="post">
                                @csrf
                                <label for="name">Student Name:</label><br>
                                <input type="text" id="name" name="name"><br>
                                <label for="email">Student Email:</label><br>
                                <input type="email" id="email" name="email"><br>
                                <label for="dob">Date of Birth:</label><br>
                                <input type="date" id="dob" name="date_of_birth"><br>
                                <label for="grade">Grade:</label><br>
                                <input type="text" id="grade" name="grade">
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