@php use App\Models\Provider; @endphp

@extends('main')

@section('title', 'Miga de Oro - Providers')

@section('content')
    @include('normalhead')

    <div class="container">
        <h2>Create a Provider</h2>
        <form action="{{ route('providers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <label for="nif">NIF</label>
                <input type="text" class="form-control" id="nif" name="nif" required pattern="[0-9]{8}[A-Za-z]{1}">
                <label for="telephone">Telephone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" pattern="[6-9]\d{8}" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
    @endif
