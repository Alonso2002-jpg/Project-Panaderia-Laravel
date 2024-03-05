@php use App\Models\Category; @endphp

@extends('main')

@section('title', 'Miga de Oro - Categories')

@section('content')

    <header class="masthead">
        <div class="container">
            <div class="masthead-subheading">Know about our Categories!</div>
            <div class="masthead-heading text-uppercase">Yum Yummy!</div>
        </div>
    </header>

    <div class="container">
        <h2>Create Category</h2>
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>

            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif