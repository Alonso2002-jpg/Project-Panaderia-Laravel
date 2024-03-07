@php use App\Models\Staff; @endphp

@extends('main')

@section('title', 'Miga de Oro - Staff')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit Image of Staff</h2>
        <p>ID:{{$staff->id}}</p>
        <p>Name:{{$staff->name}}</p>

        <p>@if($staff->image != staff::$IMAGE_DEFAULT)
                <img  src="{{ asset('storage/' . $staff->image) }}" alt="{{ $staff->name }}"  style="width: 250px"/>
            @else
                <img  src="{{ staff::$IMAGE_DEFAULT}}" alt="{{ $staff->name }}"  style="width: 250px"/>
            @endif</p>
        <form action="{{ route('staff.updateImage', $staff->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="m-md-3">
                <label for="image">Select an Image for the Staff</label>
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
