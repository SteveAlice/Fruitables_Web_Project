<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\File;
use Livewire\WithPagination;

class AdminCategoriesSubcategoriesList extends Component
{
    use WithPagination;
    public $categoriesPerPage = 5;
    public $subcategoryPerPage = 3;  // mỗi trang sẽ hiển thị tối đa 3 mục con của danh mục chính

    //Lớp này lắng nghe sự kiện 'updateCategoriesOrdering'.
    protected $listeners = [
        'updateCategoriesOrdering',
        'deleteCategory',
        'updateSubCategoriesOrdering',
        'updateChildSubCategoriesOrdering',
        'deleteSubCategory'
    ];
    //Nhận các vị trí mới của các phần tử được sắp xếp và cập nhật cơ sở dữ liệu với các vị trí mới này.
    public function updateCategoriesOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            Category::where('id', $index)->update([
                'ordering' => $newPosition
            ]);

            $this->showToastr('success', 'Categories ordering updated successfully');
        }
    }

    public function updateSubCategoriesOrdering($positions)
    {
        foreach ($positions as $position) { //lặp qua mỗi phần tử trong mảng $positions. Mỗi phần tử trong mảng này chứa thông tin về vị trí mới của một danh mục con cụ thể.
            $index = $position[0];               // lấy ra chỉ số (index)
            $newPosition = $position[1];        //và vị trí mới (newPosition) từ mỗi phần tử trong mảng $positions.
            SubCategory::where('id', $index)->update([   //câu lệnh update để cập nhật dữ liệu trong bảng dữ liệu của các danh mục con.
                'ordering' => $newPosition
            ]);
            $this->showToastr('success', 'Sub categories ordering have been successfully updated.');
        }
    }
    public function updateChildSubCategoriesOrdering($positions)
    {
        foreach ($positions as $position) {
            $index = $position[0];
            $newPosition = $position[1];
            SubCategory::where('id', $index)->update([
                'ordering' => $newPosition
            ]);
            $this->showToastr('success', 'Child Sub categories ordering have been successfully updated.');
        }
    }

    //Ham xóa một danh mục con (sub category) cụ thể, cùng với tất cả các danh mục con con của nó
    public function deleteSubCategory($subcategory_id)
    {
        $subcategory = SubCategory::findOrFail($subcategory_id);    //findOrFail() để tìm kiếm danh mục con có id tương ứng trong cơ sở dữ liệu.

        //Dùng điều kiện để kiểm tra xem danh mục con này có các danh mục con con hay không.
        if ($subcategory->children->count() > 0) {

            // Nếu có, nghĩa là nó không thể xóa trực tiếp mà cần phải xóa các danh mục con con trước.
            foreach ($subcategory->children as $child) {                  //Nếu danh mục con này có các danh mục con con, vòng lặp foreach được sử dụng để lặp qua từng danh mục con con và xóa chúng một cách tuần tự.
                SubCategory::where('id', $child->id)->delete();
            }

            $subcategory->delete();      //delete() được gọi để xóa nó khỏi cơ sở dữ liệu.
            $this->showToastr('success', 'Sub Category has been successfully deleted.');
        } else {
            //Delete sub category
            $subcategory->delete();
            $this->showToastr('success', 'Sub category has been successfully deleted.');
        }
    }
    //Xoa category
    public function deleteCategory($category_id)
    {
        $category = Category::findOrFail($category_id);
        $path = 'images/categories/';
        $category_image = $category->category_name;

        //Check if this category has subcategories
        if ($category->subcategories->count() > 0) {
            //Check if on of these subcategories has related product(s)

            //Delete sub categories
            foreach ($category->subcategories as $subcategory) {
                $subcategory = SubCategory::findOrFail($subcategory->id);
                $subcategory->delete();
            }
        }
        //Delete Category Image
        if (File::exists(public_path($path . $category_image))) {
            File::delete($path . $category_image);
        }

        //Delete category form DB
        $delete = $category->delete();

        if ($delete) {
            $this->showToastr('success', 'Category deleted successfully!');
        } else {
            $this->showToastr('error', 'Something went wrong.');
        }
    }
    //Phuong thuc hien thi thong ,can co thu vien ijabo
    public function showToastr($type, $message)
    {
        return $this->dispatch('showToastr', [
            'type' => $type,
            'message' => $message
        ]);
    }
    public function render()
    {
        return view('livewire.admin-categories-subcategories-list', [
            'categories' => Category::orderBy('ordering', 'asc')->paginate($this->categoriesPerPage,['*'],'categoriesPage'),
            'subcategories' => SubCategory::where('is_child_of', 0)->orderBy('ordering', 'asc')
            ->paginate($this->subcategoryPerPage,['*'],'subcategoriesPage')
        ]);
    }
}
