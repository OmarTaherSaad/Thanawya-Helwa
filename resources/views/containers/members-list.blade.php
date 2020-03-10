@foreach ($members as $member)
<div class="col-6 px-1 col-md-3 mb-4">
    @include('containers.member',$member)
</div>
@endforeach
