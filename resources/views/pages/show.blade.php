@extends('layout')

@section('title', $page->title ?? 'Default Title')

@section('content')
{!! $processedContent !!}


@if($page->media->first())
    <img src="{{ $page->media->first()->getUrl('preview') }}" alt="{{ $page->media->first()->custom_properties['name'] ?? '' }}">
@endif
@endsection