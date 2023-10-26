<section class="antialiased bg-gray-50 text-gray-600">
    <div class="w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
        @foreach($pageItems as $pageItem)
        <div class="bg-white flex flex-col shadow-sm border border-[#D3DBEB] overflow-hidden rounded-lg transition duration-500 ease-in-out transform glow">
            <a href="{{ route('showChild', ['parentPage' => $pageItem->parent->slug, 'childPage' => $pageItem->slug]) }}">
                <!-- Image -->
                @if($pageItem->media->first())
                <figure class="relative h-0 pb-[56.25%] overflow-hidden">
                    <img class="absolute inset-0 w-full h-full object-cover transform hover:scale-105 transition duration-700 ease-out" src="{{ $pageItem->media->first()->getUrl('bigThumb') }}" alt="{{ $pageItem->media->first()->custom_properties['name'] ?? '' }}">

                </figure>
                @endif
                <div class="flex-grow flex flex-col p-5 h-[8rem]">
                    <!-- Card body -->
                    <div class="flex-grow">
                        <!-- Header -->
                        <header class="mb-3">
                            <h3 class="text-[22px] text-gray-900 font-extrabold leading-snug">{{ $pageItem->title }}</h3>
                        </header>
                        <!-- Content -->
                        <div class="mb-8">
                            <p class="truncate">{{ $pageItem->perex }}</p>
                        </div>
                    </div>

                </div>
            </a>
        </div>
        @endforeach
    </div>
</section>