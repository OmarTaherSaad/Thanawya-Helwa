@extends('layouts.app')
@section('title',$quiz->description)

@section('content')
    <div class="row my-1">
        <div class="col-12 col-md-auto">
        <a href="{{ route('quiz.index') }}" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Quizzes</a>
        </div>
        <div class="col-12">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- TH Quizzes Page -->
            <ins class="adsbygoogle"
                style="display:block"
                data-ad-client="ca-pub-8176502663524074"
                data-ad-slot="6689657547"
                data-ad-format="auto"
                data-full-width-responsive="true"></ins>
            <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
        </div>
    </div>
    <section class="bg-gradient" id="quiz-maker-container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-8">
                <h3>{{ $quiz->description }}</h3>
                <h4>Subject: {{ $subject }}</h4>
                <h6>Quiz ID: {{ $quiz->identifier }}</h6>
                @if(isset($quiz->maker))
                <h5>Made by: {{ $quiz->maker->name }}</h5>
                @endif
                @if(isset($quiz->revisor))
                <h5>Revised by: {{ $quiz->revisor->name }}</h5>
                @endif
                @if(isset($quiz->inserter))
                <h5>Inserted by: {{ $quiz->inserter->name }}</h5>
                @endif
                <h5>Last Updated at: {{ $quiz->updated_at->toDayDateTimeString() }}</h5>
                @if(Auth::check() && Auth::user()->isTeamMember())
                <h5>Created at: {{ $quiz->created_at->toDayDateTimeString() }}</h5>
                @if($quiz->trashed())
                <h5>Deleted at: {{ $quiz->deleted_at->toDayDateTimeString() }}</h5>
                @endif
                @endif
            </div>
        </div>
        <div class="row mb-5 pb-5" @if(\Str::contains($quiz->subject,'_AR')) class="text-right" dir="rtl" @else class="text-left" dir="ltr" @endif>
            <div class="col-12 col-md-6 mx-auto">
                <mcq-question v-for="(question,index) in questions" :question="question.question" :answers="question.answers"
                :right-answer="question.rightAnswer" :ref="'question'+index"></mcq-question>
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
    <script src="{{ mix('js/quizzes/general.js') }}"></script>
    <script defer>
        window.quizApp.$data.questions = {!! json_encode($questions) !!};
    </script>
@endsection
