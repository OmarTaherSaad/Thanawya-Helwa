@component('mail::message')
مرحبًا أستاذ/ة {{ $name }},
لقد استقبلنا رسالتك بنجاح!
وكان محتواها كالآتي:

@component('mail::panel')
{{ $message }}
@endcomponent

سوف نقوم بالرد عليها في أقرب وقت ممكن.
شكرًا لتواصلكم معنا.
<br><br>
{{ config('app.name') }}
@endcomponent