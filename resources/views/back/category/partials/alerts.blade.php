@if (Session::get('success'))
<div class="alert alert-success">
    <strong><i class="dw dw-checked"></i></strong>
    {!! Session::get('success') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if (Session::get('fail'))
<div class="alert alert-danger">
    <strong><i class="dw dw-checked"></i></strong>
    {!! Session::get('fail') !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
