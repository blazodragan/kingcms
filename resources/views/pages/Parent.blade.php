@php

use app\Settings\GeneralSettings;
$settings = app(GeneralSettings::class);

@endphp

@extends('layout')

@section('meta')

<x-seo
:title="$page->meta_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()]"
:description="$page->meta_description ?: $settings->default_siteDescription[app()->getLocale()]"
:titleog="$page->og_title ?: $page->title ?: $settings->default_siteTitle[app()->getLocale()]"
:imageog="$page->cover_og_url ?: $page->cover_url ?: asset('images/logo.png')"
/>
@if($page && $page->faqs->count() > 0)
<x-faq-schema :faqs="$page->faqs" />
@endif
<x-artical-schema :page="$page" />

@endsection

@section('content')

<section>
    <div class="bg-search-welcome bg-no-repeat  bg-cover w-full p-5"> <!-- Hero Section -->
        <div class="w-full xl:w-1/2 mx-auto m-auto text-center flex"> <!-- Container Box -->
          <h1 class="text-2xl w-full text-white">{{ $page->title }}</h1>         
        </div>
      </div>
</section>
<section class="antialiased bg-gray-50 p-12">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent divtable">

    @if($page->media->first())
    <figure class="relative h-0 pb-[36.25%] overflow-hidden mb-8 rounded">
    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="{{ $page->media->first()->getUrl('bigThumb') }}" alt="{{ $page->media->first()->custom_properties['name'] ?? '' }}">

        </figure>
    @endif    

    {!! $processedContent !!}  
    </div>
</section>



@if($page && $page->faqs->count() > 0)
  <!-- Snippet -->
  <section class="bg-site-bg-gray">
    <div class="w-3/4 lg:w-1/2 mx-auto">
      <div class="text-4xl mb-5 text-site-blue-dark text-center pt-10">{{__('Frequently Asked Questions (FAQ)')}}</div>
      <div class="faq-box">
      
    @foreach($page->faqs as $faq)
    <div class="faq-item mb-4 rounded-xl border-2 border-site-border-faq bg-white">
          <div class="faq-question cursor-pointer flex justify-between items-center p-4">
            <span class="text-site-blue-ligter font-medium text-xl">{{ $loop->iteration }}. {{ $faq->question }}</span>
            <svg class="faq-arrow stroke-site-blue-ligter" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32"><path d="M6 9L12 15L18 9" stroke="#0D87C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
          </div>
          <div class="faq-answer-wrapper overflow-hidden max-h-0 transition-all duration-300">
            <div class="faq-answer p-4 text-gray-500">
            {{ $faq->answer }}
            </div>
          </div>
        </div>
    @endforeach



      </div>
  
      <div class="text-2xl mt-8 mb-4 text-gray-500 text-center">{{__('Still have a question?')}}</div>
      <div class="text-base text-gray-500 text-center pb-10">{{__('If you can not find answer to your question in our FAQ, you can always contact us. We Will answer to you shortly.')}}</div>
  
  
    </div>
  </section>
  @endif

@endsection