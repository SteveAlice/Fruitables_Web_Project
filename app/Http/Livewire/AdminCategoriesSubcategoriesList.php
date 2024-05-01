<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;

class AdminCategoriesSubcategoriesList extends Component
{
    public function render()
    {
        return view('livewire.admin-categories-subcategories-list',[
            'categories' => Category::orderBy('ordering','asc')->get()
        ]);
    }
}
