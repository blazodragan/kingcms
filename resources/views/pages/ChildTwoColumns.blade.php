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
        <div class="md:flex-row w-4/5 sm:w-full 2xl:w-3/5 mx-auto"> <!-- Container Box -->
        <h1 class="text-4xl text-white text-center">{{ $page->title }}</h1>
        
        <div class="flex justify-center items-center text-sm mt-2 text-white space-x-3">
            <span>By <a href="{{ route('showAuthor', ['slug' => $page->user->slug]) }}" class="underline hover:no-underline">{{ $page->user->name }}</a></span>
            <span class="w-2 h-2 rounded-full bg-white"></span>
            @if(strtotime($page->updated_at) > strtotime($page->published_at))
                <span>Updated on {{ date('F Y, d', strtotime($page->updated_at)) }}</span>
                @else
                <span>Published on {{ date('F Y, d', strtotime($page->published_at)) }}</span>
                @endif
        </div>
        </div>
    </div>
</section>
<section class="antialiased bg-white  p-10">

    <div class="flex flex-col md:flex-row w-4/5 sm:w-full 2xl:w-3/5 mx-auto">
        <!-- Left Column (60% on larger screens, 100% on mobile) -->
        <div class="bodycontent w-full lg:w-4/6 px-4">
            {!! $processedContent !!}
        </div>


        <!-- Right Column (40% on larger screens, 100% on mobile) -->
        <div class="w-full lg:w-2/6 p-4 ">
            <div class="rounded-lg overflow-hidden shadow">
                <!-- Blue Header -->
                <div class="bg-cyan-500 text-white text-center p-6">
                    {{ $page->why }}
                </div>
                <!-- Body with padding of 1.5rem -->
                <div class="p-12 flex-col">
                    @if($page && $page->tips->count() > 0)
                    @foreach($page->tips->where('type', 'suggestion') as $tip)
                    <div>
                        <!-- Header with SVG and h3 -->
                        <header class="flex flex-row mb-2">
                            <div>
                                <img src="{{ $tip->icon }}" alt="{{ $tip->title }}" class="align-top w-4 h-4 mr-2">
                            </div>
                            <!-- Title with a slight negative margin on top -->
                            <h3 class="text-md font-semibold leading-snug pl-1 -mt-1">{{ $tip->title }}</h3>
                        </header>

                        <!-- Content -->
                        <div class="mb-8 pl-7 text-xs"><!-- Added padding-left -->
                            <p>{{ $tip->body }}</p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>




    </div>


</section>
@if($page && $page->tips->where('type', 'question')->count() > 0)
<section class="antialiased bg-site-bg-gray p-10">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        @foreach($page->tips->where('type', 'question') as $tip)
        <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
            <a href="#" class="hover-group">
                <div class="p-6">
                    <!-- Card body -->
                    <div>
                        <header class="relative flex items-center mb-2"> <!-- Added relative positioning for header -->
                            <div style="margin-left: -0.5rem; position: absolute; left: 0;"> <!-- SVG container with negative margin and absolute positioning -->
                            <img src="{{ $tip->icon }}" alt="{{ $tip->title }}" class="align-top w-5 h-5 mr-2">
                            </div>
                            <!-- Title -->
                            @if($tip->title)<h3 class="text-[22px] text-cyan-500 font-semibold leading-snug pl-4">{{ $tip->title }}</h3>@endif
                        </header>
                        <!-- Content -->
                        <div class="mb-8 pl-4 text-sm"> <!-- Added padding-left -->
                            <p>{{ $tip->body }}</p>
                        </div>
                    </div>
                    <!-- Card footer -->
                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>
@endif


<section class="antialiased bg-gray-50  p-12">
    <div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent">

    @if($page->media->first())
    <figure class="relative h-0 pb-[36.25%] overflow-hidden mb-8 rounded">
    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="{{ $page->media->first()->getUrl('bigThumb') }}" alt="{{ $page->media->first()->custom_properties['alt'] ?? '' }}">

        </figure>
    @endif    


        {!! $page->text !!}
    </div>
</section>

<!-- Snippet -->
<section class="bg-site-bg-gray">
    <div class="w-3/4 lg:w-1/2 mx-auto">
        <div class="text-4xl mb-5 text-site-blue-dark text-center pt-10">{{__('Frequently Asked Questions (FAQ)')}}</div>
        <div class="faq-box">
            @if($page && $page->faqs->count() > 0)
            @foreach($page->faqs as $faq)
            <div class="faq-item mb-4 rounded-xl border-2 border-site-border-faq bg-white">
                <div class="faq-question cursor-pointer flex justify-between items-center p-4">
                    <span class="text-site-blue-ligter font-medium text-xl">{{ $loop->iteration }}. {{ $faq->question }}</span>
                    <svg class="faq-arrow stroke-site-blue-ligter" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32">
                        <path d="M6 9L12 15L18 9" stroke="#0D87C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </div>
                <div class="faq-answer-wrapper overflow-hidden max-h-0 transition-all duration-300">
                    <div class="faq-answer p-4 text-gray-500">
                        {{ $faq->answer }}
                    </div>
                </div>
            </div>
            @endforeach
            @endif


        </div>

        <div class="text-2xl mt-8 mb-4 text-gray-500 text-center">{{__('Still have a question?')}}</div>
        <div class="text-base text-gray-500 text-center pb-10">{{__('If you can not find answer to your question in our FAQ, you can always contact us. We Will answer to you shortly.')}}</div>


    </div>
</section>





@endsection