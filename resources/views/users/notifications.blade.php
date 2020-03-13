@extends('layouts.app-members')
@section('content')
<div class="row justify-content-center text-left" dir="ltr">
    <div class="col-md-10">
        <div class="panel-body">
            <legend>
                <h1>My Notifications</h1>
            </legend>

            @if($user->unreadNotifications->isEmpty())
            You have no new notifications.
            @else
            New Notifications
            <ul class="list-group">
                @foreach ($user->unreadNotifications as $notif)
                <li class="list-item">
                    <a href="{{ $notif->data['link'] }}" class="text-primary">
                        {{ $notif->data['text'] }}
                    </a>
                    <span class="badge badge-secondary">{{ $notif->created_at->toDayDateTimeString() }}</span>
                </li>
                @endforeach
            </ul>
            @endif
            <hr>
            @if($user->readNotifications->isEmpty())
            You have no old notifications.
            @else
            <ul class="list-group">
                @foreach ($user->readNotifications as $notif)
                <li class="list-item">
                    <a href="{{ $notif->data['link'] }}" class="text-dark">
                        {{ $notif->data['text'] }}
                    </a>
                    <span class="badge badge-secondary">{{ $notif->created_at->toDayDateTimeString() }}</span>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection

@php
Auth::user()->unreadNotifications->markAsRead();
@endphp
