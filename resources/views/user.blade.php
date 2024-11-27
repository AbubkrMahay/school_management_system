@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Users</h3>
                        </div>
                        <div class="flex-2">
                            <a href="{{ route('user.create') }}"><button>Add New User</button></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\User::exists())
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @endif
                                @foreach ($useers as $useer)
                                <tr>
                                    @php
                                    $role=$roles->where('id', $user->role_id)->first();
                                    @endphp
                                    <td>{{$useer->id}}</td>
                                    <td>{{$useer->name}}</td>
                                    <td>{{$useer->email}}</td>
                                    <td>
                                    @foreach($useer->roles as $role)
                                    {{ $role->name }}{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                    </td>

                                    <td><a href="{{ route('user.edit', $useer->id) }}">Edit</a></td>
                                    
                                    <td>
                                        <form action="{{ route('user.destroy', $useer->id) }}" method="POST">
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
                </div>
            </div>
        </main>

    </div>
</div>
@endsection