@extends('layouts.app-members')
@section('title','All Quizzes')
@section('content')
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        <a class="btn btn-primary" href="{{ route('quiz.create') }}">Add Quiz</a>
    </div>
</div>
<div class="row justify-content-center text-center mt-5">
    <div class="col-12 col-6">
        @if(session()->has('member'))
        <h1>Quizzes from {{ session('member') }}</h1>
        @elseif(session()->has('subject'))
        <h1>Quizzes of &rarr; {{ session('subject') }}</h1>
        @else
        <h1>All Quizzes of TH</h1>
        @endif
    </div>
</div>
<div class="row">
    @foreach( $quizzes as $quiz )
    <div class="col-6 col-md-4 my-2">
        @include('containers.quiz')
    </div>
    @endforeach
</div>
<div class="row justify-content-center">
    <div class="col-auto">
        {!! $quizzes->links() !!}
    </div>
</div>
@auth
@can('delete', $quizzes->first())
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deleting a Quiz</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete <span id="DeleteQuizIdentifier"></span> ? Note that this action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form id="deleteQuiz" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" type="submit">Yes, Delete!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endcan
@endauth
{{-- Deleting Modal --}}
@endsection

@section('scripts')
    <script>
        $(".deleteBtn").on('click',(e) => {
            e.preventDefault;
            $("#deleteQuiz").attr('action',$(e.target).data('id'));
            $("#DeleteQuizIdentifier").html($(e.target).data('identifier'));
        });
    </script>
@endsection
