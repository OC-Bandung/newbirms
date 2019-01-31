@extends('frontend.layouts.main')

@section('header')

    @include('frontend.layouts.nav')

@endsection

@section('content')

<section>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="blog-post">
                <h2 class="blog-post-title">{{ $article[0]->title }}</h2>
                <p class="blog-post-meta">{{ MyGlobals::indo_date($article[0]->created) }} Sumber: <a href="#">{{ $article[0]->source }}</a></p>
                <img class="card-img-top flex-auto d-none d-lg-block" src="{{ url("assets/media")}}/{{ $article[0]->filename}}" alt="{{ $article[0]->title }}">
                
                {!! $article[0]->content !!}
            </div>
        </div>
    </div>
</div>
</section>

@endsection

@section('footer')

@endsection