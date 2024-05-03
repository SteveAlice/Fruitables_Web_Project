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
                        <tbody class="table-border-bottom-0" id="sortable_categories">
                            @forelse ($categories as $item)
                            <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                                <td>
                                    <div class="avatar mr-2">
                                        <img src="/images/categories/{{$item->category_image}}" alt="" width="50" height="50">
                                    </div>
                                </td>
                                <td>{{$item->category_name}}</td>
                                <td>
                                    {{ isset($item->subcategories) ? $item->subcategories->count() : 0 }}

                                </td>
                                <td class="table-actions">
                                    <a href="{{ route('admin.manage-categories.edit-category',['id'=>$item->id])}}" class="text-primary">
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                    <a href="javascript:;" class="text-danger deleteCategoryBtn" data-id="{{
                                    $item->id }}">
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
                        <a href="{{ route('admin.manage-categories.add-subcategory')}}" class="btn btn-primary btn-sm">
                            <i class="fa fa-plus"></i>
                            Add Sub Category
                        </a>
                    </div>
                </div>
                <div class="table-responsive mt-4">
                    <table class="table table-borderless table-striped">
                        <thead class="bg-secondary text-white">
                            <tr>
                                <th>Sub Category name</th>
                                <th>Category name</th>
                                <th>Child Subs Categories</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="sortable_subcategories">
                            @forelse ($subcategories as $item)
                            <tr data-index="{{$item->id}}" data-ordering="{{ $item->ordering}}">

                                <td>
                                    {{ $item->subcategory_name}}
                                </td>
                                <td>
                                    {{ $item->parentcategory->category_name}}
                                </td>
                                <td>
                                    @if ($item->children->count() > 0)
                                    <ul class="list-group" id="sortable_child_subcategories">
                                        @foreach ($item->children as $child)
                                        <li data-index="{{ $child->id }}" data-ordering="{{ $child->ordering }}"
                                        class="d-flex justify-content-between align-item-center">
                                            - {{ $child->subcategory_name }}
                                            <div class="">
                                                <a href="{{route('admin.manage-categories.edit-subcategory',[ 'id'=>$child->id ]) }}"
                                                class="text-primary" data-toggle="tooltip" title="Edit child sub category">Edit</a>
                                                |
                                                <a href="javascript:;" class="text-danger deleteChildSubCategoryBtn" data-toggle="tooltip"
                                                title="Delete child sub category" data-id="{{$child->id}}" data-title="Child Sub Category">Delete</a>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @else
                                    none
                                    @endif
                                </td>
                                <td class="table-actions">
                                    <a href="{{route('admin.manage-categories.edit-subcategory',[ 'id'=>$item->id ]) }}" class="text-primary">
                                        <i class="dw dw-edit2"></i>
                                    </a>
                                    <a href="javascript:;" class="text-danger deleteSubCategoryBtn" data-id="{{ $item->id }}"
                                    data-title="Sub Category">
                                        <i class="dw dw-delete-3"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td>
                                    <span class="text-danger">No Sub category found!</span>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>
