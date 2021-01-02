@extends('layouts.app')

@section('title','تواصل معنا')

@section('head')
<script>
    if (!navigator.onLine) {
            window.location.href = '/offline';
        }
</script>
    <link rel="stylesheet" href="{{ mix('css/forms.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron text-right">
            <h1 class="display-4">تواصل مع فريق ثانوية حلوة</h1>
            <p class="lead">نتشرف بإستقبال رسائلكم، وسنقوم بالرد عليها في أقرب وقت ممكن.</p>
        </div>
    </div>
</div>
<div class="row justify-content-center mb-5">
    <!--Contact Form START-->
    <div class="col-12 col-xl-8 text-right">
        <form action="{{ route('contact.submit') }}" method="POST" id="ContactForm">
            @csrf
            <div class="row">
                <div class="col-12 my-2">
                    <div class="form-group my-1">
                        <label for="name">الاسم</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-danger' : '' }}" type="text" name="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-6 col-12 my-2">
                    <div class="form-group my-1">
                        <label for="phone">رقم الموبايل</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-danger' : '' }}" type="tel" name="phone" value="{{ old('phone') }}" required pattern="[0-9]{5,}">
                        @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xl-6 col-12 my-2">
                    <div class="form-group my-1">
                        <label for="email">البريد الالكتروني (الايميل)</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-danger' : '' }}" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 my-2">
                    <div class="form-group my-1">
                        <label for="subject">عنوان الرسالة (الموضوع)</label>
                        <input class="form-control {{ $errors->has('subject') ? 'is-danger' : '' }}" type="text" name="subject" value="{{ old('subject') }}" required>
                        @error('subject')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 my-2 justify-content-center">
                    <div class="form-group my-1">
                        <label for="message">الرسالة</label>
                        <textarea class="form-control {{ $errors->has('message') ? 'is-danger' : '' }}" name="message" rows="4" required>{{ old('message') }}</textarea>
                        @error('message')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 justify-content-center">
                    <input class="btn btn-primary" type="submit" value="إرسال">
                </div>
            </div>
        </form>

    </div>
    <!--Contact Form END-->
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="{{ mix('js/forms.js') }}" defer></script>
    <script defer src="https://www.google.com/recaptcha/api.js?render=6LfeSKsUAAAAAKAiHeGSYBkabpC6mh9ZmzbTKSma"></script>
    <script defer>
        window.addEventListener('load',function() {
            //Google reCaptcha
            grecaptcha.ready(function() {
                grecaptcha.execute('6LfeSKsUAAAAAKAiHeGSYBkabpC6mh9ZmzbTKSma', {action: 'contact_form'}).then(function(token) {
                    // add token to form
                    $('#ContactForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
                    $('#ContactForm').prepend('<input type="hidden" name="action" value="contact_form">');
                });
            });
        })
    </script>
@endsection
