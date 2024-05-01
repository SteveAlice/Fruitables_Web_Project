<div>

    <div class="row">
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="{{ route('admin.manage-categories.add-category') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            Add Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Category image</th>
                                <th>Category name</th>
                                <th>N. of sub categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($categories as $item)
                            <tr>
                                <td>
                                    <div class="avatar mr-2">
                                        <img src="/images/categories/{{$item->category_image}}" alt="" width="50" height="50">
                                    </div>
                                </td>
                                <td>{{$item->category_name}}</td>
                                <td>-</td>
                                <td class="table-actions">
                                    <a href="#" class="text-primary">
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                    <a href="#" class="text-danger">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4">
                                    <span class="text-danger">No category found!</span>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <div class="pd-20 card-box mb-30">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Sub Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="#" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            Add Sub Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Category name</th>
                                <th>Sub Category name</th>
                                <th>N. of Child Subs.</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>

                                <td>
                                    Vegetables
                                </td>
                                <td>
                                    Cabbage
                                </td>
                                <td>
                                    none
                                </td>
                                <td class="table-actions">
                                    <a href="#" class="text-primary">
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                    <a href="#" class="text-danger">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
