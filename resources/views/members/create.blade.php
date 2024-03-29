@extends('layouts.app')
@section('title','Members | Add a New Member')
@section('head')
<link rel="stylesheet" href="{{ mix('css/texteditor.css') }}" />
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
<form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" id="createForm" class="text-left" dir="ltr">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6">
            @csrf
            <div class="form-group">
                <label for="user_id">Select Member Account (if exist)</label>
                <select name="user_id" class="custom-select">
                    <option disabled selected>Select Account email</option>
                    @foreach ($users as $userId => $userEmail)
                        <option value="{{ $userId }}">{{ $userEmail }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" maxlength="200" class="form-control" value="{{ old('name') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="title_on_team">Title on team</label>
                <input type="text" name="title_on_team" maxlength="200" class="form-control" value="{{ old('title_on_team') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="title_personal">Personal Title</label>
                <input type="text" name="title_personal" maxlength="200" class="form-control" value="{{ old('title_personal') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="status">Status (comma separated for multi values).</label>
                <input type="text" name="status" maxlength="200" class="form-control" value="{{ old('status') }}"
                    required>
            </div>

            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="memberImage" accept="image/*">
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
<script src="{{ mix('js/members.js') }}"></script>
<script type="text/javascript" src="{{ mix('js/forms.js') }}" defer></script>
<script src="{{ asset('texteditor/ckeditor.js') }}"></script>
<script defer>
    CKEDITOR.replace('textEditor', {});
</script>
@endsection
