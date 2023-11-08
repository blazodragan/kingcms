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
<x-logo-schema/>
@if($page && $page->faqs->count() > 0)
<x-faq-schema :faqs="$page->faqs" />
@endif
    
@endsection

@section('content')
  <section>
    <div class="bg-search-welcome bg-no-repeat bg-cover w-full p-2 sm:p-8 2xl:p-20"> <!-- Hero Section -->
    <div class="w-full 2xl:w-2/3 mx-auto bg-white rounded lg:flex flex-col lg:flex-row"> <!-- Container Box -->
          
          <!-- Left Side -->
          <div class="flex-grow mb-10 p-10 border-r sm:mb-0 relative" style="flex-basis: 70%;">
            <img src="{{ asset('images/bitmap.png') }}" width="294px" height="222px" alt="Under Construction" class="absolute top-0 right-0 z-20">
            <div class="transparent-white-overlay z-10">
            

                        <h3 class="text-2xl mb-4 text-site-blue-dark text-left">{{__('Reserve a Vehicle')}}</h3>
            <form>
              <div class="flex items-center relative w-full mb-4">
                <input type="name" class="w-full p-3 rounded-l-lg border pl-12" placeholder="{{__('Pick up location')}}" disabled>
                <svg class="absolute ml-4 w-6 h-6" fill="#12B0DF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M215.7 499.2C267 435 384 279.4 384 192C384 86 298 0 192 0S0 86 0 192c0 87.4 117 243 168.3 307.2c12.3 15.3 35.1 15.3 47.4 0zM192 128a64 64 0 1 1 0 128 64 64 0 1 1 0-128z"/></svg>
                <!-- SVG for Calendar goes here -->
              </div>
                      <div class="grid gap-4 grid-cols-2">
                <!-- Pick up date -->
                <div class="w-full basis-1/2 flex">
                <div class="flex items-center relative w-1/2 mb-4">
                  <input type="name" class="w-full p-3 rounded-l-lg border border-r-0 pl-12" placeholder="{{__('Pick up date')}}" disabled>
                  <svg class="absolute ml-4 w-6 h-6" fill="#12B0DF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                  <!-- SVG for Calendar goes here -->
                </div>
                <!-- Pick up time -->
                <div class="flex items-center relative w-1/2 mb-4 ">
                  <input type="name" class="w-full p-3 rounded-r-lg border pl-12" placeholder="{{__('Time')}}" disabled>
                  <svg class="absolute ml-4 w-6 h-6" fill="#12B0DF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                  <!-- SVG for Time goes here -->
                </div>
              </div>
                <!-- Drop off date -->
                <div class="w-full basis-1/2 flex">
                  <div class="flex items-center relative w-1/2 mb-4">
                    <input type="name" class="w-full p-3 rounded-l-lg border border-r-0 pl-12" placeholder="{{__('Drop Off Date')}}" disabled>
                    <svg class="absolute ml-4 min-w-6 min-h-6" fill="#12B0DF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192H400V448c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192z"/></svg>
                  
                    <!-- SVG for Calendar goes here -->
                  </div>
                  <!-- Pick up time -->
                  <div class="flex items-center relative w-1/2 mb-4">
                    <input type="name" class="w-full p-3 rounded-r-lg border pl-12" placeholder="{{__('Time')}}" disabled>
                    <svg class="absolute ml-4 w-6 h-6" fill="#12B0DF" xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M464 256A208 208 0 1 1 48 256a208 208 0 1 1 416 0zM0 256a256 256 0 1 0 512 0A256 256 0 1 0 0 256zM232 120V256c0 8 4 15.5 10.7 20l96 64c11 7.4 25.9 4.4 33.3-6.7s4.4-25.9-6.7-33.3L280 243.2V120c0-13.3-10.7-24-24-24s-24 10.7-24 24z"/></svg>
                    <!-- SVG for Time goes here -->
                  </div>
                </div>
              </div>
              <div class="flex justify-center space-x-2 mt-4">
              <a class="inline-flex cursor-default items-center justify-center px-8 py-3 border border-transparent rounded-3xl leading-5 shadow-sm transition duration-150 ease-in-out bg-[#0C87C6] focus:outline-none focus-visible:ring-2 text-white" href="#0">
              {{__('Continue')}}
                  </a>
              </div>
            </form>
          </div>
          </div>
          <!-- Right Side -->
          <div class="flex-grow p-10 " style="flex-basis: 40%;">
            <h3 class="text-xl mb-4 text-site-blue-dark text-left">{{__('Advantages of Hiring with MietwegenParadise')}}</h3>
            <ul class="max-w-md space-y-1 text-gray-500 list-inside dark:text-gray-400">
              <li class="flex items-center">
                  <svg class="w-3.5 h-3.5 mr-2 text-[#12B0DF] flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                      <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                   </svg>
                   {{__('Save up to 43%')}}
                   
              </li>
              <li class="flex items-center">
                  <svg class="w-3.5 h-3.5 mr-2 text-[#12B0DF] flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                      <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                   </svg>
                   {{__('Compare hundreds of rental car websites at once for car rental deals in Utrecht')}}
                   
              </li>
              <li class="flex items-center">
                  <svg class="w-3.5 h-3.5 mr-2 text-[#12B0DF]  flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                      <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                   </svg>
                   {{__('We are completely free to use . There are no hidden costs or fees')}}
                   
              </li>
              <li class="flex items-center">
                <svg class="w-3.5 h-3.5 mr-2 text-[#12B0DF] flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 448 512">
                    <path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/>
                 </svg>
                 {{__('Filter by car type, free cencelation and more')}}
                 
            </li>
          </ul>
          </div>
        </div>
      </div>
  </section>
  <div class="text-4xl pt-10 bg-gray-50 text-site-blue-dark text-center">Gunstige Mietwegen</div>
  <div class="w-full pt-10 pb-10 bg-gray-50">
<div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent">
@block('ChildPagesBlock', ['count' => 3, 'parent_id' => '17'])
</div>
</div>
  
  <!-- Snippet -->
  <div class="text-4xl mt-10 text-site-blue-dark text-center">{{__('Meet The Fleet')}}</div>
  <section class="block bg-white text-gray-600 relative h-1/3 min-h-[450px] p-12">
  
    <div class="items">
    <div class=" item active">
                <!-- Box 1 -->
                <div
                class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
                <a href="#" aria-label="2023 Porsche Panamera">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/2023_Porsche_Panamera.png') }}" alt="2023 Porsche Panamera" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

                  </figure>
                  <div class="flex-grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="flex-grow">
                      <!-- Header -->
                      <header class="mb-3 text-center">
                        <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Exklusiv</h3>
                      </header>
                      <!-- Content -->
                      <div class="mb-3 text-center">
                        <p>from</p>
                      </div>
                    </div>
                    <!-- Card footer -->
                    <div class="flex justify-center space-x-2">
                      <a class="font-semibold text-sm inline-flex items-center justify-center  text-[#0F6C9B]" href="#0">$ 90/
                        Day</a>
                    </div>
                  </div>
                </a>
              </div>
      </div>
      <div class="item next">
        <!-- Box 1 -->
        <div
          class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
          <a href="#" aria-label="Minivan">
            <!-- Image -->
            <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
            <img src="{{ asset('images/minivan.png') }}" alt="Minivan" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

            </figure>
            <div class="flex-grow flex flex-col p-5">
              <!-- Card body -->
              <div class="flex-grow">
                <!-- Header -->
                <header class="mb-3 text-center">
                  <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Minivan</h3>
                </header>
                <!-- Content -->
                <div class="mb-3 text-center">
                  <p>from</p>
                </div>
              </div>
              <!-- Card footer -->
              <div class="flex justify-center space-x-2">
                <a class="font-semibold text-sm inline-flex items-center justify-center  text-[#0F6C9B]" href="#0">$ 90/
                  Day</a>
              </div>
            </div>
          </a>
        </div>
      </div>

      <div class="item">
        <!-- Box 1 -->
        <div
        class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
        <a href="#" aria-label="Polo">
          <!-- Image -->
          <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
          <img src="{{ asset('images/polo.png') }}" alt="Polo" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

          </figure>
          <div class="flex-grow flex flex-col p-5">
            <!-- Card body -->
            <div class="flex-grow">
              <!-- Header -->
              <header class="mb-3 text-center">
                <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Klein</h3>
              </header>
              <!-- Content -->
              <div class="mb-3 text-center">
                <p>from</p>
              </div>
            </div>
            <!-- Card footer -->
            <div class="flex justify-center space-x-2">
              <a class="font-semibold text-sm inline-flex items-center justify-center  text-[#0F6C9B]" href="#0">$ 90/
                Day</a>
            </div>
          </div>
        </a>
      </div>
</div>

      <div class="item">
                <!-- Box 1 -->
                <div
                class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
                <a href="#" aria-label="E-tron">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/e-tron.png') }}" alt="E-tron" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

                  </figure>
                  <div class="flex-grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="flex-grow">
                      <!-- Header -->
                      <header class="mb-3 text-center">
                        <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Mittel</h3>
                      </header>
                      <!-- Content -->
                      <div class="mb-3 text-center">
                        <p>from</p>
                      </div>
                    </div>
                    <!-- Card footer -->
                    <div class="flex justify-center space-x-2">
                      <a class="font-semibold text-sm inline-flex items-center justify-center  text-[#0F6C9B]" href="#0">$ 90/
                        Day</a>
                    </div>
                  </div>
                </a>
              </div>
      </div>

      <div class="item prev">
                <!-- Box 1 -->
                <div
                class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
                <a href="#" aria-label="Jeta">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/jeta.png') }}" alt="Jeta" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">
     
                  </figure>
                  <div class="flex-grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="flex-grow">
                      <!-- Header -->
                      <header class="mb-3 text-center">
                        <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Groß</h3>
                      </header>
                      <!-- Content -->
                      <div class="mb-3 text-center">
                        <p>from</p>
                      </div>
                    </div>
                    <!-- Card footer -->
                    <div class="flex justify-center space-x-2">
                      <a class="font-semibold text-sm inline-flex items-center justify-center  text-[#0F6C9B]" href="#0">$ 90/
                        Day</a>
                    </div>
                  </div>
                </a>
              </div>
      </div>
      <div class="button-container">
        <div class="button"><svg xmlns="http://www.w3.org/2000/svg" fill="#0C87C6" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg></div>
        <div class="button"><svg xmlns="http://www.w3.org/2000/svg" fill="#0C87C6" height="1em" viewBox="0 0 320 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg></div>
      </div>
    </div>

  </section>
  <div class="flex justify-center mb-10">
    <a class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-xl leading-5 shadow-sm transition duration-150 ease-in-out bg-[#0C87C6] focus:outline-none focus-visible:ring-2 hover:bg-[#49a5d4] text-white" href="#0">
    View All Vehicles
    </a>
</div>
<div class="text-4xl pt-10 bg-gray-50 text-site-blue-dark text-center">Geheimtipp für Mietwagen</div>
<div class="w-full pt-10 pb-10 bg-gray-50">
<div class="w-4/5 sm:w-full 2xl:w-3/5 mx-auto bodycontent">
@block('ReviewsBlock', ['count' => 3])
</div>
</div>
<!-- say about us-->
<!-- Snippet -->
<div class="text-4xl mt-10 text-site-blue-dark text-center">{{__('What customers say about us')}}</div>
<div class="text-1xl mt-2 text-gray-500 text-center">{{__('We do our best to provide you with the best expiriance')}}</div>
<section class="block bg-white text-gray-600 relative h-1/3  p-12">

<div class="center">
  <div class="wrapper w-[15rem] md:w-[30rem] lg:w-[60rem]">
    <div class="inner">

    @foreach($reviews as $review)


    <div class="card bg-white w-60 px-2">
        <div class="content border border-gray-300 shadow-md px-4 py-8 space-y-2">
                  <svg version="1.1" id="Layer_1" class="h8 w-8" ="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
          viewBox="0 0 34 31" style="enable-background:new 0 0 34 31;" xml:space="preserve">
        <style type="text/css">
          .st0{fill:#219653;}
        </style>
        <g id="rean-a-car">
          <g id="Car-rental-homepage" transform="translate(-469, -2682)">
            <g id="Review-Carousel" transform="translate(162, 2647)">
              <g id="Group" transform="translate(287, 0)">
                <path id="Shape" class="st0" d="M35,35.5c-8.2,0-15,6.8-15,15v15h15v-15H25c0-5.5,4.5-10,10-10V35.5z M54,35.5
                  c-8.2,0-15,6.8-15,15v15h15v-15H44c0-5.5,4.5-10,10-10V35.5z"/>
              </g>
            </g>
          </g>
        </g>
        </svg>

          <h2 class="text-black font-bold text-left">{{ $review->title }}</h2>
          <div class="inline-flex w-full">
            <div>
            @php
            $roundedRating = round($review->rating);
        @endphp

        <img src="{{ asset('images/stars-' . $roundedRating . '.svg') }}" alt="{{ $roundedRating }} Stars" class="w-24 mr-2">



            </div>
            <div class="text-xs align-middles">{{ $review->created_at->diffForHumans() }}</div>
          </div>
          <div class="text-left text-sm">{{ $review->description }}</div>
        </div>
      </div>

  
        


@endforeach




  
 

    </div>
  </div>
  
  <div class="map">
    <button aria-label="First Review Slide" class="active first"></button>
    <button aria-label="Second Review Slide" class="second"></button>
    <button aria-label="Third Review Slide" class="third"></button>
  </div>
</div>

<script>
const buttonsWrapper = document.querySelector(".map");
const slidesTrust = document.querySelector(".inner");

buttonsWrapper.addEventListener("click", (e) => {
  if (e.target.nodeName === "BUTTON") {
    Array.from(buttonsWrapper.children).forEach((item) =>
      item.classList.remove("active")
    );
    if (e.target.classList.contains("first")) {
      slidesTrust.style.transform = "translateX(-0%)";
      e.target.classList.add("active");
    } else if (e.target.classList.contains("second")) {
      slidesTrust.style.transform = "translateX(-60rem)";
      e.target.classList.add("active");
    } else if (e.target.classList.contains("third")) {
      slidesTrust.style.transform = "translatex(-120rem)";
      e.target.classList.add("active");
    }
  }
});
</script>

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
            <svg class="faq-arrow stroke-site-blue-ligter" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" width="32" height="32"><path d="M6 9L12 15L18 9" stroke="#0D87C6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
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
