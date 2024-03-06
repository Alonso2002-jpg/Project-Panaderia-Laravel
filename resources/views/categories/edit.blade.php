@php use App\Models\Category; @endphp

@extends('main')

@section('title', 'Miga de Oro - Categories')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit Category</h2>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $category->name }}">
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
