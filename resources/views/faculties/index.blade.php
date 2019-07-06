@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('css/projects.css') }}">
@endsection

@section('title',__('Our Projects'))
@section('content')
    <div class="row">
        @if ($Projects->count() == 0)
        <h2>{{ __('admin.NoElements') }}</h2>
        @endif

        {{-- View for Admins --}}
        @auth
        @foreach ($Projects as $Project)
            <div class="col-12 col-md-4 my-1">
                <div class="card-deck">
                    <div class="card border-secondary">
                    @if ($Project->Images->first() != null)
                    <img class="card-img-top" src="{{ $Project->Images->first()->filename }}">
                    @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $Project->name }}</h5>
                            <div class="row justify-content-center">
                                <div class="col-12">
                                <a href="/projects/{{ $Project->id }}/{{ str_slug($Project->name) }}" class="btn btn-secondary btn-block">{{ __('admin.Open') }}</a>
                                    @auth
                                    <a href="/admin/projects/{{ $Project->id }}/edit" class="btn btn-warning btn-block">{{ __('admin.Edit') }}</a>
                                    <form method='POST' action='/admin/projects/{{ $Project->id }}' class="btn-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-block">{{ __('admin.Delete') }}</button>
                                    </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endauth
    </div>

    {{-- View for Guests --}}
        @guest
                <header class="text-center">
                        <div class="row justify-content-center header">
                            <div class="col-12 col-md-10 px-0 rounded glow-effect">
                            <img src="{{ Storage::url('assets/projectsHeader.jpg') }}" alt="" class="rounded img-fluid w-100">
                            </div>
                            <div class="col-md-8 col-12 mx-auto mt-md-5 mt-1 cover-text justify-content-center">
                                <div id="headerText">
                                    <h3 class="mb-2 text-dark">
                                    @if (App::getLocale() == 'ar')
                                        أكثر من <span class="headerSpan font-weight-bold">1500 مشروعًا</span> في مجالات مختلفة بتحديات تكنولوجية مختلفة
                                    @else
                                        over <span class="headerSpan font-weight-bold">1500 Projects</span> in different areas with different technical challenges
                                    @endif    
                                    </h3>
                                </div>
                            </div>
                        </div>
                </header>

                <section class="text-center bg-gradient">
                    @if (App::getLocale() == 'ar')
                        <h3 class="text-light">اختر عامًا لترى مشروعاته</h3>
                    @else
                        <h3 class="text-light">Choose a year to see its projects</h3>
                    @endif
                    <div class="row justify-content-center header">
                        @foreach ($Projects->pluck('year')->sort()->unique() as $projectYear)
                            <div class="col-3 col-md-2 yearItem font-weight-bold glow">
                                <a href="/projects/{{ $projectYear }}">{{ $projectYear }}</a>
                            </div>
                        @endforeach
                    </div>
                </section>
        @endguest
@endsection
