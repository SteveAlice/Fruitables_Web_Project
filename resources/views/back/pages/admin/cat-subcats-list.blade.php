@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Page title here')
@section('content')
@livewire('admin-categories-subcategories-list')
@endsection

@push('scripts')
<!-- <script>
    $('table tbody#sortable_categories').sortable({
        cursor: "move",
        update: function(event, ui) {
            $(this).children().each(function(index) {
                if ($(this).attr("data-ordering") != (index + 1)) {
                    $(this).attr("data-ordering", (index + 1)).addClass("updated");
                }
            });
            var positions = [];
            $(".updated").each(function() {
                positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                $(this).removeClass("updated");
            });
            window.livewire.emit("updateCategoriesOrdering", positions);
        }
    });

    // Thêm xử lý sự kiện bên trong hàm updateCategoriesOrdering
    window.Echo.channel('toastr-channel').listen('updateCategoriesOrdering', (positions) => {
        // Xử lý sự kiện và hiển thị thông báo
        console.log('Updated positions:', positions);
    });

</script> -->

<script>
    $('table tbody#sortable_categories').sortable({ // Dòng này chọn phần tử <tbody> trong bảng có id là sortable_categories và áp dụng plugin jQuery UI Sortable để cho phép sắp xếp các phần tử bên trong nó.
        cursor: "move", // Thiết lập kiểu con trỏ của con chuột khi di chuyển phần tử.
        update: function(event, ui) { //Đây là một hàm callback được gọi khi việc sắp xếp các phần tử đã được hoàn thành.
            $(this).children().each(function(index) { //Duyệt qua từng phần tử con của phần tử <tbody> đang được sắp xếp.
                if ($(this).attr("data-ordering") != (index + 1)) { //Kiểm tra xem vị trí hiện tại của phần tử có khác với vị trí mới không.
                    $(this).attr("data-ordering", (index + 1)).addClass("updated"); //Cập nhật thuộc tính data-ordering của phần tử và thêm lớp updated nếu cần.
                }
            });
            var positions = []; //Khởi tạo một mảng để lưu trữ thông tin vị trí mới của các phần tử được cập nhật.
            $(".updated").each(function() { //Duyệt qua tất cả các phần tử có lớp updated.
                positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]); //Thêm thông tin vị trí của các phần tử vào mảng positions.
                $(this).removeClass("updated"); // Loại bỏ lớp updated khỏi các phần tử đã được xử lý.
            });
            //alert(positions)    //Hiển thị một cửa sổ cảnh báo chứa thông tin vị trí mới của các phần tử
            // window.livewire.emit("updateCategoriesOrdering", positions);
            window.Echo.channel('toastr-channel').listen('updateCategoriesOrdering', (positions) => {
                // Xử lý sự kiện và hiển thị thông báo
                console.log('Updated positions:', positions);
            });

        }
    });
    //     $(document).on('click', '.deleteCategoryBtn', function(e) {
    //     e.preventDefault(); // Ngăn chặn hành vi mặc định của trình duyệt khi nhấn nút

    //     // Lấy giá trị ID của danh mục cần xóa từ thuộc tính data-id của phần tử được nhấp
    //     var category_id = $(this).data('id');

    //     // Hiển thị hộp thoại xác nhận sử dụng window.confirm
    //     var confirmation = confirm("Are you sure you want to delete this category?");

    //     // Xử lý kết quả của hộp thoại xác nhận
    //     if (confirmation) {
    //         // Nếu người dùng xác nhận muốn xóa, thực hiện hành động xóa (ví dụ: chuyển hướng đến trang xóa)
    //         alert('Yes, delete category');
    //         // Thực hiện hành động xóa, ví dụ:
    //         // window.location.href = "/categories/delete/" + category_id;
    //     } else {
    //         // Nếu người dùng không xác nhận muốn xóa, không thực hiện hành động nào
    //         alert('Cancelled');
    //     }
    // });

    //SweetAlert2
    // xử lý việc khi người dùng nhấn vào nút xóa.
    $(document).on('click', '.deleteCategoryBtn', function(e) {
        e.preventDefault(); //Ngăn chặn hành vi mặc định của trình duyệt khi nhấn nút, giúp tránh việc tải lại trang hoặc chuyển hướng tới một URL khác.
        var category_id = $(this).data('id'); //Lấy giá trị của thuộc tính data-id từ phần tử được nhấn, tức là id của danh mục cần xóa

        // Sử dụng thư viện SweetAlert để hiển thị hộp thoại xác nhận
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this category',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Thực hiện hành động xóa
                // alert('Yes, delete category');
                window.livewire.emit('deleteCategory', category_id);
            }
        });
    });
    $('table tbody#sortable_subcategories').sortable({
        cursor: "move",
        update: function(event, ui) {
            $(this).children().each(function(index) {
                if ($(this).attr("data-ordering") != (index + 1)) {
                    $(this).attr("data-ordering", (index + 1)).addClass("updated");
                }
            });
            var postitions = [];
            $(".updated").each(function() {
                postitions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
            });
            window.livewire.emit("updateSubCategoriesOrdering", postitions);
        }
    });
    $('ul#sortable_child_subcategories').sortable({
        cursor: "move",
        update: function(event, ui) {
            $(this).children().each(function(index) {
                if ($(this).attr("data-ordering") != (index + 1)) {
                    $(this).attr("data-ordering", (index + 1)).addClass("updated");
                }
            });
            var postitions = [];
            $(".updated").each(function() {
                postitions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
            });
            window.livewire.emit("updateChildSubCategoriesOrdering", postitions);
        }
    });

    $(document).on('click', '.deleteSubCategoryBtn,.deleteChildSubCategoryBtn', function(e) {
        e.preventDefault();
        var subcategory_id = $(this).data("id");
        var title = $(this).data("title");

        Swal.fire({
            title: 'Are you sure?',
            html: 'You want to delete this <b>' + title + '</b>',
            showCloseButton: true,
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            confirmButtonText: 'Yes, Delete',
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            width: 400, // Chỉnh kích thước của hộp thoại
            icon: 'warning', // Thêm biểu tượng cảnh báo
            customClass: {
                title: 'text-danger', // Tùy chỉnh lớp CSS cho tiêu đề
                content: 'text-dark', // Tùy chỉnh lớp CSS cho nội dung
                confirmButton: 'btn btn-danger', // Tùy chỉnh lớp CSS cho nút xác nhận
                cancelButton: 'btn btn-secondary' // Tùy chỉnh lớp CSS cho nút hủy
            },
            allowOutsideClick: false
        }).then(function(result) {
            if (result.value) {
                // Thực hiện hành động xóa
                // alert('Yes, delete sub category');
                window.livewire.emit('deleteSubCategory', subcategory_id);
            }
        });

    })
</script>

@endpush
