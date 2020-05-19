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
        <div class="col-12">
            <form class="form-inline" {{ route('ministryExam.index') }} id="filterForm">
                <div class="form-group">
                    <label>قم باختيار الشعبة</label>
                    <select class="form-control" name="major" onchange="this.form.submit()">
                        <option selected disabled>اختر الشعبة</option>
                        <option value="adby" @if('adby'==Request::get('major')) selected @endif>أدبي</option>
                        <option value="oloom" @if('oloom'==Request::get('major')) selected @endif>علمي علوم</option>
                        <option value="ryada" @if('ryada'==Request::get('major')) selected @endif>علمي رياضة</option>
                    </select>
                </div>
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
        <div class="col-12 table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>العنوان</th>
                        <th>السنة</th>
                        <th>الصف الدراسي</th>
                        @can('update', $ministryExams->first())
                        <th>Edit</th>
                        @endcan
                        @can('delete', $ministryExams->first())
                        <th>Delete</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                        @forelse( $ministryExams as $ministryExam )
                        <tr>
                            <td>
                                <a href="{{ route('ministryExam.show',['ministryExam'=>$ministryExam]) }}">{{ $ministryExam->subject_name }} - {{$ministryExam->title}}</a>
                            </td>
                            <td>{{ $ministryExam->year }}</td>
                            <td>{{ $ministryExam->educational_year }}</td>
                            @can('update', $ministryExam)
                            <td>
                                <a href="{{ $ministryExam->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
                            </td>
                            @endcan
                            @can('delete', $ministryExam)
                            <td>
                                <a href="#deleteModal" data-id="{{ $ministryExam->getLinkToDelete() }}" data-name="{{ $ministryExam->title }}"
                                    data-toggle="modal" class=" deleteBtn btn btn-danger">Delete</a>
                            </td>
                            @endcan
                        </tr>
                        @empty
                        @endforelse
                    </tbody>
            </table>
        </div>
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
