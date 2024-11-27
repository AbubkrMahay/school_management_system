@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Roles</h3>
                        </div>
                        <div class="flex-2">
                            <a href="{{ route('role.create') }}"><button>Add New Role</button></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Role::exists())
                                <tr>
                                    <th>Role Id</th>
                                    <th>Role Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @endif
                                @foreach ($roles as $role)
                                <tr>
                                    <td>{{$role->id}}</td>
                                    <td>{{$role->name}}</td>
                                    <td><a href="{{ route('role.edit', $role->id)}}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('role.destroy', $role->id)}}" method="POST">
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