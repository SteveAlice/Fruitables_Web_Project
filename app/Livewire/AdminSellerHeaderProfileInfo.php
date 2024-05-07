<?php

namespace App\Livewire;

use App\Models\Admin;
use App\Models\Seller;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

// component Livewire được sử dụng để hiển thị thông tin về người dùng (admin) và người bán (seller) trên header của giao diện.
class AdminSellerHeaderProfileInfo extends Component
{
    public $admin;
    public $seller;
    public $listeners =[  //component lắng nghe sự kiện có tên là 'updateAdminsSellerHeaderInfo' và khi sự kiện này xảy ra, component sẽ thực hiện $refresh để render lại component.
        'updateAdminsSellerHeaderInfo' => '$refresh'
    ];

    // component kiểm tra xem người dùng đã đăng nhập với vai trò admin hay chưa
    public function mount(){
        if(Auth::guard('admin')->check()){  //Nếu đã đăng nhập, component sẽ lấy thông tin về admin và gán cho biến $admin.
            $this->admin= Admin::findOrFail(auth('admin') -> id());
        }

        if(Auth::guard('seller')->check()){
            $this->seller= Seller::findOrFail(auth('seller') -> id());
        }
    }
    public function render()
    {
        return view('livewire.admin-seller-header-profile-info');
    }
}
