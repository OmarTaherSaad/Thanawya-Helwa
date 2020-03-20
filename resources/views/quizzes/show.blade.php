@extends('layouts.app-members')
@section('title',"View Quiz")

@section('content')
    <div class="row my-1">
        <div class="col-12 col-md-auto">
        <a href="{{ route('quiz.index') }}" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Quizzes</a>
        </div>
    </div>
    <section class="bg-gradient" id="quiz-maker-container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-8">
                <h4>Subject: {{ $subject }}</h4>
                <h4>Quiz ID: {{ $quiz->identifier }}</h4>
                <h5>{{ $quiz->description }}</h5>
                @if(isset($quiz->maker))
                <h4>Made by: {{ $quiz->maker->name }}</h4>
                @endif
                @if(isset($quiz->revisor))
                <h4>Revised by: {{ $quiz->revisor->name }}</h4>
                @endif
                @if(isset($quiz->inserter))
                <h4>Inserted by: {{ $quiz->inserter->name }}</h4>
                @endif
                <h4>Last Updated at: {{ $quiz->updated_at->toDayDateTimeString() }}</h4>
                @if(Auth::check() && Auth::user()->isTeamMember())
                <h4>Created at: {{ $quiz->created_at->toDayDateTimeString() }}</h4>
                @if($quiz->trashed())
                <h4>Deleted at: {{ $quiz->deleted_at->toDayDateTimeString() }}</h4>
                @endif
                @endif
            </div>
        </div>
        <div class="row mb-5 pb-5" @if(\Str::contains($quiz->subject,'_AR')) class="text-right" dir="rtl" @endif>
            <div class="col-12 col-md-6 mx-auto">
                <mcq-question v-for="question in questions" :question="question.question" :answers="question.answers"
                :right-answer="question.rightAnswer" :ref="'question'+question.question.id"></mcq-question>
            </div>
            <div class="col-12 text-center">
                <button type="button" class="btn btn-success" @click="submit()">Submit</button>
            </div>
            <div class="col-12 text-center" v-if="total_mark != null">
                <h3>Total Marks: @{{ total_mark }} / {{ $quiz->total_mark }}</h3>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script src="{{ asset('js/quizzes/general.js') }}"></script>
    <script defer>
        window.quizApp.$data.questions = {!! json_encode($questions) !!};
    </script>
@endsection
