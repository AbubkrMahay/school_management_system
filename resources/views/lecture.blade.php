@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            @if(Auth::user()->roles->contains('name', 'Admin'))
                            <h3 class="fw-bold fs-4 my-3">Lectures</h3>
                            @elseif (Auth::user()->roles->contains('name', 'Teacher') || Auth::user()->roles->contains('name', 'Student'))
                            <h3 class="fw-bold fs-4 my-3">Your Lectures</h3>
                            @endif
                        </div>
                        @if(Auth::user()->roles->contains('name', 'Admin'))
                        <div class="flex-2">
                            <a href="{{ route('lecture.create') }}"><button>Add New Lecture</button></a>
                        </div>
                        @endif
                    </div>

                    @if(Auth::user()->roles->contains('name', 'Admin'))
                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                <tr>
                                    <th>Lecture Id</th>
                                    <th>Lecture Name</th>
                                    <th>Grade</th>
                                    <th>Teacher Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
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
                                    <td><a href="{{ route('lecture.edit', $lecture->id)}}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('lecture.destroy', $lecture->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; color: red; border: none;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </table><br>

                            </table>
                        </div>
                    </div>
                    @elseif(Auth::user()->roles->contains('name', 'Teacher'))
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
                    @elseif(Auth::user()->roles->contains('name', 'Student'))
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
                    @endif
                </div>
            </div>
        </main>

    </div>
</div>
@endsection