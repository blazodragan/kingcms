<!-- resources/views/welcome.blade.php -->

@extends('layout')

@section('title', 'Welcome Page')

@section('content')

  <section>
    <div class="bg-[url('panoramic-aerial-shot-california-bixby-bridge-green-hill-near-beautiful-blue-water.jpg')] bg-no-repeat bg-cover w-full p-2 sm:p-8 2xl:p-20"> <!-- Hero Section -->
    <div class="w-full 2xl:w-2/3 mx-auto bg-white rounded lg:flex flex-col lg:flex-row"> <!-- Container Box -->
          
          <!-- Left Side -->
          <div class="flex-grow mb-10 p-10 border-r sm:mb-0 relative" style="flex-basis: 70%;">
            <img src="{{ asset('images/bitmap.png') }}" alt="Under Construction" class="absolute top-0 right-0 z-20">
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
  @block('TopNewsBlock', ['count' => 5, 'category' => 'asd'])
  <section class="antialiased bg-gray-50 text-gray-600 p-12">
    <div class="text-4xl mb-10 text-site-blue-dark text-center">Gunstige Mietwegen Mallorca</div>
    <div class="w-full 2xl:w-3/5 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Box 1 -->
      <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
        <a href="#">
         <!-- Image -->
          <figure class="relative h-0 pb-[56.25%] overflow-hidden">
          <img src="{{ asset('images/compettitve.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" width="240" height="120" alt="Course">
          </figure>
      <div class="flex-grow flex flex-col p-5">
        <!-- Card body -->
        <div class="flex-grow h-[8rem]">
            <!-- Header -->
            <header class="mb-3">
                    <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Die besten Preise für Autovermietung</h3>
            </header>
            <!-- Content -->
            <div class="mb-8">
                <p>Ob Kleinwagen, Mittelklasse oder Cabrio, vergleichen Sie und finden Sie bei uns die besten Preise.</p>
            </div>
        </div>
        <!-- Card footer -->
        <div class="flex justify-center space-x-2">
          <a class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-3xl leading-5 shadow-sm transition duration-150 ease-in-out bg-[#0C87C6] focus:outline-none focus-visible:ring-2 hover:bg-[#49a5d4] text-white" href="#0">
              Upgrade now
            </a>
        </div>
    </div>
  </a>
      </div>
      
        <!-- Box 1 -->
        <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
          <a href="#">
           <!-- Image -->
            <figure class="relative h-0 pb-[56.25%] overflow-hidden">
            <img src="{{ asset('images/43023.jpg') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" width="240" height="120" alt="Course">
                
            </figure>
        <div class="flex-grow flex flex-col p-5">
          <!-- Card body -->
          <div class="flex-grow h-[8rem]">
              <!-- Header -->
              <header class="mb-3">
                      <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Versicherung ist bei jeder unserer Buchungen inklusive
</h3>
              </header>
              <!-- Content -->
              <div class="mb-8">
                  <p>Spontanbucher profitieren auch von unserer Last-Minute Autovermietung</p>
              </div>
          </div>
          <!-- Card footer -->
          <div class="flex justify-center space-x-2">
            <a class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-3xl leading-5 shadow-sm transition duration-150 ease-in-out bg-[#0C87C6] focus:outline-none focus-visible:ring-2 hover:bg-[#49a5d4] text-white" href="#0">
              Save now
            </a>
          </div>
      </div>
    </a>
        </div>
      
      <!-- Box 1 -->
      <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
        <a href="#">
         <!-- Image -->
          <figure class="relative h-0 pb-[56.25%] overflow-hidden">
          <img src="{{ asset('images/651.jpg') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" width="240" height="120" alt="Course">
          </figure>
      <div class="flex-grow flex flex-col p-5">
        <!-- Card body -->
        <div class="flex-grow h-[8rem]">
            <!-- Header -->
            <header class="mb-3">
                    <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Stressfrei-Garantie bei jeder Autovermietung
</h3>
            </header>
            <!-- Content -->
            <div class="mb-8">
                <p>Unser Wunsch ist es, Ihre Wünsche zu erfüllen.</p>
            </div>
        </div>
        <!-- Card footer -->
        <div class="flex justify-center space-x-2">
          <a class="inline-flex items-center justify-center px-8 py-3 border border-transparent rounded-3xl leading-5 shadow-sm transition duration-150 ease-in-out bg-[#0C87C6] focus:outline-none focus-visible:ring-2 hover:bg-[#49a5d4] text-white" href="#0">
            Save now
          </a>
        </div>
    </div>
  </a>
      </div>
    </div>
  </section>
  <!-- Snippet -->
  <div class="text-4xl mt-10 text-site-blue-dark text-center">{{__('Meet The Fleet')}}</div>
  <section class="block bg-white text-gray-600 relative h-1/3 min-h-[450px] p-12">
  
    <div class="items">
      <div class="item active">
        <!-- Box 1 -->
        <div
          class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
          <a href="#">
            <!-- Image -->
            <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
            <img src="{{ asset('images/toyota.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

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
      <div class=" item next">
                <!-- Box 1 -->
                <div
                class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
                <a href="#">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/bmv.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

                  </figure>
                  <div class="flex-grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="flex-grow">
                      <!-- Header -->
                      <header class="mb-3 text-center">
                        <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">BMW</h3>
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
        <a href="#">
          <!-- Image -->
          <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
          <img src="{{ asset('images/minivan.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

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
                <a href="#">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/minivan.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

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

      <div class="item prev">
                <!-- Box 1 -->
                <div
                class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow mt-4">
                <a href="#">
                  <!-- Image -->
                  <figure class="relative h-0 pb-[56.25%] overflow-hidden mt-5">
                  <img src="{{ asset('images/toyota.png') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">
     
                  </figure>
                  <div class="flex-grow flex flex-col p-5">
                    <!-- Card body -->
                    <div class="flex-grow">
                      <!-- Header -->
                      <header class="mb-3 text-center">
                        <h3 class="text-[18px] text-[#0C87C6] font-semibold leading-snug">Toyota</h3>
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

<section class="antialiased bg-gray-50 text-gray-600  p-12">
  <div class="text-4xl mb-10 text-site-blue-dark text-center">Geheimtipp für Mietwagen in [Insert Location]</div>
  <div class="w-full 2xl:w-3/5 mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Box 1 -->
    <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
      <a href="#">
       <!-- Image -->
        <figure class="relative h-0 pb-[56.25%] overflow-hidden">
        <img src="{{ asset('images/tp212-socialmedia-07.jpg') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">
        </figure>
    <div class="flex-grow flex flex-col p-5">
      <!-- Card body -->
      <div class="flex-grow">
          <!-- Header -->
          <header class="mb-3">
                  <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Gut versichert während Ihrer Reise
                  </h3>
          </header>
          <!-- Content -->
          <div class="mb-8">
              <p>Genießen Sie einen sorgenfreien Urlaub mit unsern Partner, der ANWB Reiseversicherung. Berechnen Sie Ihre Versicherung hier Online.
</p>
          </div>
      </div>

  </div>
</a>
    </div>
    
      <!-- Box 1 -->
      <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
        <a href="#"></a>
         <!-- Image -->
          <figure class="relative h-0 pb-[56.25%] overflow-hidden">
          <img src="{{ asset('images/Wavy_Edu-03_Single-09.jpg') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">
          </figure>
      <div class="flex-grow flex flex-col p-5">
        <!-- Card body -->
        <div class="flex-grow">
            <!-- Header -->
            <header class="mb-3">
                    <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Travel Guides</h3>
            </header>
            <!-- Content -->
            <div class="mb-8">
                <p>Vorbereitung ist der halbe Urlaub. Werfen Sie einen Blick auf die Reiseführer von ANWB und planen Sie Ihren Urlaub perfekt. </p>
            </div>
        </div>
 
    </div>
  </a>
      </div>
    
    <!-- Box 1 -->
    <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
      <a href="#">
       <!-- Image -->
        <figure class="relative h-0 pb-[56.25%] overflow-hidden">
        <img src="{{ asset('images/Person ordering cab to airport online.jpg') }}" class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out">

        </figure>
    <div class="flex-grow flex flex-col p-5">
      <!-- Card body -->
      <div class="flex-grow">
          <!-- Header -->
          <header class="mb-3">
                  <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">Die Top 7 der besten Urlaubsorte, die Sie nur mit einem Mietwagen erreichen</h3>
          </header>
          <!-- Content -->
          <div class="mb-8">
              <p>Erreichen Sie auch die entlegensten Plätze und geheimen Paradiese mit einem unserer Mietwagen. </p>
          </div>
      </div>

  </div>
</a>
    </div>
  </div>
</section>
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
    <button class="active first"></button>
    <button class="second"></button>
    <button class="third"></button>
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
      slidesTrust.style.transform = "translateX(-33.33333333333333%)";
      e.target.classList.add("active");
    } else if (e.target.classList.contains("third")) {
      slidesTrust.style.transform = "translatex(-66.6666666667%)";
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

<section>
    <div class=" w-full p-5"> <!-- Hero Section -->
      <div class="text-4xl mt-8 mb-4 text-site-blue-dark text-center">{{__('Get in touch')}}</div>
  
        <div class="container mx-auto p-10 lg:flex flex-col lg:flex-row space-y-6 lg:space-y-0"> <!-- Container Box -->
          
          <!-- Left Side -->
          <div class="xl:w-1/2 xl:border-r border-gray-300 items-center text-center flex-col">
            <div class="flex justify-center items-center ">
              <svg width="800px" height="800px" class="w-16 h-16 fill-cyan-500" fill="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.7177 3.0919C5.94388 1.80096 7.9721 2.04283 8.98569 3.47641L10.2467 5.25989C11.0574 6.40656 10.9889 8.00073 10.0214 9.0194L9.7765 9.27719C9.77582 9.27897 9.7751 9.2809 9.77436 9.28299C9.76142 9.31935 9.7287 9.43513 9.7609 9.65489C9.82765 10.1104 10.1793 11.0361 11.607 12.5392C13.0391 14.0469 13.9078 14.4023 14.3103 14.4677C14.484 14.4959 14.5748 14.4714 14.6038 14.4612L15.0124 14.031C15.8862 13.111 17.2485 12.9298 18.347 13.5621L20.2575 14.6617C21.8904 15.6016 22.2705 17.9008 20.9655 19.2747L19.545 20.7703C19.1016 21.2371 18.497 21.6355 17.75 21.7092C15.9261 21.8893 11.701 21.6548 7.27161 16.9915C3.13844 12.64 2.35326 8.85513 2.25401 7.00591L2.92011 6.97016L2.25401 7.00591C2.20497 6.09224 2.61224 5.30855 3.1481 4.7444L4.7177 3.0919ZM7.7609 4.34237C7.24855 3.61773 6.32812 3.57449 5.80528 4.12493L4.23568 5.77743C3.90429 6.12632 3.73042 6.52621 3.75185 6.92552C3.83289 8.43533 4.48307 11.8776 8.35919 15.9584C12.4234 20.2373 16.1676 20.3581 17.6026 20.2165C17.8864 20.1885 18.1783 20.031 18.4574 19.7373L19.8779 18.2417C20.4907 17.5965 20.3301 16.4342 19.5092 15.9618L17.5987 14.8621C17.086 14.567 16.4854 14.6582 16.1 15.064L15.6445 15.5435L15.1174 15.0428C15.6445 15.5435 15.6438 15.5442 15.6432 15.545L15.6417 15.5464L15.6388 15.5495L15.6324 15.556L15.6181 15.5701C15.6078 15.5801 15.5959 15.591 15.5825 15.6028C15.5556 15.6264 15.5223 15.6533 15.4824 15.6816C15.4022 15.7384 15.2955 15.8009 15.1606 15.8541C14.8846 15.963 14.5201 16.0214 14.0699 15.9483C13.1923 15.8058 12.0422 15.1755 10.5194 13.5722C8.99202 11.9642 8.40746 10.7645 8.27675 9.87234C8.21022 9.41827 8.26346 9.05468 8.36116 8.78011C8.40921 8.64508 8.46594 8.53742 8.51826 8.45566C8.54435 8.41489 8.56922 8.38075 8.5912 8.35298C8.60219 8.33909 8.61246 8.32678 8.62182 8.31603L8.63514 8.30104L8.64125 8.29441L8.64415 8.2913L8.64556 8.2898C8.64625 8.28907 8.64694 8.28835 9.17861 8.79333L8.64695 8.28834L8.93376 7.98637C9.3793 7.51731 9.44403 6.72292 9.02189 6.12586L7.7609 4.34237Z"/>
                <path d="M13.2595 1.87983C13.3257 1.47094 13.7122 1.19357 14.1211 1.25976C14.1464 1.26461 14.2279 1.27983 14.2705 1.28933C14.3559 1.30834 14.4749 1.33759 14.6233 1.38082C14.9201 1.46726 15.3347 1.60967 15.8323 1.8378C16.8286 2.29456 18.1544 3.09356 19.5302 4.46936C20.906 5.84516 21.705 7.17097 22.1617 8.16725C22.3899 8.66487 22.5323 9.07947 22.6187 9.37625C22.6619 9.52466 22.6912 9.64369 22.7102 9.72901C22.7197 9.77168 22.7267 9.80594 22.7315 9.83125L22.7373 9.86245C22.8034 10.2713 22.5286 10.6739 22.1197 10.7401C21.712 10.8061 21.3279 10.53 21.2601 10.1231C21.258 10.1121 21.2522 10.0828 21.2461 10.0551C21.2337 9.9997 21.2124 9.91188 21.1786 9.79572C21.1109 9.56339 20.9934 9.21806 20.7982 8.79238C20.4084 7.94207 19.7074 6.76789 18.4695 5.53002C17.2317 4.29216 16.0575 3.59117 15.2072 3.20134C14.7815 3.00618 14.4362 2.88865 14.2038 2.82097C14.0877 2.78714 13.9417 2.75363 13.8863 2.7413C13.4793 2.67347 13.1935 2.28755 13.2595 1.87983Z"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4861 5.32931C13.5999 4.93103 14.015 4.70041 14.4133 4.81421L14.2072 5.53535C14.4133 4.81421 14.4136 4.81431 14.414 4.81441L14.4147 4.81462L14.4162 4.81506L14.4196 4.81604L14.4273 4.81835L14.4471 4.82451C14.4622 4.82934 14.481 4.83562 14.5035 4.84358C14.5484 4.85952 14.6077 4.88218 14.6805 4.91339C14.8262 4.97582 15.0253 5.07224 15.2698 5.21695C15.7593 5.50664 16.4275 5.98781 17.2124 6.77279C17.9974 7.55776 18.4786 8.22595 18.7683 8.71541C18.913 8.95992 19.0094 9.15899 19.0718 9.30467C19.103 9.37748 19.1257 9.43683 19.1416 9.48175C19.1496 9.5042 19.1559 9.52303 19.1607 9.5381L19.1669 9.55789L19.1692 9.56564L19.1702 9.56898L19.1706 9.57051L19.1708 9.57124C19.1709 9.5716 19.171 9.57195 18.4499 9.77799L19.171 9.57195C19.2848 9.97023 19.0542 10.3853 18.6559 10.4991C18.261 10.612 17.8496 10.3862 17.7317 9.99414L17.728 9.98336C17.7227 9.96833 17.7116 9.93875 17.6931 9.89555C17.6561 9.80921 17.589 9.66798 17.4774 9.47939C17.2544 9.10265 16.8517 8.5334 16.1518 7.83345C15.4518 7.13349 14.8826 6.73079 14.5058 6.50782C14.3172 6.3962 14.176 6.32911 14.0897 6.2921C14.0465 6.27359 14.0169 6.26256 14.0019 6.25722L13.9911 6.25353C13.599 6.13565 13.3733 5.7242 13.4861 5.32931Z"/>
                </svg>
            </div>
                  <div class="text-2xl font-semibold text-[#4A4A4A]">{{__('Give us a call')}}</div>      
                  <div class="mb-6 mt-2 w-1/2 flex m-auto">{{__('If you have additional questions, please do not hesitate call us.')}}</div>      
                  <button class="rounded-3xl border-2 border-cyan-500 px-8 py-2">023 569 96 96</button>
            
          </div>
          
          <!-- Right Side -->
          <div class="xl:w-1/2 items-center text-center">
            <div class="flex justify-center items-center ">
              <svg width="800px" height="800px" class="w-16 h-16 fill-cyan-500" fill="currentColor" viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.94358 3.25H14.0564C15.8942 3.24998 17.3498 3.24997 18.489 3.40314C19.6614 3.56076 20.6104 3.89288 21.3588 4.64124C22.1071 5.38961 22.4392 6.33856 22.5969 7.51098C22.75 8.65019 22.75 10.1058 22.75 11.9436V12.0564C22.75 13.8942 22.75 15.3498 22.5969 16.489C22.4392 17.6614 22.1071 18.6104 21.3588 19.3588C20.6104 20.1071 19.6614 20.4392 18.489 20.5969C17.3498 20.75 15.8942 20.75 14.0564 20.75H9.94359C8.10583 20.75 6.65019 20.75 5.51098 20.5969C4.33856 20.4392 3.38961 20.1071 2.64124 19.3588C1.89288 18.6104 1.56076 17.6614 1.40314 16.489C1.24997 15.3498 1.24998 13.8942 1.25 12.0564V11.9436C1.24998 10.1058 1.24997 8.65019 1.40314 7.51098C1.56076 6.33856 1.89288 5.38961 2.64124 4.64124C3.38961 3.89288 4.33856 3.56076 5.51098 3.40314C6.65019 3.24997 8.10582 3.24998 9.94358 3.25ZM5.71085 4.88976C4.70476 5.02502 4.12511 5.27869 3.7019 5.7019C3.27869 6.12511 3.02502 6.70476 2.88976 7.71085C2.75159 8.73851 2.75 10.0932 2.75 12C2.75 13.9068 2.75159 15.2615 2.88976 16.2892C3.02502 17.2952 3.27869 17.8749 3.7019 18.2981C4.12511 18.7213 4.70476 18.975 5.71085 19.1102C6.73851 19.2484 8.09318 19.25 10 19.25H14C15.9068 19.25 17.2615 19.2484 18.2892 19.1102C19.2952 18.975 19.8749 18.7213 20.2981 18.2981C20.7213 17.8749 20.975 17.2952 21.1102 16.2892C21.2484 15.2615 21.25 13.9068 21.25 12C21.25 10.0932 21.2484 8.73851 21.1102 7.71085C20.975 6.70476 20.7213 6.12511 20.2981 5.7019C19.8749 5.27869 19.2952 5.02502 18.2892 4.88976C17.2615 4.75159 15.9068 4.75 14 4.75H10C8.09318 4.75 6.73851 4.75159 5.71085 4.88976ZM5.42383 7.51986C5.68901 7.20165 6.16193 7.15866 6.48014 7.42383L8.63903 9.22291C9.57199 10.0004 10.2197 10.5384 10.7666 10.8901C11.2959 11.2306 11.6549 11.3449 12 11.3449C12.3451 11.3449 12.7041 11.2306 13.2334 10.8901C13.7803 10.5384 14.428 10.0004 15.361 9.22291L17.5199 7.42383C17.8381 7.15866 18.311 7.20165 18.5762 7.51986C18.8413 7.83807 18.7983 8.31099 18.4801 8.57617L16.2836 10.4066C15.3973 11.1452 14.6789 11.7439 14.0448 12.1517C13.3843 12.5765 12.7411 12.8449 12 12.8449C11.2589 12.8449 10.6157 12.5765 9.95518 12.1517C9.32112 11.7439 8.60272 11.1452 7.71636 10.4066L5.51986 8.57617C5.20165 8.31099 5.15866 7.83807 5.42383 7.51986Z" />
                </svg>
            </div>
                  <div class="text-2xl font-semibold text-[#4A4A4A]">{{__('Write to us')}}</div>      
                  <div class="mb-6 mt-2 w-1/2 flex m-auto">{{__('Have a question or just want to say hi, Drop us a message')}}</div>      
                  <button class="rounded-3xl border-2 border-cyan-500 px-8 py-2">Write a message</button>
          </div>
          
        </div>
      </div>
    
  </section>
@endsection
