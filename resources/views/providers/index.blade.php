@php use App\Models\Provider; @endphp

@extends('main')

@section('title', 'Miga de Oro - Providers')

@section('content')
    @include('normalhead')
    <div class="container">
        <h2>Our Providers</h2>
        <div class="row">
            <div class="col-md-3">
                <a class="btn btn-primary" href="{{ route('providers.create') }}">Create a Provider</a>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>NIF</th>
                    <th>Telephone</th>
                    <th>Image</th>
                </tr>
                </thead>

                <tbody>
                @foreach($providers as $provider)
                    <tr>
                        @if($provider->id!=1)
                            <td>{{ $provider->name }}</td>
                            <td>{{ $provider->nif }}</td>
                            <td>{{$provider->telephone}}</td>
                            <td><img width="100px" src="{{ $provider->image }}"></td>
                            <td>
                                <button><a class="btn btn-primary" href="{{ route('providers.edit', $provider->id) }}">Edit</a>
                                </button>
                                <form action="{{ route('providers.destroy', $provider->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete
                                    </button>
                                </form>
                                @endif
                            </td>

                    </tr>

                @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                {{ $providers->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
