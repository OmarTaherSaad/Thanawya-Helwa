@extends('layouts.app')

@section('title',$Project->name)

@section('head')
<link type="text/css" rel="stylesheet" href="{{ asset('css/pages.css') }}">
<link type="text/css" rel="stylesheet" href="{{ asset('css/enlarge.css') }}">
@endsection

@section('content')
    <div class="row my-1">
        <div class="col-12 col-md-auto">
            <a href="/projects" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-{{ App::getLocale() == 'ar' ? 'right' : 'left' }}"></i>&nbsp; {{ __('admin.AllProjects') }}</a>
        </div>
    </div>

    <h2 class="text-center font-weight-bold">{{ __('Projects of') }} {{ $Project->year }}</h2>
    <section class="bg-gradient">
        <div class="row">
            <!--Titles-->
            <div class="col-12 order-12 order-md-first col-md-3">
                <div class="list-group list-group-flush bg-gradient">
                    @foreach ($Projects as $OneProject)
                    <a href="/projects/{{ $OneProject->year }}/{{ $OneProject->id }}/{{ str_slug($OneProject->name) }}" class="list-group-item list-group-item-action {{ $OneProject == $Project ? 'current' : '' }}">
                            {{ $OneProject->name }}
                    </a>
                        <hr>
                    @endforeach
                </div>
            </div>
            <!--Current Project Description-->
            <div class="col-12 col-md-9 content">
                <h2>{{ $Project->name }}</h2>
                <div class="row justify-content-center">
                    <div class="col align-self-end text-color font-weight-bold">
                        @php
                            setlocale(LC_ALL,App::getLocale().'_'.App::getLocale());
                        @endphp
                        {{ __('Year') }}:<br>{{ $Project->year }}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <p>
                            {!! $Project->description !!}
                        </p>
                    </div>
                </div>
                <div class="row justify-content-center">
                        @foreach ($Project->Images as $image)
                        <div class="col-4 col-md-3 my-1">
                            <img class="img-thumbnail rounded enlarge glow-on-hover" src="{{ $image->filename }}">
                        </div>
                        @endforeach
                </div>
            </div>
            <hr class="d-md-none my-4 mx-auto">
        </div>
    </section>


    <!--Image Enlarge Modal-->
    <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <img src="" class="enlargeImageModalSource" style="width: 100%;">
            </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts_down')
    <script>
        $(function() {
            $('img.enlarge').on('click', function() {
                $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
                $('#enlargeImageModal').modal('show');
            });
        });
    </script>
@endsection