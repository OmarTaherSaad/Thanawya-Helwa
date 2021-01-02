@extends('layouts.app')
@section('title','تعديل بيانات التنسيق')
@section('head')
@endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-auto">
        <h2>تعديل رقم "{{ $edge->id }}</h2>
        <h4>إنت عملت: {{ $count }} تعديل/تعديلات</h4>
    </div>
</div>
<form action="{{ route('tansik.edges.update',['facultyEdge' => $edge]) }}" method="POST" class="text-left">
    @csrf
    @method('PATCH')
    <div class="row justify-content-center mt-2">
        <div class="col-12 col-md-6 text-center">
            <div class="form-group">
                <label for="name">الاسم</label>
                <input type="text" name="name" readonly class="form-control" value="{{ $edge->TempName }}">
            </div>
            <div class="form-group">
                <label for="faculty">معهد أم كلية؟</label>
                <select class="form-control" name="is_faculty" id="is_faculty" required>
                    <option value="" disabled selected>اختر إجابة</option>
                    <option value="0">معهد</option>
                    <option value="1">كلية</option>
                </select>
            </div>
            <div class="form-group">
              <label for="university">الجامعة</label>
              <select class="form-control" name="university" id="university">
                  <option value="" disabled selected>اختر إجابة</option>
                @foreach ($universities as $id => $u)
                <option value="{{ $id }}">{{ $u }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="faculty">الكلية</label>
              <select class="form-control" name="faculty" id="faculty">
                  <option value="" disabled selected>اختر إجابة</option>
                @foreach ($faculties as $id => $f)
                <option value="{{ $id }}">{{ $f }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="احفظ وهات اللي بعده" />
            </div>
            <a class="btn btn-danger" href="">هات اللي بعده</a>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script type="text/javascript" src="{{ mix('js/forms.js') }}" defer></script>
@endsection
