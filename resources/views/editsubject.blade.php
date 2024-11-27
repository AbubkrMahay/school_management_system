@extends('layouts.app')
@section('content')
<head>
<link rel="stylesheet" href="/css/style.css">
</head>
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Edit Student</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('subject.update', $subject->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <label for="name">Subject Name:</label><br>
                                <input type="text" id="name" name="name" value="{{$subject->name}}"><br>
                                <input type="submit" value="Update">
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