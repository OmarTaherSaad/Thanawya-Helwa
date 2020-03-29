@extends('layouts.app')
@section('title','كل الامتحانات')
@section('content')
<div class="container pb-5 mb-5">
    @if(auth()->check() && auth()->user()->isTeamMember())
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-6">
            <a class="btn btn-primary" href="{{ route('ministryExam.create') }}">Add Exam</a>
        </div>
    </div>
    @endif
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-md-6">
            <h1>امتحانات من الوزارة</h1>
        </div>
    </div>
    <div class="row justify-content-center text-center mt-5">
        <div class="col-12 col-6">
            <form class="form-inline" {{ route('ministryExam.index') }} id="filterForm">
                <div class="form-group">
                    <label>قم باختيار المادة</label>
                    <select class="form-control" name="subject" onchange="this.form.submit()">
                        <option selected disabled>اختر المادة</option>
                        @foreach ($subjects as $key => $s)
                        <option value="{{ $key }}" @if($key==Request::get('subject')) selected @endif>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>قم باختيار السنة الدراسية (الصف الثانوي)</label>
                    <select class="form-control" name="educational_year" onchange="this.form.submit()">
                        <option selected disabled>اختر السنة</option>
                        @foreach ($educational_years as $y)
                        <option value="{{ $y }}" @if($y == Request::get('educational_year')) selected @endif>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>قم باختيار سنة الامتحان</label>
                    <select class="form-control" name="year" onchange="this.form.submit()">
                        <option selected disabled>اختر السنة</option>
                        @foreach ($years as $y)
                        <option value="{{ $y }}" @if($y == Request::get('year')) selected @endif>{{ $y }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" onclick="resetFilters();this.form.submit();" class="btn btn-danger m-2">إعادة الضبط</button>
            </form>
        </div>
    </div>
    <div class="row">
        @forelse( $ministryExams as $ministryExam )
        <div class="col-6 col-md-4 my-2">
            @include('containers.ministryExam',$ministryExam)
        </div>
        @empty
        <div class="col-8 p-4">
            <h2>لا توجد امتحانات الآن</h2>
        </div>
        @endforelse
    </div>
    <div class="row justify-content-center">
        <div class="col-auto">
            {!! $ministryExams->links() !!}
        </div>
    </div>
    @auth
    @can('delete', $ministryExams->first())
    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Deleting an exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete <span id="DeleteExamName"></span> ? Note that this action cannot be
                        undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <form id="deleteExam" method="POST">
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
</div>
@endsection

@section('scripts')
<script>
    $(".deleteBtn").on('click',(e) => {
        e.preventDefault;
        $("#deleteExam").attr('action',$(e.target).data('id'));
        $("#DeleteExamName").html($(e.target).data('name'));
    });
    function resetFilters() {
        $("#filterForm select").prop('selectedIndex',0);
    }
</script>
@endsection
