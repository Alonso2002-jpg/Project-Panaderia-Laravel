@php use App\Models\Staff; @endphp

@extends('main')

@section('title', 'Miga de Oro - Staff')

@section('content')
    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Know about our Staff!</div>
            <div class="masthead-heading text-uppercase">Hello people!</div>
        </div>
    </header>
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
                </tr>
                </thead>

                <tbody>
                @foreach($personal as $staff)
                    <tr>
                        @if($staff->id!=1)
                            <td><img src="{{ asset('storage/' . $staff->image) }}" style="width: 45px"></td>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->lastname }}</td>
                            <td>{{ $staff->dni }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->role }}</td>
                            <td>
                                <button><a class="btn btn-primary" href="{{ route('staff.edit', $staff->id) }}">Edit</a>
                                </button>
                                <button><a class="btn btn-secondary"
                                           href="{{ route('staff.editImage', $staff->id) }}">EditImage</a>
                                </button>
                                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete
                                    </button>
                                </form>
                                @endif
                            </td>

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
