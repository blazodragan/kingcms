<div class="news-block">
    @foreach($newsItems as $news)
        <article>
            <h2>{{ $news->title }}</h2>
            <p>{{ $news->perex }}</p>
            <a href="{{ route('home', $news->id) }}">Read More</a>
        </article>
    @endforeach
</div>

