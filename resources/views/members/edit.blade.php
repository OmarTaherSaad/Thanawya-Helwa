@extends('layouts.app')
@section('title',"Products | Edit ".$product->name)
@section('head')
<link rel="stylesheet" href="{{ asset('css/products.css') }}" />
<link rel="stylesheet" href="{{ asset('css/texteditor.css') }}" />
@endsection
@section('content')
<div class="row">
    <div class="col-12 my-2" id="response_alert">
    </div>
</div>
<div class="row my-1">
    <div class="col-12 col-md-auto">
        <a href="{{ route('products.index') }}" class="btn btn-primary">
            <i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Products
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>Edit {{ $product->name }}</h2>
    </div>
</div>
<h5>Current Photo</h5>
<div class="row justify-content-center">
    <div class="col-6">
        {!! $product->getFirstMedia('products')->img('',['class'=>'img-fluid','alt'=> htmlspecialchars($product->name)]) !!}
    </div>
</div>

<form action="{{ $product->getLinkToEdit() }}" method="POST" id="editForm">
    @csrf
    @method('PATCH')
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" maxlength="200" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="form-group">
                <label for="id">Product ID on "Jan Drozd"</label>
                <input type="number" min="0" name="id" class="form-control" value="{{ $product->id }}" required>
            </div>


            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="productImage" accept="image/*">
                    <label class="custom-file-label" for="productImage">Choose Product Image</label>
                </div>
                <small class="form-text text-muted">It must be a valid image,with square dimensions (width = height) and
                    with maximum size of 10MB.</small>
                <p id="drop-area">
                    <span class="drop-instructions">or drag and drop files here</span>
                    <span class="drop-over">Drop files here!</span>
                </p>
                <ul id="file-list">
                </ul>
            </div>

            <div class="form-group">
                <textarea id="textEditor" name="description">{!! $product->description !!}</textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Edit" />
            </div>
        </div>
    </div>
</form>
<div id="result"></div>

@endsection

@section('scripts')
<script src="{{ asset('js/products.js') }}"></script>
<script src="{{ asset('js/texteditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/forms.js') }}" defer></script>
<script defer>
    $(document).ready(function() {
        $('#textEditor').summernote({
            minHeight: 300
        });
    });
    // onImageUpload callback
    $('#textEditor').summernote({
        callbacks: {
            onImageUpload: function (files) {
                // upload image to server and create imgNode...
                let imgNode = document.createElement('img');
                let data = new FormData();
                data.append('image',files[0])
                window.axios.post("{{ route('products.save_image') }}",data,{
                headers: {
                'Content-Type': 'multipart/form-data'
                }
                }).then(response => {
                    if (response.data.success == undefined) {
                        alert("Sorry, we couldn't insert this image.");
                    } else {
                        imgNode.src = response.data.url;
                        imgNode.classList.add('img-fluid');
                        $('#textEditor').summernote('insertNode', imgNode);
                    }
                }).catch(error => {
                    alert("Sorry, an error occured!");
                    // console.log('error');
                    // console.log(error);
                });
            }
        }
    });
    $("#editForm").submit(e => {
        e.preventDefault();
        let data = new FormData(e.target);
        let alerts = "";
        let alertsList = null;
        window.axios.post("{{ $product->getLinkToUpdate() }}",data,{
            headers: {
            'Content-Type': 'multipart/form-data'
            }
        }).then(response => {
            if (response.data.success == undefined) {
                alerts = '<div class="alert alert-danger"><ul>';
                alertsList = response.data;
            } else {
                alerts = '<div class="alert alert-success"><ul>';
                alertsList = {Done: response.data.message};
            }
        }).catch(error => {
            alertsList = error.errors;
            alerts = '<div class="alert alert-danger"><ul>';
        }).finally(function() {
            $.each(alertsList,function (k,v) {
                    alerts += '<li>'+ v + '</li>';
            });
            alerts += '</ul></di>';
            $( '#response_alert' ).html( alerts );
            window.scrollTo(0,0);
        });
    });
</script>
@endsection
