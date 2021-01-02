@extends('layouts.app')
@section('title','Make a Quiz')
@section('content')
<div class="container-fluid mb-5 pb-5" id="quiz-maker-container" dir="ltr">
    <div class="row mt-2">
        <div class="col-12 my-2" v-if="alerts !== null">
            <div class="alert fade show" v-bind:class='{ "alert-success": alerts, "alert-danger": !alerts }' role="alert">
                <ul>
                    <li v-if="Array.isArray(alertsList)" v-for="alert in alertsList">
                        <span v-for="miniAlert in alert">@{{ miniAlert }}<br></span>
                    </li>
                    <li v-if="!Array.isArray(alertsList)" v-for="alert in alertsList">@{{ alert }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-6">
            {{-- <a class="btn btn-primary" href="{{ route('posts.create') }}">Quiz Maker</a> --}}
        </div>
    </div>
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-md-6">
            <div class="form-group">
              <label for="type">Question Type</label>
              <select class="form-control" name="type" id="type" v-model="type">
                <option value="MCQ" selected>MCQ (Choose)</option>
              </select>
            </div>
            <div class="form-group" v-if="type != null">
                <label>Question Label</label>
              <input type="text" class="form-control" v-model="question.text" id="" aria-describedby="helpId" placeholder="Question Label">
            </div>
            <div class="form-group" v-if="type != null">
                <label>Question Marks</label>
              <input type="text" pattern="[0-9]+" class="form-control" v-model="question.mark" placeholder="Question Marks">
            </div>
            <ul class="list-group list-group-horizontal" v-if="type == 'MCQ'">
                <li class="list-group-item" v-for="answer in answers" v-html="answer.text"></li>
            </ul>
            <div class="form-group" v-if="type == 'MCQ'">
                <label>Answer Label</label>
              <input type="text" class="form-control" v-model="tempAnswer.text" placeholder="Answer Label">
              <button class="btn btn-secondary my-1" @click="addAnswer()">Add Answer</button>
              <button class="btn btn-warning my-1" @click="deleteAnswer()">Delete Last Answer</button>
              <hr>
            </div>
            <div class="form-group" v-if="type == 'MCQ'">
              <input type="text" pattern="[0-9]+" class="form-control" v-model="tempRightAnswer" placeholder="Right Answer Place (from 1, left to right)">
            </div>
            <button class="btn btn-primary" @click="addQclicked()">Add Question</button>
        </div>

        <div class="col-12 col-md-6" v-if="MCQ.length">
            <div v-for="(question,key) in MCQ">
                <mcq-question  :question="question.question" :answers="question.answers"
                :right-answer="question.rightAnswer" :corrected="true"></mcq-question>
                <button class="btn btn-danger" @click="deleteQuestion(key)">Delete Question</button>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6">
            <div class="form-group">
              <label>Subject</label>
              <select class="form-control" v-model="subject">
                <option selected disabled>Select a subject</option>
                @foreach ($subjects as $key => $s)
                <option value="{{ $key }}">{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label>Quiz Description</label>
              <textarea class="form-control" v-model="desc" rows="3"></textarea>
            </div>

            <div class="form-group m-2">
                <label>Maker</label>
                <select class="form-control" v-model="maker">
                    <option value="0" disabled selected>Select Maker</option>
                    @foreach ($members as $key => $member)
                    <option value="{{ $key }}">{{ $member }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group m-2">
                <label>Maker</label>
                <select class="form-control" v-model="revisor">
                    <option value="0" disabled selected>Select Revisor</option>
                    @foreach ($members as $key => $member)
                    <option value="{{ $key }}">{{ $member }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success" @click="saveQuiz()">Save Quiz</button>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ mix('js/quizzes/quiz-maker.js') }}"></script>
<script defer>
    window.quizApp.$data.saveURL = "{{ route('quiz.store') }}";
</script>
@endsection
