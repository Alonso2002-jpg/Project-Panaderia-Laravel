@php use App\Models\Staff; @endphp

@extends('main')

@section('title', 'Miga de Oro - Staff')

@section('content')

    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Know about our Staff!</div>
            <div class="masthead-heading text-uppercase">Hello People!</div>
        </div>
    </header>

    <div class="container">
        <h2>Create Staff</h2>
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <label for="dni">DNI</label>
                <input type="text" class="form-control" id="dni" name="dni" required>
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <label for="lastname">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
                <label for="startDate">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
                <label for="endDate">End Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>

            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
    @endif
