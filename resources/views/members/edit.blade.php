@extends('layouts.app')
@section('title', 'Members | Edit ' . $member->name)
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
    <div class="row my-1">
        <div class="col-12 col-md-auto">
            <a href="{{ route('members.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Members
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-auto">
            <h2>Edit {{ $member->name }}</h2>
        </div>
    </div>
    <h5>Current Photo</h5>
    <div class="row justify-content-center">
        <div class="col-6">
            @if (is_null($member->getFirstMedia('members/profile-photos')))
                <img src="{{ Storage::url('assets/blank.gif') }}"
                    data-src="{{ $member->getFirstMediaUrl('members/profile-photos') }}" class="lazyload img-fluid"
                    alt="{!! htmlspecialchars($member->name) !!}">
            @else
                {!! $member->getFirstMedia('members/profile-photos')->img('', ['class' => 'img-fluid', 'alt' => htmlspecialchars($member->name)]) !!}
            @endif
        </div>
    </div>

    <form action="{{ route('members.update', ['member' => $member]) }}" method="POST" enctype="multipart/form-data"
        id="createForm" class="text-left" dir="ltr">
        <div class="row justify-content-center mt-2">
            <div class="col-12 col-md-6">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" maxlength="200" class="form-control" value="{{ $member->name }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="title_on_team">Title on team</label>
                    <input type="text" name="title_on_team" maxlength="200" class="form-control"
                        value="{{ $member->title_on_team }}">
                </div>
                <div class="form-group">
                    <label for="title_personal">Personal Title</label>
                    <input type="text" name="title_personal" maxlength="200" class="form-control"
                        value="{{ $member->title_personal }}" required>
                </div>
                @if (auth()->user()->isAdmin())
                    <div class="form-group">
                        <label for="status">Status (comma separated for multi values).</label>
                        <input type="text" name="status" maxlength="200" class="form-control"
                            value="{{ $member->status_csv }}" required>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Associated User Account</label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option selected disabled>Select Account</option>
                            @foreach ($users as $id => $name)
                                <option value="{{ $id }}" @selected($member->user_id == $id)>{{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
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
