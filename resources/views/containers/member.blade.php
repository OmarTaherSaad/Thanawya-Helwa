<div class="card text-center">
    @if (is_null($member->getFirstMedia('profile-photo')))
    <img src="{{ $member->getFirstMediaUrl('profile-photo') }}" class="card-img-top" alt="{!! htmlspecialchars($member->name) !!}">
    @else
    {!! $member->getFirstMedia('profile-photo')->img('',['class'=>'card-img-top','alt'=> htmlspecialchars($member->name)]) !!}
    @endif
    <div class="card-body">
        <h5 class="card-title">{{$member->name}}</h5>
        <p class="card-text text-black-50">
            {{ $member->title }}
        </p>
        @if ($member->text != '')
            <a href="{{ $member->getLinkToView() }}" class="btn btn-primary">View</a>
        @endif
        @auth
            @can('update', $member)
                <a href="{{ $member->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
            @endcan
            @can('delete', $member)
                <a href="#deleteModal" data-id="{{ $member->getLinkToDelete() }}" data-name="{{ $member->name }}" data-toggle="modal" class=" deleteBtn btn btn-danger">Delete</a>
            @endcan
        @endauth
    </div>
</div>
