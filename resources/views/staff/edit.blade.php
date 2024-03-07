@php use App\Models\Staff; @endphp

@extends('main')

@section('title', 'Miga de Oro - Staff')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit the Staff</h2>
        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $staff->name }}">
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" value="{{ $staff->dni }}">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $staff->email }}">
                <label for="lastname">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $staff->lastname }}">
                <label for="role">Role</label>
                <input type="text" class="form-control" id="role" name="role" value="{{ $staff->role }}">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>

            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif
        </form>
    </div>
