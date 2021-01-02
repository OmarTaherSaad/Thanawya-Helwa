@extends('layouts.app')
@section('title','Exams | Edit an Exam')
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
        <h2>Edit an Exam</h2>
    </div>
</div>
<form action="{{ route('ministryExam.update',$ministryExam) }}" enctype="multipart/form-data" method="POST" class="text-left" dir="ltr" onsubmit="window.document.body.classList.add('loading');">
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 text-center">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label>Year</label>
                <input type="number" name="year" class="form-control" value="{{ $ministryExam->year }}"
                    required>
            </div>
            <div class="form-group">
                <label>Educational Year</label>
                <select class="form-control" name="educational_year">
                    <option disabled>Select Year</option>
                    <option value="1" @if($ministryExam->educational_year == '1') selected @endif>First</option>
                    <option value="2" @if($ministryExam->educational_year == '2') selected @endif>Second</option>
                    <option value="3" @if($ministryExam->educational_year == '3') selected @endif>Third</option>
                </select>
            </div>
            <div class="form-group">
                <label>Insert Title</label>
                <input type="text" name="title" maxlength="200" class="form-control" value="{{ $ministryExam->title }}"
                    required>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file" accept="application/pdf">
                <label class="custom-file-label" for="file">Choose file (PDF)</label>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <select class="form-control" name="subject">
                    <option selected disabled>Select a subject</option>
                    @foreach ($subjects as $key => $s)
                    <option value="{{ $key }}" @if($key == $ministryExam->subject) selected @endif>{{ $s }}</option>
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
<script type="text/javascript" src="{{ mix('js/forms.js') }}" defer></script>
@endsection
