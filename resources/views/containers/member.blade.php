<div class="card text-center h-100 shadow">
    @if (is_null($member->getFirstMedia('members/profile-photos')))
    <img src="{{ Storage::url('assets/blank.gif') }}" data-src="{{ $member->getFirstMediaUrl('members/profile-photos') }}" class="lazyload card-img-top"
        alt="{!! htmlspecialchars($member->name) !!}">
    @else
    {!! $member->getFirstMedia('members/profile-photos')->img('',['class'=>'card-img-top','alt'=>
    htmlspecialchars($member->name)]) !!}
    @endif
    <div class="card-body p-1 p-md-2">
        <h5 class="card-title mb-1">{{$member->name}}</h5>
        <p class="card-text text-black-50">
            {{ $member->title_on_team }}
            <hr class="my-2">
            <span class="font-italic">{{ $member->title_personal }}</span>
        </p>
        @if ($member->text != '')
            <a href="{{ $member->getLinkToView() }}" class="btn btn-primary">View</a>
        @endif
        @auth
            @can('update', $member)
                <a href="{{ $member->getLinkToEdit() }}" class="btn btn-secondary">Edit</a>
            @endcan
            @can('delete', $member)
                <a href="#deleteModal" data-id="{{ $member->getLinkToDelete() }}" data-name="{{ $member->name }}"
                data-toggle="modal" class=" deleteBtn btn btn-danger">Delete</a>
            @endcan
        @endauth
    </div>
</div>
