@php use App\Models\Provider; @endphp

@extends('main')

@section('title', 'Miga de Oro - Providers')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Edit Provider</h2>
        <form action="{{ route('providers.update', $provider->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $provider->name }}" required maxlength="120" minlength="4">
                <label for="nif">NIF</label>
                <input type="text" class="form-control" id="nif" name="nif" value="{{ $provider->nif }}" required pattern="[0-9]{8}[A-Za-z]{1}">
                <label for="telephone">Telephone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ $provider->telephone }}" pattern="[6-9]\d{8}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    @if($errors ->any())
                <div class="alert alert-danger">
                    <ul>@foreach($errors->all( ) as $error)
                            <li>{{ $error }}</li>
                        @endforeach</ul>
            @endif
    </div>
    @endsection
