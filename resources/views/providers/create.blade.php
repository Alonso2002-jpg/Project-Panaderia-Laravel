@php use App\Models\Provider; @endphp

@extends('main')

@section('title', 'Miga de Oro - Providers')

@section('content')

    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Know about our Providers!</div>
            <div class="masthead-heading text-uppercase">Yum Yum Hello!</div>
        </div>
    </header>

    <div class="container">
        <h2>Create a Provider</h2>
        <form action="{{ route('providers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <label for="nif">NIF</label>
                <input type="text" class="form-control" id="nif" name="nif" required>
                <label for="telephone">Telephone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>

            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
    @endif
