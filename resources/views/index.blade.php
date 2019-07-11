@extends('layouts.app')

@section('title','الرئيسية')

@section('head')
<style>
	main {
		margin-bottom: 9vh !important;
	}
	.overlay {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 0;
		right: 0;
		height: 100%;
		width: 100%;
		transition: 0.5s ease;
		background-color: rgba(255, 255, 255, 0.8);
		border: 1px solid rgba(210, 69, 54, );
	}
	.thumbnail:hover .overlay {
		background-color: rgba(210, 69, 54, 0.8);
	}
	.thumbnail:hover .thumbnail-text {
		font-size: 150%;
		color: black;
		font-weight: bolder;
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
		transition: 0.4s ease;
		margin: 0;
	}
	.thumbnail-text:hover {
		text-decoration: none;
	}

</style>
@endsection

@php
	$Items = [
		//[0 => image, 1 => text, 2 => link]
		[[Storage::url('assets/images/tv-sm.jpg'),Storage::url('assets/images/tv.jpg')], 'ثانوية حلوة على التليفزيون', route('media-TV')],
		[[Storage::url('assets/images/newspaper-sm.jpg'),Storage::url('assets/images/newspaper.jpg')], 'ثانوية حلوة على الصحافة', route('media-newspaper')],
		[[Storage::url('assets/images/about_team-sm.jpg'),Storage::url('assets/images/about_team.jpg')], 'اعرف أكتر عن الفريق', route('about-us')],
		[[Storage::url('assets/images/feedback-sm.jpg'),Storage::url('assets/images/feedback.jpg')], 'آراء الطلبة عننا', route('feedback')],
		[[Storage::url('assets/images/faculties-sm.jpg'),Storage::url('assets/images/faculties.jpg')], 'تنسيق السنين اللي فاتت', route('Tansik-Previous-Edges')],
		[[Storage::url('assets/images/faculties-sm.jpg'),Storage::url('assets/images/faculties.jpg')], 'يعني إيه قبول جغرافي؟', route('Tansik-Geo-Dist-Info')],
		[[Storage::url('assets/images/faculties-sm.jpg'),Storage::url('assets/images/faculties.jpg')], 'يعني إيه تقليل اغتراب؟', route('Tansik-ReduceAlienation')],
		[[Storage::url('assets/images/faculties-sm.jpg'),Storage::url('assets/images/faculties.jpg')], 'إيه هو التظلم وبيتعمل ازاي؟', route('Tansik-Tzalom')]
		//[Storage::url('assets/images/.jpg'), '', route('')],
	];
@endphp

@section('content')
		<div class="row">
			<div class="col p-0" style="margin-top:-20px; border-bottom: 3px solid #d24536;">
				<a href="{{ Storage::url('assets/images/Header.jpg') }}" class="progressive replace" width="100%">
					<img src="{{ Storage::url('assets/images/Header-sm.jpg') }}" class="preview img-fluid" alt="Welcome to Thanawya Helwa Website"/>
				</a>
			</div>
    	</div>
		<div class="row">
			@foreach ($Items as $item)
			@if ($loop->count%4 != 0 && $loop->index >= $loop->count - 3)
			<div class="col-6 col-md-4 p-0 thumbnail text-center">
			@else
			<div class="col-6 col-md-3 p-0 thumbnail text-center">
			@endif
				<a href="{{ $item[0][1] }}" class="progressive replace">
					<img src="{{ $item[0][0] }}" alt="{{ $item[1] }}" class="preview">
				</a>
				<a href="{{ $item[2] }}" class="overlay">
					<span class="thumbnail-text">
						{{ $item[1] }}
					</span>
				</a>
			</div>
			@endforeach
			</div>
    	</div>
@endsection

@section('scripts')
	<script defer>
		 //Thumbnail as a whole link
        document.querySelector('.thumbnail').addEventListener('click', function (e) {
            let targetLink = e.target.querySelector('.thumbnail-text').href;
            if (targetLink.indexOf("thanawyahelwa.org") != -1 || targetLink.indexOf("localhost") != -1) {
                window.open(targetLink, "_self");
            } else {
                window.open(targetLink, "_blank");
            }
        });
        document.querySelector('.thumbnail-text').addEventListener('click', function (e) {
            e.preventDefault();
        });
	</script>
@endsection