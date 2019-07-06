@extends('layouts.app')

@section('title','الرئيسية')

@section('head')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">    
@endsection

@php
	$Items = [
		//[0 => image, 1 => text, 2 => link]
		[Storage::url('assets/images/tv.jpg'), 'ثانوية حلوة على التليفزيون', route('media-TV')],
		[Storage::url('assets/images/newspaper.jpg'), 'ثانوية حلوة على الصحافة', route('media-newspaper')],
		[Storage::url('assets/images/about_team.jpg'), 'اعرف أكتر عن الفريق', route('about-us')],
		[Storage::url('assets/images/feedback.jpg'), 'آراء الطلبة عننا', route('feedback')],
		[Storage::url('assets/images/faculties.jpg'), 'الكليات بتقبل من كام؟', route('Tansik-Previous-Edges')],
		[Storage::url('assets/images/faculties.jpg'), 'يعني إيه قبول جغرافي؟', route('Tansik-Geo-Dist')],
		[Storage::url('assets/images/faculties.jpg'), 'يعني إيه تقليل اغتراب؟', route('Tansik-ReduceAlienation')]
		//[Storage::url('assets/images/.jpg'), '', route('')],
	];
@endphp

@section('content')
		<div class="row">
			<div class="col p-0" style="margin-top:-20px; border-bottom: 3px solid #d24536;">
				<img class="img-fluid" src="{{ Storage::url('assets/images/Header.jpg') }}" width="100%"/>
			</div>
    	</div>
		<div class="row" style="margin-bottom: -5%;">
			@foreach ($Items as $item)
			@if ($loop->count%4 != 0 && $loop->index >= $loop->count - 3)
			<div class="col-6 col-md-4 p-0 thumbnail text-center">
			@else
			<div class="col-6 col-md-3 p-0 thumbnail text-center">
			@endif
				<img src="{{ $item[0] }}" alt="" class="img-fluid" width="100%">
				<div class="overlay">
					<a href="{{ $item[2] }}" class="thumbnail-text">{{ $item[1] }}</a>
				</div>
			</div>
			@endforeach
			</div>
    	</div>
@endsection