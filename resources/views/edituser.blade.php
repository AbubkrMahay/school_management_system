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
                            <h3 class="fw-bold fs-4 my-3">Edit User</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">

                            <form action="{{ route('user.update', $userr->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <label for="name">User Name:</label><br>
                                <input type="text" id="name" name="name" value="{{$userr->name}}"><br>

                                <label for="email">Email:</label><br>
                                <input type="email" id="email" name="email" value="{{$userr->email}}"><br>

                                <label for="password">Password:</label><br>
                                <input type="password" id="password" name="password"><br>

                                <label for="password">Confirm Password:</label><br>
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>

                                <label for="role_id">Role:</label><br>
                                <select id="role_id" name="role_id">
                                    <option value="">Select the Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select><br>
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