@extends('layouts.app')
@section('content')
<div class="container">
    <h1>News</h1>
        @if(count($news) > 0)
        <div class="d-flex justify-content-center flex-wrap">
            @foreach($news as $newsItem)
                <div style="max-width: 300px" class="text-center">
                <p>{{ $newsItem->type }} - {{ $newsItem->created_at->format('d/m/Y') }}</p>
                    <img class="w-100" src="{{ asset('stay-put.png')}} " />
                    <h3>{{ $newsItem->title }}</p>
                    <h4>{{ $newsItem->subtitle }}</p>
                    <a href="/news/{{ $newsItem->id }}">Read More</a>
                </div>
            @endforeach
        </div>
        {{ $news->withQueryString()->links('pagination::bootstrap-5') }}
        @else
            <p>No news found</p>
        @endif
</div>
@endsection
