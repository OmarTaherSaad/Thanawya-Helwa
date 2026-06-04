@extends('layouts.app')
@section('title', 'كل الامتحانات')
@section('content')
    @if (auth()->check() && auth()->user()->isTeamMember())
        <div class="row justify-content-center text-center mt-3">
            <div class="col-12 col-sm-auto">
                <a class="btn btn-primary" href="{{ route('ministryExam.create') }}">Add Exam</a>
            </div>
        </div>
    @endif

    <div class="row justify-content-center text-center mt-4">
        <div class="col-12 col-md-8">
            <h1 class="h2 mb-0">امتحانات من الوزارة</h1>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-12">
            <form action="{{ route('ministryExam.index') }}" method="get" id="filterForm" class="text-end">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label mb-1 d-block" for="filter-major">قم باختيار الشعبة</label>
                        <select class="form-select" id="filter-major" name="major" onchange="this.form.submit()">
                            <option selected disabled>اختر الشعبة</option>
                            <option value="adby" @selected('adby' == Request::get('major'))>أدبي</option>
                            <option value="oloom" @selected('oloom' == Request::get('major'))>علمي علوم</option>
                            <option value="ryada" @selected('ryada' == Request::get('major'))>علمي رياضة</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label mb-1 d-block" for="filter-subject">قم باختيار المادة</label>
                        <select class="form-select" id="filter-subject" name="subject" onchange="this.form.submit()">
                            <option selected disabled>اختر المادة</option>
                            @foreach ($subjects as $key => $s)
                                <option value="{{ $key }}" @selected($key == Request::get('subject'))>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label mb-1 d-block" for="filter-educational-year">قم باختيار السنة الدراسية (الصف الثانوي)</label>
                        <select class="form-select" id="filter-educational-year" name="educational_year" onchange="this.form.submit()">
                            <option selected disabled>اختر السنة</option>
                            @foreach ($educational_years as $y)
                                <option value="{{ $y }}" @selected($y == Request::get('educational_year'))>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label mb-1 d-block" for="filter-year">قم باختيار سنة الامتحان</label>
                        <select class="form-select" id="filter-year" name="year" onchange="this.form.submit()">
                            <option selected disabled>اختر السنة</option>
                            @foreach ($years as $y)
                                <option value="{{ $y }}" @selected($y == Request::get('year'))>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 text-center text-md-end">
                        <button type="button" class="btn btn-danger" onclick="resetFilters(); document.getElementById('filterForm').submit();">إعادة الضبط</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">العنوان</th>
                        <th scope="col">السنة</th>
                        <th scope="col">الصف الدراسي</th>
                        @auth
                            @if (auth()->user()->isTeamMember())
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            @endif
                        @endauth
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ministryExams as $ministryExam)
                        <tr>
                            <td>
                                <a href="{{ route('ministryExam.show', ['ministryExam' => $ministryExam]) }}">{{ $ministryExam->subject_name }}
                                    - {{ $ministryExam->title }}</a>
                            </td>
                            <td>{{ $ministryExam->year }}</td>
                            <td>{{ $ministryExam->educational_year }}</td>
                            @auth
                                @if (auth()->user()->isTeamMember())
                                    <td>
                                        @can('update', $ministryExam)
                                            <a href="{{ $ministryExam->getLinkToEdit() }}" class="btn btn-sm btn-secondary">Edit</a>
                                        @endcan
                                    </td>
                                    <td>
                                        @can('delete', $ministryExam)
                                            <a href="#deleteModal" data-id="{{ $ministryExam->getLinkToDelete() }}"
                                                data-name="{{ $ministryExam->title }}" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" class="deleteBtn btn btn-sm btn-danger">Delete</a>
                                        @endcan
                                    </td>
                                @endif
                            @endauth
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->check() && auth()->user()->isTeamMember() ? 5 : 3 }}" class="text-center text-muted py-4">لا توجد امتحانات مطابقة للفلاتر الحالية.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-center mt-3">
        <div class="col-auto">
            {!! $ministryExams->links() !!}
        </div>
    </div>

    @auth
        @if ($ministryExams->contains(fn ($exam) => auth()->user()->can('delete', $exam)))
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Deleting an exam</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="mb-0">Do you really want to delete <span id="DeleteExamName"></span>? Note that this action cannot be undone.</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <form id="deleteExam" method="POST" class="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-danger" type="submit">Yes, Delete!</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    @endauth
@endsection

@section('scripts')
    <script>
        $(document).on('click', '.deleteBtn', function (e) {
            e.preventDefault();
            const $btn = $(this);
            $('#deleteExam').attr('action', $btn.data('id'));
            $('#DeleteExamName').text($btn.data('name'));
        });

        function resetFilters() {
            $('#filterForm select').prop('selectedIndex', 0);
        }
    </script>
@endsection
