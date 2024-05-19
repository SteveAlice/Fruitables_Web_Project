@extends('layouts.admin')
@section('title', 'Product Manager')

@section('master')
    @parent
@endsection



@section('content')
    <main>
        <h1 class="m-3">Product Manager</h1>
        <div class="container-fluid py-2">
            @if (session('notice'))
                <div class="alert alert-info" role="alert">
                    {{ session('notice') }}
                </div>
            @endif

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-success my-2"><a href="{{ route('admin.product.create') }}"><i
                            class="fa-solid fa-plus"></i> Add new</a></button>
            </div>

            <table class="table table-bordered border-info align-middle table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <td>{{ $item->name }}</td>
                            <td><img src="{{ asset('/img/' . $item->image) }}" class="img-thumbnail object-fit-fill"
                                    style="max-width: 120px; max-height: 120px"></td>
                            <td>{{ $item->category->name }}</td>
                            <th>${{ $item->price }}</th>
                            <td class="d-flex justify-content-center mt-md-4">
                                

                                <form action="{{ route('admin.product.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a class="btn btn-sm" href="{{ route('admin.product.edit', $item->id) }}"><i class="fa-solid fa-pen-to-square fa-xl text-info me-2"></i></a>

                                    <button class="btn btn-sm"><i
                                            class="fa-solid fa-trash fa-xl text-danger"></i></button>
                                </form>

                            </td>
                        </tr>
                    @empty
                    @endforelse


                </tbody>
            </table>
        </div>

    </main>
@endsection
