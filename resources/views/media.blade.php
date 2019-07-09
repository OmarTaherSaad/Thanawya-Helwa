@extends('layouts.app')

@section('title','الأخبار '.$type[0].' عننا')

@section('head')
<style>
    .card-header button {
        font-size: 1.3em;
        color: #d24536;

        &:hover {
            text-decoration: none;
            color: #6d65ae;
        }

        &:focus {
            text-decoration: none;
        }
    }

    .overlay {
        border-radius: 20px;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        transition: .5s ease;
        background-color: rgba(255, 255, 255, 1);
    }

    .thumbnail {
        border-radius: 20px;
        min-width: 20vh;
        min-height: 20vh;

        &:hover {
            .overlay {
                background-color: rgba(210, 69, 54, 1);
            }

            .thumbnail-text {
                font-size: 150%;
                color: black;
                font-weight: bolder;
            }
        }
    }

    .thumbnail-text {
        position: absolute;
        top: 50%;
        left: 50%;
        width: inherit;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
        font-size: 130%;
        font-weight: bold;
        color: #d24536;
        transition: .4s ease;
    }

    .thumbnail-text:hover {
        text-decoration: none;
    }
</style>
@endsection

@section('content')
    <div class="row justify-content-center" id="Newspaper">
        <div class="col-12 text-center">
            <h2>لقاءات وحوارات فريق ثانوية حلوة {{ $type[0] }}</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        @if($type[1] == 'TV')
        <div class="col-12 col-md-10 m-md-2 m-1 text-center">
            <div class="accordion" id="TV">
                @foreach($Items as $name => $link)
                <div class="card">
                    <div class="card-header" id="TVheading{{ $loop->index }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                data-target="#TVcollapse{{ $loop->index }}" aria-expanded="false"
                                aria-controls="collapse{{ $loop->index }}">
                                {{ $name }}
                            </button>
                        </h5>
                    </div>
            
                    <div id="TVcollapse{{ $loop->index }}" class="collapse" aria-labelledby="TVheading{{ $loop->index }}"
                        data-parent="#TV" i-src="{{ $link }}" index="{{ $loop->index }}">
                        <div class="card-body">
                            <div class="i-loader">
                                <h5 class="loading"></h5>
                                <div class="lds-ellipsis">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                            <div class="embed-responsive embed-responsive-16by9 p-3" id="TV{{ $loop->index }}" hidden>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        @foreach ($Items as $name => $link)
        <div class="col-5 col-md-2 m-md-2 m-1 thumbnail text-center">
            <div class="overlay">
                <a href="{{ $link }}" class="thumbnail-text">{{ $name }}</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
@endsection

@section('scripts')
<script defer>
    //Animate "loading" text
    i = 0;
    text = "جاري إحضار الفيديو";
    setInterval(function() {
    $(".loading").html(text+Array((++i % 4)+1).join("."));
    if (i===10) text = "جاري إحضار الفيديو";
    }, 500);

    $("#TV").on('show.bs.collapse',function(e) {
        const el = $(e.target);
        if (el.has('iframe').length) {
            return;
        }
        var iframe = document.createElement('iframe');
        iframe.onload = function() {
            el.find('.i-loader').hide();
            document.getElementById('TV'+el.attr('index')).removeAttribute('hidden');
        };
        iframe.src = $(e.target).attr('i-src');
        document.getElementById('TV'+$(e.target).attr('index')).appendChild(iframe);
    });
</script>
@endsection