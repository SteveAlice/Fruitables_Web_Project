@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="pd-20 card-box mb-30">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="text-dark">Add category</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ route('admin.manage-categories.cat-subcats-list')}}" class="btn btn-primary btn-sm">
                        <i class="ion-arrow-left-b"></i> Back to categories list
                    </a>
                </div>
            </div>
            <hr>
            <form action="{{ route('admin.manage-categories.store-category')}}" method="post" enctype="multipart/form-data" class="mt-3">
                @csrf
                @include('back.category.partials.alerts')
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="category_name">Category name</label>
                            <input type="text" class="form-control" name="category_name" id="category_name"
                            placeholder="Enter Category Name" value="{{ old('category_name') }}">
                            @error('category_name')
                            <span class="text-danger ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="">Category Image</label>
                            <input type="file" class="form-control-file" name="category_image" id="category_image">
                            @error('category_image')
                            <span class="text-danger ml-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">CREATE</button>
            </form>

        </div>
    </div>
</div>
@endsection
