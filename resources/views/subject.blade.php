@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Subjects</h3>
                        </div>
                        @if(Auth::user()->roles->contains('name', 'Admin'))
                        <div class="flex-2">
                            <a href="{{ route('subject.create') }}"><button>Add New Subject</button></a>
                        </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Subject::exists())
                                <tr>
                                    <th>Subject Id</th>
                                    <th>Subject Name</th>
                                    @if(Auth::user()->roles->contains('name', 'Admin'))
                                    <th></th>
                                    <th></th>
                                    @endif
                                </tr>
                                @endif
                                @foreach ($subjects as $subject)
                                <tr>
                                    <td>{{$subject->id}}</td>
                                    <td>{{$subject->name}}</td>
                                    @if(Auth::user()->roles->contains('name', 'Admin'))
                                    <td><a href="{{ route('subject.edit', $subject->id)}}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('subject.destroy', $subject->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: none; color: red; border: none;">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </table><br>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>
@endsection