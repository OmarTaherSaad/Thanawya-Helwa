@auth
@if(Auth::user()->isTeamMember())
<script src="{{ asset('js/notifications.js') }}" defer></script>
<script>
    window.userId = {{ auth()->user()->id }};
    //Get Notifications
    window.notifications = {!! json_encode(Auth::user()->latestNotificationsData()) !!};
    window.markReadURL = "{{ route('users.notifications.mark-as-read',['user' => Auth::user()]) }}";
</script>
@endif
@endauth
