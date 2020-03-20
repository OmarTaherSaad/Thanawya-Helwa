@php
$class = 'bordered border-';

if(isset($quiz->revisor)) {
    $class .= 'success';
}
else if(isset($quiz->maker)) {
    $class .= 'primary';
}
else if(isset($quiz->inserter)) {
    $class .= 'secondary';
} else {
    $class .= 'danger';
}

@endphp
<div class="card text-center h-100 shadow {{ $class }}" style="border-width: 3px;">
    <div class="card-body p-1 p-md-2">
        <h5 class="card-title mb-1"><a href="{{ route('quiz.show',['quiz' => $quiz]) }}">{{ $quiz->identifier }}</a></h5>
        <h4>Subject: {{ $quiz->subjectName }}</h4>
        <h5>{{ $quiz->description }}</h5>
        @if(isset($quiz->maker))
        <hr>
        <h4>Made by: {{ $quiz->maker->name }}</h4>
        @endif
        @if(isset($quiz->revisor))
        <hr>
        <h4>Revised by: {{ $quiz->revisor->name }}</h4>
        @endif
        @if(isset($quiz->inserter))
        <hr>
        <h4>Inserted by: {{ $quiz->inserter->name }}</h4>
        @endif
        @if($quiz->trashed())
        <hr>
        <h6>Deleted at: {{ $quiz->deleted_at->locale('en-US')->diffForHumans() }}</h6>
        @endif
        <h6>Last Updated: {{ $quiz->updated_at->locale('en-US')->diffForHumans() }}</h6>
        @auth
        @if($quiz->trashed())
            @can('restore', $quiz)
            <form action="{{ $quiz->getLinkToRestore() }}" method="POST" onsubmit="return confirm('Are you sure you want to restore this quiz?')">
                @csrf
                <button type="submit" class="btn btn-info">Restore</button>
            </form>
            @endcan
            @can('forceDelete', $quiz)
            <form action="{{ $quiz->getLinkToForceDelete() }}" method="POST"
                onsubmit="return confirm('Are you sure you want to force delete this quiz? this action is irreversible')">
                @csrf
                <button type="submit" class="btn btn-danger">Force Delete</button>
            </form>
            @endcan
        @else
            @can('update', $quiz)
            <a href="{{ $quiz->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
            @endcan
            {{-- @can('revise', $quiz)
            <a href="{{ $quiz->getLinkToRevise() }}" class="btn btn-success">Revise</a>
            @endcan --}}
            @can('delete', $quiz)
            <a href="#deleteModal" data-id="{{ $quiz->getLinkToDelete() }}" data-identifier="{{ $quiz->identifier }}" data-toggle="modal"
                class=" deleteBtn btn btn-danger">Delete</a>
            @endcan
        @endif
        @endauth
    </div>
</div>
