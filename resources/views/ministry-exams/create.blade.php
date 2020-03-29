@extends('layouts.app-members')
@section('title','Exams | Add a New Exam')
@section('head')
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-auto">
        <a href="{{ route('ministryExam.index') }}" class="btn btn-primary">All Exams</a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>Add a New Exam</h2>
    </div>
</div>
<form action="{{ route('ministryExam.store') }}" enctype="multipart/form-data" method="POST" class="text-left" dir="ltr" onsubmit="window.document.body.classList.add('loading');">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 text-center">
            @csrf
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" class="form-control" value="{{ old('year') ?? \Carbon\Carbon::now()->year }}"
                    required>
            </div>
            <div class="form-group">
                <label>Educational Year</label>
                <select class="form-control" name="educational_year">
                    <option disabled>Select Year</option>
                    <option value="1">First</option>
                    <option value="2">Second</option>
                    <option value="3" selected>Third</option>
                </select>
            </div>
            <div class="form-group">
                <label>Insert Title</label>
                <input type="text" name="title" maxlength="200" class="form-control" value="{{ old('title') }}"
                    required>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file" required accept="application/pdf">
                <label class="custom-file-label" for="file">Choose file (PDF)</label>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select class="form-control" name="subject">
                    <option selected disabled>Select a subject</option>
                    @foreach ($subjects as $key => $s)
                    <option value="{{ $key }}" @if($key == old('subject')) selected @endif>{{ $s }}</option>
                    @endforeach
                </select>
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
