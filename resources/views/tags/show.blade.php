@extends('layouts.app-members')
@section('title',$member->name)
@section('head')
<link type="text/css" rel="stylesheet" href="{{ asset('css/enlarge.css') }}">
@endsection

@section('content')
    <div class="row my-1">
        <div class="col-12 col-md-auto">
        <a href="{{ route('members.index') }}" class="btn btn-primary"><i class="fas fa-arrow-alt-circle-left"></i>&nbsp; All Members</a>
        </div>
    </div>
    <section class="bg-gradient">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 content">
                <h2 class="text-center">{{ $member->name }}</h2>
                <h4 class="text-center text-black-50">{{ $member->title }}</h4>
                <h6 class="text-center text-black-50">{{ $member->title_personal }}</h6>
                <div class="row justify-content-center">
                        <div class="col-8 col-md-6 my-1">
                            {!! $member->getFirstMedia('profile-photo')->img('',['class'=>'img-fluid rounded','alt'=>$member->name]) !!}
                        </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <p>
                            {!! $member->text !!}
                        </p>
                    </div>
                </div>
            </div>
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

@section('scripts')
    <script>
        $(function() {
            $('img.enlarge').on('click', function() {
                console.log($(this).attr('srcset'));
                $('.enlargeImageModalSource').attr('src', $(this).attr('src'));
                $('#enlargeImageModal').modal('show');
            });
        });
    </script>
@endsection
