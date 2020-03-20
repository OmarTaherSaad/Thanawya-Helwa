<div class="card text-center h-100 shadow">
    <div class="card-body p-1 p-md-2">
        @can('view',$tag)
        <h5 class="card-title mb-1"><a href="{{ route('tags.show',['tag'=>$tag]) }}">{{$tag->name}}</a></h5>
        @else
        <h5 class="card-title mb-1">{{$tag->name}}</h5>
        @endcan
        @can('update', $tag)
        <a href="{{ $tag->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
        @endcan
        @can('delete', $tag)
        <a href="#deleteModal" data-id="{{ $tag->getLinkToDelete() }}" data-name="{{ $tag->name }}" data-toggle="modal"
            class=" deleteBtn btn btn-danger">Delete</a>
        @endcan
    </div>
</div>
