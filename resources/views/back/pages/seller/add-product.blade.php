@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>New Product</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{route('seller.home')}}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        New product
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{route('seller.product.all-products')}}" class="btn btn-primary">View all products</a>
        </div>
    </div>
</div>
<form action="{{ route('seller.product.create-product') }}" method="post" enctype="multipart/form-data" id="addProductForm">
    @csrf
    <div class="row pd-10">
        <div class="col-md-8 mb-20">
            <div class="card-box height-100-p pd-20" style="position: relative;">
                <div class="form-group">
                    <label for=""><b>Product name:</b></label>
                    <input type="text" class="form-control" name="name" placeholder="Enter product name">
                    <span class="text-danger error-text name_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>Product summary:</b></label>
                    <textarea id="summary" class="form-control" cols="30" rows="10"></textarea>
                    <span class="text-danger error-text summary_error"></span>
                </div>
                <div class="form-group">
                    <label for=""><b>Product image:</b><small> Must be square and maximum dimension of (1080x1080)</small></label>
                    <input type="file" class="form-control" name="product_image">
                    <span class="text-danger error-text product_image_error"></span>
                </div>
                <div class="d-block mb-3" style="max-width: 250px;">
                    <img src="" class="img-thumbnail " id="image-preview" data-ijabo-default-img="">
                </div>
                <b>NB:</b><small class="text-danger"> You will be able to add more images related to this product when you are on edit product page.</small>
            </div>
        </div>
        <div class="col-md-4 mb-20">
            <div class="card-box min-height-200px pd-20 mb-20">
                <div class="form-group">
                    <label for=""><b>Category:</b></label>
                    <select name="category" id="category" class="form-control">
                        <option value="" selected>Not set</option>
                        <option value="1">Cat 1</option>
                        <option value="2">Cat 2</option>
                        <option value="2">Cat n</option>
                    </select>
                    <span class="text-danger error-text category_error"></span>
                </div>

                <div class="form-group">
                    <label for=""><b>Sub Category:</b></label>
                    <select name="subcategory" id="subcategory" class="form-control">
                        <option value="" selected>Not set</option>
                        <option value="1">Sub Cat 1</option>
                        <option value="2">Sub Cat 2</option>
                        <option value="2">Sub Cat n</option>
                    </select>
                    <span class="text-danger error-text subcategory_error"></span>
                </div>
            </div>
            <div class="card-box min-height-200px pd-20 mb-20">
                <div class="from-group">
                    <label for=""><b>Price:</b><small>In VND Currency (VND)</small></label>
                    <input type="text" name="price" class="form-control" placeholder="Eg: 20.000">
                    <span class="text-danger error-text price_error"></span>
                </div>
                <div class="from-group">
                    <label for=""><b>Compare Price:</b><small>Optional</small></label>
                    <input type="text" name="compare_price" class="form-control" placeholder="Eg: 50.000">
                    <span class="text-danger error-text compare_price_error"></span>
                </div>
            </div>
            <div class="card-box min-height-120px pd-20 ">
                <div class="from-group">
                    <label for=""><b>Visibility:</b></label>
                    <select name="visibility" id="" class="form-control">
                        <option value="1" selected>Public</option>
                        <option value="0">Private</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Create Product</button>
    </div>
</form>


@endsection
