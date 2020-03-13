<!DOCTYPE html>

<head>
    <title>Pusher Test</title>
</head>

<body>
    <h1>Pusher Test</h1>
    <p>
        Publish an event to channel <code>my-channel</code>
        with event name <code>my-event</code>; it will appear below:
    </p>
    <div id="app">
        <ul>
            <li v-for="message in messages">
                @{{message}}
            </li>
        </ul>
    </div>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script defer>

    </script>
</body>
