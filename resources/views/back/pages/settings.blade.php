@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Settings')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.settings')}}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="pd-20 card-box mb-4">
    @livewire('admin-settings')
</div>
@endsection
@push('scripts')
<script>
    $(document).on('change', 'input[type="file"][name="site_logo"]', function(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function() {
            var dataURL = reader.result;
            $('#site_logo_image_preview').attr('src', dataURL);
        };

        reader.readAsDataURL(input.files[0]);
    });
    $(document).on('submit', '#change_site_logo_form', function(e) {
    e.preventDefault();
    var form = this;
    var formdata = new FormData(form);

    $.ajax({
        url: $(form).attr('action'),
        method: $(form).attr('method'),
        data: formdata,
        processData: false,
        contentType: false,
        success: function(response) {
            // Xử lý phản hồi từ máy chủ ở đây
            console.log(response);
            // Hiển thị thông báo hoặc thực hiện các hành động khác
        },
        error: function(xhr, status, error) {
            // Xử lý lỗi nếu có
            console.error(error);
        }
    });
});

    $('#change_site_logo_form').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formdata = new FormData(form);
        var inputFileVal = $(form).find('input[type="file"][name="site_logo"]').val();

        if (inputFileVal.length > 0) {
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: formdata,
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    toastr.remove();
                    $(form).find('span.error-text').text('');
                },
                success: function(response) {
                    if (response.status == 1) {
                        toastr.success(response.msg);
                        $(form)[0].reset();
                    } else {
                        toastr.error(response.msg);
                    }
                }
            });
        } else {
            $(form).find('span.error-text').text('Please select a file image PNG, JPG, JNPG, to upload.');
        }
    });

    $('input[type="file"][name="site_favicon"][id="site_favicon"]').ijaboViewer({
        preview:'#site_favicon_image_preview',
        imageShape:'square',
        allowedExtensions :['png'],
        onErrorShape:function(message, element){
            alert(message);
        },
        onInvalidType:function(message, element){
            alert(message);
        },
        onSuccess:function(message, element){}
    });

    $('#change_site_favicon_form').on('submit', function(e){
        e.preventDefault();
        var form = this;
        var formdata = new FormData();
        var inputFileVal = $(form).find('input[type="file"][name="site_favicon"]').val();

        if( inputFileVal.length > 0 ){
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:formdata,
                processData: false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(form).findI('span.error-text').text('');
                },
                success:function(response){
                    if( response.status == 1){
                        toastr.success(response.msg);
                        $(form)[0].reset();
                    }else{
                        toastr.error(response.msg);
                    }
                }
            });
        }else{
            $(form).find('span.error-text').text('Please, sellect favicon image file.PNG file type is recommended.');
        }
    });
</script>
@endpush
