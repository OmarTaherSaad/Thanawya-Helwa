<div class="card text-center h-100 shadow">
    <div class="card-body p-1 p-md-2">
        <h5 class="card-title mb-1"><a href="{{ route('ministryExam.show',['ministryExam'=>$ministryExam]) }}">{{$ministryExam->title}}</a></h5>
        <h5>المادة: {{$ministryExam->subject_name }}</h5>
        <h6>لعام {{ $ministryExam->year }}</h6>
        <h6>الصف الدراسي: {{ $ministryExam->educational_year }}</h6>
        @can('update', $ministryExam)
        <a href="{{ $ministryExam->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
        @endcan
        @can('delete', $ministryExam)
        <a href="#deleteModal" data-id="{{ $ministryExam->getLinkToDelete() }}" data-name="{{ $ministryExam->title }}" data-toggle="modal"
            class=" deleteBtn btn btn-danger">Delete</a>
        @endcan
    </div>
</div>
