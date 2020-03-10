@extends('layouts.app-members')
@section('title','Tags | Add a New Tag')
@section('head')
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>Edit "{{ $tag->name }}" Tag</h2>
    </div>
</div>
<form action="{{ route('tags.update',['tag' => $tag]) }}" method="POST" class="text-left">
    @csrf
    @method('PATCH')
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 text-center">
            <div class="form-group">
                <label for="name">Tag Name</label>
                <input type="text" name="name" maxlength="200" class="form-control" value="{{ $tag->name }}" required>
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
<script type="text/javascript" src="{{ asset('js/forms.js') }}" defer></script>
@endsection
