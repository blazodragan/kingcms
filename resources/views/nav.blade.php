@php
    function isActiveRoute($routeName, $output = "text-site-blue-dark") {
        if (Route::currentRouteName() == $routeName) return $output;
        return null;
    }
@endphp



<nav class="bg-white p-4">
    <div class="container mx-auto flex items-center justify-between">
      <!-- Logo (Left Side) -->
      <div class="text-white ">
        <span>
        <a href="{{ route('home') }}" ><img src="{{ asset('images/logo.png') }}" class="w-44" alt="Logo"></a>

        </span>
      </div>
      <!-- Menu Items (Middle) -->
      <div class="hidden md:flex space-x-10">
        
        <a href="{{ route('home') }}" class="{{ isActiveRoute('home') }} text-gray-700 font-medium text-lg" >{{__('Car Rental')}}</a>
        <a href="#" class="text-gray-700 font-medium text-lg">{{__('Vehicles')}}</a>
        <a href="{{ route('location') }}" class="{{ isActiveRoute('location') }} text-gray-700 font-medium text-lg" >{{__('Locations')}}</a>
        <a href="{{ route('allnews') }}" class="{{ isActiveRoute('allnews') }} text-gray-700 font-medium text-lg" >{{__('News')}}</a>
        <a href="{{ route('home') }}" class="{{ isActiveRoute('home') }} text-gray-700 font-medium text-lg">{{__('Loyalty Program')}}</a>
      </div>
      <!-- Right Side Items -->
      <div class="hidden md:flex items-center space-x-4">
        <span></span>
        <span class="text-gray-700 flex items-center"><svg width="800px" height="800px" class="w-6 h-6 mr-2 fill-cyan-500" fill="currentColor" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M4.7177 3.0919C5.94388 1.80096 7.9721 2.04283 8.98569 3.47641L10.2467 5.25989C11.0574 6.40656 10.9889 8.00073 10.0214 9.0194L9.7765 9.27719C9.77582 9.27897 9.7751 9.2809 9.77436 9.28299C9.76142 9.31935 9.7287 9.43513 9.7609 9.65489C9.82765 10.1104 10.1793 11.0361 11.607 12.5392C13.0391 14.0469 13.9078 14.4023 14.3103 14.4677C14.484 14.4959 14.5748 14.4714 14.6038 14.4612L15.0124 14.031C15.8862 13.111 17.2485 12.9298 18.347 13.5621L20.2575 14.6617C21.8904 15.6016 22.2705 17.9008 20.9655 19.2747L19.545 20.7703C19.1016 21.2371 18.497 21.6355 17.75 21.7092C15.9261 21.8893 11.701 21.6548 7.27161 16.9915C3.13844 12.64 2.35326 8.85513 2.25401 7.00591L2.92011 6.97016L2.25401 7.00591C2.20497 6.09224 2.61224 5.30855 3.1481 4.7444L4.7177 3.0919ZM7.7609 4.34237C7.24855 3.61773 6.32812 3.57449 5.80528 4.12493L4.23568 5.77743C3.90429 6.12632 3.73042 6.52621 3.75185 6.92552C3.83289 8.43533 4.48307 11.8776 8.35919 15.9584C12.4234 20.2373 16.1676 20.3581 17.6026 20.2165C17.8864 20.1885 18.1783 20.031 18.4574 19.7373L19.8779 18.2417C20.4907 17.5965 20.3301 16.4342 19.5092 15.9618L17.5987 14.8621C17.086 14.567 16.4854 14.6582 16.1 15.064L15.6445 15.5435L15.1174 15.0428C15.6445 15.5435 15.6438 15.5442 15.6432 15.545L15.6417 15.5464L15.6388 15.5495L15.6324 15.556L15.6181 15.5701C15.6078 15.5801 15.5959 15.591 15.5825 15.6028C15.5556 15.6264 15.5223 15.6533 15.4824 15.6816C15.4022 15.7384 15.2955 15.8009 15.1606 15.8541C14.8846 15.963 14.5201 16.0214 14.0699 15.9483C13.1923 15.8058 12.0422 15.1755 10.5194 13.5722C8.99202 11.9642 8.40746 10.7645 8.27675 9.87234C8.21022 9.41827 8.26346 9.05468 8.36116 8.78011C8.40921 8.64508 8.46594 8.53742 8.51826 8.45566C8.54435 8.41489 8.56922 8.38075 8.5912 8.35298C8.60219 8.33909 8.61246 8.32678 8.62182 8.31603L8.63514 8.30104L8.64125 8.29441L8.64415 8.2913L8.64556 8.2898C8.64625 8.28907 8.64694 8.28835 9.17861 8.79333L8.64695 8.28834L8.93376 7.98637C9.3793 7.51731 9.44403 6.72292 9.02189 6.12586L7.7609 4.34237Z"/>
          <path d="M13.2595 1.87983C13.3257 1.47094 13.7122 1.19357 14.1211 1.25976C14.1464 1.26461 14.2279 1.27983 14.2705 1.28933C14.3559 1.30834 14.4749 1.33759 14.6233 1.38082C14.9201 1.46726 15.3347 1.60967 15.8323 1.8378C16.8286 2.29456 18.1544 3.09356 19.5302 4.46936C20.906 5.84516 21.705 7.17097 22.1617 8.16725C22.3899 8.66487 22.5323 9.07947 22.6187 9.37625C22.6619 9.52466 22.6912 9.64369 22.7102 9.72901C22.7197 9.77168 22.7267 9.80594 22.7315 9.83125L22.7373 9.86245C22.8034 10.2713 22.5286 10.6739 22.1197 10.7401C21.712 10.8061 21.3279 10.53 21.2601 10.1231C21.258 10.1121 21.2522 10.0828 21.2461 10.0551C21.2337 9.9997 21.2124 9.91188 21.1786 9.79572C21.1109 9.56339 20.9934 9.21806 20.7982 8.79238C20.4084 7.94207 19.7074 6.76789 18.4695 5.53002C17.2317 4.29216 16.0575 3.59117 15.2072 3.20134C14.7815 3.00618 14.4362 2.88865 14.2038 2.82097C14.0877 2.78714 13.9417 2.75363 13.8863 2.7413C13.4793 2.67347 13.1935 2.28755 13.2595 1.87983Z"/>
          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.4861 5.32931C13.5999 4.93103 14.015 4.70041 14.4133 4.81421L14.2072 5.53535C14.4133 4.81421 14.4136 4.81431 14.414 4.81441L14.4147 4.81462L14.4162 4.81506L14.4196 4.81604L14.4273 4.81835L14.4471 4.82451C14.4622 4.82934 14.481 4.83562 14.5035 4.84358C14.5484 4.85952 14.6077 4.88218 14.6805 4.91339C14.8262 4.97582 15.0253 5.07224 15.2698 5.21695C15.7593 5.50664 16.4275 5.98781 17.2124 6.77279C17.9974 7.55776 18.4786 8.22595 18.7683 8.71541C18.913 8.95992 19.0094 9.15899 19.0718 9.30467C19.103 9.37748 19.1257 9.43683 19.1416 9.48175C19.1496 9.5042 19.1559 9.52303 19.1607 9.5381L19.1669 9.55789L19.1692 9.56564L19.1702 9.56898L19.1706 9.57051L19.1708 9.57124C19.1709 9.5716 19.171 9.57195 18.4499 9.77799L19.171 9.57195C19.2848 9.97023 19.0542 10.3853 18.6559 10.4991C18.261 10.612 17.8496 10.3862 17.7317 9.99414L17.728 9.98336C17.7227 9.96833 17.7116 9.93875 17.6931 9.89555C17.6561 9.80921 17.589 9.66798 17.4774 9.47939C17.2544 9.10265 16.8517 8.5334 16.1518 7.83345C15.4518 7.13349 14.8826 6.73079 14.5058 6.50782C14.3172 6.3962 14.176 6.32911 14.0897 6.2921C14.0465 6.27359 14.0169 6.26256 14.0019 6.25722L13.9911 6.25353C13.599 6.13565 13.3733 5.7242 13.4861 5.32931Z"/>
          </svg>(023) 569 96 96</span>
        <button class="bg-cyan-600 text-white px-8 py-2 rounded-3xl font-medium">{{__('Sign up')}}</button> 
<!-- Language Selector Dropdown -->
<div class="relative">
    <button id="langButton" class="lang-button rounded-full p-1 border overflow-hidden">
      <div>
        <svg class="w-7 h-7 rounded-full" viewBox="0 0 24 24"><rect width="24" height="8" fill="#000"/><rect width="24" height="8" y="8" fill="#ff0000"/><rect width="24" height="8" y="16" fill="#ffcc00"/></svg>
      </div>
      <span class="text-xs">DE</span>
    </button>
    <!-- Language List -->
    <div id="langList" class="lang-list absolute top-full left-0 right-0 rounded overflow-hidden transition-all duration-300 max-h-0 hidden">
      <!-- English -->
    <!-- <div class="lang-item flex flex-col items-center justify-center rounded-full p-1 border cursor-pointer bg-white hover:bg-gray-200">
        <div>
          <svg class="w-7 h-7 rounded-full" xmlns="http://www.w3.org/2000/svg" id="flag-icons-gb" viewBox="0 0 512 512">
            <path fill="#012169" d="M0 0h512v512H0z"/>
            <path fill="#FFF" d="M512 0v64L322 256l190 187v69h-67L254 324 68 512H0v-68l186-187L0 74V0h62l192 188L440 0z"/>
            <path fill="#C8102E" d="m184 324 11 34L42 512H0v-3l184-185zm124-12 54 8 150 147v45L308 312zM512 0 320 196l-4-44L466 0h46zM0 1l193 189-59-8L0 49V1z"/>
            <path fill="#FFF" d="M176 0v512h160V0H176zM0 176v160h512V176H0z"/>
            <path fill="#C8102E" d="M0 208v96h512v-96H0zM208 0v512h96V0h-96z"/>
          </svg>
        </div>
        <span class="text-xs">EN</span>
      </div> -->
      <!-- French -->
      <!-- <div class="lang-item flex flex-col items-center justify-center rounded-full p-1 border cursor-pointer bg-white hover:bg-gray-200">
        <div>
          <svg class="w-7 h-7 rounded-full" viewBox="0 0 24 24"><rect width="8" height="24" fill="#005cbf"/><rect width="8" height="24" x="8" fill="#fff"/><rect width="8" height="24" x="16" fill="#ef4135"/></svg>
        </div>
        <span class="text-xs">FR</span>
      </div> -->
            <!-- French -->
            <!-- <div class="lang-item flex flex-col items-center justify-center rounded-full p-1 border cursor-pointer bg-white hover:bg-gray-200">
              <div>
                <svg class="w-7 h-7 rounded-full" viewBox="0 0 24 24"><rect width="24" height="8" fill="#000"/><rect width="24" height="8" y="8" fill="#ff0000"/><rect width="24" height="8" y="16" fill="#ffcc00"/></svg>
              </div>
              <span class="text-xs">DE</span>
            </div> -->
    </div>
  </div>
      </div>
      <!-- Burger Menu (Mobile) -->
      <div class="md:hidden flex items-center">
        <button id="menuButton" class="text-white">
          <!-- SVG for Burger Icon -->
          <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" stroke="#49a5d4" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <!-- Dropdown Menu (Mobile) -->
    <div id="mobileMenu" class="md:hidden mt-2 space-y-2 hidden overflow-hidden transition-all duration-300" style="max-height: 0;">
      <a class="{{ isActiveRoute('home') }} text-[#49a5d4] block" href="{{ route('home') }}">{{__('Car Rental')}}</a>
      <a class="{{ isActiveRoute('home') }} text-[#49a5d4] block" href="{{ route('home') }}">{{__('Vehicles')}}</a>
      <a class="{{ isActiveRoute('location') }} text-[#49a5d4] block" href="{{ route('location') }}">{{__('Locations')}}</a>
      <a class="{{ isActiveRoute('allnews') }} text-[#49a5d4] block" href="{{ route('allnews') }}">{{__('News')}}</a>
      <a class="{{ isActiveRoute('home') }} text-[#49a5d4] block" href="{{ route('home') }}">{{__('Loyalty Program')}}</a>

    </div>
  </nav>