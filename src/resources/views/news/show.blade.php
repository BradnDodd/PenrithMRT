@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <p>{{ $news->type }}</p>
        <h2>{{ $news->subtitle }}</h2>
        <h1>{{ $news->title }}</h1>
        <div class="col-md-6">
            <p>{{ $news->description }}
        </div>
    </div>
</div>
@endsection
