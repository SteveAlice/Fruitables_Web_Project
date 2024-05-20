@extends('layouts.admin')
@section('title', 'Create New Category')

@section('master')
    @parent
@endsection



@section('content')
    <main>
        <h1 class="m-3">Create New Category</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @isset($notice)
                <div class="alert alert-info" role="alert">
                    {{ $notice }}
                </div>
            @endisset
        <div class="container-fluid py-2">
            <form id="form" method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data">
                @csrf
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" name="name" id="name" class="form-control" />
                            <label class="form-label">Product name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <div class="input-group mb-3">
                                
                                
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Price input  2 col-->

                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="number" id="price" name="price" class="form-control" />
                            <label class="form-label">Price</label>
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="number" id="stock" name="stock" class="form-control" />
                            <label class="form-label">Stock</label>
                        </div>
                    </div>
                </div>


                <!-- Describption input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                    <label class="form-label">Description</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4 col-md-3">
                    <label for="formFileSm" class="form-label">Upload image</label>
                    <input class="form-control form-control-sm" accept="image/*" type="file" name="image"
                        id="image">
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg mb-4" id="addButton">Save</button>
                </div>

            </form>

        </div>
    </main>
    {{-- <script>
        document.getElementById('addButton').addEventListener('click', function(event) {
            // Validate name
            const name = document.getElementById('name').value.trim();
            if (name === '') {
                alert('Product name is required.');
                return;
            }

            // Validate category
            const category = document.getElementById('category').value;
            if (category === '') {
                alert('Category is required.');
                return;
            }

            // Validate price
            const price = document.getElementById('price').value;
            if (price === '' || isNaN(price) || parseFloat(price) <= 0) {
                alert('Valid price is required.');
                return;
            }

            // Validate stock
            const stock = document.getElementById('stock').value;
            if (stock === '' || isNaN(stock) || parseInt(stock) < 0) {
                alert('Valid stock quantity is required.');
                return;
            }

            // Validate description
            const description = document.getElementById('description').value.trim();
            if (description === '') {
                alert('Description is required.');
                return;
            }

            // Validate image
            const image = document.getElementById('image').files[0];
            if (!image) {
                alert('Image is required.');
                return;
            } else if (!image.type.startsWith('image/')) {
                alert('Valid image file is required.');
                return;
            }
        });
    </script> --}}
@endsection
