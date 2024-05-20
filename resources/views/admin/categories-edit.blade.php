@extends('layouts.admin')
@section('title', 'Edit Product')

@section('master')
    @parent
@endsection



@section('content')
    <main>
        <h1 class="m-3">Edit Product {{ $product->name }}</h1>
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
            <form id="form" method="POST" action="{{ route('admin.product.update', $product->id) }}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $product->name }}" />
                            <label class="form-label">Product name</label>
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <div class="input-group mb-3">
                                <label class="input-group-text">Category</label>
                                <select class="form-select" id="category" name="category">
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $cat->id == $product->category_id ? 'selected' : '' }}>{{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Price input  2 col-->

                <div class="row mb-4">
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="number" id="price" name="price" class="form-control"
                                value="{{ $product->price }}" />
                            <label class="form-label">Price</label>
                        </div>
                    </div>
                    <div class="col">
                        <div data-mdb-input-init class="form-outline">
                            <input type="number" id="stock" name="stock" class="form-control"
                                value="{{ $product->stock }}" />
                            <label class="form-label">Stock</label>
                        </div>
                    </div>
                </div>


                <!-- Describption input -->
                <div data-mdb-input-init class="form-outline mb-4">
                    <textarea class="form-control" rows="5" id="description" name="description">{{ $product->description }}</textarea>
                    <label class="form-label">Description</label>
                </div>

                <div data-mdb-input-init class="form-outline mb-4 col-md-3">
                    <label for="formFileSm" class="form-label">Upload image</label>
                    <input class="form-control form-control-sm" accept="image/*" type="file" name="image"
                        id="image">
                    <img id="previewImage" src="{{ asset('/img/' . $product->image) }}" class="mw-100">
                </div>

                <!-- Submit button -->
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary btn-block btn-lg mb-4" id="addButton">Save</button>
                </div>

            </form>

        </div>
    </main>
    <script>
        document.getElementById('image').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var previewImage = document.getElementById('previewImage');
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
