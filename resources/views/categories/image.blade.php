@php use App\Models\Category; @endphp

@extends('main')

@section('title', 'Miga de Oro - Categories')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit Image Category</h2>
        <p>ID:{{$category->id}}</p>
        <p>Name:{{$category->name}}</p>
        <p><img  src="{{ asset('storage/' . $category->image) }}"></p>
        <form action="{{ route('categories.updateImage', $category->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="m-md-3">
                <label for="image">Select an Image for the Category</label>
                <input type="file" name="image" required class="form-control">
            <div class="invalid-feedback"> Please select an Image valid</div>
            </div>
            <button type="submit" class="btn btn-primary">Update Image</button>
            @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif
        </form>
            </div>
