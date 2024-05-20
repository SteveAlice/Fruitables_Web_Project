@extends('layouts.admin')
@section('title', 'Categories Manager')

@section('master')
    @parent
@endsection



@section('content')
    <main>
        <h1 class="m-3">Categories Manager</h1>
        <div class="container-fluid py-2">
            @if (session('notice'))
                <div class="alert alert-info" role="alert">
                    {{ session('notice') }}
                </div>
            @endif
            <form id="form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col-8">
                        <div data-mdb-input-init class="form-outline d-flex">
                            <label class="form-label col-2">Category name</label>
                            <input type="text" name="name" id="name" class="form-control" />

                        </div>
                    </div>
                    <div class="col-4">
                        <div data-mdb-input-init class="form-outline d-flex">
                            <button type="submit" class="btn btn-success my-0"><i class="fa-solid fa-plus"></i> Add
                                new</button>

                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-bordered border-info align-middle table-responsive">
                <thead class="thead-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Name</th>
                        <th>Number of products</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $item)
                        <tr>
                            <th>{{ $item->id }}</th>
                            <th class="d-none" id="toggle">
                                <form id="form" method="POST" action="{{ route('admin.categories.update', $item->id) }}"
                                    enctype="multipart/form-data">
                                     @csrf @method('PUT')
                                    
                                     <input type="text" name="name" id="name" class="form-control" value="{{ $item->name }}"/>
                                    <button type="submit" class="btn btn-primary btn-block btn-sm mb-4"
                                        id="addButton">Save</button>
                                </form>
                            </th>
                            <td id="toggle2">{{ $item->name }}</td>
                            <td>{{ $item->products->count() }}</td>

                            <td class="d-flex justify-content-center mt-md-4">
                                <button class="btn btn-sm" onclick="editBtn()"><i
                                        class="fa-solid fa-pen-to-square fa-xl text-info me-2"></i></button>

                                <form action="{{ route('admin.categories.destroy', $item->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm"><i class="fa-solid fa-trash fa-xl text-danger"></i></button>
                                </form>

                            </td>
                        </tr>
                    @empty
                    @endforelse


                </tbody>
            </table>
        </div>

    </main>
    <script>
        function editBtn() {
            var x = document.getElementById("toggle");
            var y = document.getElementById("toggle2");
            if (x.classList.contains("d-none")) {
                x.classList.remove("d-none");
                y.classList.add("d-none");
                x.classList.add("d-block");
            } else {
                x.classList.remove("d-block");
                x.classList.add("d-none");
                y.classList.remove("d-none");
            }
        }
    </script>
@endsection
