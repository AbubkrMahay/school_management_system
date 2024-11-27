@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Add New Subject</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('subject.store') }}" method="post">
                                @csrf
                                <label for="name">Subject Name:</label><br>
                                <input type="text" id="name" name="name"><br>
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