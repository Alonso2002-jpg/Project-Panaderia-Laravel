@php use App\Models\Staff; @endphp

@extends('main')

@section('title', 'Miga de Oro - Staff')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Our Staff</h2>
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-primary" href="{{ route('staff.create') }}">Add Staff</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Lastname</th>
                    <th>Dni</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>State</th>
                </tr>
                </thead>

                <tbody>
                @foreach($personal as $staff)
                    <tr>
                        @if($staff->id!=1)
                            <td> @if($staff->image != staff::$IMAGE_DEFAULT)
                                    <img  src="{{ asset('storage/' . $staff->image) }}" alt="{{ $staff->name }}"  style="width: 90px"/>
                                @else
                                    <img  src="{{ staff::$IMAGE_DEFAULT}}" alt="{{ $staff->name }}"  style="width: 90px"/>
                                @endif</td>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->lastname }}</td>
                            <td>{{ $staff->dni }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->role }}</td>
                            <td>{{ $staff->isDelete  ? 'deleted' : 'Active'}}</td>
                            <td>
                                <button><a class="btn btn-primary" href="{{ route('staff.edit', $staff->id) }}">Edit</a></button>
                                <button><a class="btn btn-secondary" href="{{ route('staff.editImage', $staff->id) }}">EditImage</a></button>

                                @if($staff->isDelete)
                                    <form action="{{ route('staff.recover', $staff->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Recover</button>
                                    </form>
                                @else
                                    <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $personal->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
