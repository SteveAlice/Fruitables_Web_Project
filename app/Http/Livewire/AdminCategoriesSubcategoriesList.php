<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class AdminCategoriesSubcategoriesList extends Component
{
    //Lớp này lắng nghe sự kiện 'updateCategoriesOrdering'.
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory'
    ];
    //Nhận các vị trí mới của các phần tử được sắp xếp và cập nhật cơ sở dữ liệu với các vị trí mới này.
    public function updateCategoriesOrdering($positions){
        foreach($positions as $position){
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id', $index)->update([
                'ordering'=> $newPosition
            ]);

            $this->showToastr('success', 'Categories ordering updated successfully');
        }
    }
    //Xoa category
    public function deleteCategory($category_id){
        $category = Category::findOrFail($category_id);
        $path = 'images/categories/';
        $category_image = $category->category_name;

        //Check if this category has subcategories

        //Delete Category Image
        if(File::exists(public_path($path.$category_image)) ){
            File::delete($path.$category_image);
        }

        //Delete category form DB
        $delete = $category->delete();

        if( $delete ) {
            $this->showToastr('success','Category deleted successfully!');
        }else{
            $this->showToastr('error', 'Something went wrong.');
        }
    }
    public function showToastr($type, $message) {
        return $this->dispatchBrowserEvent('showToastr',[
            'type' => $type,
            'message' => $message
        ]);
    }
    public function render()
    {
        return view('livewire.admin-categories-subcategories-list',[
            'categories' => Category::orderBy('ordering','asc')->get()
        ]);
    }
}
