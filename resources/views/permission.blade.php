@extends('layouts.app')
@section('content')
<div class="wrapper">
    <div class="main">
        <main class="content px-3 py-4">
            <div class="container-fluid">
                <div class="mb-3">
                    <div class="row" style="width: 82%; margin-bottom: 20px;">
                        <div class="flex-1">
                            <h3 class="fw-bold fs-4 my-3">Permission</h3>
                        </div>
                        <div class="flex-2">
                            <a href="{{ route('permission.create') }}"><button>Add New Permission</button></a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <table style="width: 80%;">
                                @if (App\Models\Permission::exists())
                                <tr>
                                    <th>Permission Id</th>
                                    <th>Permission Name</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                @endif
                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{$permission->id}}</td>
                                    <td>{{$permission->name}}</td>
                                    <td><a href="{{ route('permission.edit', $permission->id)}}">Edit</a></td>
                                    <td>
                                        <form action="{{ route('permission.destroy', $permission->id)}}" method="POST">
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