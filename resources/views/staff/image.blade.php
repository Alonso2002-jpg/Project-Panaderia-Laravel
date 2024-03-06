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
        <h2>Edit Image of Staff</h2>
        <p>ID:{{$staff->id}}</p>
        <p>Name:{{$staff->name}}</p>

        <p><img src="{{ asset('storage/' . $staff->image) }}"></p>
        <form action="{{ route('staff.updateImage', $staff->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="m-md-3">
                <label for="image">Select an Image for the Staff guy/gal</label>
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
