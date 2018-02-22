<div class="container bg-white flex-grow-1 related-videos">
    <a class="playlist-title__link related-videos__title">
        Related Videos
    </a>
    <div class="row justify-content-center pb-4 related-videos__list">
        @foreach($videos as $video)
            <div class="col-12 col-md-6 col-lg-4 px-3 mb-3 mb-lg-0 portfolio-item">
                <div class="card h-100">
                    <a href="{{ route('video.show', $video->slug) }}" data-category="{{ $video->categories()->count() ? $video->categories[0]->name : 'New'}}" class="{{ $video->categories()->count() ? $video->categories[0]->name : 'New'}}"><img class="card-img-top" src="{{ $video->getThumbnail() }}" alt=""></a>
                </div>
            </div>
        @endforeach
    </div>
</div>