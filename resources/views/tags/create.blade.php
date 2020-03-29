@extends('layouts.app')
@section('title','Tags | Add a New Tag')
@section('head')
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-auto">
        <a href="{{ route('tags.index') }}" class="btn btn-primary">All Tags</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>Add a New Tag</h2>
    </div>
</div>
<form action="{{ route('tags.store') }}" method="POST" class="text-left" dir="ltr">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 text-center">
            @csrf
            <div class="form-group">
                <label for="name">Insert Tag Name</label>
                <input type="text" name="name" maxlength="200" class="form-control" value="{{ old('name') }}"
                    required>
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
<script type="text/javascript" src="{{ asset('js/forms.js') }}" defer></script>
@endsection
