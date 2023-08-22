@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>{{ $callout->title }}</h1>
            <img class="w-100" src="{{ asset('stay-put.png') }}" />
        </div>
        <div class="col-md-6">
            <p>Date: {{ $callout->start_time->format('D M Y') }}</p>
            <p>Time: {{ $callout->start_time->format('Hm') }}</p>
            <p>Location: {{ $callout->location }}</p>
            <p>Penrith Team Members: {{ $callout->num_team_members }}</p>
            <p>Duration: {{ date_diff($callout->end_time, $callout->start_time)->format('%h hours %i minutes') }}</p>
            <p>Incident Type: {{ $callout->type }}</p>
            <p>Other Agencies Involved:</p>
            <p>{{ $callout->description }}</p>
        </div>
    </div>
</div>
@endsection
