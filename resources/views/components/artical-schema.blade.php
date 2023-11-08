
<script type="application/ld+json">
{
  "@context": "https://schema.org/",
  "@type": "Article",
  "author": [
    {
      "@type": "Person",
      "name": "{{ $page->user->name }}",
      "url": "{{ route('showAuthor', ['slug' => $page->user->slug]) }}"
      @if($page->user->avatar_url),
      "image": {
            "@type": "ImageObject",
            "url": "{{ $page->user->avatar_url }}"
        }
        @endif
    }
  ],
  "headline": "{{ $page->title }}",
  @if($page->media->first())
  
  "image": {
    "@type": "ImageObject",
    "url": "{{ $page->media->first()->getUrl('bigThumb') }}"
  },

  @endif
  
  "datePublished": "{{ date('c', strtotime($page->published_at . ' UTC')) }}",
  "publisher": {
    "@type": "Organization",
    "name": "{{ config('app.name') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/logo.png') }}"
    }
  },
  "dateModified": "{{ date('c', strtotime($page->updated_at . ' UTC')) }}",
  "mainEntityOfPage": " {{ url()->current() }}"@if($page->perex),"description": "{{ $page->perex }}"@endif
}
</script>