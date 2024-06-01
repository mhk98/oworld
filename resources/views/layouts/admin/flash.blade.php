@if($message = Session::get('success'))
<div class="my-2">
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
</div>
@endif

@if($message = Session::get('error'))
<div class="my-2">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
</div>
@endif

@if($message = Session::get('warning'))
<div class="my-2">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
</div>
@endif

@if($message = Session::get('info'))
<div class="my-2">
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ $message }}
    </div>
</div>
@endif

@if($errors->any())
<div class="my-2">
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Please check the form below for errors
    </div>
</div>
@endif