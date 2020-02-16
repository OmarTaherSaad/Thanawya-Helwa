@extends('layouts.app')
@section('title','Members | Add a New Member')
@section('head')
<link rel="stylesheet" href="{{ asset('css/texteditor.css') }}" />
<style>
    .note-toolbar {
        z-index: 1 !important;
    }
</style>
@endsection
@section('content')
<div class="row">
    <div class="col-12 my-2" id="response_alert">
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>Add a New Member</h2>
    </div>
</div>
<form action="{{ route('members.store') }}" method="POST" id="createForm" class="text-left" dir="ltr">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" maxlength="200" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" maxlength="200" class="form-control" value="{{ old('title') }}" required>
            </div>
            <div class="form-group">
                <label for="education">Education</label>
                <input type="text" name="education" maxlength="200" class="form-control" value="{{ old('education') }}" required>
            </div>
            <div class="form-group">
                <label for="status">Status (comma separated for multi values).</label>
                <input type="text" name="status" maxlength="200" class="form-control" value="{{ old('status') }}" required>
            </div>

            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="memberImage" accept="image/*"
                        required>
                    <label class="custom-file-label" for="memberImage">Choose Member Image</label>
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
                <textarea id="textEditor" name="text"></textarea>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add" />
            </div>
        </div>
    </div>
</form>
<div id="result"></div>

@endsection

@section('scripts')
<script src="{{ asset('js/members.js') }}"></script>
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
                window.axios.post("{{ route('members.save_image') }}",data,{
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
                });
            }
        }
    });
    $("#createForm").submit(e => {
        e.preventDefault();
        let data = new FormData(e.target);
        let alerts = "";
        let alertsList = null;
        window.axios.post("{{ route('members.store') }}",data,{
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
                $('#createForm')[0].reset();
                $("#textEditor").summernote('code', '');
                document.getElementById("file-list").innerHTML = '';
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
