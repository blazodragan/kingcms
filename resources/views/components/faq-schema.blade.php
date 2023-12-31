<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "FAQPage",
    "mainEntity": [
        @foreach($faqs as $item)
        {
            "@type": "Question",
            "name": "{{ $item->question ?? '' }}",
            "acceptedAnswer": {
                "@type": "Answer",
                "text": "{{ $item->answer ?? '' }}"
            }
        }
        @if(!$loop->last), @endif
        @endforeach
    ]
}
</script>
