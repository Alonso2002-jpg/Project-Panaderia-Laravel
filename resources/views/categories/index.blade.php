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
        <h2>Our Categories</h2>
                <div class="row">
                        <div class="col-md-3">
                            <a class="btn btn-primary" href="{{ route('categories.create') }}">Create Category</a>
                        </div>
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($categories as $category)
                            <tr>
                                @if($category->id!=1)
                                <td><img src="{{ asset('storage/' . $category->image) }}" style="width: 45px"></td>
                                    <td>{{ $category->name }}</td>
                                <td><button><a class="btn btn-primary" href="{{ route('categories.edit', $category->id) }}">Edit</a></button>
                                    <button><a class="btn btn-secondary" href="{{ route('categories.editImage', $category->id) }}">EditImage</a></button>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endif
                                </td>

                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-container">
                        {{ $categories->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
@endsection
